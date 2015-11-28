<?php
/* @var $this AccountController */
/* @var $model Account */

?>

<h3>Update Account <?php echo AccountProfile::model()->getShortFullName($model->account_id); ?></h3>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'accountProfileModel' => $accountProfileModel)); ?>