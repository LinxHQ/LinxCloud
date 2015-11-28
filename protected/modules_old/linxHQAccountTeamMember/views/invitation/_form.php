<?php
/* @var $this AccountInvitationController */
/* @var $model AccountInvitation */
/* @var $form CActiveForm */
?>

<div class="form">

<?php 
/**
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'account-invitation-form',
	'enableAjaxValidation'=>false,
));**/
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'issue-form',
		'htmlOptions' => array('class'=>'well'),
		'enableAjaxValidation'=>false,
));

?>
<fieldset>

	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->textFieldRow($model,'account_invitation_to_email',array('style'=> 'width: 500px;','maxlength'=>255, 'hint'=>'Multiple emails separated by comma.')); ?>
	<?php echo $form->textAreaRow($model, "account_invitation_message", array('style'=> 'width: 600px; height: 150px;')); ?>
	<?php echo $form->dropDownListRow($model, 'application_id', 
                CHtml::listData(LinxHQSysApplication::model()->getActiveApplications(), 'application_id', 'application_full_name')
                );?>
	<?php echo $form->dropDownListRow($model, 'account_invitation_type', array(-1=>'API call required')); ?>
	<?php echo $form->dropDownListRow($model, 'account_invitation_entity_to_join', array(-1=>'API call required'));?>
	
	<?php //echo $form->error($model,'account_invitation_to_email'); ?>
</fieldset>
	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Invite' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->