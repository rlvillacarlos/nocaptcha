(function(){
    $noCAPTCHA = new Object();
    
    $noCAPTCHA.requireCAPTCHA = function(success,failure){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4) {
                var resp = (JSON.parse(xhttp.responseText));                    
                if(xhttp.status === 200){
                    if(resp){
                        if(resp.success){
                            success({quota:resp.quota,remaining:resp.remaining});                                                    
                        }else{
                            failure({reason:{text:'Quota limit.',value:0}});                                        
                        }
                    }else{
                        failure({reason:{text:'Failed to get response',value:-1}});                                        
                    }
                }else{
                    failure({reason:{text:'No credentials.',value:2}});
                }
            }
        };
        xhttp.open("GET", "http://localhost/nocaptcha/verify", true);
        xhttp.withCredentials = true;
        xhttp.send();        
    };
    return $noCAPTCHA;
})();



