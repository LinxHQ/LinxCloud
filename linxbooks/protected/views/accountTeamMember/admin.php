<?php
/* @var $this AccountTeamMemberController */
/* @var $memberCADataProvider CActiveDataProvider for AccountTeamMember */
/* @var $otherMemberCADataProvider for team members that this user is NOT master account of */
?>
<?php // echo $model->lb_record_primary_key; 
echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" style="margin-left:-11px;" ><h4>Team Members</h4></div>';
            echo '<div class="lb-header-left">';
            echo '&nbsp;';
            echo '</div>';
echo '</div><br>';
?>
<?php 
// see if this user has any subscription
$subscriptions = AccountSubscription::model()->findSubscriptions(Yii::app()->user->id, true);


if (count($subscriptions))
{
        echo "<h4>Company: " . AccountSubscription::model()->getSubscriptionName(Yii::app()->user->linx_app_selected_subscription).'</h4>';
	
	$this->widget('bootstrap.widgets.TbGridView', array(
			'type' => 'striped',
			'dataProvider' => $memberCADataProvider,
			//'enablePagination'=> false,
			'columns' => array(
				array('type' => 'raw', 'value' => 'AccountProfile::model()->getProfilePhoto($data->member_account_id)'),
				array('name'=> 'member_account.account_profile.account_profile_preferred_display_name', 'header'=>''),
				array('name'=> 'member_account.account_email', 'header'=>''),
				array(
					'type' => 'raw',
					'value' => ' ($data->is_customer == ACCOUNT_TEAM_MEMBER_IS_CUSTOMER ? "Customer" : "")'		
				),
				array(
					'type' => 'raw',
					'value' => ' ($data->is_active == AccountTeamMember::ACCOUNT_TEAM_MEMBER_IS_DEACTIVATED ? 
						"<i class=\'blur-summary\'>Deactivated</i>" : "")'		
				),/**
				array(
					'class'=>'bootstrap.widgets.TbButtonColumn',
					'htmlOptions'=>array('style'=>'width: 50px'),
				),**/
				array(
					'header' => '',
					'type' => 'raw',
					'value' => '
						CHtml::link("<i class=\'icon-eye-open\'></i>",
							array("account/view/", "id" => $data->member_account_id),
							array("rel" => "tooltip", 
									"data-original-title" => "Update")).
						CHtml::link("<i class=\'icon-pencil\'></i>",
							array("accountTeamMember/update", "id" => $data->account_team_member_id),
							array("rel" => "tooltip", 
									"data-original-title" => "Update")) . 
						/**LBApplication::generateManualAjaxLink("<i class=\'icon-trash\'></i>",
							array("url" => array("accountTeamMember/delete", "id" => $data->account_team_member_id),
								"type" => "POST",
								"cache"=> FALSE,
								"data"=>"jQuery(this).parents(\"form\").serialize()",
								"success"=>"function(html){jQuery(\"#content\").html(html)}"),
							array("confirm" => "Are you sure to delete this member?",
									"rel" => "tooltip", 
									"data-original-title" => "Delete"))
						**/
						CHtml::link("<i class=\'icon-trash\'></i>",
							array("accountTeamMember/delete", "id" => $data->account_team_member_id),
							array("confirm" => "Are you sure to delete this member?",
									"rel" => "tooltip", 
									"data-original-title" => "Delete"))
						',
					'htmlOptions' => array('style'=>'width: 45px')
				)
			),
	));
	
	// show invite button for master account
	$this->widget('bootstrap.widgets.TbButton',
			array('buttonType'=>'link',
					//'ajaxOptions' => array('update' => '#wiki-content', 'id' => 'ajax-link' . uniqid()),
					'htmlOptions' => array('live' => false),
					//'linkOptions' => array(),
					'url' => array('accountInvitation/admin'),
					'type'=>'',
					'label'=>'Invite Member',
			));
        echo "<br/><br/><br/><hr/>";
} 
//else {
//	echo 'You only have a member account. Subscribe now to form your own team.<br/>';
//	$this->widget('bootstrap.widgets.TbButton', array(
//			'label'=>'Subscribe to Free Package',
//			'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
//			'url'=>array('accountSubscription/inappSubscribe',
//					'package_id'=>SubscriptionPackage::SUBSCRIPTION_PACKAGE_FREE),
//	));
//}


echo "<h4>Team(s) that you're part of:</h4>";
$this->widget('bootstrap.widgets.TbGridView', array(
		'type' => 'striped',
		'dataProvider' => $otherMemberCADataProvider,
		'template' => "{items}{pager}",
		'columns' => array(
				array(
						'header'=>'Master Account',
						'type'=>'raw',
						'value'=>'AccountProfile::model()->getShortFullName($data->master_account_id)'),
				array(
						//'name'=> 'member_account.account_profile.account_profile_preferred_display_name', 
						'type'=>'raw',
						'value'=>'AccountProfile::model()->getShortFullName($data->member_account_id) . 
								($data->member_account_id == Yii::app()->user->id ? "(You)" : "")',
						'header'=>'Member'),
				array('name'=> 'member_account.account_email', 'header'=>'Email'),
				array(
						'header' => 'Customer?',
						'type' => 'raw',
						'value' => ' ($data->is_customer == ACCOUNT_TEAM_MEMBER_IS_CUSTOMER ? "Customer" : "")'
				)
				//array(
				//	'class'=>'bootstrap.widgets.TbButtonColumn',
				//	'htmlOptions'=>array('style'=>'width: 50px'),
				//),
		),
));

echo "<br/><br/><br/><hr/>";

//
// Pending invitations to user
//
echo '<h4>Team(s) that you are invited to:</h4>';
$this->widget('bootstrap.widgets.TbGridView', array(
		'type' => 'striped',
		'dataProvider' => $invitesToUserCADataProvider,
		'template' => "{items}{pager}",
		'columns' => array(
				array(
						'header'=>'From',
						'type'=>'raw',
						'value'=>'AccountProfile::model()->getShortFullName($data->account_invitation_master_id)'),
				array(
						//'name'=> 'member_account.account_profile.account_profile_preferred_display_name',
						'header'=>'Date',
						'type'=>'raw',
						'value'=>'LBApplication::displayFriendlyDate($data->account_invitation_date)'),
				array(
						'header'=>'Status',
						'type'=> 'raw', 
						'value'=>'$data->getInvitationStatusName()'),
				array(
						'header' => '',
						'type' => 'raw',
						'value' => ' ($data->account_invitation_status == AccountInvitation::ACCOUNT_INVITATION_STATUS_PENDING ? 
							CHtml::link("Accept",array("accountInvitation/joinTeam","invite_id" => $data->account_invitation_id)) : 
							"")'
				)
				//array(
				//	'class'=>'bootstrap.widgets.TbButtonColumn',
				//	'htmlOptions'=>array('style'=>'width: 50px'),
				//),
		),
));
?>
