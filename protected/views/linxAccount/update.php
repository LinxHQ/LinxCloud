<?php
/* @var $this LinxAccountController */
/* @var $model LinxAccount */

$this->breadcrumbs=array(
	'Linx Accounts'=>array('index'),
	$model->account_id=>array('view','id'=>$model->account_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LinxAccount', 'url'=>array('index')),
	array('label'=>'Create LinxAccount', 'url'=>array('create')),
	array('label'=>'View LinxAccount', 'url'=>array('view', 'id'=>$model->account_id)),
	array('label'=>'Manage LinxAccount', 'url'=>array('admin')),
);
?>

<h1>Update LinxAccount <?php echo $model->account_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>