<?php
/* @var $this LinxAppAccessListController */
/* @var $model LinxAppAccessList */

$this->breadcrumbs=array(
	'Linx App Access Lists'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LinxAppAccessList', 'url'=>array('index')),
	array('label'=>'Manage LinxAppAccessList', 'url'=>array('admin')),
);
?>

<h1>Create LinxAppAccessList</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>