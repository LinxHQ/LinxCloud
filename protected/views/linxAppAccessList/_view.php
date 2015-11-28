<?php
/* @var $this LinxAppAccessListController */
/* @var $data LinxAppAccessList */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('al_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->al_id), array('view', 'id'=>$data->al_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('al_app_id')); ?>:</b>
	<?php echo CHtml::encode($data->al_app_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('al_account_id')); ?>:</b>
	<?php echo CHtml::encode($data->al_account_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('al_access_code')); ?>:</b>
	<?php echo CHtml::encode($data->al_access_code); ?>
	<br />


</div>