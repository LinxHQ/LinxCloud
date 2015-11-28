<?php
/* @var $this LinxAppController */
/* @var $data LinxApp */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('app_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->app_id), array('view', 'id'=>$data->app_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('app_name')); ?>:</b>
	<?php echo CHtml::encode($data->app_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('app_gui_name')); ?>:</b>
	<?php echo CHtml::encode($data->app_gui_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('app_short_description')); ?>:</b>
	<?php echo CHtml::encode($data->app_short_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('app_secret_identity')); ?>:</b>
	<?php echo CHtml::encode($data->app_secret_identity); ?>
	<br />


</div>