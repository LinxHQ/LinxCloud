<?php
/* @var $this LinxAccountController */
/* @var $model LinxAccount */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'account_id'); ?>
		<?php echo $form->textField($model,'account_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_username'); ?>
		<?php echo $form->textField($model,'account_username',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_last_update'); ?>
		<?php echo $form->textField($model,'account_last_update'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_created_date'); ?>
		<?php echo $form->textField($model,'account_created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_status'); ?>
		<?php echo $form->textField($model,'account_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->