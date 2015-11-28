<?php

/**
 * This is the model class for table "sys_applications".
 *
 * The followings are the available columns in table 'sys_applications':
 * @property integer $application_id
 * @property integer $vendor_id
 * @property string $application_full_name
 * @property string $application_ui_name
 * @property string $application_reg_date
 * @property string $application_secret_key
 */
class LinxHQSysApplication extends LinxHQCActiveModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sys_applications';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vendor_id, application_full_name, application_ui_name, application_reg_date, application_secret_key', 'required'),
			array('vendor_id', 'numerical', 'integerOnly'=>true),
			array('application_full_name, application_ui_name, application_secret_key', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('application_id, vendor_id, application_full_name, application_ui_name, application_reg_date, application_secret_key', 'safe', 'on'=>'search'),
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
			'application_id' => 'Application',
			'vendor_id' => 'Vendor',
			'application_full_name' => 'Application Full Name',
			'application_ui_name' => 'Application Ui Name',
			'application_reg_date' => 'Application Reg Date',
			'application_secret_key' => 'Application Secret Key',
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

		$criteria->compare('application_id',$this->application_id);
		$criteria->compare('vendor_id',$this->vendor_id);
		$criteria->compare('application_full_name',$this->application_full_name,true);
		$criteria->compare('application_ui_name',$this->application_ui_name,true);
		$criteria->compare('application_reg_date',$this->application_reg_date,true);
		$criteria->compare('application_secret_key',$this->application_secret_key,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SysApplication the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getActiveApplications()
        {
            return self::model()->findAll();
        }
}
