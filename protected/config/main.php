<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

require_once(dirname(__FILE__).'/db.php');

define('SUCCESS', 'success');
define('FAILURE', 'failure');
define('APP_NO_PERMISSION', 'noPermission');
define('YES', 1);
define('NO', 0);
define('LINXHQ_GLOBAL_SESSION_TIMEOUT', 60*60*24*254);

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'LinxCloud',
	'theme' => 'bootstrap',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.components.lnls.*',
		'ext.yii-mail.YiiMailMessage',
                'application.modules.*',
		'application.modules.linxHQAccount.models.*',
                'application.modules.linxHQAccountProfile.models.*',
		//'application.modules.linxHQAccountSubscription.models.*',
                //'application.modules.linxHQAccountTeamMember.models.*',
                'application.modules.linxHQApplication.models.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'mylinxhq123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			//'ipFilters'=>array('127.0.0.1','::1'),            
                        //'generatorPaths'=>array(
			//	'bootstrap.gii',
			//),
		),
            
		'linxHQAccount','linxHQAccountProfile',
		//'linxHQAccountSubscription','linxHQAccountTeamMember',
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
                        //'class'=>'WebUser',
		),
		
            
		'session' => array(
			'class' => 'application.components.lnls.LinxHQCDbHttpSession' ,//'CDbHttpSession',
			'timeout' => LINXHQ_GLOBAL_SESSION_TIMEOUT, // never timeout
			'connectionID' => 'db',
		),
            
            
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
                        'caseSensitive'=>'false',
                        'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		//'db'=>array(
		//	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		//),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => $dbConfig['connectionString'],
			'emulatePrepare' => true,
			'username' => $dbConfig['username'],
			'password' => $dbConfig['password'],
			'charset' => 'utf8',
		),
            
		'mail' => array(
				'class' => 'ext.yii-mail.YiiMail',
				'transportType' => 'smtp', // php
				
				'transportOptions' => array( // only if use smtp
						'host' => 'mail.lionsoftwaresolutions.com',
						//'encryption' => 'ssl',
						'username' => 'postmaster@lionsoftwaresolutions.com',
						'password' => 'LssExpress',
						'port' => 25,
				),
				//'viewPath' => 'application.views.mails',
		),
                
		'bootstrap'=>array(
			'class'=>'bootstrap.components.Bootstrap',
		),
            
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
            
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminID'=>1,
		'adminEmail'=>'admin@linxcircle.com',
		'emailSignature' => 'Have a nice day!<br/>Admin.', // this can contain html
		'documentRootDir' => 'documents/',
		'profilePhotosDir' => 'profile_photos/',
		'enableMobileWeb'=>NO,
                'maxUploadSize'=>20, // MB
                //'HQACCOUNTS_URL'=>'http://accounts.linxenterprisedemo.com/',
                //'HQACCOUNTS_REMOTE_LOGIN_URL' => 'http://accounts.linxenterprisedemo.com/index.php/site/remoteLogin',
                'HQACCOUNTS_URL'=>'http://localhost/LinxHQ/',
                'HQACCOUNTS_REMOTE_LOGIN_URL' => 'http://localhost/LinxHQ/site/remoteLogin',
	),
);