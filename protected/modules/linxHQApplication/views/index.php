<?php
/* @var $this SysApplicationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sys Applications',
);

$this->menu=array(
	array('label'=>'Create SysApplication', 'url'=>array('create')),
	array('label'=>'Manage SysApplication', 'url'=>array('admin')),
);
?>

<h1>Sys Applications</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
