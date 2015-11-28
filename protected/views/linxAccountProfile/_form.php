<?php
/* @var $this LinxAccountProfileController */
/* @var $model LinxAccountProfile */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'linx-account-profile-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'account_profile_fullname'); ?>
		<?php echo $form->textField($model,'account_profile_fullname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'account_profile_fullname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'account_profile_given_name'); ?>
		<?php echo $form->textField($model,'account_profile_given_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'account_profile_given_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'account_profile_surname'); ?>
		<?php echo $form->textField($model,'account_profile_surname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'account_profile_surname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'account_profile_dob'); ?>
		<?php echo $form->textField($model,'account_profile_dob'); ?>
		<?php echo $form->error($model,'account_profile_dob'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->