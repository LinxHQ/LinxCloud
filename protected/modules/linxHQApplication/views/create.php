<?php
/* @var $this SysApplicationController */
/* @var $model SysApplication */

$this->breadcrumbs=array(
	'Sys Applications'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SysApplication', 'url'=>array('index')),
	array('label'=>'Manage SysApplication', 'url'=>array('admin')),
);
?>

<h1>Create SysApplication</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>