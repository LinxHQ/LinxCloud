<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// list app that this user can access
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'linx-account-app-access-list-grid',
    'dataProvider' => LinxAppAccessList::getAllowedApp($linxAccount->account_id),
    'columns' => array(
        array(
            'type' => 'raw',
            'value' => '$data->linxApp->app_gui_name ? $data->linxApp->app_gui_name : ""'
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{delete}',
        ),
    ),
));

// form to add more
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'linx-account-form',
    'action'=>array('/linxAppAccessList/updateUser', 'user_id' => $linxAccount->account_id),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
));

echo CHtml::activeHiddenField($model, 'al_account_id', array('value' => $linxAccount->account_id));
echo CHtml::activeHiddenField($model, 'al_access_code', array('value' => LinxPermission::LINX_PERMISSION_ALLOWED));
echo $form->dropDownListRow($model,'al_app_id', CHtml::listData(LinxApp::model()->search()->getData(), 'app_id', 'app_gui_name'));
echo CHtml::submitButton('Grant Access'); 

$this->endWidget();
