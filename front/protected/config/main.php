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
        'common.behaviors.*',
        'common.components.*',
        'common.helpers.*',
        'common.models.*',
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
                'api/' => 'site/api',
                '<controller:.*>' => 'site/index',
            ),
        ),
        'db' => array(
            'connectionString'  => 'mysql:host=127.0.0.1;dbname=local.boogi.co',
            'emulatePrepare'    => true,
            'username'          => 'boogi',
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
                array(
                    'class'              => 'CDbLogRoute',
                    'levels'             => 'error, warning',
                    'logTableName'       => 'error',
                    'connectionID'       => 'db',
                    'autoCreateLogTable' => true,
                    'filter'             => 'CLogFilter',
                )
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
        ),
        'image'=>array(
            'class'     => 'common.components.image.CImageComponent',
            'driver'    => 'GD',
        ),
    ),

    // Application-level parameters that can be accessed
    // Using Yii::app()->params['paramName']
    'params' => array(
        'isDebug'       => false,
        'enableCache'   => true,
        'emailTestMode' => false,

        'baseUrl'       => 'http://boogi.co',
        'adminUrl'      => 'http://admin.boogi.co',

        'adminEmail'    => 'info@boogi.co',
        'adminName'     => 'Boogi Admin',

        'sendEmail'     => true,
        'fromEmail'     => 'info@boogi.co',
        'fromName'      => 'Boogi Notifications',

        'smtpAuth'      => true,
        'smtpHost'      => 'smtp.gmail.com',
        'smtpPort'      => 465,
        'smtpSecure'    => 'ssl',
        'smtpUser'      => 'info@boogi.co',
        'smtpPassword'  => 'password',

        'ipinfoKey'     => '8067b473e90dd43d4db06cc5dfd490dfd2bf201086fb166fa33e39c9b2d45fb5',
        'googleApiKey'  => 'AIzaSyA4124zZrcbE0GpcX3cZscWqlwjYDQCNzQ',

        'fbAppId'       => '177857332412297',
        'fbSecret'      => 'de369485628908e74b2c3396ceb6dcb3',

        'gtApiKey'      => '03767f2fec2f5ef4a1',
        'bitApiKey'     => 'starway.pro',

        'gaCounter'     => 'UA-36308334-2',
        'gaDomain'      => 'boogi.co',
        'yaCounter'     => 24423476,

        'metatitle'     => 'Boogi helps professional promoters and artists to optimize time, effort and cost on bookings and tour management.',
        'metakeys'      => 'Boogi, promoters, artists, booking, tour management.',
        'metadesc'      => 'Boogi helps professional promoters and artists to optimize time, effort and cost on bookings and tour management.',

        'mcApiKey'      => '4e1dfc443ecc84c955570ad79523ccae-us3',
        'mdApiKey'      => 'SZeRND7OpK6pjk5PlQxp-w',
    ),
);