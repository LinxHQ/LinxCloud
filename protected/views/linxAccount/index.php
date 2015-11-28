<?php
/* @var $this LinxAccountController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Linx Accounts',
);

$this->menu=array(
	array('label'=>'Create LinxAccount', 'url'=>array('create')),
	array('label'=>'Manage LinxAccount', 'url'=>array('admin')),
);
?>

<h1>Linx Accounts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
