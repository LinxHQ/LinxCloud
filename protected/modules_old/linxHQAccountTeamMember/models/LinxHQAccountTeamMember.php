<?php

/**
 * This is the model class for table "account_team_members".
 *
 * The followings are the available columns in table 'account_team_members':
 * @property integer $account_team_member_id
 * @property integer $application_id
 * @property integer $member_account_id
 * @property integer $master_account_id
 * @property integer $is_customer
 * @property integer $is_active
 */
define('ACCOUNT_TEAM_MEMBER_IS_CUSTOMER', 1);

class LinxHQAccountTeamMember extends LinxHQCActiveModel {

    public $accepting_invitation = false;

    const ACCOUNT_TEAM_MEMBER_IS_ACTIVE = 1;
    const ACCOUNT_TEAM_MEMBER_IS_DEACTIVATED = -1;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LinxHQAccountTeamMember the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sys_account_team_members';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('member_account_id, application_id, member_since, master_account_id', 'required'),
            array('member_account_id, master_account_id, is_active', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('application_id, member_types, account_team_member_id, member_account_id, master_account_id, is_customer, is_active', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'member_account' => array(self::BELONGS_TO, 'LinxHQAccount', 'member_account_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'application_id' => 'Application',
            'account_team_member_id' => 'Account Team Member',
            'member_account_id' => 'Member Account',
            'master_account_id' => 'Master Account',
            'is_customer' => 'Customer',
            'is_active' => 'Active'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('account_team_member_id', $this->account_team_member_id);
        $criteria->compare('member_account_id', $this->member_account_id);
        $criteria->compare('master_account_id', $this->master_account_id);
        $criteria->compare('is_customer', $this->is_customer);
        $criteria->compare('is_active', $this->is_active);
        $criteria->compare('application_id', $this->application_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function save($runValidation = TRUE, $attributes = NULL) {
        if ($this->isNewRecord) {
            $this->member_since = date('Y-m-d H:i:s');
        }
        if ($this->is_active === NULL || $this->is_active == 0)
            $this->is_active = $this::ACCOUNT_TEAM_MEMBER_IS_DEACTIVATED;

        return parent::save($runValidation, $attributes);
    }

    public function delete() {
        return parent::delete();
    }

    /**
     * Return team members of team that this account is the master account of.
     * 
     * @param unknown $master_account_id
     * @param string $get_all_records default = false
     * @return CActiveDataProvider if get_all_records = false, otherwise array of models
     */
    public function getTeamMembers($master_account_id, $get_all_records = FALSE) {
        $dataProvider = new CActiveDataProvider('LinxHQAccountTeamMember', array(
            'criteria' => array(
                'condition' => "master_account_id = " . $master_account_id,
                //'order' => 'task_last_commented_date DESC',
                'with' => array(
                    'member_account'
                ),
            ),
                //'pagination'=>array(
                //		'pageSize' => 10,
                //),
        ));

        if ($get_all_records === true) {
            $dataProvider->setPagination(false);
            return $dataProvider->getData();
        }
        return $dataProvider;
    }

    /**
     * Return list of all the members of other teams that this account belongs to.
     * This is used for team that this account is NOT the master account of that team.
     * 
     * @param unknown $account_id
     */
    public function getMyOtherTeams($account_id) {
        // get all master accounts that I'm member of
        $members = LinxHQAccountTeamMember::model()->findAll('member_account_id = :account_id', array(":account_id" => $account_id));
        $master_accounts_ids = array(0);
        foreach ($members as $mem) {
            $master_accounts_ids[] = $mem->master_account_id;
        }
        $master_accounts_ids_str = implode(',', $master_accounts_ids);

        // get all members of these master accounts
        $dataProvider = new CActiveDataProvider('LinxHQAccountTeamMember', array(
            'criteria' => array(
                'condition' => "master_account_id in ($master_accounts_ids_str) ",
                'order' => 'master_account_id DESC',
                'with' => array(
                    'member_account'
                ),
            ),
                //'pagination'=>array(
                //		'pageSize' => 10,
                //),
        ));

        $dataProvider->setPagination(false);
        return $dataProvider;
    }

    /**
     * Check if a team member to a master account is only a customer
     * @param integer $master_account_id
     * @param integer $member_account_id
     */
    public function isCustomer($master_account_id, $member_account_id) {
        $teamMember = LinxHQAccountTeamMember::model()->find('master_account_id = :master_account_id AND member_account_id = :member_account_id', array(':master_account_id' => $master_account_id, ':member_account_id' => $member_account_id));

        if ($teamMember && $teamMember->is_customer == ACCOUNT_TEAM_MEMBER_IS_CUSTOMER)
            return true;
        return false;
    }

    /**
     * Check if an account is member of this master account 
     * 
     * @param integer $master_account_id
     * @param integer $member_account_id
     */
    public function isValidMember($master_account_id, $member_account_id) {
        $teamMember = LinxHQAccountTeamMember::model()->find('master_account_id = :master_account_id 
				AND member_account_id = :member_account_id', array(
            ':master_account_id' => $master_account_id,
            ':member_account_id' => $member_account_id));

        if ($teamMember && $teamMember->account_team_member_id > 0)
            return true;
        return false;
    }

    /**
     * 
     * @param unknown $master_account_id
     * @param unknown $member_account_id
     * @return boolean
     */
    public function isActive($master_account_id = 0, $member_account_id = 0) {
        if ($master_account_id == 0)
            $master_account_id = $this->master_account_id;
        if ($member_account_id == 0)
            $member_account_id = $this->member_account_id;

        // if master and member are same user
        // that means yes
        if ($master_account_id == $member_account_id)
            return true;

        $teamMember = LinxHQAccountTeamMember::model()->find('master_account_id = :master_account_id
				AND member_account_id = :member_account_id 
				AND is_active = :is_active', array(
            ':master_account_id' => $master_account_id,
            ':member_account_id' => $member_account_id,
            ':is_active' => self::ACCOUNT_TEAM_MEMBER_IS_ACTIVE));

        if ($teamMember && $teamMember->account_team_member_id > 0)
            return true;
        return false;
    }

    /**
     * Check if these 2 users are team members of each other.
     * This function can even ben used when NONE are master accounts
     * 
     * @param unknown $my_id
     * @param unknown $team_member_account_id
     * @return boolean
     */
    public function isMyTeamMember($my_id, $team_member_account_id) {
        // if my_id is a master account, and the other one is his/her teammate
        if ($this->isValidMember($my_id, $team_member_account_id))
            return true;

        // get master account id of my_id
        // get master account id of team member account id
        // if of same master account, yes, we are team members
        $my_master_account_ids = $this->getMasterAccountIDs($my_id);
        $team_member_master_account_ids = $this->getMasterAccountIDs($team_member_account_id);
        foreach ($my_master_account_ids as $master_id) {
            if (in_array($master_id, $team_member_master_account_ids)) {
                // if none of us is de-activated
                if (LinxHQAccountTeamMember::model()->isActive($master_id, $my_id) && LinxHQAccountTeamMember::model()->isActive($master_id, $team_member_account_id))
                    return true;
            }
        }

        return false;
    }

    /**
     * Get master account for a project that this user belongs to.
     * This is use to find master account of a project that this user is involved with.
     * This user is assumed to be NOT a master account user
     * 
     * @param integer $member_account_id
     * @param number $project_id
     * @return mix Array of master account ids, master account id if project id is passed in.
     */
    public function getMasterAccountIDs($member_account_id, $project_id = 0) {
        // find all the records that reflect team membership of this account
        $teamMembers = LinxHQAccountTeamMember::model()->findAll('member_account_id = :member_account_id', array(':member_account_id' => $member_account_id));

        // get ids of master account
        $master_acc_ids = array();
        foreach ($teamMembers as $mem) {
            $master_acc_ids[] = $mem->master_account_id;
        }

        // return array of master account ids
        return $master_acc_ids;
    }

}
