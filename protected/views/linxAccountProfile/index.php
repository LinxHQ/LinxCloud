<?php
/* @var $this LinxAccountProfileController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Linx Account Profiles',
);

$this->menu=array(
	array('label'=>'Create LinxAccountProfile', 'url'=>array('create')),
	array('label'=>'Manage LinxAccountProfile', 'url'=>array('admin')),
);
?>

<h1>Linx Account Profiles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
