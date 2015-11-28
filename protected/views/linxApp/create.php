<?php
/* @var $this LinxAppController */
/* @var $model LinxApp */

$this->breadcrumbs=array(
	'Linx Apps'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LinxApp', 'url'=>array('index')),
	array('label'=>'Manage LinxApp', 'url'=>array('admin')),
);
?>

<h1>Create LinxApp</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>