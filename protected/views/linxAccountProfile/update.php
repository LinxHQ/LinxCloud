<?php
/* @var $this LinxAccountProfileController */
/* @var $model LinxAccountProfile */

$this->breadcrumbs=array(
	'Linx Account Profiles'=>array('index'),
	$model->account_profile_id=>array('view','id'=>$model->account_profile_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LinxAccountProfile', 'url'=>array('index')),
	array('label'=>'Create LinxAccountProfile', 'url'=>array('create')),
	array('label'=>'View LinxAccountProfile', 'url'=>array('view', 'id'=>$model->account_profile_id)),
	array('label'=>'Manage LinxAccountProfile', 'url'=>array('admin')),
);
?>

<h1>Update LinxAccountProfile <?php echo $model->account_profile_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>