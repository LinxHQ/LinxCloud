<?php

/**
 * This is the model class for table "linx_app".
 *
 * The followings are the available columns in table 'linx_app':
 * @property integer $app_id
 * @property string $app_name
 * @property string $app_gui_name
 * @property string $app_short_description
 * @property string $app_secret_identity
 * @property string $app_url
 * @property string $app_order
 * @property string $app_images_url
 */
class LinxApp extends CActiveRecord
{
        //const HQACCOUNTS_REMOTE_LOGIN_URL = Yii::app()->params['HQACCOUNTS_REMOTE_LOGIN_URL'].'/site/remoteLogin';
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'linx_app';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('app_name, app_url, app_gui_name, app_secret_identity', 'required'),
			array('app_name, app_gui_name, app_short_description, app_images_url', 'length', 'max'=>255),
			array('app_secret_identity', 'length', 'max'=>100),
                        array('app_order', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('app_id, app_name, app_gui_name, app_short_description, app_secret_identity, app_order, app_images_url', 'safe', 'on'=>'search'),
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
			'app_id' => 'App',
			'app_name' => 'App Code Name',
			'app_gui_name' => 'App',
			'app_short_description' => 'Short Description',
			'app_secret_identity' => 'App Secret Identity',
                        'app_url' => 'App URL',
                        'app_order'=>'Order',
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

		$criteria->compare('app_id',$this->app_id);
		$criteria->compare('app_name',$this->app_name,true);
		$criteria->compare('app_gui_name',$this->app_gui_name,true);
		$criteria->compare('app_short_description',$this->app_short_description,true);
		$criteria->compare('app_secret_identity',$this->app_secret_identity,true);
                $criteria->compare('app_url',$this->app_url);
                $criteria->compare('app_order',$this->app_order);
                $criteria->order = "app_order ASC";
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LinxApp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Check if app name and secret identity are true
         * 
         * @param type $app_name
         * @param string $secret_identity
         * 
         * @return boolean
         */
        public function appExists($app_name, $secret_identity)
        {
            $this->app_name = $app_name;
            $this->app_secret_identity = $secret_identity;
            $adp = $this->search();
            $data = $adp->getData();
            if (count($data))
            {
                return true;
            }
            
            return false;
        }
        
        public function getApp($app_name, $secret_identity)
        {
            $this->app_name = $app_name;
            $this->app_secret_identity = $secret_identity;
            $adp = $this->search();
            $data = $adp->getData();
            if (count($data))
            {
                return $data[0];
            }
            
            return null;
        }
        
        /**
         * Check if caller is from the allowed list of app, by looking
         * at its http host, aka foo.example.com, and checking it against the 
         * list of urls of our apps
         * 
         * @return boolean
         */
        public static function callerIsAllowedHost()
        {
            $all_apps = LinxApp::model()->findAll();
            $all_hosts = array();
            
            // get all apps' urls
            foreach ($all_apps as $app)
            {
                $all_hosts[] = $app->app_url;
            }
            
            if (!isset($_SERVER['HTTP_HOST']) || !in_array($_SERVER['HTTP_HOST'], $all_hosts)) {
                return false;
            }
            
            return true;
        }
		
		/**
		 * @return string $url
		 */
		public function getAppPhotoURL($app_id = 0)
		{
			if ($app_id == 0)
                            $images_url = $this->app_images_url;
                        else
                        {
                            $app = LinxApp::model()->findByPk($app_id);
                            $images_url = $app->app_images_url;
                        }
			
			//if (file_exists(Yii::app()->request->baseUrl . $images_url))
				return $images_url;
			
			return '/images/dove.png';
		}
}
