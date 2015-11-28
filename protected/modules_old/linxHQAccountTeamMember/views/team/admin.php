<?php
/* @var $this AccountTeamMemberController */
/* @var $memberCADataProvider CActiveDataProvider for AccountTeamMember */
/* @var $otherMemberCADataProvider for team members that this user is NOT master account of */
?>

<h3>Team Members</h3>

<?php
// see if this user has any subscription
$subscriptions = LinxHQAccountSubscription::model()->findSubscriptions(Yii::app()->user->id, true);

echo "<h4>Account: " . Yii::app()->user->account_email . " (Me)</h4>";
if (count($subscriptions)) {
    // FORMALITY, there should be only ONE master subscription for each account
    echo 'Plan: ';
    foreach ($subscriptions as $sub_key => $sub_name) {
        $accountSubscription = LinxHQAccountSubscription::model()->findByPk($sub_key);
        echo LinxHQSubscriptionPackage::model()->getPackageName($accountSubscription->account_subscription_package_id);
    }

    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped',
        'dataProvider' => $memberCADataProvider,
        'template' => "{items}{pager}",
        //'enablePagination'=> false,
        'columns' => array(
            array('type' => 'raw', 'value' => 'LinxHQAccountProfile::model()->getProfilePhoto($data->member_account_id)'),
            array('name' => 'member_account.account_profile.account_profile_preferred_display_name', 'header' => ''),
            array('name' => 'member_account.account_email', 'header' => ''),
            array(
                'type' => 'raw',
                'value' => ' ($data->is_customer == ACCOUNT_TEAM_MEMBER_IS_CUSTOMER ? "Customer" : "")'
            ),
            array(
                'type' => 'raw',
                'value' => ' ($data->is_active == LinxHQAccountTeamMember::ACCOUNT_TEAM_MEMBER_IS_DEACTIVATED ? 
						"<i class=\'blur-summary\'>Deactivated</i>" : "")'
            ), /**
              array(
              'class'=>'bootstrap.widgets.TbButtonColumn',
              'htmlOptions'=>array('style'=>'width: 50px'),
              ),* */
            array(
                'header' => '',
                'type' => 'raw',
                'value' => '
						CHtml::link("<i class=\'icon-pencil\'></i>",
							array("linxHQAccountTeamMember/accountTeamMember/update", "id" => $data->account_team_member_id),
							array("rel" => "tooltip", 
									"data-original-title" => "Update")) . 
						/**LBApplication::generateManualAjaxLink("<i class=\'icon-trash\'></i>",
							array("url" => array("linxHQAccountTeamMember/accountTeamMember/delete", "id" => $data->account_team_member_id),
								"type" => "POST",
								"cache"=> FALSE,
								"data"=>"jQuery(this).parents(\"form\").serialize()",
								"success"=>"function(html){jQuery(\"#content\").html(html)}"),
							array("confirm" => "Are you sure to delete this member?",
									"rel" => "tooltip", 
									"data-original-title" => "Delete"))
						**/
						CHtml::link("<i class=\'icon-trash\'></i>",
							array("linxHQAccountTeamMember/accountTeamMember/delete", "id" => $data->account_team_member_id),
							array("confirm" => "Are you sure to delete this member?",
									"rel" => "tooltip", 
									"data-original-title" => "Delete"))
						',
                'htmlOptions' => array('style' => 'width: 30px')
            )
        ),
    ));

    // show invite button for master account
    $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'link',
        //'ajaxOptions' => array('update' => '#wiki-content', 'id' => 'ajax-link' . uniqid()),
        'htmlOptions' => array('live' => false),
        //'linkOptions' => array(),
        'url' => array('accountInvitation/admin'),
        'type' => '',
        'label' => 'Invite Member',
    ));
} else {
    echo 'You only have a member account. Subscribe now to form your own team.<br/>';
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => 'Subscribe to Free Package',
        'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'url' => array('accountSubscription/inappSubscribe',
            'package_id' => LinxHQSubscriptionPackage::SUBSCRIPTION_PACKAGE_FREE),
    ));
}

echo "<br/><br/><br/><hr/>";

echo "<h4>Team(s) that you're part of:</h4>";
$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => 'striped',
    'dataProvider' => $otherMemberCADataProvider,
    'template' => "{items}{pager}",
    'columns' => array(
        array(
            'header' => 'Master Account',
            'type' => 'raw',
            'value' => 'LinxHQAccountProfile::model()->getShortFullName($data->master_account_id)'),
        array(
            //'name'=> 'member_account.account_profile.account_profile_preferred_display_name', 
            'type' => 'raw',
            'value' => 'LinxHQAccountProfile::model()->getShortFullName($data->member_account_id) . 
								($data->member_account_id == Yii::app()->user->id ? "(You)" : "")',
            'header' => 'Member'),
        array('name' => 'member_account.account_email', 'header' => 'Email'),
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
            'header' => 'From',
            'type' => 'raw',
            'value' => 'LinxHQAccountProfile::model()->getShortFullName($data->account_invitation_master_id)'),
        array(
            //'name'=> 'member_account.account_profile.account_profile_preferred_display_name',
            'header' => 'Date',
            'type' => 'raw',
            'value' => 'LBApplication::displayFriendlyDate($data->account_invitation_date)'),
        array(
            'header' => 'Status',
            'type' => 'raw',
            'value' => '$data->getInvitationStatusName()'),
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
