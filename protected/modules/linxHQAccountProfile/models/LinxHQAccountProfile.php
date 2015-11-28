<?php

/**
 * This is the model class for table "account_profiles".
 *
 * The followings are the available columns in table 'account_profiles':
 * @property integer $account_profile_id
 * @property integer $account_id
 * @property string $account_profile_surname
 * @property string $account_profile_given_name
 * @property string $account_profile_preferred_display_name
 * @property string $account_profile_company_name
 */
class LinxHQAccountProfile extends LinxHQCActiveModel
{
	public $account_profile_photo;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AccountProfile the static model class
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
		return 'sys_account_profiles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, account_profile_surname, account_profile_given_name, account_profile_preferred_display_name', 'required'),
			array('account_id', 'numerical', 'integerOnly'=>true),
			array('account_profile_surname, account_profile_given_name, account_profile_preferred_display_name, account_profile_company_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('account_profile_id, account_id, account_profile_surname, account_profile_given_name, account_profile_preferred_display_name', 'safe', 'on'=>'search'),
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
				'comments' => array(self::HAS_MANY, 'TaskComment', 'account_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'account_profile_id' => 'Account Profile',
			'account_id' => 'Account',
			'account_profile_surname' => 'Surname',
			'account_profile_given_name' => 'Given Name',
			'account_profile_preferred_display_name' => 'Preferred Name',
			'account_profile_company_name' => 'Company Name',
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

		$criteria->compare('account_profile_id',$this->account_profile_id);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('account_profile_surname',$this->account_profile_surname,true);
		$criteria->compare('account_profile_given_name',$this->account_profile_given_name,true);
		$criteria->compare('account_profile_preferred_display_name',$this->account_profile_preferred_display_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * 
	 * @param unknown $account_id
	 * @return unknown|AccountProfile
	 */
	public function getProfile($account_id)
	{
		$this->unsetAttributes();
		$this->account_id = $account_id;
		
		$result = $this->search();
		if (count($result))
		{
			$profiles = $result->getData();
			return $profiles[0];
		}
		
		return new LinxHQAccountProfile();
	}
	
	/**
	 * @param integer	account id if any. Existing model loaded from db doesn't need this param.
	 */
	public function getShortFullName($account_id = 0)
	{
		$model = $this;
		if ($account_id > 0) {
			$profile = LinxHQAccountProfile::model()->getProfile($account_id);
			if ($profile)
			{
				$model = $profile;
			}
		}
		
		if ($model->account_id == Yii::app()->user->id)
		{
			return 'You';
		}
		
		$name = $model->account_profile_given_name . " " . mb_substr($model->account_profile_surname, 0, 1) . ".";
		if (trim($name) != '.')
			return LinxHQApplication::encodeToUTF8($name);
		
		return '';
	}
	
	/**
	 * GET FULL NAME
	 * 
	 * @param number $account_id
	 * @return string|Ambigous <string, string>
	 */
	public function getFullName($account_id = 0)
	{
		$model = $this;
		if ($account_id > 0) {
			$profile = AccountProfile::model()->getProfile($account_id);
			if ($profile)
			{
				$model = $profile;
			}
		}
	
		$name = $model->account_profile_given_name . " " . $model->account_profile_surname . ".";
		if (trim($name) != '.')
			return LinxHQApplication::encodeToUTF8($name);
	
		return '';
	}
	
	/**
	 * Validate profile photo
	 * 
	 * @return boolean
	 */
	public function validateProfilePhoto()
	{
		if (isset($this->account_profile_photo->size))
		{
			// don't allow pic larger than 200 Kb
			if ($this->account_profile_photo->size > 200*1024)
			{
				$this->addError('account_profile_photo', 'Photo cannot be larger than 200Kb.');
				return false;
			}
		}
		
		// check MIME/Type (such as "image/gif")
		if (isset($this->account_profile_photo->type))
		{
			if (!in_array(CFileHelper::getMimeType($this->account_profile_photo->getTempName()), 
					array('image/png', 'image/jpg', 'image/jpeg')))
			{
				$this->addError('account_profile_photo', 'Photo must be of type PNG, JPG, or JPEG.');
				return false;
			}
		}
		
		return true;
	}
		
	/**
	 * @param mixed account_id (default is integer, if array then we get multiple photos
	 * @param boolean big size or not. default is false.
	 * @param integer size the dimension (width = height so we only take in one value)
	 * 
	 * @return html code for profile photo
	 */
	public function getProfilePhoto($account_id = 0, $big = false, $size = 50)
	{
		if ($account_id == 0) $account_id = $this->account_id;
		
		// account_id arrays
		$account_ids_arr = array();
		if (is_array($account_id))
		{
			$account_ids_arr = $account_id;
		} else {
			$account_ids_arr[] = $account_id;
		}
		
		//$size = 50;
		$link = '';
		foreach ($account_ids_arr as $acc_id_tmp_)
		{
			if ($acc_id_tmp_ == null) continue;
			
			if ($big)
			{
				$size = 100;
			}
			
			$radius = intval($size/2);
			
			$image = CHtml::image($this->getProfilePhotoURL($acc_id_tmp_), '',
					array(
							'height' => $size,
							'width' => $size,
							'style' => "margin-right: 5px; height: {$size}px; border-radius:{$radius}px; width: {$size}px; "));
			
			$link .= CHtml::link($image, array('account/view', 'id' => $acc_id_tmp_),
					array('style'=>'display: inline-block;',
							'rel'=>'tooltip',
							'title'=>$this->getShortFullName($acc_id_tmp_),));
		}
		
		
		return $link;
	}
	
	/**
	 * @return string $url
	 */
	public function getProfilePhotoURL($account_id = 0)
	{
		if ($account_id == 0) $account_id = $this->account_id;
		
		if (file_exists(Yii::app()->params['profilePhotosDir'] . $account_id))
			return Yii::app()->request->baseUrl . '/' . Yii::app()->params['profilePhotosDir'] . $account_id;
		
		return Yii::app()->request->baseUrl . '/images/lincoln-default-profile-pic.png';
	}
    
	
	////////////////////////////// API /////////////////////////////
	
	/**
	 * Specify whether this model allows Service API for action List
	 * @return boolean
	 */
	public static function apiAllowsList() {
		return true;
	}
	
	public static function apiAllowsView() {
		return true;
	}
	
	public static function apiAllowsCreate() {
		return true;
	}
	
	/**
	 * the List API
	 */
	public static function apiList() {
		if (isset($_GET['list_type']))
        {
            $list_type = $_GET['list_type'];
            switch($list_type)
            {
                case 'get_profile_by_account_id':
                    $results = array();
                    
                    if (isset($_GET['account_id']))
                    {
                        $profile = AccountProfile::model()->getProfile($_GET['account_id']);
                        if ($profile != null)
                            $results[] = $profile;
                    } // end if isset account_id
                    
                    return $results;
                    
                    break;
                    
                    // end case get_profile_by_account_id
                default:
                    break;
            } // end switch for list_type
        }// end if for list_type
	}

}