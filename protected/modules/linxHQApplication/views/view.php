<?php
/* @var $this SysApplicationController */
/* @var $model SysApplication */

$this->breadcrumbs=array(
	'Sys Applications'=>array('index'),
	$model->application_id,
);

$this->menu=array(
	array('label'=>'List SysApplication', 'url'=>array('index')),
	array('label'=>'Create SysApplication', 'url'=>array('create')),
	array('label'=>'Update SysApplication', 'url'=>array('update', 'id'=>$model->application_id)),
	array('label'=>'Delete SysApplication', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->application_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SysApplication', 'url'=>array('admin')),
);
?>

<h1>View SysApplication #<?php echo $model->application_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'application_id',
		'vendor_id',
		'application_full_name',
		'application_ui_name',
		'application_reg_date',
		'application_secret_key',
	),
)); ?>
