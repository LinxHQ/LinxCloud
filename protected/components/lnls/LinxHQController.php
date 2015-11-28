<?php
class LinxHQController extends Controller
{
	public $layout='//layouts/column1';
	public $default_view_path = '';
	
	public function __construct($id, $module = null)
	{
		parent::__construct($id, $module);
		
		$this->default_view_path = $this->module->id . '.views.';
	}
	
	/**
	 * Use for updating a single field through inline editable
	 * such as jquery editable, bootstrap x-editable, etc.
	 *
	 * POST params
	 * pk	the primary key of this record
	 * name attribute name
	 * value value to be updated to
	 */
	public function actionAjaxUpdateField()
	{
		if (isset($_POST['pk']) && isset($_POST['name']) && isset($_POST['value']))
		{
			$id = $_POST['pk'];
			$attribute = $_POST['name'];
			$value = $_POST['value'];
	
			// get model
			$model = $this->loadModel($id);
			// update
			$model->$attribute = $value;
			return $model->save();
		}
	
		return false;
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Task the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		return null;
	}
}