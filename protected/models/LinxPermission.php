<?php

/**
 * This is the model class for table "linx_permission".
 *
 * The followings are the available columns in table 'linx_permission':
 * @property integer $lp_id
 * @property integer $account_id
 * @property string $lp_permission_name
 * @property integer $lp_permission_status
 */
class LinxPermission extends CActiveRecord {

    const LINX_PERMISSION_ALLOWED = 1;
    const LINX_PERMISSION_NOT_ALLOWED = 0;
    // account type
    const ACCOUNT_TYPE_ADMINISTRATOR = 'administrator';
    const ACCOUNT_TYPE_NORMAL = 'normal';
    // default action
    const ACCOUNT_ADD = 'account_add';
    const ACCOUNT_LIST = 'account_list';
    const ACCOUNT_VIEW_ANY = 'account_view_any';
    const ACCOUNT_DELETE_ANY = 'account_delete_any';
    const ACCOUNT_DELETE_OWN = 'account_delete_own';
    const ACCOUNT_UPDATE_ANY = 'account_update_any';
    const ACCOUNT_UPDATE_OWN = 'account_update_own';
    const ACCOUNT_PROFILE_UPDATE_ANY = 'account_profile_update_any';
    const ACCOUNT_PROFILE_UPDATE_OWN = 'account_profile_update_own';
    const ACCOUNT_PROFILE_VIEW_ANY = 'account_profile_view_any';
    const ACCOUNT_PROFILE_VIEW_OWN = 'account_profile_view_own';
    const ACCOUNT_PASSWORD_UPDATE_ANY = 'account_password_update_any';
    const ACCOUNT_PASSWORD_UPDATE_OWN = 'account_password_update_own';
    
    public $account_types = array(
        LinxPermission::ACCOUNT_TYPE_NORMAL => 'Normal',
        LinxPermission::ACCOUNT_TYPE_ADMINISTRATOR => 'User Administrator',
    );

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'linx_permission';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('account_id, lp_permission_name, lp_permission_status', 'required'),
            array('account_id, lp_permission_status', 'numerical', 'integerOnly' => true),
            array('lp_permission_name', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('lp_id, account_id, lp_permission_name, lp_permission_status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'lp_id' => 'Lp',
            'account_id' => 'Account',
            'lp_permission_name' => 'Lp Permission Name',
            'lp_permission_status' => 'Lp Permission Status',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('lp_id', $this->lp_id);
        $criteria->compare('account_id', $this->account_id);
        $criteria->compare('lp_permission_name', $this->lp_permission_name, true);
        $criteria->compare('lp_permission_status', $this->lp_permission_status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return LinxPermission the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Check permission of the current user
     * 
     * @param string $do_action
     * @return const    LINX_PERMISSION_ALLOWED or LINX_PERMISSION_NOT_ALLOWED
     */
    public static function can($do_action) {
        $account_id = Yii::app()->user->id;// checking for current user
        // root account can do all things, no need to check
        if (LinxPermission::isRoot())
            return LinxPermission::LINX_PERMISSION_ALLOWED;

        // else check
        $perm = new LinxPermission();
        $perm->account_id = $account_id;
        $perm->lp_permission_name = $do_action;
        $dp = $perm->search();

        $data = $dp->getData();
        foreach ($data as $linxPerm) {
            return $linxPerm->lp_permission_status;
        }

        return LinxPermission::LINX_PERMISSION_NOT_ALLOWED;
    }

    /**
     * Set default permission for an account, such as a newly created account
     * @param int $account_id
     * @param const $account_type, default is normal account 
     */
    public static function setDefault($account_id, $account_type = LinxPermission::ACCOUNT_TYPE_NORMAL) {
        // normal account can list, view any, add update own
        $perm_array = array(LinxPermission::ACCOUNT_LIST,
            LinxPermission::ACCOUNT_VIEW_ANY,
            LinxPermission::ACCOUNT_PASSWORD_UPDATE_OWN,
            LinxPermission::ACCOUNT_PROFILE_VIEW_ANY,
            LinxPermission::ACCOUNT_PROFILE_VIEW_OWN,
            LinxPermission::ACCOUNT_PROFILE_UPDATE_OWN);

        // user admin has more perm
        if ($account_type == LinxPermission::ACCOUNT_TYPE_ADMINISTRATOR) {
            $perm_array[] = LinxPermission::ACCOUNT_ADD;
            $perm_array[] = LinxPermission::ACCOUNT_UPDATE_ANY;
            $perm_array[] = LinxPermission::ACCOUNT_PROFILE_UPDATE_ANY;
            $perm_array[] = LinxPermission::ACCOUNT_PASSWORD_UPDATE_ANY;
        }
        
        // set perm
        foreach ($perm_array as $perm) {
            $linxPerm = new LinxPermission();
            $linxPerm->account_id = $account_id;
            $linxPerm->lp_permission_name = $perm;
            $linxPerm->lp_permission_status = LinxPermission::LINX_PERMISSION_ALLOWED;
            $linxPerm->save();
        }
    }
    
    public static function isRoot()
    {
        return 1 == Yii::app()->user->id;
    }

}
