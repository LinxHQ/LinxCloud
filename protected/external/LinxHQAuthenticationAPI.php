<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * @author Joseph Pham
 * @date 27 Mar 2015
 * @company LinxHQ Pte Ltd
 * 
 * Copyright (c) 2015
 * 
 * This class can be used by other linxhq apps to check if the current app
 * is being registered as logged in with LinxHQ SSO or not. 
 * There are also other useful functions.
 */

require_once 'LinxHQCurl.php';

class LinxHQAuthenticationAPI {
    const LINXHQ_SSO_URL = 'http://hqaccounts.linxcircle.com/index.php/';
    const THIS_APP_NAME = 'projects';
    const THIS_APP_SECRET_IDENTITY = 'cfe077d021a66ac00eab6408003bc2a8';
    
    public function isAuthenticated()
    {
        $cookie_secret_variable_name = 'LINX_SESSION_VAR';
        $cookie_secret_variable_value = isset($_COOKIE[$cookie_secret_variable_name]) ? 
        $_COOKIE[$cookie_secret_variable_name] : '';
        
        // call remote api to check if user is still registered as logged in
        $return = LinxHQCurl::callRemoteAPI(LinxHQAuthenticationAPI::LINXHQ_SSO_URL . "site/remoteCheckSession",
                array(
                    'caller_app_name' => LinxHQAuthenticationAPI::THIS_APP_NAME,
                    'caller_app_secret_identity' => LinxHQAuthenticationAPI::THIS_APP_SECRET_IDENTITY,
                    'cookie_secret_value' => $cookie_secret_variable_value,
        ));
        
        // analyze return
        //echo $return;
        $return_array = json_decode($return);
        return $return_array;
        /**
        if (isset($return_array->action_code)) {
            $action_code = $return_array->action_code;
            if ($action_code == 'ALREADY_AUTHENTICATED') 
            {
                // return user data
                return $return_array;
                return true;
                //echo 'You are already authenticated.';
            } else if ($action_code == 'AUTHENTICATION_REQUIRED') {
                if (isset($return_array->loginURL)) {
                    // write script to post data to login URL
                    // because we have secret app identity to post, we want to use post form
                    // instead of raw header redirect
                    $remote_login_url = stripslashes($return_array->loginURL);
                    echo '<form action="'.$remote_login_url.'" method="post" name="app_authentication_redirect">';
                    echo '<input type="hidden" name="return_type" value="redirect"/>';
                    echo '<input type="hidden" name="caller_app_name" value="'.LinxHQAuthenticationAPI::THIS_APP_NAME.'"/>';
                    echo '<input type="hidden" name="caller_app_secret_identity" value="'.LinxHQAuthenticationAPI::THIS_APP_SECRET_IDENTITY.'"/>';
                    //echo '<input type="hidden" name="return_url" value="linxhq.com"/>';
                    echo '</form>';
                    echo '<script language="javascript">document.app_authentication_redirect.submit()</script>';
                    //header('Location: '.);
                }
            } else {
                echo 'action code invalid.';
                exit;
            }
        } else {
            echo 'Not sure what you are trying to do, pal!';
            print_r($return_array);
            exit;
        }
         * 
         */
    } // end isAuthenticated
} // end class LinxHQAuthenticationAPI