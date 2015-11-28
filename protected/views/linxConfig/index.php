<?php
/* @var $this LinxConfigController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Linx Configs',
);

$this->menu=array(
	array('label'=>'Create LinxConfig', 'url'=>array('create')),
	array('label'=>'Manage LinxConfig', 'url'=>array('admin')),
);
?>

<h1>Linx Configs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
