<?php

class LinxAccountController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('activate'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create', 'index', 'view','update', 'updatePassword', 'admin','updateStatus'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'testEmail'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
                $account = $this->loadModel($id);
		
		// check permission
                // if viewing other user, check if this user is root admin or 
                // if it has type as user administrator or not
                if ($id != Yii::app()->user->id)
                {
                    if (!LinxPermission::isRoot()
                            && !LinxPermission::can(LinxPermission::ACCOUNT_VIEW_ANY))
                    {
                        throw new CHttpException(404,'You are not authorized to perform this action.');
                    }
                }
		
		$attributes_array = array();
		if ($account != null) {
			$attributes_array = $account->attributes;
		}
		
		// get profile
		$profile = LinxAccountProfile::model()->getProfile($account->account_id);
		
		$this->render('view',array(
		 		'model'=> $account,
		 		'profile'=> $profile,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                // Permission check
                if (!LinxPermission::can(LinxPermission::ACCOUNT_ADD))
                {
                    throw new CHttpException(404,'You are not authorized to perform this action.');
                }
		
		$model=new LinxAccount();
		$accountProfile = new LinxAccountProfile();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		/**
		 * Process form's submission
		 * param's name must be in this format, e.g. "Account[account_email]"
		 */
                $save_result ='';
		if(isset($_POST['LinxAccount']))
		{
			$model->attributes=$_POST['LinxAccount'];
			$model->account_id = null;
			
			$accountProfile->attributes = $_POST['LinxAccountProfile'];
			$model->accountProfileModel = $accountProfile;

			// SAVE ACCOUNT
			//$model->account_password = $model->hashPassword($model->account_password);
			$model->account_status = LinxAccount::ACCOUNT_STATUS_ACTIVATED;// ACCOUNT_STATUS_NOT_ACTIVATED;
			
			$save_result = '';
                        $save_apilcicle_result = '';
                        $save_apilbooks_result = '';
                        $url_linxblue = '';
                        $url_linxowncloud = '';
                        $url_linxhrm='';
			// save user account record to database
			$save_result = $model->save();
			
			if ($save_result) {				
				// create account profile
				$accountProfile->account_id = $model->account_id;
				$accountProfile->account_profile_fullname 
					= $accountProfile->account_profile_given_name . ' ' . $accountProfile->account_profile_surname;
				$accountProfile->save();
                                
                                // prefill initial permission
                                LinxPermission::setDefault($model->account_id, $model->account_type);
                                
                                // save app access info
                                if ($_POST['LinxApp'])
                                {
                                    $selected_apps = $_POST['LinxApp']['app_gui_name'];
                                    if(count($selected_apps)>0 && is_array($selected_apps))
                                    {
                                        foreach ($selected_apps as $app_id)
                                        {
                                            $appAccess = new LinxAppAccessList;
                                            $appAccess->al_app_id = $app_id;
                                            $appAccess->al_account_id = $model->account_id;
                                            $appAccess->al_access_code = LinxPermission::LINX_PERMISSION_ALLOWED;
                                            $appAccess->save();
                                        }
                                    }
                                }
                                
				// notify user through email
				//$model->sendSuccessfulSignupEmailNotification();
                                
                                
                            
			}
			// redirect to view
			if($save_result){
                            /**Goi API Create Account của các APP**/
                            $url_linxcircle ='http://localhost:8080/linxcicle/index.php/api/CreateAccount/model';
                            $url_linxbooks ='http://localhost:8080/linxbooks/index.php/api/CreateAccount/model';
                            $url_linxblue ='http://localhost:8080/linxblue/index.php/api/CreateAccount/model';
                            $url_linxowncloud ='http://localhost/linxowncloud/api/create_account.php';
                            $url_linxhrm ='http://localhost/linxhrm/api/create_account.php';
                            $fields = array(
                                        'account_password'=>$_POST['LinxAccount']['account_password'],
                                        'account_email'=>$model->account_username,
                                        'account_id'=>$model->account_id
                                    );
                            $save_apilcicle_result = LinxHQCurl::callRemoteAPI($url_linxcircle, $fields);
                            $save_apilbooks_result = LinxHQCurl::callRemoteAPI($url_linxbooks, $fields);
                            $save_apilblue_result = LinxHQCurl::callRemoteAPI($url_linxblue, $fields);
                            
                            /////
                            $data_user_zurmo = Array
                                       (
                                           'firstName' => $accountProfile->account_profile_given_name,
                                           'lastName' => $accountProfile->account_profile_surname,
                                           'username' => $model->account_username,
                                           'password' => $_POST['LinxAccount']['account_password'],
                                           'language' => 'en',
                                           'timeZone' => 'America/Chicago',
                                       );
                            $callApiZurmo = new CallApiZurmo();
                            $callApiZurmo->zurmoCreateUser($data_user_zurmo);
                            
                            ////
                            $data_owncloud = array(
                                'userid'=>$model->account_username
                            );
                            $save_apionwcloud_result = LinxHQCurl::callRemoteAPI($url_linxowncloud, $data_owncloud);
                            
                            ////
                            $data_linxhrm = array(
                                'userid'=>$model->account_id,
                                'username'=>$model->account_username,
                            );
                            $save_apionwcloud_result = LinxHQCurl::callRemoteAPI($url_linxhrm, $data_linxhrm);
                            
                            
                            $this->redirect(array('view','id'=>$model->account_id));
			}
                        else{
                            // get list of apps
                            $linxApp = new LinxApp;

                            $data = array(
                                    'model' => $model,
                                    'accountProfileModel' => $accountProfile,
                                    'linxApp' => $linxApp,
                            );
                            //Utilities::render($this, 'create', $data);
                            $this->render('create',$data);
                        }
		}
                else{

                    // get list of apps
                    $linxApp = new LinxApp;

                    $data = array(
                            'model' => $model,
                            'accountProfileModel' => $accountProfile,
                            'linxApp' => $linxApp,
                    );
                    //Utilities::render($this, 'create', $data);
                    $this->render('create',$data);
                }

	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$accountProfile = new LinxAccountProfile();
		
		// check permission
		// check other permission
                if (!LinxPermission::can(LinxPermission::ACCOUNT_UPDATE_ANY))
                {
                    throw new CHttpException(403,'You are not allowed to perform this action.');
                }
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LinxAccount']))
		{
			$model->attributes=$_POST['LinxAccount'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->account_id));
		}

		$this->render('update',array(
			'model'=>$model,
			'accountProfileModel' => $accountProfile,
		));
	}
        
        public function actionUpdatePassword($id)
	{
		$model=$this->loadModel($id);
		
		// check permission
		if (!LinxPermission::can(LinxPermission::ACCOUNT_PASSWORD_UPDATE_ANY) // can update any
                    && !(LinxPermission::can(LinxPermission::ACCOUNT_PASSWORD_UPDATE_OWN) && $id == Yii::app()->user->id)) // or can update own
                {
                    //echo LinxPermission::can(LinxPermission::ACCOUNT_PASSWORD_UPDATE_OWN) . "::::" . $id == Yii::app()->user->id;
                    throw new CHttpException(404,'You are not authorized for this action.');
                }
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['LinxAccount']))
		{
			$model->attributes=$_POST['LinxAccount'];
			$result = $model->updatePassword();
			if($result == true)
			{
				$this->redirect(array('view','id'=>$model->account_id));
			}
		}
		
		$this->render('_form_changepassword',array(
				'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
//	public function actionDelete($id)
//	{
//            if ($id == 1) 
//            {
//                throw new CHttpException(404,'You are not allowed to delete the root account.');
//            }
//            
//            // check other permission
//            if (!LinxPermission::can(LinxPermission::ACCOUNT_DELETE_ANY))
//            {
//                throw new CHttpException(403,'You are not allowed to perform this action.');
//            }
//		$this->loadModel($id)->delete();
//
//		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//		if(!isset($_GET['ajax']))
//			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('LinxAccount');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LinxAccount('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LinxAccount']))
			$model->attributes=$_GET['LinxAccount'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
        /**
	 * Activate newly signed up account
	 * @param string $id	ID of this account
	 * @param string $key	Activation key
	 */
	public function actionActivate($id, $key) {
		$account = $this->loadModel($id);
		$status = false;
		
		$message = '';
		if ($account->account_id) {
			
			if ($account->isActivated()) {
				$status = false;
				$message = "Account is already activated.";
			} else {
				$status = $account->activateAccount($key);
				if ($status == false)
					$message = "Account activation failed. Please contact the Administrator.";
				
				//$message = "ID: " . $account->account_id . ". Current Status: " . $account->account_status 
				//	. "Given key $key and actual key " . $account->getActivationKey();
			}
		} else {
			$message = 'Cannot find account';
		}
		
		$this->render('activation',array(
				'activation_status' => $status,
				'activation_message' => $message,
				'account' => $account,
		));
	}
        
	public function actionUpdateStatus()
	{
		// check permission
		// check other permission
                if (!LinxPermission::can(LinxPermission::ACCOUNT_UPDATE_ANY))
                {
                    throw new CHttpException(403,'You are not allowed to perform this action.');
                }
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['account_id']))
		{
                        $model=$this->loadModel($_POST['account_id']);
			if($model->account_status==1)
                            $model->account_status = 0;
                        else
                            $model->account_status = 1;
                        
			if($model->save())
                            echo '{"status":"success"}';
                        else
                            echo '{"status":"fail"}';
		}
//                else
//                    echo '{"status":"fail"}';
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LinxAccount the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LinxAccount::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LinxAccount $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='linx-account-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
