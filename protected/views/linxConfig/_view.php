<?php
/* @var $this LinxConfigController */
/* @var $data LinxConfig */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lc_name')); ?>:</b>
	<?php echo CHtml::encode($data->lc_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lc_value')); ?>:</b>
	<?php echo CHtml::encode($data->lc_value); ?>
	<br />


</div>