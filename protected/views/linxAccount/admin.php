<?php
/* @var $this LinxAccountController */
/* @var $model LinxAccount */

/**
$this->breadcrumbs=array(
	'Linx Accounts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List LinxAccount', 'url'=>array('index')),
	array('label'=>'Create LinxAccount', 'url'=>array('create')),
);
**/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#linx-account-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Linx Accounts</h1>

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

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'linx-account-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'account_id',
		'account_username',
		//'account_password',
		'account_last_update',
		'account_created_date',
//		'account_status',
                array(
                    'header'=>'Active',
                    'type'=>'raw',
                    'value'=>'($data->account_status==1) ? '
                            . '"<a href=\"#\" onclick=\"updateStatusAccount($data->account_id); return false;\"><span class=\"icon-ok\"></span></a>" : '
                            . '"<a href=\"#\" onclick=\"updateStatusAccount($data->account_id); return false;\"><span class=\"icon-remove\"></span></a>"',
                ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
                    'template' => '{view}{update}',
		),
	),
)); ?>
<script>
    function updateStatusAccount(account_id)
    {
        $.ajax({
            url:'<?php echo YII::app()->createUrl('linxAccount/updateStatus'); ?>',
            type:'POST',
            data:{account_id:account_id},
            success:function(data){
                var responseJSON = jQuery.parseJSON(data);
                if(responseJSON.status=="success")
                    $.fn.yiiGridView.update('linx-account-grid');
            }
            
        });
    }
</script>