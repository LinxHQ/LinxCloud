<?php
/* @var $this LinxAccountProfileController */
/* @var $model LinxAccountProfile */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'account_profile_id'); ?>
		<?php echo $form->textField($model,'account_profile_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_id'); ?>
		<?php echo $form->textField($model,'account_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_profile_fullname'); ?>
		<?php echo $form->textField($model,'account_profile_fullname',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_profile_first_name'); ?>
		<?php echo $form->textField($model,'account_profile_first_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_profile_last_name'); ?>
		<?php echo $form->textField($model,'account_profile_last_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_profile_dob'); ?>
		<?php echo $form->textField($model,'account_profile_dob'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->