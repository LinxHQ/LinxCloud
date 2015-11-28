<?php

/**
 * This is the model class for table "linx_account".
 *
 * The followings are the available columns in table 'linx_account':
 * @property integer $account_id
 * @property string $account_username
 * @property string $account_password
 * @property string $account_last_update
 * @property string $account_created_date
 * @property integer $account_status
 */
class LinxAccount extends CActiveRecord {
    
    public $account_current_password;
    public $account_new_password;
    public $account_new_password_retype;
    public $account_profile_id;
    public $accountProfileModel = null;
    public $account_type = LinxPermission::ACCOUNT_TYPE_NORMAL;
    
    const ACCOUNT_STATUS_ACTIVATED = 1;
    const ACCOUNT_STATUS_NOT_ACTIVATED = 0;
    const ACCOUNT_STATUS_DEACTIVIATED = -1;
    const ACCOUNT_ERROR_WRONG_CURRENT_PASSWORD = -1;
    const ACCOUNT_ERROR_PASSWORD_RETYPE_NOT_MATCHED = -2;
    const ACCOUNT_ERROR_PASSWORD_NOT_SAFE = -3;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'linx_account';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('account_username, account_password, account_last_update, account_created_date, account_status', 'required'),
            array('account_status', 'numerical', 'integerOnly' => true),
            array('account_username, account_password', 'length', 'max' => 100),
            array('account_type, account_current_password, account_new_password, account_new_password_retype', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('account_id, account_username, account_password, account_last_update, account_created_date, account_status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'linx_account_profile' => array(self::HAS_ONE, 'LinxAccountProfile', 'account_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'account_id' => 'Account',
            'account_username' => 'Account Username',
            'account_password' => 'Account Password',
            'account_last_update' => 'Account Last Update',
            'account_created_date' => 'Account Created Date',
            'account_status' => 'Account Status',
            'account_type' => 'Account Type',
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

        $criteria->compare('account_id', $this->account_id);
        $criteria->compare('account_username', $this->account_username, true);
        $criteria->compare('account_password', $this->account_password, true);
        $criteria->compare('account_last_update', $this->account_last_update, true);
        $criteria->compare('account_created_date', $this->account_created_date, true);
        $criteria->compare('account_status', $this->account_status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return LinxAccount the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * This method update password based on user's input
     * from change password form.
     */
    public function updatePassword() {
        // first, check if the entered current password is correct
        if ($this->validateCurrentPassword()) {
            // check if new password and its retype matched
            // and if it's strong 
            if ($this->account_new_password == $this->account_new_password_retype) {
                if ($this->evalPasswordStrength($this->account_new_password) === true) {
                    $this->account_password = $this->hashPassword($this->account_new_password);
                    return $this->save();
                    //return true;
                } else {
                    $this->addError('account_new_password', 'Password is not safe.');
                    return false;
                }
            } else {
                $this->addError('account_new_password_retype', 'Retyped password is not matched.');
                return false;
            }
        } else {
            $this->addError('account_password', 'Wrong password enter for field Current Password.' . $this->account_current_password);
            return false;
        }
    }
    
    
    /**
     * check if a password is strong enough
     * 
     * @param unknown $password
     * @return boolean
     */
    public function evalPasswordStrength($password) {
        
        //if (strlen($password) < 8 || preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $password) <= 0) {
        if (strlen($password) < 8) {
            $this->addError('account_new_password_retype', 'Password is not safe. Your password should have at least 8 characters.');

            //$this->addError('account_new_password_retype', 'Password is not safe. Your password should have at least 8 characters, and include digits, letters, and special characters (such as &, *, $, [, ], etc.');
            return false; //ACCOUNT_ERROR_PASSWORD_NOT_SAFE;
        }

        return true;
    }

    /**
     * 
     * @param unknown $password
     * @return boolean
     */
    public function passwordIsSafe($password) {
        if (strlen($password) < 8 || preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $password) <= 0)
            return false;

        return true;
    }

    /**
     * Validate if password typed in by user is correct
     * This is just a wrapper for validatePassword
     * 
     * @param string $password
     * @return boolean
     */
    public function validateCurrentPassword($password = '') {
        if ($password == '')
            $password = $this->account_current_password;

        return $this->validatePassword($this->account_current_password);
    }

    public function sendSuccessfulSignupEmailNotification() {
        $message = new YiiMailMessage();
        $activation_key = $this->getActivationKey();
        $activation_url = $this->getActivationURL($activation_key);

        /**
          $body = '<p>Hello.</p>';
          $body .= "<p>Welcome to " . Yii::app()->name . "</p>";
          $body .= '<p>Your registration is successful. In order to start enjoying our amazing stuff, please activate your account by clicking the link below: </p>';
          $body .= '<p><a href="' . $activation_url . '">Activate my account now.</a></p>';
          //$body .= '<p>DEBUG: ' . $account->account_email . $account->account_created_date . '</p>';
          $body .= "<p>" . Yii::app()->params['emailSignature'] . "</p>";
         * */
        $message->view = "successfulSignupEmail";
        //userModel is passed to the view
        $message->setBody(array('activation_url' => $activation_url), 'text/html');

        $message->setSubject('Account Activation');
        //$message->setBody($body, 'text/html');
        $message->addTo($this->account_email);
        //$message->from = Yii::app()->params['adminEmail'];
        $message->setFrom(array(Yii::app()->params['adminEmail'] => "LinxCircle Admin"));
        Yii::app()->mail->send($message);
    }

    /**
     * Override the save() method to handle signup process: Create user account, subscription, company, contact
     * 
     */
    public function save($runValidation = true, $attributes = NULL) {
        // create user account, check password
        if ($this->isNewRecord) {
            // eval password strength
            if (!$this->evalPasswordStrength($this->account_password)) {
                return false;
            }

            $this->account_password = $this->hashPassword($this->account_password);

            // basic profile
            if ($this->accountProfileModel) {
                if ($this->accountProfileModel->account_profile_surname == '') {
                    $this->addError('', 'Please provide Surname.');
                    return false;
                }
                if ($this->accountProfileModel->account_profile_given_name == '') {
                    $this->addError('', 'Please provide Given Name.');
                    return false;
                }
                /**
                if ($this->accountProfileModel->account_profile_company_name == '') {
                    $this->addError('', 'Please provide Company Name.');
                    return false;
                }**/
            } else {
                $this->addError('', 'Please provide given name and surname.');
                return false;
            }
        }
        // only for new account
        if ($this->isNewRecord) {
            $this->account_created_date = date('Y-m-d H:i');
        } else {
            // updating account. check permission
            if (Yii::app()->user->id != $this->account_id && Yii::app()->user->id != 1) {
                $this->addError('account_email', 'This account doesn\'t have permission to perform this feature.');
                return false;
            }
        }

        $this->account_last_update = date('Y-m-d H:i');
        
        if ($this->validateEmail() === false) {
            $this->addError('account_email', 'This email is invalid.');
            return false;
        }

        return parent::save($runValidation, $attributes);
    }

    /**
     * This reset is NOT by updating password feature.
     * This reset is used under Forgot Password feature
     * 
     * @param unknown $password
     */
    public function resetPassword($password) {
        if ($this->passwordIsSafe($password)) {
            $this->account_password = $this->hashPassword($password);
            return parent::save();
        }

        return false;
    }

    /**
     * Check if given password is correct, against user's password
     * 
     * @param unknown $password
     * @return boolean
     */
    public function validatePassword($password) {
        return crypt($password, $this->account_password) === $this->account_password;
    }

    public function hashPassword($password) {
        return crypt($password, $this->generateSalt());
    }

    /**
     * Generate a random salt in the crypt(3) standard Blowfish format.
     *
     * @param int $cost Cost parameter from 4 to 31.
     *
     * @throws Exception on invalid cost parameter.
     * @return string A Blowfish hash salt for use in PHP's crypt()
     */
    public function generateSalt($cost = 13) {
        if (!is_numeric($cost) || $cost < 4 || $cost > 31) {
            throw new Exception("cost parameter must be between 4 and 31");
        }

        $rand = array();
        for ($i = 0; $i < 8; $i += 1) {
            $rand[] = pack('S', mt_rand(0, 0xffff));
        }

        $rand[] = substr(microtime(), 2, 6);
        $rand = sha1(implode('', $rand), true);
        $salt = '$2a$' . str_pad((int) $cost, 2, '0', STR_PAD_RIGHT) . '$';
        $salt .= strtr(substr(base64_encode($rand), 0, 22), array('+' => '.'));

        return $salt;
    }

    /**
     * Get account record associated to this email address
     * 
     * @param unknown $email
     * @return CActiveRecord or NULL
     */
    public function getAccountByEmail($email) {
        $account = Account::model()->find('account_username = :account_email', array(':account_email' => $email));

        if ($account != null && $account->account_id > 0)
            return $account;

        return null;
    }

    /**
     * This key is used during account registration process
     * @return string
     */
    public function getActivationKey() {
        $string = trim($this->account_username) . trim(date('Y-m-d H:i', strtotime($this->account_created_date)));

        return md5($string);
    }

    /**
     * Get URL for activation. This URL is used in welcome email.
     * @return string
     */
    public function getActivationURL($activation_key) {
        $url = Yii::app()->createAbsoluteUrl('account/activate', array('id' => $this->account_id, 'key' => $activation_key));
        return $url;
    }

    /**
     * Perform account activation
     * @param string $activation_key
     * @return boolean
     */
    public function activateAccount($activation_key) {
        if (trim($activation_key) == trim($this->getActivationKey())) {
            // update account status
            $this->account_status = 1; //ACCOUNT_STATUS_ACTIVATED;
            $this->save();

            return true;
        }

        return false;
    }

    /**
     * check if an account is already activated
     * @return boolean
     */
    public function isActivated() {
        return ($this->account_status == LinxAccount::ACCOUNT_STATUS_ACTIVATED);
    }

    public function isAdmin() {
        if (Yii::app()->user->id == 1)
            return true;
    }

    public function validateEmail() {
        if (Utilities::isValidEmail($this->account_username) !== false) {
            // find if this email is used by other account already or not
            $account = LinxAccount::model()->find('account_id != :account_id AND account_username = :account_email', array(
                ':account_id' => $this->account_id, ':account_email' => $this->account_username
            ));

            if ($account != null && $account->account_id > 0) {
                $this->addError('account_username', 'This email is already used.');
            } else {
                return true;
            }
        } else {
            $this->addError('account_username', 'This email is not a valid email: ' . $this->account_username);
        }

        return false;
    }
}
