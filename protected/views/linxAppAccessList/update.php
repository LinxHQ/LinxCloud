<?php
/* @var $this LinxAppAccessListController */
/* @var $model LinxAppAccessList */

$this->breadcrumbs=array(
	'Linx App Access Lists'=>array('index'),
	$model->al_id=>array('view','id'=>$model->al_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LinxAppAccessList', 'url'=>array('index')),
	array('label'=>'Create LinxAppAccessList', 'url'=>array('create')),
	array('label'=>'View LinxAppAccessList', 'url'=>array('view', 'id'=>$model->al_id)),
	array('label'=>'Manage LinxAppAccessList', 'url'=>array('admin')),
);
?>

<h1>Update LinxAppAccessList <?php echo $model->al_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>