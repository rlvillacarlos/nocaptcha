<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index extends Controller {
    const MAX_QUOTA = 5;
    public $client;
    public $origin = "";
    
    public function before() {
        parent::before();
        $this->client = new Google_Client();
        $this->client->setAuthConfigFile(APPPATH . "/vendor/credentials.json");
        $this->client->setRedirectUri("http://localhost/nocaptcha/register");
        $this->client->setAccessType("offline");
        $this->client->setApprovalPrompt("force");
        $this->client->addScope(array(
            Google_Service_Oauth2::USERINFO_PROFILE,
            Google_Service_Oauth2::USERINFO_EMAIL
        ));
        
        $this->origin = $this->request->headers("Origin");
        
        if(isset($this->origin)){
            $this->response->headers('Access-Control-Allow-Origin', $this->origin);
            $this->response->headers('Access-Control-Allow-Credentials', "true");
            $this->response->headers('Access-Control-Allow-Methods', 'POST, GET, OPTIONS');
        }
    }

    public function action_index() {
        $session = Session::instance('database');
        $indexView = View::factory("index");
        Log::instance()->add(Log::DEBUG, print_r($session->get('credentials'),true));
        $credentials = json_decode($session->get('credentials'), true);
        $user = "";
        $state=null;
        if (isset($credentials)) {
            $isLogged = true;
            $this->client->setAccessToken($credentials['access_token']);
            
            if ($this->client->isAccessTokenExpired()) {
                $this->client->getRefreshToken($credentials['refresh_token']);
            }

            $oauth = new Google_Service_Oauth2($this->client);
            $userInfo = $oauth->userinfo->get();
            $user = $userInfo->name;
            $acct = new Model_Account($userInfo->id);
            $state=$this->generateAccountState($acct);
            
//            Log::instance()->add(Log::ALERT, print_r($userInfo,true));
        }else{
            Log::instance()->add(Log::ALERT, "NO CREDENTIALS");
        }
        $indexView->set("isLogged",  isset($isLogged));
        $indexView->set("user",  $user);
        $indexView->set("state",  $state);
        $this->response->body($indexView->render());
    }
    
    public function action_disconnect(){
        $session = Session::instance('database');        
        $session->destroy();
        $this->redirect('index');
    }
    
    public function action_verify() {
        if(isset($this->origin)){
            $session = Session::instance('database');
            $credentials = json_decode($session->get('credentials'), true);
            try {
                if (isset($credentials)) {
                    $this->client->setAccessToken($credentials['access_token']);

                    if ($this->client->isAccessTokenExpired()) {
                        $this->client->getRefreshToken($credentials['refresh_token']);
                    }

                    $oauth = new Google_Service_Oauth2($this->client);
                    $userInfo = $oauth->userinfo->get();

                    $acct = new Model_Account($userInfo->id);
                    $this->updateAccountState($acct);
                    $state=$this->generateAccountState($acct);
                    
                    if ($acct->loaded()) {                        
                        $this->response
                                ->headers("Content-Type", "text.json")
                                ->status(200)
                                ->body(json_encode($state));
                        return;
                    }
                } else {
                    Log::instance()->add(Log::ALERT, "NO CREDENTIALS");
                }
            } catch (Exception $ex) {
                /* Ignore exception */
                $this->response
                        ->status(500)
                        ->headers("Content-Type", "text/json")
                        ->body(json_encode($this->generateAccountState(NULL)));
                
                Log::instance()->add(Log::ERROR, $ex->getMessage());
                return;
            }
        }
        $this->response
                ->status(401)
                ->headers("Content-Type", "text/json")
                ->body(json_encode($this->generateAccountState(NULL))); 
        
    }

    public function action_register() {
        $code = $this->request->query("code");
        $state = $this->request->query('state');

        if (!isset($code) && !isset($state)) {
            $state = mt_rand();
            $this->client->setState($state);
            $auth_url = $this->client->createAuthUrl();
            $this->redirect(filter_var($auth_url, FILTER_SANITIZE_URL));
        } else {
            $this->client->authenticate($code);            
            $oauth = new Google_Service_Oauth2($this->client);
            $userInfo = $oauth->userinfo->get();
            
            $acct = new Model_Account($userInfo->id);
            
            if(!$acct->loaded()){
                $acct->set('id', $userInfo->id)->create();
                
                $quota = new Model_Quota();
                $quota->set('account',$acct)
                      ->set('value',self::MAX_QUOTA)
                      ->save();
            }            
            
            $acct->set('refreshToken', $this->client->getRefreshToken())->save();

            $session = Session::instance('database');
            $session->set("credentials", 
                            json_encode([
                                "access_token"=>$this->client->getAccessToken(),
                                "refresh_token"=>$this->client->getRefreshToken(),
                            ])
                        );
            $this->redirect('index');
        }
    }
    private function updateAccountState($acct){
        if ($acct && $acct->loaded()) {
//            $state["success"]=true;
            $start_date = (new DateTime(date('Y-m-d H:i:s', time())))->setTime(0, 0, 0);
            $end_date = (new DateTime(date('Y-m-d H:i:s', time())))->setTime(23, 59, 59);

            $access_count = $acct->access
                    ->where('entry_date', '>=', $start_date->format('Y-m-d H:i:s'))
                    ->where('entry_date', '<=', $end_date->format('Y-m-d H:i:s'))
                    ->where('referer', 'LIKE', $this->origin . '%')
                    ->count_all();

            if ($access_count < $acct->quota->value) {
                (new Model_Access())->set('account', $acct)
                        ->set('ip', Request::$client_ip)
                        ->set('referer', $this->request->referrer())
                        ->save();
                
                return true;
            }
        }
        return false;                
    }
    private function generateAccountState($acct){        
        $state =["success"=>FALSE, "quota"=>-1,"access_count"=>-1,"remaining"=>-1];
        
        if ($acct && $acct->loaded()) {
            $state["success"]=true;
            $start_date = (new DateTime(date('Y-m-d H:i:s', time())))->setTime(0, 0, 0);
            $end_date = (new DateTime(date('Y-m-d H:i:s', time())))->setTime(23, 59, 59);

            $access_count = $acct->access
                    ->where('entry_date', '>=', $start_date->format('Y-m-d H:i:s'))
                    ->where('entry_date', '<=', $end_date->format('Y-m-d H:i:s'))
                    ->where('referer', 'LIKE', $this->origin . '%')
                    ->count_all();

//            if ($access_count < $acct->quota->value) {                
            $state['access_count'] = $access_count;
            $state['quota'] = $acct->quota->value;
            $state['remaining'] = $acct->quota->value - $access_count;
//            } else {
//                $state['access_count'] = $access_count;
//                $state['quota'] = $acct->quota->value;
//                $state['remaining'] = 0;                
//            }
        }
        
        return $state;
    }
}
