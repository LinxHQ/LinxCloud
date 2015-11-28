<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LinxHQCActiveModel
 *
 * @author josephpnc
 */
class LinxHQCActiveModel extends CActiveRecord {
    const MODEL_ACTION_CREATE = 'create';
    const MODEL_ACTION_DELETE = 'delete';
    const MODEL_ACTION_VIEW = 'view';
    const MODEL_ACTION_INDEX = 'index';
    const MODEL_ACTION_ADMIN = 'admin';
    
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return LbCoreEntity the static model class
     */
    public static function model($className=__CLASS__)
    {
    	return parent::model($className);
    }
    
    /**
     * Over rides save
     * @param type $runValidation
     * @param type $attributes
     * @return type
     */
    public function save($runValidation = true, $attributes = null) {
        return parent::save($runValidation, $attributes);
    }
    
    /**
     * 
     * Over rides delete 
     * @return type
     */
    public function delete()
    {
        return parent::delete();
    }
    
    /**
     * Get the url of any action we want
     * 
     * @param unknown $action
     * @param array $params
     * @return multitype:string
     */
    function getActionURL($action, $params = null)
    {
    	$url = '/'.$action;
    	
    	// add params if available
    	if (is_array($params) && count($params))
    	{
    		$url .= '?';
    		foreach ($params as $param_=>$val)
    		{
    			$url .= "$param_=$val&";
    		}
    	}
    	
    	return array($url);
    }
    
    /**
     * Get the normlized url of action
     * 
     * @param unknown $action
     * @param array $params
     * 
     * @return string url
     * @access public
     */
    function getActionURLNormalized($action, $params = null)
    {
    	return CHtml::normalizeUrl($this->getActionURL($action, $params));
    }
    
    
    //******************* PERMISSIONS **************************//
    function canCreate()
    {
        
    }
    
    function canUpdate()
    {
        
    }
    
    function canDelete()
    {
        
    }
    
    function canView()
    {
        
    }
    
    function canList()
    {
        
    }
    
    function canDo($action)
    {
        
    }
}
