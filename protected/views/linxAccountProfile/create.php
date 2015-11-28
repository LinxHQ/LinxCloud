<?php
/* @var $this LinxAccountProfileController */
/* @var $model LinxAccountProfile */

$this->breadcrumbs=array(
	'Linx Account Profiles'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LinxAccountProfile', 'url'=>array('index')),
	array('label'=>'Manage LinxAccountProfile', 'url'=>array('admin')),
);
?>

<h1>Create LinxAccountProfile</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>