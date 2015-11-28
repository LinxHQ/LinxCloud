<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    private $_id;

    public function authenticate() {
        $username = strtolower($this->username);
        $user = LinxAccount::model()->find('LOWER(account_username)=?', array($username));

        if ($user === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if (!$user->validatePassword($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else {
            $this->_id = $user->account_id;

            // get Profile detail
            $accountProfile = LinxAccountProfile::model()->find('account_id = ?', array($user->account_id));

            $this->username = $user->account_username;
            $this->setState('account_email', $user->account_username);
            //$tz = $user->account_timezone;
            //if (trim($tz) == '')
            //    $tz = 'Asia/Singapore';
            //$this->setState('timezone', $tz);

            if ($accountProfile === null) {
                $this->setState('account_contact_surname', '');
                $this->setState('account_contact_given_name', '');
            } else {
                $this->setState('account_profile_surname', $accountProfile->account_profile_surname);
                $this->setState('account_profile_given_name', $accountProfile->account_profile_given_name);
                $this->setState('account_profile_fullname', $accountProfile->account_profile_fullname);
                $this->setState('account_profile_short_name', $accountProfile->getShortFullName());
            }

            $this->errorCode = self::ERROR_NONE;
        }

        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId() {
        return $this->_id;
    }

}
