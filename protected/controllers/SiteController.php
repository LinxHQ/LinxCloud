<?php

class SiteController extends Controller {

    
    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
            if(!Yii::app()->user->isGuest)
            {
                $this->render('index');
            }
            else
            {
                $this->redirect($this->createUrl('site/login'));
            }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        
        // redirect if already logged in
        // not sure why have to do it, should be auto
        if (!Yii::app()->user->isGuest)
        {
            $this->redirect(Yii::app()->user->returnUrl);
        }
        
        // display the login form
        $this->layout = '//layouts/plain';
        $this->render('login', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionRemoteLogin() {
        $model = new LoginForm;
        $returnType = isset($_POST['return_type']) ? $_POST['return_type'] : '';
        $caller_app_name = isset($_POST['caller_app_name']) ? $_POST['caller_app_name'] : '';
        $caller_app_secret_identity = isset($_POST['caller_app_secret_identity']) ? $_POST['caller_app_secret_identity'] : '';
        $apiController = new LinxHQAPIController;
        $return_url = isset($_POST['return_url']) ? $_POST['return_url'] : '';
        
        // collect user input data
        if (isset($_POST['LoginForm'])) {            
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {

                // look for app
                $app = LinxApp::model()->getApp($caller_app_name, $caller_app_secret_identity);
                $account_id = Yii::app()->user->id;

                if ($returnType == 'json') {
                    // check if user is allowed to use this app
                    if (!LinxAppAccessList::model()->isAllowed($account_id, $app->app_id)) {
                        $apiController->sendResponse(403, 'You are not allowed to use this app.');
                    }

                    $account = LinxAccount::model()->findByPk($account_id);
                    $accountProfile = LinxAccountProfile::model()->getProfile($account_id);
                    $returnData->account_username = $account->account_username;
                    $returnData->account_email = $account->account_username;
                    $returnData->account_id = $account_id;
                    $returnData->account_profile_surname = $accountProfile->account_profile_surname;
                    $returnData->account_profile_given_name = $accountProfile->account_profile_given_name;
                    $apiController->sendResponse(200, 'New session started.', $returnData);
                } else if ($returnType == 'redirect') {
                    // check if user is allowed to use this app
                    if (!LinxAppAccessList::model()->isAllowed($account_id, $app->app_id)) {
                        $apiController->sendResponse(403, '[Redirect] You are not allowed to use this app.');
                    }

                    if ($app) {
                        // if return url is available, redirect user there
                        if ($return_url)
                        {
                            $this->redirect($return_url);
                        }
                        
                        // redirect to app's default url
                        $this->redirect($app->app_url);
                    }
                    
                    // go to home page of linxhq sso if app cannot be found
                    $this->redirect(Yii::app()->user->returnUrl);
                } else {
                    $this->redirect(Yii::app()->user->returnUrl);
                }
            }
        }
        
        // redirect if already logged in
        // not sure why have to do it, should be auto
        if (!Yii::app()->user->isGuest)
        {
            //$this->redirect(Yii::app()->user->returnUrl);
        }

        // display the login form
		$this->layout = '//layouts/plain';
        $this->render('login', array(
            'model' => $model,
            'return_type'=>$returnType,
            'caller_app_name'=>$caller_app_name,
            'caller_app_secret_identity' => $caller_app_secret_identity,
            'return_url'=>$return_url
            ));
    }

    /**
     * Remote check session
     * Usually called by other apps to use our SSO 
     * 
     * POST DATA required: cookie_secret_value, caller_app_name, caller_app_secret_identity
     * 
     * @return string json result
     */
    public function actionRemoteCheckSession() {
        $model = new LoginForm;
        $session = new LinxSession();
        $returnData = new stdClass;
        $apiController = new LinxHQAPIController;
                
        /**
         * GET POST DATA
         */
        // check if caller app has the right identity
        $caller_app_name = $_POST['caller_app_name'];
        $caller_app_secret_identity = $_POST['caller_app_secret_identity'];
        if (!LinxApp::model()->appExists($caller_app_name, $caller_app_secret_identity)) {
            $apiController->sendResponse(403, 'Your app is not allowed access to this API.');
        }

        // validate session data
        if (!isset($_POST['cookie_secret_value'])) {
            $apiController->sendResponse(403, 'No session data provided.');
        }
        $cookie_secret_value = $_POST['cookie_secret_value'];
        // END GET POST DATA
        
        /**
         * START PROPER LOGIC
         */
        
        // check if session is alive
        if ($session->isAlive($cookie_secret_value)) {
            // get user data and return
            $session = LinxSession::model()->getSession($cookie_secret_value);
            if ($session) {
                $account_id = $session->account_id;


                // check if user is allowed to use this app
                $app = LinxApp::model()->getApp($caller_app_name, $caller_app_secret_identity);
                if (!LinxAppAccessList::model()->isAllowed($account_id, $app->app_id)) {
                    $apiController->sendResponse(403, 'Your are not allowed to access to this app.');
                }

                $account = LinxAccount::model()->findByPk($account_id);
                $accountProfile = LinxAccountProfile::model()->getProfile($account_id);
                $returnData->account_username = $account->account_username;
                $returnData->account_email = $account->account_username;
                $returnData->account_id = $account_id;
                $returnData->account_profile_surname = $accountProfile->account_profile_surname;
                $returnData->account_profile_given_name = $accountProfile->account_profile_given_name;
                $returnData->action_code = 'ALREADY_AUTHENTICATED';
                $apiController->sendResponse(200, 'Session is still alive. User data is passed back for further verification.', $returnData);
            } else {
                // somehow session is null
                $apiController->sendResponse(403, 'Session is null.');
            }
        } else {
            // session is not alive
            // send message to caller so that they know to redirect to home page
            $returnData->loginURL = Yii::app()->params['HQACCOUNTS_REMOTE_LOGIN_URL']; //LinxApp::HQACCOUNTS_REMOTE_LOGIN_URL;
            $returnData->action_code = 'AUTHENTICATION_REQUIRED';
            $apiController->sendResponse(200, 'You are not logged in. Please use the url provided to redirect user to login page.', $returnData);
        }
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
		
        unset($_COOKIE['LINX_SESSION_VAR']);
        setcookie('LINX_SESSION_VAR', null, -1, '/');
        // clear session secret value
        $session_id = Yii::app()->session->sessionID;
        $currentSession = LinxSession::model()->findByPk($session_id);
        $currentSession->clearSessionCookieSecretValue();

        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
    
    function actionRemoteMenu($id)
    {
        $url = YII::app()->params['HQACCOUNTS_URL'];
        $this->renderPartial('menu/remote_menu',array(
               'account_id'=>$id,
               'url'=>$url
        ));
    }
    
    function actionLoadListApp($id)
    {
        $this->renderPartial('menu/_list_app',array(
                    'account_id'=>$id
                ));
    }
    
    function actionRemoteMyAccount($id)
    {
	$url = YII::app()->params['HQACCOUNTS_URL'];
        
        $this->renderPartial('remote_my_account',array(
            'url'=>$url,
            'user_id'=>$id
        ));
    }
	
    function actionRemoteMenuByUsername($username)
    {

        $account = LinxAccount::model()->find('account_username = "'.$username.'"');
        $id = $account->account_id;

        $url = YII::app()->params['HQACCOUNTS_URL'];
        $this->renderPartial('menu/remote_menu',array(
               'account_id'=>$id,
               'url'=>$url
        ));
    }
	
    function actionRemoteMyAccountByUsername($username)
    {
            $account = LinxAccount::model()->find('account_username = "'.$username.'"');
            $id = $account->account_id;
			
		$url = YII::app()->params['HQACCOUNTS_URL'];
        
        $this->renderPartial('remote_my_account',array(
            'url'=>$url,
            'user_id'=>$id
        ));
    }

}
