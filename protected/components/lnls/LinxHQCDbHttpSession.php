<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LinxHQCDbHttpSession extends CDbHttpSession
{
    public $sessionTableName = 'linx_session';
    var $autoCreateSessionTable = false;
    
    // deprecated
    // this shall be executed at successful login instead
    public function setCookieSecretValue($value)
    {
        $db=$this->getDbConnection();
        $db->setActive(true);
        $db->createCommand()->update(
            $this->sessionTableName,
            array('session_cookie_secret_value'=>  $value), 
            'id=:id AND session_cookie_secret_value = null ',
            array(':id'=>session_id())
       );
    }
    
    public function setStart($start)
    {
        $db=$this->getDbConnection();
        $db->setActive(true);
        $db->createCommand()->update(
            $this->sessionTableName,
            array('start'=>$start), 
            'id=:id',
            array(':id'=>session_id())
       );
    }
    
    public function setUserId($userId)
    {
        $db=$this->getDbConnection();
        $db->setActive(true);
        $db->createCommand()->update(
            $this->sessionTableName,
            array('account_id'=>$userId), 
            'id=:id',
            array(':id'=>session_id())
       );
    }
    
    public function setBrowserInfo($browserInfo)
    {
        $db=$this->getDbConnection();
        $db->setActive(true);
        $db->createCommand()->update(
            $this->sessionTableName,
            array('browser_info'=>$browserInfo), 
            'id=:id',
            array(':id'=>session_id())
       );
    }
    
    public function writeSession($id,$data)
    {
        if (parent::writeSession($id, $data)) {
            $this->setUserId(Yii::app()->user->id);
            $this->setStart(time());
            // comment the below line. We do this at login instead.
            //$this->setCookieSecretValue(LinxSession::generateCookieSecretValue(session_id()));
            
            $browser = new LinxBrowserDetect();
            $browser_info = $browser->detect();
            $browser_info_php = get_browser(null, true);
            $this->setBrowserInfo($browser_info['name'] . ' ' 
                    . $browser_info['version']
                    . ' ' . $browser_info['platform']
                    . "\n". $browser_info_php['parent']);
        }
    }
}