<?php
/* @var $this LinxAccountProfileController */
/* @var $data LinxAccountProfile */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_profile_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->account_profile_id), array('view', 'id'=>$data->account_profile_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_id')); ?>:</b>
	<?php echo CHtml::encode($data->account_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_profile_fullname')); ?>:</b>
	<?php echo CHtml::encode($data->account_profile_fullname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_profile_first_name')); ?>:</b>
	<?php echo CHtml::encode($data->account_profile_first_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_profile_last_name')); ?>:</b>
	<?php echo CHtml::encode($data->account_profile_last_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_profile_dob')); ?>:</b>
	<?php echo CHtml::encode($data->account_profile_dob); ?>
	<br />


</div>