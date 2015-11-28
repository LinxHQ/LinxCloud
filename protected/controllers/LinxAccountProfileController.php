<?php

class LinxAccountProfileController extends Controller
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
				'actions'=>array('view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update', 'updatePhoto'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','index'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new LinxAccountProfile;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LinxAccountProfile']))
		{
			$model->attributes=$_POST['LinxAccountProfile'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->account_profile_id));
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

		if(isset($_POST['LinxAccountProfile']))
		{
			$model->attributes=$_POST['LinxAccountProfile'];
			if($model->save())
				$this->redirect(array('/linxAccount/view','id'=>$model->account_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
        
        /**
	 * update profile photos
	 * 
	 * @param unknown $id
	 */
	public function actionUpdatePhoto($id)
	{
		$model=$this->loadModel($id);
	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	
		if(isset($_POST['LinxAccountProfile']))
		{
			$model->account_profile_photo = CUploadedFile::getInstance($model,'account_profile_photo');
			if ($model->validateProfilePhoto())
			{
				$model->account_profile_photo->saveAs(Yii::app()->params['profilePhotosDir'] . $model->hashProfilePhotoName());
				
				$this->redirect(array('/linxAccount/view','id'=>$model->account_id));
			}
		}
	
		$this->render('_form_photo',array(
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
                // permission
                // only administrator can do this
                if (!LinxPermission::can(LinxPermission::ACCOUNT_DELETE_ANY))
                {
                    throw new CHttpException(404,'You are not allowed to perform this action.');
                }
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
		$dataProvider=new CActiveDataProvider('LinxAccountProfile');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LinxAccountProfile('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LinxAccountProfile']))
			$model->attributes=$_GET['LinxAccountProfile'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LinxAccountProfile the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LinxAccountProfile::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LinxAccountProfile $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='linx-account-profile-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
