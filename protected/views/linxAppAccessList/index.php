<?php
/* @var $this LinxAppAccessListController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Linx App Access Lists',
);

$this->menu=array(
	array('label'=>'Create LinxAppAccessList', 'url'=>array('create')),
	array('label'=>'Manage LinxAppAccessList', 'url'=>array('admin')),
);
?>

<h1>Linx App Access Lists</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
