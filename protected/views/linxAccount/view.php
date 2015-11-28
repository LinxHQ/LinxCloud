<?php
/* @var $this LinxAccountController */
/* @var $model LinxAccount */

/**
$this->breadcrumbs = array(
    'Linx Accounts' => array('index'),
    $model->account_id,
);

$this->menu = array(
    array('label' => 'List LinxAccount', 'url' => array('index')),
    array('label' => 'Create LinxAccount', 'url' => array('create')),
    array('label' => 'Update LinxAccount', 'url' => array('update', 'id' => $model->account_id)),
    array('label' => 'Delete LinxAccount', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->account_id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage LinxAccount', 'url' => array('admin')),
);**/
?>

<h1>View LinxAccount #<?php echo $model->account_id; ?></h1>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'account_id',
        'account_username',
        //'account_password',
        'account_last_update',
        'account_created_date',
        'account_status',
    ),
));

//if (LinxPermission::can(LinxPermission::ACCOUNT_PASSWORD_UPDATE_ANY) // can update any
//        || (LinxPermission::can(LinxPermission::ACCOUNT_PASSWORD_UPDATE_OWN) && $model->account_id == Yii::app()->user->id)) { // or can update own
if($model->account_id == Yii::app()->user->id){
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => 'Change Password',
        'type' => '', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size' => 'small', // null, 'large', 'small' or 'mini'
        'url' => array('linxAccount/updatePassword', 'id' => $model->account_id),
    ));

    echo '&nbsp;';
}

//if (LinxPermission::can(LinxPermission::ACCOUNT_UPDATE_ANY) // can update any
//        || (LinxPermission::can(LinxPermission::ACCOUNT_UPDATE_OWN) && $model->account_id == Yii::app()->user->id)) { // or can update own
if($model->account_id == Yii::app()->user->id){
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => 'Update Account',
        'type' => '', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size' => 'small', // null, 'large', 'small' or 'mini'
        'url' => array('linxAccount/update', 'id' => $model->account_id)
    ));
}

echo '<h3>Profile Information</h3>';
echo $profile->getProfilePhoto(0, true); // printbig size

$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $profile,
    'attributes' => array(
        //'account_id',
        'account_profile_surname',
        'account_profile_given_name',
        'account_profile_fullname',
    //'account_profile_company_name',
    ),
));

//if (LinxPermission::can(LinxPermission::ACCOUNT_PROFILE_UPDATE_ANY) // can update any
//        || (LinxPermission::can(LinxPermission::ACCOUNT_PROFILE_UPDATE_OWN) && $model->account_id == Yii::app()->user->id)) { // or can update own
if($model->account_id == Yii::app()->user->id){
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => 'Update Profile',
        'type' => '', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size' => 'small', // null, 'large', 'small' or 'mini'
        'url' => array('linxAccountProfile/update', 'id' => $profile->account_profile_id),
    ));
    echo '&nbsp;';
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => 'Update Photo',
        'type' => '', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size' => 'small', // null, 'large', 'small' or 'mini'
        'url' => array('linxAccountProfile/updatePhoto', 'id' => $profile->account_profile_id),
    ));
}

// Access List
// only viewable by admin

    echo '<h3>Applications</h3>';

    // list app that this user can access
    $this->widget('bootstrap.widgets.TbGridView', array(
        'id' => 'linx-account-app-access-list-grid',
        'dataProvider' => LinxAppAccessList::getAllowedApp($model->account_id),
        'columns' => array(
            array(
                'type' => 'raw',
                'value' => '$data->linxApp->app_gui_name ? $data->linxApp->app_gui_name : ""'
            ),
        ),
    ));
if (LinxPermission::can(LinxPermission::ACCOUNT_UPDATE_ANY)) {
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => 'Update',
        'type' => '', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size' => 'small', // null, 'large', 'small' or 'mini'
        'url' => array('linxAppAccessList/updateUser', 'user_id' => $model->account_id),
    ));
}
?>
