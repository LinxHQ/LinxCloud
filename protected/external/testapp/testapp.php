<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);

class LinxHQCurl {

    public static function callRemoteAPI($url, $fields = array()) {
        /**error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);**/
        // Create cookie file if it doesn't exists
        $cookieFile = '/tmp/linxhqcurl_cookies.txt';
        //$cookieFile = '/tmp/linxhq_curl.txt';//debug
        //echo "COOKIE FILE: " . file_exists($cookieFile) . "???";

        if (!file_exists($cookieFile)) {
            $fh = fopen($cookieFile, "w");
            fwrite($fh, "");
            fclose($fh);
        }

        //url-ify the data for the POST
        $fields_string = '';
        if (count($fields) > 0)
            foreach ($fields as $key => $value) {
                $fields_string .= $key . '=' . $value . '&';
            }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();
        
        // send user id on header
        /**$cookie = Yii::app()->Cookies->getCookie('user_cookie');
        $userid = null;
        $username = null;
        $password = null;
        if(isset($cookie->userid)) {
            $userid = $cookie->userid;
            $username = $cookie->username;
            $password = $cookie->password;
        }**/
        $http_headers = array();/** = array(            
            "userid: ".$userid,
            "username: ".$username,
            "password: ".$password,
        );**/
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);

        return $result;
    }
}

$cookie_secret_variable_name = 'LINX_SESSION_VAR';
        $cookie_secret_variable_value = isset($_COOKIE[$cookie_secret_variable_name]) ? 
                $_COOKIE[$cookie_secret_variable_name] : '';
        //setcookie(session_name(),'linxhrm-test-session-name-cookie-secret',time()+600);
        
        // call remote api to check if user is still registered as logged in
        $return = LinxHQCurl::callRemoteAPI("http://hqaccounts.linxcircle.com/index.php/site/remoteCheckSession",
                array(
                    'caller_app_name' => 'projects',
                    'caller_app_secret_identity' => 'cfe077d021a66ac00eab6408003bc2a8',
                    'cookie_secret_value' => $cookie_secret_variable_value,
                ));
        
        // analyze return
//echo $return;
$return_array = json_decode($return);
if (isset($return_array->action_code)) {
    $action_code = $return_array->action_code;
    if ($action_code == 'ALREADY_AUTHENTICATED') 
    {
        echo 'You are already authenticated.';
    } else if ($action_code == 'AUTHENTICATION_REQUIRED') {
        if (isset($return_array->loginURL)) {
            // write script to post data to login URL
            // because we have secret app identity to post, we want to use post form
            // instead of raw header redirect
            $remote_login_url = stripslashes($return_array->loginURL);
            echo '<form action="'.$remote_login_url.'" method="post" name="app_authentication_redirect">';
            echo '<input type="hidden" name="return_type" value="redirect"/>';
            echo '<input type="hidden" name="caller_app_name" value="projects"/>';
            echo '<input type="hidden" name="caller_app_secret_identity" value="cfe077d021a66ac00eab6408003bc2a8"/>';
            echo '<input type="hidden" name="return_url" value="linxhq.com"/>';
            echo '</form>';
            echo '<script language="javascript">document.app_authentication_redirect.submit()</script>';
            //header('Location: '.);
        }
    } else {
        echo 'action code invalid.';
    }
} else {
    echo 'Not sure what you are trying to do, pal!';
    print_r($return_array);
}
        