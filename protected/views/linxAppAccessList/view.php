<?php
/* @var $this LinxAppAccessListController */
/* @var $model LinxAppAccessList */

$this->breadcrumbs=array(
	'Linx App Access Lists'=>array('index'),
	$model->al_id,
);

$this->menu=array(
	array('label'=>'List LinxAppAccessList', 'url'=>array('index')),
	array('label'=>'Create LinxAppAccessList', 'url'=>array('create')),
	array('label'=>'Update LinxAppAccessList', 'url'=>array('update', 'id'=>$model->al_id)),
	array('label'=>'Delete LinxAppAccessList', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->al_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LinxAppAccessList', 'url'=>array('admin')),
);
?>

<h1>View LinxAppAccessList #<?php echo $model->al_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'al_id',
		'al_app_id',
		'al_account_id',
		'al_access_code',
	),
)); ?>
