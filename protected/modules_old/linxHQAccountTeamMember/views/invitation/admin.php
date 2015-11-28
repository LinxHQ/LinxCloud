<?php
/* @var $this AccountInvitationController */
/* @var $model AccountInvitation */

?>

<h3>Invitations</h3>
<div id="account-invitation-new-form"></div>

<h5>Sent Invitations</h5>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'account-invitation-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		'account_invitation_id',
                'application_id',
		//'account_invitation_master_id',
		'account_invitation_to_email',
		'account_invitation_date',
		'account_invitation_status',
		//'account_invitation_rand_key',
		/**
		array(
			'class'=>'CButtonColumn',
		),**/
	),
)); 