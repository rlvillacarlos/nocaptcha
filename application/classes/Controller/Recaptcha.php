<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Description of Recaptcha
 *
 * @author RLVillacarlos
 */
class Controller_Recaptcha extends Controller{
    
    public function action_index() {
        $recaptcha_req= Request::factory("verify");
        $recaptcha_req->referrer($this->request->referrer());
        $response = $recaptcha_req->execute();
        
        
        if($response->status()==200){
            $result = json_decode($response->body(),TRUE);
            echo $response->body();
            if($result['valid']){
                echo 'Good';
                
                return;
            }
        }     
    }
}
