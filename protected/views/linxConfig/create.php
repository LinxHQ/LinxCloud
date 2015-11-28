<?php
/* @var $this LinxConfigController */
/* @var $model LinxConfig */

$this->breadcrumbs=array(
	'Linx Configs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LinxConfig', 'url'=>array('index')),
	array('label'=>'Manage LinxConfig', 'url'=>array('admin')),
);
?>

<h1>Create LinxConfig</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>