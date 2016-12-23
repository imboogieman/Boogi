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
            'connectionString'  => 'mysql:host=127.0.0.1;dbname=boogi_dev',
            'emulatePrepare'    => true,
            'username'          => 'boogi_dev',
            'password'          => 'R7_he#j+a',
            'charset'           => 'utf8',
            'initSQLs' => array("SET SESSION sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';")
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

        'baseUrl'       => 'https://dev.boogi.co/',
        'adminUrl'      => 'https://admin.dev.boogi.co/',

        'adminEmail'    => 'info@dev.boogi.co',
        'adminName'     => 'Boogi Admin',

        'sendEmail'     => true,
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

        'fbAppId'       => '1591226087852311',
        'fbSecret'      => '3b8c698f5cc59b6fd3b22279221842bc',

        'gtApiKey'      => '03767f2fec2f5ef4a1',
        'bitApiKey'     => 'starway.pro',

        'gaCounter'     => 'UA-36308334-2',
        'gaDomain'      => 'boogi.co',
        'yaCounter'     => 24423476,

        'metatitle'     => 'Boogi helps professional promoters and artists to optimize time, effort and cost on bookings and tour management.',
        'metakeys'      => 'Boogi, promoters, artists, booking, tour management.',
        'metadesc'      => 'Boogi helps professional promoters and artists to optimize time, effort and cost on bookings and tour management.',

        'mcApiKey'      => '4e1dfc443ecc84c955570ad79523ccae-us3',
        'mdApiKey'      => 'hMxnW8-5BJAKzC7HHxSUdg',
    ),
);