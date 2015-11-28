<?php
/* @var $this LinxAppAccessListController */
/* @var $model LinxAppAccessList */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'al_id'); ?>
		<?php echo $form->textField($model,'al_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'al_app_id'); ?>
		<?php echo $form->textField($model,'al_app_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'al_account_id'); ?>
		<?php echo $form->textField($model,'al_account_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'al_access_code'); ?>
		<?php echo $form->textField($model,'al_access_code'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->