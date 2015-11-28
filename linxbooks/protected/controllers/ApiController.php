<?php
/**
 * Key which has to be in HTTP USERNAME and PASSWORD headers
 */
define('APPLICATION_ID', 'LINCOLN022013-LNLS-PTE-LTD-WOUIMF');
define('API_PUBLIC_KEY', 'LINCOLN08273057163841');

/**
 * 
 * @author joseph
 *
 * Example call:
 * http://localhost/lincoln/index.php/api/view/model/account/id/1
 * 
 * Headers must contain:
 * LINX-APPLICATION-ID
 * LINX-PUBLIC-KEY
 * LINX-ACCOUNT-EMAIL
 * LINX-PASSWORD
 */

class ApiController extends Controller
{	
	/**
	 * Default response format
	 * either 'json' or 'xml'
	 */
	private $format = 'json';
	
	/**
	 * List of public api
	 * format array('model' => 'action1,action2,action3',...)
	 */
	private $public_apis = array('emailNotification' => 'view', 'account' => 'emailExists,authenticate');

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	// NOTE ABOUT ACTION
	/**
	 * Model that wants to allow certain action/mode must conforms to the following requirements:
	 * 	a. It must has a method named in this convention: "allowsAPI<Model>", which returns boolean.
	 * 		e.g. allowsAPIList (note the first char of mode is uppercase 'L')
	 * 	b. Nothing else for now =D
	 */
	
	// START ACTIONS
        
        public function actionAuthenticate()
        {
                
                $this->_checkAuth('account', 'authenticate');
                if (isset($_POST['email']) && isset($_POST['password']))
                {
                        $identity = new UserIdentity($_POST['email'], $_POST['password']);
                        $identity->authenticate();
                        
                        if ($identity->errorCode === UserIdentity::ERROR_NONE)
                        {
                                // succeeded
                                // register a user session
                                $duration = 3600*24*30*1000; // 1000 days
                                Yii::app()->user->login($identity,$duration);
                        
                                // send results json
                                $account = Account::model()->findByPk($identity->getId());
                                // get account profile id
                                $accountProfile = AccountProfile::model()->getProfile($account->account_id);
                                $account->getMetaData()->columns =
                                    array_merge($account->getMetaData()->columns,
                                        array('account_profile_id' => ''));                            
                                $account->account_profile_id = $accountProfile->account_profile_id;
                                $this->_sendResponse(200, CJSON::encode(array('results' => array($account))));
                                
                        } else {
                                // failed
                                $account = new Account;
                                $account->account_id = 0;
                                $this->_sendResponse(200, CJSON::encode(array('results' => array($account), 'failed' => 1)));
                        }
                }
                
                $this->_sendMessageModeNotImplemented('authenticate');
        }
        
	public function actionList()
	{
		// Get the respective model instance
		$model = $_GET['model'];
		
		$this->_checkAuth($model, 'list');
		$model = ucfirst($model); // IMPORTANT
		
		// check if this model exists
		if (class_exists($model)) {
			// check if this model allows List API
			if ($this->_modelAllowsAPI($model, 'list')) {
				//$models = $model::model()->findAll();
				$models = call_user_func("$model::apiList");
			} else {
				// Model not implemented error
				$this->_sendMessageModeNotImplemented($model);
				Yii::app()->end();
			}
		} else {
			// Model not implemented error
			$this->_sendMessageNoSuchModel($model);
			Yii::app()->end();
		}
		
		// Did we get some results?
		if(empty($models)) {
			// No
			$this->_sendMessageNoItemFound($model);
		} else {
			// Prepare response
			$rows = array();
			foreach($models as $model)
				$rows[] = $model->attributes;
			// Send the response
			$this->_sendResponse(200, CJSON::encode(array('results' => $rows)));
		}
	}
	
	public function actionView()
	{
		$model = $_GET['model'];
		
		$this->_checkAuth($model, 'view');
		$model = ucfirst($model); // IMPORTANT
		
		// Check if id was submitted via GET
		if(!isset($_GET['id']))
			$this->_sendResponse(500, 'Error: Parameter <b>id</b> is missing' );
		
		if (class_exists($model)) {
			// check if this model allows view api
			if ($this->_modelAllowsAPI($model, 'view')) {
				$found_model = $model::model()->findByPk($_GET['id']);
			} else {
				$this->_sendMessageModeNotImplemented($model);
				Yii::app()->end();
			}				
		} else {
			$this->_sendMessageNoSuchModel($model);
		}
		
		// Did we find the requested model? If not, raise an error
		if(is_null($found_model))
			$this->_sendMessageNoItemFound($model);
		else
			$this->_sendResponse(200, CJSON::encode(array('results' => array($found_model))));
	}
	
	public function actionCreate()
	{
		$model = $_GET['model'];
		
		$this->_checkAuth($model, 'create');	
		$model = ucfirst($model); // IMPORTANT	
		
		if (class_exists($model)) {
			// check if this model allows view api
			
			if ($this->_modelAllowsAPI($model, 'create')) {
				
				$modelObject = new $model;
				
				// Try to assign POST values to attributes
				foreach($_POST as $var => $value) {
					//$this->_sendResponse(500,"OK==========================" . $modelObject->hasAttribute($var));
					// Does the model have this attribute? If not raise an error
					if($modelObject->hasAttribute($var))
                        $modelObject->$var = $value;
					/**else
						$this->_sendResponse(500,
								sprintf('%s is not allowed', $var,
										$_GET['model']) );**/
				}
				// Try to save the model
				if($modelObject->save())
				{
					//$modelObject->apiEmailNotification('create');
					$this->_sendResponse(200, CJSON::encode($modelObject));
				}
				else {
					// Errors occurred
					$msg = "<h1>Error</h1>";
					$msg .= sprintf("Couldn't create <b>%s</b>", $_GET['model']);
					$msg .= "<ul>";
					
					// generating errors details
					foreach($modelObject->errors as $attribute=>$attr_errors) {
						$msg .= "<li>Attribute: $attribute</li>";
						$msg .= "<ul>";
						foreach($attr_errors as $attr_error)
							$msg .= "<li>$attr_error</li>";
						$msg .= "</ul>";
					}
					
					$msg .= "</ul>";
					$this->_sendResponse(500, $msg );
				}
			} else {
				$this->_sendMessageModeNotImplemented($model);
				Yii::app()->end();
			}
		} else {
			$this->_sendMessageNoSuchModel($model);
		}
	}
        
        public function actionCreateAccount()
	{
		$model = 'Account';
                $modelProfile = new AccountProfile();
                $modelProfile->account_profile_surname = "Sername";
                $modelProfile->account_profile_given_name = "Give Name";
                $modelProfile->account_profile_company_name = "Company Name";
                
		
		$this->_checkAuth($model, 'create');	
		$model = ucfirst($model); // IMPORTANT	
		
		if (class_exists($model)) {
			// check if this model allows view api
			
			if ($this->_modelAllowsAPI($model, 'create')) {
				
				$modelObject = new $model;
                                $modelObject->account_status=1;
				
				// Try to assign POST values to attributes
				foreach($_POST as $var => $value) {
					//$this->_sendResponse(500,"OK==========================" . $modelObject->hasAttribute($var));
					// Does the model have this attribute? If not raise an error
					if($modelObject->hasAttribute($var))
                        $modelObject->$var = $value;
					/**else
						$this->_sendResponse(500,
								sprintf('%s is not allowed', $var,
										$_GET['model']) );**/
				}
				// Try to save the model
				if($modelObject->save())
				{
                                        $modelObject->account_id;
                                        $modelProfile->account_id = $modelObject->account_id;
                                        $modelProfile->account_profile_preferred_display_name 
                                                = $modelProfile->account_profile_given_name . ' ' . $modelProfile->account_profile_surname;
                                        $modelProfile->save();
					$modelObject->apiEmailNotification('create');
					//$this->_sendResponse(200, CJSON::encode($modelObject));
                                        echo SUCCESS;
				}
				else {
					// Errors occurred
					$msg = "<h1>Error</h1>";
					$msg .= sprintf("Couldn't create <b>%s</b>", $_GET['model']);
					$msg .= "<ul>";
					
					// generating errors details
					foreach($modelObject->errors as $attribute=>$attr_errors) {
						$msg .= "<li>Attribute: $attribute</li>";
						$msg .= "<ul>";
						foreach($attr_errors as $attr_error)
							$msg .= "<li>$attr_error</li>";
						$msg .= "</ul>";
					}
					
					$msg .= "</ul>";
					$this->_sendResponse(500, $msg );
				}
			} else {
				$this->_sendMessageModeNotImplemented($model);
				Yii::app()->end();
			}
		} else {
			$this->_sendMessageNoSuchModel($model);
		}
	}
        
	public function actionUpdate()
	{
		$model = $_GET['model'];
		
		$this->_checkAuth($model, 'update');
		$model = ucfirst($model); // IMPORTANT
        
		
		if (class_exists($model)) {
			// check if this model allows view api
			
			if ($this->_modelAllowsAPI($model, 'update')) {
				
				$modelObject = $model::model()->findByPk($_GET['primary_key']);
				
				// Try to assign POST values to attributes
				foreach($_POST as $var => $value) {
					// Does the model have this attribute? If not raise an error
					if($modelObject->hasAttribute($var))
						$modelObject->$var = $value;
					else
						$this->_sendResponse(500,
                                             sprintf('%s is not allowed', $var,
                                                     $_GET['model']) );
				}
                
				// Try to save the model
				if($modelObject->save())
				{
					$this->_sendResponse(200, CJSON::encode($modelObject));
				}
				else {
					// Errors occurred
					$msg = "<h1>Error</h1>";
					$msg .= sprintf("Couldn't update <b>%s</b>", $_GET['model']);
					$msg .= "<ul>";
					
					// generating errors details
					foreach($modelObject->errors as $attribute=>$attr_errors) {
						$msg .= "<li>Attribute: $attribute</li>";
						$msg .= "<ul>";
						foreach($attr_errors as $attr_error)
                        $msg .= "<li>$attr_error</li>";
						$msg .= "</ul>";
					}
					
					$msg .= "</ul>";
					$this->_sendResponse(500, $msg );
				}
			} else {
				$this->_sendMessageModeNotImplemented($model);
				Yii::app()->end();
			}
		} else {
			$this->_sendMessageNoSuchModel($model);
		}
	}
    
	public function actionDelete()
	{
		$model = $_GET['model'];
		
		$this->_checkAuth($model, 'delete');
		$model = ucfirst($model); // IMPORTANT
	}
	
	public function actionEmailExists()
	{
		// verify
		// as long as caller is from the same domain as us, we allow this call
		if ($this->callerIsSameDomain() === FALSE)
			return;
			
		if (isset($_GET['email']))
		{
			$email = $_GET['email'];
			$account = Account::model()->find('account_email = :email', array(':email' => $_GET['email']));
			
			if ($account && $account->account_id > 0)
				$this->_sendResponse(200, CJSON::encode(array('results' => array('email_exists' => 'yes'))));
			else 
				$this->_sendResponse(200, CJSON::encode(array('results' => array('email_exists' => 'no'))));
		} else {
			$this->_sendResponse(500, CJSON::encode(array('results' => array('error' => 'cannot find param'))));
		}
		
	}

	private function _sendResponse($status = 200, $body = '', $content_type = 'application/json')
	{
		// set the status
		$status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
		header($status_header);

		if($status == 200)
		{
			// send the body
			// and the content type
			header('Content-type: ' . $content_type);
			echo $body;
		}
		// we need to create the body if none is passed
		else
		{
			// create some body messages
			$message = '';

			// this is purely optional, but makes the pages a little nicer to read
			// for your users.  Since you won't likely send a lot of different status codes,
			// this also shouldn't be too ponderous to maintain
			switch($status)
			{
				case 401:
					$message = 'You must be authorized to view this page.';
					break;
				case 404:
					$message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
					break;
				case 500:
					$message = 'The server encountered an error processing your request.';
					break;
				case 501:
					$message = 'The requested method is not implemented.';
					break;
			}

			// servers don't always have a signature turned on
			// (this is an apache directive "ServerSignature On")
			$signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

			// this should be templated 
			/**$full_body = '
					<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
					<html>
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
					<title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
							</head>
							<body>
							<h1>' . $this->_getStatusCodeMessage($status) . '</h1>
									<p>' . $message . '</p>
									<p>' . $body . '</p>
											<hr />
											<address>' . $signature . '</address>
													</body>
													</html>';

			echo $full_body;**/
                        echo CJSON::encode(array('results' => array('errorCode' => $status, 'message' => addslashes("$message. $body"))));
		}
		Yii::app()->end();
	}
	
	private function _getStatusCodeMessage($status)
	{
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
	
	private function _checkAuth($model, $action)
	{
		// Check App ID
		if (!isset($_SERVER['HTTP_LINX_APPLICATION_ID']) 
				|| $_SERVER['HTTP_LINX_APPLICATION_ID'] != APPLICATION_ID)
		{
			$this->_sendResponse(401, 'You do not possess the right APP ID');
			exit;
		}
		
		// if public api, allow right away
		if ($this->isPublicAPI($model, $action))
			return true;
		
                // check if user is already logged in
                if (!Yii::app()->user->isGuest && Yii::app()->user->id > 0)
                        return true;
		// Check if we have the EMAIL and PASSWORD HTTP headers set?
//		if(!(isset($_SERVER['HTTP_LINX_ACCOUNT_EMAIL']))) {
//			// Error: Unauthorized
//			$this->_sendResponse(401, 'Please provide login credentials.');
//			exit;
//		}
//		if(!isset($_SERVER['HTTP_LINX_PASSWORD'])) {
//			// Error: Unauthorized
//			$this->_sendResponse(401, 'Please provide login credentials.');
//			exit;
//		}
//		$account_email = $_SERVER['HTTP_LINX_ACCOUNT_EMAIL'];
//		$password = $_SERVER['HTTP_LINX_PASSWORD'];
//		
//		// Find the user
//		$account = Account::model()->find('LOWER(account_email) = ?',array(strtolower($account_email)));
//		if($account === null) {
//			// Error: Unauthorized
//			$this->_sendResponse(401, 'Error: Account Email is invalid');
//			exit;
//		} else if(!$account->validatePassword($password)) {
//			// Error: Unauthorized
//			$this->_sendResponse(401, 'Error: Account Password is invalid');
//			exit;
//		}
		
		return true;
	}
	
	/**
	 * check if the caller of our API is from the same domain or not
	 */
	private function callerIsSameDomain()
	{
		return strstr(Yii::app()->getBaseUrl(true), $_SERVER['SERVER_NAME']);
	}
	
	/**
	 * 
	 * @param unknown $model	Model to check 
	 * @param unknown $action	Action to check if available for this model: 
	 * 							list, view, create, update, delete (IMPORTANT: all SMALLCAPS)
	 * 							This method will capitalize the first character
	 * @return boolean
	 */
	private function _modelAllowsAPI($model, $action) {
		$method = 'apiAllows' . ucfirst($action);
		//return call_user_func("$model::$method");
		
		return (method_exists($model, $method) && call_user_func("$model::$method"));
	}
	
	/**
	 * 
	 * @param unknown $model
	 */
	private function _sendMessageNoSuchModel($model) {
		$this->_sendResponse(501, sprintf(
				'Error: No such model <b>%s</b>',
				$model));
	}
	
	/**
	 *
	 * @param unknown $model
	 */
	private function _sendMessageModeNotImplemented($model) {
		$this->_sendResponse(501, sprintf(
				'Error: Mode <b>list</b> is not implemented for model <b>%s</b>',
				$model));
	}
	
	/**
	 *
	 * @param unknown $model
	 */
	private function _sendMessageNoItemFound($model) {
		$this->_sendResponse(200,
					CJSON::encode($this->_messageIntoArray('No items where found for model' . $model)));
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
	
	/**
	 * Check if an API is public
	 * 
	 * @param unknown $model
	 * @param unknown $action
	 * 
	 */
	private function isPublicAPI($model, $action)
	{
		// caller doesn't have the correct key
		// return false
		if (!isset($_SERVER['HTTP_LINX_PUBLIC_KEY'])
				|| $_SERVER['HTTP_LINX_PUBLIC_KEY'] != API_PUBLIC_KEY)
			return false;
		
		// if model has no public api return false
		if (!isset($this->public_apis[$model]))
			return false;
		
		// check if action is listed as a public api of this model
		$model_public_actions = explode(',', $this->public_apis[$model]);
		if (in_array($action, $model_public_actions))
			return true;
		
		return false;
	}
}