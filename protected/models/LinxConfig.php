<?php

/**
 * This is the model class for table "linx_config".
 *
 * The followings are the available columns in table 'linx_config':
 * @property integer $id
 * @property string $lc_name
 * @property string $lc_value
 */
class LinxConfig extends CActiveRecord
{
        const LINXHQ_CONFIG_COOKIE_SECRET_VARIABLE_NAME = 'LINXHQ_COOKIE_SECRET_VARIABLE_NAME';
        const LINXHQ_CONFIG_ROOT_DOMAIN = 'LINXHQ_ROOT_DOMAIN';
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'linx_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lc_name, lc_value', 'required'),
			array('lc_name', 'length', 'max'=>100),
			array('lc_value', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, lc_name, lc_value', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'lc_name' => 'Lc Name',
			'lc_value' => 'Lc Value',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('lc_name',$this->lc_name,true);
		$criteria->compare('lc_value',$this->lc_value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LinxConfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Get the name of the secret variable, used for
         * storing session cookie in the local web browser
         */
        public function getCookieSecretVariableName()
        {
            $model = LinxConfig::model()->find('lc_name = :lc_name', 
                    array(':lc_name'=>  LinxConfig::LINXHQ_CONFIG_COOKIE_SECRET_VARIABLE_NAME));
            
            if ($model)
            {
                return $model->lc_value;
            }
            
            return '';
        }
        
        public function getRootDomain()
        {
            $model = LinxConfig::model()->find('lc_name = :lc_name', 
                    array(':lc_name'=>  LinxConfig::LINXHQ_CONFIG_ROOT_DOMAIN));
            
            if ($model)
            {
                return $model->lc_value;
            }
            
            return '';
        }
        
        public function getConfig($config_name)
        {
            $value = '';
            $model = new LinxConfig;
            $model->find('lc_name=:lc_name', array(':lc_name'=>  $config_name));
            
            if ($model)
            {
                $value = $model->lc_value;
            }
            
            return $value;
        }
}
