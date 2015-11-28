<?php
/* @var $this LinxConfigController */
/* @var $model LinxConfig */

$this->breadcrumbs=array(
	'Linx Configs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List LinxConfig', 'url'=>array('index')),
	array('label'=>'Create LinxConfig', 'url'=>array('create')),
	array('label'=>'Update LinxConfig', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LinxConfig', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LinxConfig', 'url'=>array('admin')),
);
?>

<h1>View LinxConfig #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'lc_name',
		'lc_value',
	),
)); ?>
