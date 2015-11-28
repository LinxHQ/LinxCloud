<?php
/* @var $this LinxAccountController */
/* @var $model LinxAccount */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'linx-account-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php 
        echo $form->errorSummary($model); 
        
        echo '<h5>Account Information</h5>';
        echo $form->textFieldRow($model,'account_username',array('size'=>60,'maxlength'=>100));
        //echo $form->passwordFieldRow($model,'account_password',array('size'=>60,'maxlength'=>100)); 
        
        // add new account fields
	if ($model->isNewRecord)
	{
                echo $form->passwordFieldRow($model,'account_password',array('size'=>60,'maxlength'=>100)); 
                echo $form->dropDownListRow($model, 'account_type', LinxPermission::model()->account_types );
                
                echo '<h5>Personal Details</h5>';
		echo $form->textFieldRow($accountProfileModel,'account_profile_given_name',
				array('size'=>60,'maxlength'=>255) + (isset($_GET['ajax']) ? $iframe_input_style : array())); 
		echo $form->textFieldRow($accountProfileModel,'account_profile_surname',
				array('size'=>60,'maxlength'=>255) + (isset($_GET['ajax']) ? $iframe_input_style : array()));
                
                echo '<h5>Apps Access</h5>';
                echo $form->checkBoxList($linxApp, 'app_gui_name', CHtml::listData($linxApp->search()->getData(), 'app_id', 'app_gui_name'));
	} // end showing fields for adding new account
                
        echo '<div style="clear: both;"></div>';
        echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); 
        ?>

<?php $this->endWidget(); ?>

</div><!-- form -->