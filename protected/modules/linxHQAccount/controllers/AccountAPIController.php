<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccountAPIController
 *
 * @author josephpnc
 * @copyright (c) 2013, Lion and Lamb Soft Pte Ltd 
 */
class AccountAPIController extends LinxHQAPIController {

    public function actionAuthenticate() {

        $this->_checkAuth('account', 'authenticate');
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $identity = new UserIdentity($_POST['email'], $_POST['password']);
            $identity->authenticate();

            if ($identity->errorCode === UserIdentity::ERROR_NONE) {
                // succeeded
                // register a user session
                $duration = 3600 * 24 * 30 * 1000; // 1000 days
                Yii::app()->user->login($identity, $duration);

                // send results json
                $account = LinxHQAccount::model()->findByPk($identity->getId());
                // get account profile id
                $accountProfile = LinxHQAccountProfile::model()->getProfile($account->account_id);
                $account->getMetaData()->columns = array_merge($account->getMetaData()->columns, array('account_profile_id' => ''));
                $account->account_profile_id = $accountProfile->account_profile_id;
                $this->_sendResponse(200, CJSON::encode(array('results' => array($account, $accountProfile))));
            } else {
                // failed
                $account = new Account;
                $account->account_id = 0;
                $this->_sendResponse(200, CJSON::encode(array('results' => array($account), 'failed' => 1)));
            }
        }

        $this->_sendMessageModeNotImplemented('authenticate');
    }

}
