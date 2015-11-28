<?php
/* @var $this LinxAccountProfileController */
/* @var $model LinxAccountProfile */

$this->breadcrumbs=array(
	'Linx Account Profiles'=>array('index'),
	$model->account_profile_id,
);

$this->menu=array(
	array('label'=>'List LinxAccountProfile', 'url'=>array('index')),
	array('label'=>'Create LinxAccountProfile', 'url'=>array('create')),
	array('label'=>'Update LinxAccountProfile', 'url'=>array('update', 'id'=>$model->account_profile_id)),
	array('label'=>'Delete LinxAccountProfile', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->account_profile_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LinxAccountProfile', 'url'=>array('admin')),
);
?>

<h1>View LinxAccountProfile #<?php echo $model->account_profile_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'account_profile_id',
		'account_id',
		'account_profile_fullname',
		'account_profile_first_name',
		'account_profile_last_name',
		'account_profile_dob',
	),
)); ?>
