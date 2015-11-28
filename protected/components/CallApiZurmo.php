<?php
/**
 * Truy cập vào http://zurmo.org/wiki-subject/api để xem cách gọi API.
 */
class CallApiZurmo {
    
    // url api của zurmo
    private $zurmo_url =  'http://localhost:8080/zurmo/app/index.php';
    
    // username đăng nhập vào zurmo và phải có quyền thêm user
    private $username = 'admin';
    
    // password đăng nhập vào zurmo
    private $password = 'admin123';

    public function zurmoLogin() 
    {
        $headers = array(
            'Accept: application/json',
            'ZURMO_AUTH_USERNAME: ' . $this->username,
            'ZURMO_AUTH_PASSWORD: ' . $this->password,
            'ZURMO_API_REQUEST_TYPE: REST',
        );
        $response = LinxHQCurl::createApiCall($this->zurmo_url.'/zurmo/api/login', 'POST', $headers);

        $response = json_decode($response, true);
        if ($response['status'] == 'SUCCESS')
        {
            return ($response['data']);
        }
        else
            return false;
    }
    
    
    public function zurmoCreateUser($data = array())
    {
       $authenticationData = $this->zurmoLogin();
        $headers = array(
            'Accept: application/json',
            'ZURMO_SESSION_ID: ' . $authenticationData['sessionId'],
            'ZURMO_TOKEN: ' . $authenticationData['token'],
            'ZURMO_API_REQUEST_TYPE: REST',
        );
        $response = LinxHQCurl::createApiCall($this->zurmo_url.'/users/user/api/create/', 'POST', $headers, array('data' => $data));
        $response = json_decode($response, true);

        if ($response['status'] == 'SUCCESS')
        {
            $user = $response['data'];
            //Do something with user data
        }
        else
        {
            // Error
            $errors = $response['errors'];
            // Do something with errors, show them to user
        }
    }
    
    
}
