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
        'common.behaviors.*',
        'application.models.*',
        'application.controllers.api.*',
    ),

    'modules'   => array(),

    // Application components
    'components' => array(
        'user' => array(
            // Enable cookie-based authentication
            'allowAutoLogin' => true,
            'loginUrl' => array (
                'promoter/login'
            )
        ),
        'urlManager' => array(
            'urlFormat'         => 'path',
            'showScriptName'    => false,
            'rules'             => array(
                'api/<controller:\w+>/<action:\w+>' => 'API/<controller>/<action>',
                '<controller:.*>' => 'site/index',
            ),
        ),
        'db' => array(
            'connectionString'  => 'mysql:host=127.0.0.1;dbname=boogi.co',
            'emulatePrepare'    => true,
            'username'          => 'root',
            'password'          => 'password',
            'charset'           => 'utf8',
        ),
        'errorHandler' => array(
            // Use 'site/error' action to display errors
            'errorAction'       => 'site/error',
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
        'baseUrl'       => 'http://boogi.co',
        'adminUrl'      => 'http://admin.boogi.co',

        'adminEmail'    => 'info@boogi.co',
        'adminName'     => 'Boogi Admin',

        'fromEmail'     => 'info@boogi.co',
        'fromName'      => 'Boogi Notifications',

        'smtpAuth'      => true,
        'smtpHost'      => 'smtp.gmail.com',
        'smtpPort'      => 465,
        'smtpSecure'    => 'ssl',
        'smtpUser'      => 'info@boogi.co',
        'smtpPassword'  => 'password',

        'ipinfoKey'     => '8067b473e90dd43d4db06cc5dfd490dfd2bf201086fb166fa33e39c9b2d45fb5',
        'googleApiKey'  => 'AIzaSyDwABveJ-O5F0i5fUSo3dHWKkkpfzx2Po4',

        'fbAppId'       => '177857332412297',
        'fbSecret'      => 'de369485628908e74b2c3396ceb6dcb3',

        'gtApiKey'      => '03767f2fec2f5ef4a1',
        'bitApiKey'     => 'boogi.co',

        'gaCounter'     => 'UA-36308334-2',
        'gaDomain'      => 'boogi.co',
        'yaCounter'     => 24423476,

        'metatitle'     => 'Boogi',
        'metakeys'      => 'Boogi',
        'metadesc'      => 'Boogi'
    ),
);