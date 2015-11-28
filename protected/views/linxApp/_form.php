<?php
/* @var $this LinxAppController */
/* @var $model LinxApp */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'linx-app-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'app_name'); ?>
		<?php echo $form->textField($model,'app_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'app_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'app_gui_name'); ?>
		<?php echo $form->textField($model,'app_gui_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'app_gui_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'app_short_description'); ?>
		<?php echo $form->textField($model,'app_short_description',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'app_short_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'app_secret_identity'); ?>
		<?php echo $form->textField($model,'app_secret_identity',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'app_secret_identity'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'app_url'); ?>
		<?php echo $form->textField($model,'app_url',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'app_url'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->