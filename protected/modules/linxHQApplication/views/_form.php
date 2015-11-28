<?php
/* @var $this SysApplicationController */
/* @var $model SysApplication */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sys-application-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'vendor_id'); ?>
		<?php echo $form->textField($model,'vendor_id'); ?>
		<?php echo $form->error($model,'vendor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'application_full_name'); ?>
		<?php echo $form->textField($model,'application_full_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'application_full_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'application_ui_name'); ?>
		<?php echo $form->textField($model,'application_ui_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'application_ui_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'application_reg_date'); ?>
		<?php echo $form->textField($model,'application_reg_date'); ?>
		<?php echo $form->error($model,'application_reg_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'application_secret_key'); ?>
		<?php echo $form->textField($model,'application_secret_key',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'application_secret_key'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->