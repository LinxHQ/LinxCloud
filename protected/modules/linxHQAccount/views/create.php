<?php
/* @var $this AccountController */
/* @var $model Account */

?>

<h1>Signup</h1>

<?php echo $this->renderPartial('/_form', 
		array('model'=>$model, 
				'sysApplication' => $sysApplication,
				'accountProfileModel' => $accountProfileModel,
				//'accountSubscriptionModel' => $accountSubscriptionModel,
				//'active_subscription_packages' => $active_subscription_packages
                                ));