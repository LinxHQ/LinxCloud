<?php
/* @var $this LinxAppController */
/* @var $model LinxApp */

$this->breadcrumbs=array(
	'Linx Apps'=>array('index'),
	$model->app_id,
);

$this->menu=array(
	array('label'=>'List LinxApp', 'url'=>array('index')),
	array('label'=>'Create LinxApp', 'url'=>array('create')),
	array('label'=>'Update LinxApp', 'url'=>array('update', 'id'=>$model->app_id)),
	array('label'=>'Delete LinxApp', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->app_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LinxApp', 'url'=>array('admin')),
);
?>

<h1>View LinxApp #<?php echo $model->app_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'app_id',
		'app_name',
		'app_gui_name',
		'app_short_description',
		'app_secret_identity',
	),
)); ?>
