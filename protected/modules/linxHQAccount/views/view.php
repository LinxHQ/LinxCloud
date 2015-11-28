<?php
/* @var $this AccountController */
/* @var $model Account */
/* @var $profile AccountProfile */

/**
$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	$model->account_id,
);**/

$this->menu=array(
	//array('label'=>'List Account', 'url'=>array('index')),
	//array('label'=>'Create Account', 'url'=>array('create')),
	array('label'=>'Invite Team Member', 'url'=>array('/accountInvitation/create')),
	array('label'=>'List Invitations', 'url'=>array('/accountInvitation/admin')),
	array('label'=>'Update Account', 'url'=>array('update', 'id'=>$model->account_id)),
	array('label'=>'Delete Account', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->account_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Account', 'url'=>array('admin')),
	array('label'=>'Manage Team Members', 'url'=>array('admin')),
);
?>

<h3>Account Information <?php //echo $model->account_id; ?></h3>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'account_id',
		'account_email',
		//'account_password',
		//'account_master_account_id',
		'account_created_date',
		'account_timezone',
		'account_language',
		//'account_status',
	),
)); 

if (Permission::checkPermission($model, PERMISSION_ACCOUNT_UPDATE))
{
	$this->widget('bootstrap.widgets.TbButton', array(
			'label'=>'Change Password',
			'type'=>'', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			'size'=>'small', // null, 'large', 'small' or 'mini'
			'url' => array('account/updatePassword', 'id' => $model->account_id),
	));
	
	echo '&nbsp;';
	$this->widget('bootstrap.widgets.TbButton', array(
			'label'=>'Update Account',
			'type'=>'', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			'size'=>'small', // null, 'large', 'small' or 'mini'
			'url'=>array('account/update', 'id' => $model->account_id)
	));
}
?>

<h3>Profile Information</h3>
<?php 
echo $profile->getProfilePhoto(0, true); // printbig size

$this->widget('bootstrap.widgets.TbDetailView', array(
		'data'=>$profile,
		'attributes'=>array(
				//'account_id',
				'account_profile_surname',
				'account_profile_given_name',
				'account_profile_preferred_display_name',
				'account_profile_company_name',
		),
));

if (Permission::checkPermission($profile, PERMISSION_ACCOUNT_PROFILE_UPDATE))
{
	$this->widget('bootstrap.widgets.TbButton', array(
			'label'=>'Update Profile',
			'type'=>'', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			'size'=>'small', // null, 'large', 'small' or 'mini'
			'url'=>array('accountProfile/update', 'id' => $profile->account_profile_id),
	));
	echo '&nbsp;';
	$this->widget('bootstrap.widgets.TbButton', array(
			'label'=>'Update Photo',
			'type'=>'', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			'size'=>'small', // null, 'large', 'small' or 'mini'
			'url'=>array('accountProfile/updatePhoto', 'id' => $profile->account_profile_id),
	));
}
?>