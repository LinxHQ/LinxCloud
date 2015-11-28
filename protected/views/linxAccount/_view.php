<?php
/* @var $this LinxAccountController */
/* @var $data LinxAccount */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->account_id), array('view', 'id'=>$data->account_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_username')); ?>:</b>
	<?php echo CHtml::encode($data->account_username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_password')); ?>:</b>
	<?php echo CHtml::encode($data->account_password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_last_update')); ?>:</b>
	<?php echo CHtml::encode($data->account_last_update); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_created_date')); ?>:</b>
	<?php echo CHtml::encode($data->account_created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_status')); ?>:</b>
	<?php echo CHtml::encode($data->account_status); ?>
	<br />


</div>