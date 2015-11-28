<?php

/**
 * This is the model class for table "linx_session".
 *
 * The followings are the available columns in table 'linx_session':
 * @property string $id
 * @property string $session_cookie_secret_value
 * @property integer $start
 * @property integer $expire
 * @property string $data
 * @property integer $account_id
 * @property string $browser_info
 */
class LinxSession extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'linx_session';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, start', 'required'),
			array('start, expire, account_id', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>32),
			array('session_cookie_secret_value', 'length', 'max'=>100),
			array('data, browser_info,session_cookie_secret_value', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, session_cookie_secret_value, start, expire, data, account_id, browser_info', 'safe', 'on'=>'search'),
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
			'session_cookie_secret_value' => 'Session Cookie Secret Value',
			'start' => 'Start',
			'expire' => 'Expire',
			'data' => 'Data',
			'account_id' => 'Account',
			'browser_info' => 'Browser Info',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('session_cookie_secret_value',$this->session_cookie_secret_value,true);
		$criteria->compare('start',$this->start);
		$criteria->compare('expire',$this->expire);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('browser_info',$this->browser_info,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LinxSession the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function generateCookieSecretValue($session_id)
        {
            return md5(time() . $session_id);
        }
        
        /**
         * Check if this session is available
         * 
         * condition: secret value exists, account id is valid, and session not expired yet
         * 
         * @param type $cookie_secret_value
         * @param boolean true of alive
         */
        public function isAlive($cookie_secret_value)
        {
            $this->session_cookie_secret_value = $cookie_secret_value;
            $adp = $this->search();            
            $record = $adp->getData();
            
            if (count($record) == 1)
            {
                $session = $record[0];
                
                if ($session->account_id > 0 && 
                        $session->expire > time())
                {
                    return true;
                }
            }
            
            return false;
        }
        
        /**
         * This is set in the session db in the database
         */
        public function setSessionCookieSecretValue()
        {
            $this->session_cookie_secret_value = $this->generateCookieSecretValue($this->id);
            $this->save();
        }
        
        /**
         * This set the cookie value(s) for this session locally
         */
        public function setSessionCookieLocal()
        {
            setcookie(LinxConfig::model()->getCookieSecretVariableName(),
                    $this->session_cookie_secret_value,
                    time()+LINXHQ_GLOBAL_SESSION_TIMEOUT,
                    '/',  
                    LinxConfig::model()->getRootDomain());
        }
        
        // usually called when user log out
        public function clearSessionCookieSecretValue()
        {
            $this->session_cookie_secret_value = null;
            $this->save();
        }
        
        public function getSession($session_cookie_secret_value)
        {
            $this->session_cookie_secret_value = $session_cookie_secret_value;
            $adp = $this->search();            
            $record = $adp->getData();
            
            if (count($record) == 1)
            {
                $session = $record[0];
                
                if ($session->account_id > 0 && 
                        $session->expire > time())
                {
                    return $session;
                }
            }
            
            return null;
        }
}
