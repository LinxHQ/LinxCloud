<?php
/* @var $this SysApplicationController */
/* @var $model SysApplication */

$this->breadcrumbs=array(
	'Sys Applications'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List SysApplication', 'url'=>array('index')),
	array('label'=>'Create SysApplication', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#sys-application-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Sys Applications</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sys-application-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'application_id',
		'vendor_id',
		'application_full_name',
		'application_ui_name',
		'application_reg_date',
		'application_secret_key',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
