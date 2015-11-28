<?php
/* @var $this SysApplicationController */
/* @var $model SysApplication */

$this->breadcrumbs=array(
	'Sys Applications'=>array('index'),
	$model->application_id=>array('view','id'=>$model->application_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SysApplication', 'url'=>array('index')),
	array('label'=>'Create SysApplication', 'url'=>array('create')),
	array('label'=>'View SysApplication', 'url'=>array('view', 'id'=>$model->application_id)),
	array('label'=>'Manage SysApplication', 'url'=>array('admin')),
);
?>

<h1>Update SysApplication <?php echo $model->application_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>