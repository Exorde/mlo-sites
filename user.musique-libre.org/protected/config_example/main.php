<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Yii User',
        'theme'=>'',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
    'application.modules.user.models.*',
    'application.modules.user.components.*',
    'application.modules.rights.*',
    'application.modules.rights.components.*',

	),
	'modules'=>array(
		// uncomment the following to enable the Gii tool
                'gii'=>array(
		    'class'=>'system.gii.GiiModule',
		    'password'=>'password',
		    // If removed, Gii defaults to localhost only. Edit carefully to taste.
		    'ipFilters'=>array('127.0.0.1','::1'),
		),
                'rights'=>array(
                    'install'=>false,
                ),
               'message' => array(
                        'userModel' => 'Users',
                        'getNameMethod' => 'getFullName',
                        'getSuggestMethod' => 'getSuggest',
                        'viewPath' => '/message/fancy',
                ),
                
                'user'=>array(
                    # encrypting method (php hash function)
                    'hash' => 'crypt',
         
                    # send activation email
                    'sendActivationMail' => true,
         
                    # allow access for non-activated users
                    'loginNotActiv' => false,
         
                    # activate user on registration (only sendActivationMail = false)
                    'activeAfterRegister' => false,
         
                    # automatically login from registration
                    'autoLogin' => true,
         
                    # registration path
                    'registrationUrl' => array('/user/registration'),
         
                    # recovery password path
                    'recoveryUrl' => array('/user/recovery'),
         
                    # login form path
                    'loginUrl' => array('/user/login'),
         
                    # page after login
                    'returnUrl' => array('/user/profile'),
         
                    # page after logout
                    'returnLogoutUrl' => array('/user/login'),
                    
                ),
),

	// application components
	'components'=>array(
		'user'=>array(
	            'class'=>'RWebUser',
                // enable cookie-based authentication
                    'allowAutoLogin'=>true,
                    'loginUrl'=>array('/user/login'),
		),
    'copyvalues'=>array(
      'class'=>'copyValues'    
    ),
                    

		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
                'authManager'=>array(
                    'class'=>'RDbAuthManager',
                    'connectionID'=>'db',
                    'defaultRoles'=>array('Authenticated', 'Guest'),
                ),
                /*
                // uncomment the following to use a sqlite database
                
    // Comment the following to use a sqlite database
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=@@yiiDBName@@',
			'emulatePrepare' => true,
			'username' => '@@yiiDBUser@@',
			'password' => '@@yiiDBPass@@',
			'charset' => 'utf8',
			'tablePrefix' => '',
		),
		'dbforum'=>array(
      'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=@@forumDBName@@',
			'emulatePrepare' => true,
			'username' => '@@forumDBUser@@',
			'password' => '@@forumDBPass@@',
			'charset' => 'utf8',
			'tablePrefix' => 'vanilla_',
		),
		'dbblog'=>array(
      'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=@@blogDBName@@',
			'emulatePrepare' => true,
			'username' => '@@blogDBUser@@',
      'password' => '@@blogDBPass@@',
			'charset' => 'utf8',
			'tablePrefix' => 'wp_',
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
		'adminEmail'=>'webmaster@example.com',
	),
);
