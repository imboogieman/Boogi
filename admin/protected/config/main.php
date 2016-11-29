<?php

// This is the main Web application configuration.
// Any writable CWebApplication properties can be configured here.
return array(
    'basePath'  => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'      => 'Boogi',

    // Preloading 'log' component
    'preload'   => array('log'),

    // Autoloading model and component classes
    'import'    => array(
        'common.models.*',
        'common.components.*',
        'common.helpers.*',
        'common.behaviors.*',
    ),

    'modules'   => array(),

    // Application components
    'components' => array(
        'user' => array(
            // Enable cookie-based authentication
            'allowAutoLogin' => true,
            'loginUrl' => array('user/login')
        ),
        'urlManager' => array(
            'urlFormat'         => 'path',
            'showScriptName'    => false,
            'rules'             => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'db' => array(
            'connectionString'  => 'mysql:host=127.0.0.1;dbname=boogi_dev',
            'emulatePrepare'    => true,
            'username'          => 'boogi_dev',
            'password'          => 'R7_he#j+a',
            'charset'           => 'utf8',
        ),
        'errorHandler' => array(
            // Use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class'     => 'Logger',
                    'levels'    => 'error, warning',
                    'logPath'   => LOG_PATH
                ),
            ),
        ),
        'email' => array(
            'class'     => 'common.components.Email'
        ),
        'cache' => array(
            'class'     => 'system.caching.CMemCache',
            'servers'   => array(
                array(
                    'host'  => '127.0.0.1',
                    'port'  => 11211
                )
            ),
        )
    ),

    // Application-level parameters that can be accessed
    // Using Yii::app()->params['paramName']
    'params' => array(
        'isDebug'       => false,
        'sendEmail'     => true,
        'emailTestMode' => false,
        'baseUrl'       => 'http://dev.boogi.co/',

        'adminEmail'    => 'info@dev.boogi.co',
        'adminName'     => 'Boogi Admin',

        'fromEmail'     => 'info@dev.boogi.co',
        'fromName'      => 'Boogi Notifications',

        'smtpAuth'      => true,
        'smtpHost'      => 'smtp.gmail.com',
        'smtpPort'      => 465,
        'smtpSecure'    => 'ssl',
        'smtpUser'      => 'info@boogi.co',
        'smtpPassword'  => 'password',

        'ipinfoKey'     => '8067b473e90dd43d4db06cc5dfd490dfd2bf201086fb166fa33e39c9b2d45fb5',
        'googleApiKey'  => 'AIzaSyCLKqHXPHpSPf8FVqCK6Sn7Ki-wazch00Y',

        'fbAppId'       => '177857332412297',
        'fbSecret'      => 'de369485628908e74b2c3396ceb6dcb3',

        'gtApiKey'      => '03767f2fec2f5ef4a1',
        'bitApiKey'     => 'boogi.co',

        'bpAppId'       => '011957277e32b3e807622e52418de8bc',
        'bpSecret'      => 'b0f17725ced82f322c3d55337c57d5ca',

        'mcApiKey'      => '4e1dfc443ecc84c955570ad79523ccae-us3',
        'mdApiKey'      => 'SZeRND7OpK6pjk5PlQxp-w',
    ),
);
