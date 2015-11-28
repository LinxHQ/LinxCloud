<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define('APPLICATION_ID', 'LINX-LNLS-PTE-LTD-WOUIMF');
define('API_PUBLIC_KEY', 'LINX-KO09E-08273057163841');

/**
 * Description of LinxHQAPIController
 *
 * @author josephpnc
 * @copyright   2013    Lion and Lamb Soft Pte Ltd
 */
class LinxHQAPIController {
    //put your code here
    

    /**
     * 
     * @param int $status default 200
     * @param text $message default ''
     * @param stdClass $body to be converted into json
     * @param text $content_type default 'application/json'
     */
    public function sendResponse($status = 200, $message = '', $body = '', $content_type = 'application/json') {
        // set the status
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        header($status_header);

        if ($status == 200) {
            // send the body
            // and the content type
            header('Content-type: ' . $content_type);
            $body->message = $message;
            echo CJSON::encode($body);
        }
        // we need to create the body if none is passed
        else {

            // this is purely optional, but makes the pages a little nicer to read
            // for your users.  Since you won't likely send a lot of different status codes,
            // this also shouldn't be too ponderous to maintain
            switch ($status) {
                case 403:
                case 401:
                    $message .= 'You must be authorized to view this page.';
                    break;
                case 404:
                    $message .= 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                    break;
                case 500:
                    $message .= 'The server encountered an error processing your request.';
                    break;
                case 501:
                    $message .= 'The requested method is not implemented.';
                    break;
            }
            
            echo CJSON::encode(array('results' => array('errorCode' => $status, 'message' => addslashes("$message"))));
        }
        Yii::app()->end();
    }

    private function _getStatusCodeMessage($status) {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    /**
     * check if the caller of our API is from the same domain or not
     */
    private function callerIsSameDomain() {
        return strstr(Yii::app()->getBaseUrl(true), $_SERVER['SERVER_NAME']);
    }

    /**
     * 
     * @param unknown $model
     */
    private function _sendMessageNoSuchModel($model) {
        $this->_sendResponse(501, sprintf(
                        'Error: No such model <b>%s</b>', $model));
    }

    /**
     *
     * @param unknown $model
     */
    private function _sendMessageModeNotImplemented($model) {
        $this->_sendResponse(501, sprintf(
                        'Error: Mode <b>list</b> is not implemented for model <b>%s</b>', $model));
    }

    /**
     *
     * @param unknown $model
     */
    private function _sendMessageNoItemFound($model) {
        $this->_sendResponse(200, CJSON::encode($this->_messageIntoArray('No items where found for model' . $model)));
    }

    /**
     * encode message into an array so that it can be later on encode into JSON
     * Usually only use for status 200
     * 
     * @param unknown $message
     * @return multitype:unknown
     */
    private function _messageIntoArray($message) {
        $array = array("message" => $message);

        return $array;
    }
}
