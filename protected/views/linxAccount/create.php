<?php
/* @var $this LinxAccountController */
/* @var $model LinxAccount */

$this->breadcrumbs=array(
	'Linx Accounts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LinxAccount', 'url'=>array('index')),
	array('label'=>'Manage LinxAccount', 'url'=>array('admin')),
);
?>

<h1>Create LinxAccount</h1>

<?php $this->renderPartial('_form', array(
    'model'=>$model, 
    'accountProfileModel' => $accountProfileModel,
    'linxApp' => $linxApp)); ?>