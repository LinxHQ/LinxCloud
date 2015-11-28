<?php
/* @var $this AccountController */
/* @var $model Account */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'account-form',
	'enableAjaxValidation'=>false,
)); ?>

<fieldset>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); 
        
        // Show (selected) application
        /**
	echo $form->dropDownListRow($accountSubscriptionModel, 'application_id', 
            CHtml::listData($sysApplication->getActiveApplications(),
                    'application_id','application_full_name'),
                array('onchange'=>'javascript: $("#account-form").submit();')); 
        
        // Show (selected) subscription packages of this application
        echo $form->dropDownListRow($accountSubscriptionModel, 'account_subscription_package_id', 
			$active_subscription_packages); 
        **/
        
        echo $form->textFieldRow($model,'account_email',
			array('size'=>60,'maxlength'=>255) + (isset($_GET['ajax']) ? $iframe_input_style : array()));
        
	// add new account fields
	if ($model->isNewRecord)
	{
		echo $form->textFieldRow($accountProfileModel,'account_profile_company_name',
				array('size'=>60,'maxlength'=>255) + (isset($_GET['ajax']) ? $iframe_input_style : array())); 
		echo $form->textFieldRow($accountProfileModel,'account_profile_given_name',
				array('size'=>60,'maxlength'=>255) + (isset($_GET['ajax']) ? $iframe_input_style : array())); 
		echo $form->textFieldRow($accountProfileModel,'account_profile_surname',
				array('size'=>60,'maxlength'=>255) + (isset($_GET['ajax']) ? $iframe_input_style : array())); 
		echo $form->passwordFieldRow($model,'account_password',
				array('size'=>60,'maxlength'=>255) + (isset($_GET['ajax']) ? $iframe_input_style : array())); 
		echo $form->hiddenField($model, 'account_timezone');
	} // end showing fields for adding new account
	else {
		// showing fields for updating account
		/**echo $form->textFieldRow($model,'account_timezone',
			array('size'=>60,'maxlength'=>255));**/
		echo $form->dropDownListRow($model, 'account_timezone', 
				LinxHQApplication::getTimeZoneListSource());
		echo $form->textFieldRow($model,'account_language',
			array('size'=>60,'maxlength'=>255));
	}
	?>
</fieldset>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Save'); ?>

<?php $this->endWidget(); ?>
</div>