<?php
/* @var $this LinxAppController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Linx Apps',
);

$this->menu=array(
	array('label'=>'Create LinxApp', 'url'=>array('create')),
	array('label'=>'Manage LinxApp', 'url'=>array('admin')),
);
?>

<h1>Linx Apps</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
