<?php
/* @var $this LinxAppController */
/* @var $model LinxApp */

$this->breadcrumbs=array(
	'Linx Apps'=>array('index'),
	$model->app_id=>array('view','id'=>$model->app_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LinxApp', 'url'=>array('index')),
	array('label'=>'Create LinxApp', 'url'=>array('create')),
	array('label'=>'View LinxApp', 'url'=>array('view', 'id'=>$model->app_id)),
	array('label'=>'Manage LinxApp', 'url'=>array('admin')),
);
?>

<h1>Update LinxApp <?php echo $model->app_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>