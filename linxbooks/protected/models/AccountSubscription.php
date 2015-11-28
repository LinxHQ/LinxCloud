<?php

/**
 * This is the model class for table "account_subscriptions".
 *
 * The followings are the available columns in table 'account_subscriptions':
 * @property integer $account_subscription_id
 * @property integer $account_id
 * @property integer $account_subscription_package_id
 * @property string $account_subscription_start_date
 * @property string $account_subscription_end_date
 * @property integer $account_subscription_status_id
 * @property string $subscription_name
 */
define('ACCOUNT_SUBSCRIPTION_STATUS_ACTIVE', 1);
define('ACCOUNT_SUBSCRIPTION_STATUS_ARCHIVED', 0);

class AccountSubscription extends CActiveRecord
{
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AccountSubscription the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_sys_account_subscriptions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, account_subscription_package_id, account_subscription_start_date, account_subscription_status_id, subscription_name', 'required'),
			array('account_id, account_subscription_package_id, account_subscription_status_id', 'numerical', 'integerOnly'=>true),
			array('subscription_name', 'unique','message'=>'Exist subscription name.'),
                        array('account_subscription_end_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('account_subscription_id, account_id, account_subscription_package_id, account_subscription_start_date, account_subscription_end_date, account_subscription_status_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'account_subscription_id' => Yii::t('lang','Account Subscription'),
			'account_id' => Yii::t('lang','Account'),
			'account_subscription_package_id' => Yii::t('lang','Package'),
			'account_subscription_start_date' => Yii::t('lang','Start Date'),
			'account_subscription_end_date' => Yii::t('lang','End Date'),
			'account_subscription_status_id' => Yii::t('lang','Status'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('account_subscription_id',$this->account_subscription_id);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('account_subscription_package_id',$this->account_subscription_package_id);
		$criteria->compare('account_subscription_start_date',$this->account_subscription_start_date,true);
		$criteria->compare('account_subscription_end_date',$this->account_subscription_end_date,true);
		$criteria->compare('account_subscription_status_id',$this->account_subscription_status_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Look for all subscriptions that this account is under.
	 * There are 2 cases:
	 * 	1. Her own subscription, ie her account is a master account.
	 *  2. Subscriptions of team leads of teams she belongs to.
	 * @param integer $account_id
	 * @param boolean	$is_master	indicating if we should only get subscription of which this account is master account
	 * @return array $results	subscription id => subscription label. Label could be company name if available
	 * 							, otherwise, we'll use display name
	 */
	public function findSubscriptions($account_id, $is_master = false)
	{
		$results = array();
		
		// case 1: account's own subscription
		$subscription_case1 = self::model()->findAll('account_id = :account_id AND account_subscription_status_id = :status'
				, array(':account_id' => $account_id, ':status' => ACCOUNT_SUBSCRIPTION_STATUS_ACTIVE));
		if (count($subscription_case1)>0)
		{
                    foreach ($subscription_case1 as $subscription_case1_item) {
//			$profile = AccountProfile::model()->find('account_id = :account_id', array(':account_id' => $account_id));
//			if ($profile)
//			{
//				$label = $profile->account_profile_preferred_display_name;
//				if ($profile->account_profile_company_name != null)
//				{
//					$label = $profile->account_profile_company_name;
//				}
//				$results[$subscription_case1_item->account_subscription_id] = $label;
//			}
                        $results[$subscription_case1_item->account_subscription_id] = $subscription_case1_item->subscription_name;
                    }
		}
		
		if ($is_master === false)
		{
			// case2: team lead's subscription
			// find all teamlead's id
			$teams = AccountTeamMember::model()->findAll('member_account_id = ?', array($account_id));

			foreach ($teams as $team_)
			{
				// if inactive team member skip
				if (!$team_->isActive())
					continue;
				
				//$master_account_id = $team_['master_account_id'];
                                $master_subscription_id = $team_['account_subscription_id'];
				// find subscription for this master account
				$subscription_case2 = self::model()->find('account_subscription_id = :account_subscription_id AND account_subscription_status_id = :status'
						, array(':account_subscription_id' => $master_subscription_id, ':status' => ACCOUNT_SUBSCRIPTION_STATUS_ACTIVE));
				
				if ($subscription_case2)
				{
//					$profile = AccountProfile::model()->find('account_id = ?', array($subscription_case2->account_id));
//					if ($profile)
//					{
//						$label = $profile->account_profile_preferred_display_name;
//						if ($profile->account_profile_company_name != null)
//						{
//							$label = $profile->account_profile_company_name;
//						}
//						$results[$subscription_case2->account_subscription_id] = $label;
//					}
                                        $results[$subscription_case2->account_subscription_id] = $subscription_case2->subscription_name;
				}
			}
		}
		
		return $results;
	}
	
	/**
	 * Get name of this subscription
	 * 
	 * @param unknown $subscription_id
	 * @return string
	 */
	public function getSubscriptionName($subscription_id)
	{
		$subscription = AccountSubscription::model()->findByPk($subscription_id);
	
		return $subscription->subscription_name;
	}
	
	/**
	 * Get account id of the owner of this subscription
	 * 
	 * @param number $subscription_id
	 * @return unknown
	 */
	public function getSubscriptionOwnerID($subscription_id = 0)
	{
		$subscription = $this;
		
		if ($subscription_id > 0){
			$subscription = AccountSubscription::model()->findByPk($subscription_id);
		}
		
		return $subscription->account_id;
	}
	
	/**
	 * Check if this account has any subscription, which qualifies it to be a master type.
	 * 
	 * @param unknown $account_id
	 */
	public function isSubscriber($account_id)
	{
		$result = $this->findSubscriptions($account_id, true);
		
		if (count($result) > 0)
			return true;
		return false;
	}
	
	/**
	 * Check if a user is already subscribed to a package
	 * 
	 * @param number $package_id
	 * @param number $account_id
	 * @return boolean true or false
	 */
	public function isAlreadySubscribedToPackage($package_id, $account_id = 0)
	{
		if ($account_id == 0)
			$account_id = Yii::app()->user->id;
		
		$results = $this->findAll('account_id = :account_id AND account_subscription_package_id = :account_subscription_package_id ',
				array(':account_id'=>$account_id,':account_subscription_package_id'=>$package_id));
		
		if (count($results))
			return true;
		
		return false;
	}	
        
        /**
         * Kiểm tra xem user login có phải là chủ thuê bao không.
         * 
         * @param type $subscription_id
         * @return boolean
         */
        public function checkIsSubscriptionOwner($subscription_id)
        {
            $onwSubcriptAccount = $this->getSubscriptionOwnerID($subscription_id);
            if($onwSubcriptAccount==Yii::app()->user->id)
                return true;
            return false;
        }
}