<?php
/* @var $this SysApplicationController */
/* @var $data SysApplication */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('application_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->application_id), array('view', 'id'=>$data->application_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vendor_id')); ?>:</b>
	<?php echo CHtml::encode($data->vendor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('application_full_name')); ?>:</b>
	<?php echo CHtml::encode($data->application_full_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('application_ui_name')); ?>:</b>
	<?php echo CHtml::encode($data->application_ui_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('application_reg_date')); ?>:</b>
	<?php echo CHtml::encode($data->application_reg_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('application_secret_key')); ?>:</b>
	<?php echo CHtml::encode($data->application_secret_key); ?>
	<br />


</div>