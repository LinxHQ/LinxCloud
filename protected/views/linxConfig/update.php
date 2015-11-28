<?php
/* @var $this LinxConfigController */
/* @var $model LinxConfig */

$this->breadcrumbs=array(
	'Linx Configs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LinxConfig', 'url'=>array('index')),
	array('label'=>'Create LinxConfig', 'url'=>array('create')),
	array('label'=>'View LinxConfig', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LinxConfig', 'url'=>array('admin')),
);
?>

<h1>Update LinxConfig <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>