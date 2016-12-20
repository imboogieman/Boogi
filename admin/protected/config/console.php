<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Boogi',

    // Preloading 'log' component
    'preload' => array('log'),

    // Autoloading model and component classes
    'import' => array(
        'common.models.*',
        'common.components.*',
        'common.behaviors.*',
    ),

    // Application components
    'components' => array(
        'db' => array(
            'connectionString'  => 'mysql:host=127.0.0.1;dbname=boogi_dev',
            'emulatePrepare'    => true,
            'username'          => 'boogi_dev',
            'password'          => 'R7_he#j+a',
            'charset'           => 'utf8',
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
        )
    ),

    // Application-level parameters that can be accessed
    // Using Yii::app()->params['paramName']
    'params' => array(
        'isDebug'       => false,
        'sendEmail'     => true,
        'emailTestMode' => false,

        'baseUrl'       => 'http://dev.boogi.co/',
        'adminUrl'      => 'http://admin.dev.boogi.co/',

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
        'mdApiKey'      => 'hMxnW8-5BJAKzC7HHxSUdg',
    ),
);
