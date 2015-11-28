<?php
/* @var $this LinxAppController */
/* @var $model LinxApp */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'app_id'); ?>
		<?php echo $form->textField($model,'app_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'app_name'); ?>
		<?php echo $form->textField($model,'app_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'app_gui_name'); ?>
		<?php echo $form->textField($model,'app_gui_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'app_short_description'); ?>
		<?php echo $form->textField($model,'app_short_description',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'app_secret_identity'); ?>
		<?php echo $form->textField($model,'app_secret_identity',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->