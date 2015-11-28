<?php

/**
 * This is the model class for table "linx_app_access_list".
 *
 * The followings are the available columns in table 'linx_app_access_list':
 * @property integer $al_id
 * @property integer $al_app_id
 * @property integer $al_account_id
 * @property integer $al_access_code
 */
class LinxAppAccessList extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'linx_app_access_list';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('al_app_id, al_account_id, al_access_code', 'required'),
			array('al_app_id, al_account_id, al_access_code', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('al_id, al_app_id, al_account_id, al_access_code', 'safe', 'on'=>'search'),
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
                    'linxApp'=>array(self::BELONGS_TO, 'LinxApp', array('al_app_id' => 'app_id'))
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'al_id' => 'ID',
			'al_app_id' => 'App',
			'al_account_id' => 'Al Account',
			'al_access_code' => 'Al Access Code',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('al_id',$this->al_id);
		$criteria->compare('al_app_id',$this->al_app_id);
		$criteria->compare('al_account_id',$this->al_account_id);
		$criteria->compare('al_access_code',$this->al_access_code);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LinxAppAccessList the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function save($runValidation = true, $attributes = null) {
            // check for duplicate
            if ($this->isNewRecord && $this->isDuplicated())
            {
                return false;
            }
            
            $status = parent::save($runValidation, $attributes);
            
            return $status;
        }
        
        /**
         * Get list of app that this account is allowed to access
         * 
         * @param int $account_id
         * @return mixed if $get_data is true, array of LinxAppAccessList models found. Otherwise, return CActiveDataProvider
         */
        public static function getAllowedApp($account_id, $get_data = false)
        {
            $appAccessList = new LinxAppAccessList;
            $criteria=new CDbCriteria;

            $criteria->compare('al_account_id',$account_id);
            $criteria->compare('al_access_code', LinxPermission::LINX_PERMISSION_ALLOWED);
			
            $criteria->join = 'LEFT JOIN linx_app la ON la.app_id = t.al_app_id';
            $criteria->order = 'la.app_order ASC';
            
            $adp = new CActiveDataProvider($appAccessList, array(
                'criteria'=>$criteria,
            ));
            
            // if to return array of models instead
            if ($get_data)
            {
                $data = $adp->getData();
                return $data;
            }
            
            return $adp;
        }
        
        public function isDuplicated()
        {
            $model = new LinxAppAccessList;
            $model->al_app_id = $this->al_app_id;
            $model->al_account_id = $this->al_account_id;
            
            $records = $model->search();
            if (count($records->getData()))
            {
                return true;
            }
            
            return false;
        }
        
        /**
         * Check if user is allowed to use this app or not
         * 
         * @param type $account_id
         * @param type $app_id
         * @return boolean
         */
        public function isAllowed($account_id, $app_id)
        {
            $this->al_account_id = $account_id;
            $this->al_app_id = $app_id;
            $adp = $this->search();
            $data = $adp->getData();
            if (count($data))
            {
                return true;
            }
            
            return false;
        }
}
