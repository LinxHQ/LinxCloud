<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LinxHQCurl {

    public static function callRemoteAPI($url, $fields = array()) {
        /**error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);**/
        // Create cookie file if it doesn't exists
        $cookieFile = dirname(Yii::app()->request->scriptFile) . '/assets/linxhqcurl_cookies.txt';
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
        //$cookie = Yii::app()->Cookies->getCookie('user_cookie');
        $userid = null;
        $username = null;
        $password = null;
        /**if(isset($cookie->userid)) {
            $userid = $cookie->userid;
            $username = $cookie->username;
            $password = $cookie->password;
        }**/
        $http_headers = array(            
            "userid: ".$userid,
            "username: ".$username,
            "password: ".$password,
        );
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
    
    
    public static function createApiCall($url, $method, $headers, $data = array())
        {
            if ($method == 'PUT')
            {
                $headers[] = 'X-HTTP-Method-Override: PUT';
            }

            $headers = CMap::mergeArray(array("Cache-Control: no-cache"), $headers);
            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($handle, CURLOPT_FRESH_CONNECT, true);

            switch($method)
            {
                case 'GET':
                    break;
                case 'POST':
                    curl_setopt($handle, CURLOPT_POST, true);
                    curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($data));
                    break;
                case 'PUT':
                    curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'PUT');
                    curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($data));
                    break;
                case 'DELETE':
                    curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'DELETE');
                    break;
            }
            $response = curl_exec($handle);
            return $response;
    }
}
