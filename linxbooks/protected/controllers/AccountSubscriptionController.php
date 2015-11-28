<?php

class AccountSubscriptionController extends Controller
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
				'actions'=>array('view','inappSubscribe'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('update','create','index','admin','delete'),
				'users'=>array('@'),
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
		$model = $this->loadModel($id);
		
		// check permission
//		if (!Permission::checkPermission($model, PERMISSION_ACCOUNT_SUBSCRIPTION_VIEW))
//		{
//			throw new CHttpException(401,'You are not given the permission to view this page.');
//			return false;
//		}
		
		$this->render('view',array(
			'model'=>$model,
		));
	}
	
	public function actionInappSubscribe()
	{
		if (isset($_GET['package_id']))
		{
			$package_id = $_GET['package_id'];
			
			// check if this user is already subscribe to this package
			if (AccountSubscription::model()->isAlreadySubscribedToPackage($package_id))
			{
				$this->redirect(array('accountTeamMember/admin'));
			}
			
			// add subscription
			$accountSubscription = new AccountSubscription();
			$accountSubscription->account_id = Yii::app()->user->id;
			$accountSubscription->account_subscription_package_id = $package_id;
			$accountSubscription->account_subscription_start_date = date('Y-m-d H:i:s');
			$accountSubscription->account_subscription_status_id = ACCOUNT_SUBSCRIPTION_STATUS_ACTIVE;
			$accountSubscription->save();
			
			$this->redirect(array('accountTeamMember/admin'));
		}
		
		// no package id, go to home
		$this->redirect(array('project/index'));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new AccountSubscription;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AccountSubscription']))
		{
//			$model->attributes=$_POST['AccountSubscription'];
//			if($model->save())
//				$this->redirect(array('view','id'=>$model->account_subscription_id));
                    
//                    if (isset($_GET['package_id']))
//                    {
			$package_id = 4;
			
			// check if this user is already subscribe to this package
//			if (AccountSubscription::model()->isAlreadySubscribedToPackage($package_id))
//			{
//				$this->redirect(array('accountTeamMember/admin'));
//			}
			
			// add subscription
			$accountSubscription = new AccountSubscription();
			$accountSubscription->account_id = Yii::app()->user->id;
			$accountSubscription->account_subscription_package_id = $package_id;
			$accountSubscription->account_subscription_start_date = date('Y-m-d H:i:s');
			$accountSubscription->account_subscription_status_id = ACCOUNT_SUBSCRIPTION_STATUS_ACTIVE;
                        $accountSubscription->subscription_name = $_POST['AccountSubscription']['subscription_name'];
			
                        if($accountSubscription->save())
                            $this->redirect(array('accountTeamMember/admin'));
//                        }
		
//                        // no package id, go to home
//                        $this->redirect(array('project/index'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AccountSubscription']))
		{
			$model->attributes=$_POST['AccountSubscription'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		// DISABLE DELETE FOR NOW
		return false;
		
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('AccountSubscription');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new AccountSubscription('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AccountSubscription']))
			$model->attributes=$_GET['AccountSubscription'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AccountSubscription the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AccountSubscription::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AccountSubscription $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='account-subscription-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
