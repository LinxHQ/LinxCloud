<?php
/* @var $this SysApplicationController */
/* @var $model SysApplication */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'application_id'); ?>
		<?php echo $form->textField($model,'application_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vendor_id'); ?>
		<?php echo $form->textField($model,'vendor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'application_full_name'); ?>
		<?php echo $form->textField($model,'application_full_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'application_ui_name'); ?>
		<?php echo $form->textField($model,'application_ui_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'application_reg_date'); ?>
		<?php echo $form->textField($model,'application_reg_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'application_secret_key'); ?>
		<?php echo $form->textField($model,'application_secret_key',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->