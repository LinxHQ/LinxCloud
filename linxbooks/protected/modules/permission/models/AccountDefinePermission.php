<?php

/**
 * This is the model class for table "lb_account_define_permission".
 *
 * The followings are the available columns in table 'lb_account_define_permission':
 * @property integer $lb_record_primary_key
 * @property integer $define_permission_id
 * @property integer $account_id
 * @property integer $module_id
 */
class AccountDefinePermission extends CLBActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_account_define_permission';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('define_permission_id, account_id', 'required'),
			array('define_permission_id, account_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lb_record_primary_key, define_permission_id, account_id', 'safe', 'on'=>'search'),
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
			'lb_record_primary_key' => 'Account Define Permission',
			'define_permission_id' => 'Define Permission',
			'account_id' => 'Account',
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

		$criteria->compare('lb_record_primary_key',$this->lb_record_primary_key);
		$criteria->compare('define_permission_id',$this->define_permission_id);
		$criteria->compare('account_id',$this->account_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AccountDefinePermission the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function CheckDefinePerAccount($account_id,$define_permission_id)
        {
            $criteria=new CDbCriteria;
            $criteria->condition = 'account_id = '.  intval($account_id);
            $criteria->condition .= ' AND define_permission_id = '.  intval($define_permission_id);
            $defineRole = $this->getFullRecordsDataProvider($criteria);
            if($defineRole->totalItemCount>0)
                return true;
            return false;
        }
}
