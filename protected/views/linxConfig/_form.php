<?php
/* @var $this LinxConfigController */
/* @var $model LinxConfig */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'linx-config-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'lc_name'); ?>
		<?php echo $form->textField($model,'lc_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'lc_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lc_value'); ?>
		<?php echo $form->textField($model,'lc_value',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'lc_value'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->