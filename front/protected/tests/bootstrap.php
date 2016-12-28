<?php

// Default constants
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('DOC_ROOT') or define('DOC_ROOT', realpath(dirname(__FILE__) . '/../../'));

// Log path
if (!defined('LOG_PATH')) {
    $path = realpath(DOC_ROOT . '/../../log/');
    if ($path !== false && is_dir($path)) {
        define('LOG_PATH', $path);
    } else {
        $path = realpath('/var/log/boogi/');
        if ($path !== false && is_dir($path)) {
            define('LOG_PATH', $path);
        } else {
            mkdir($path, 0777);
            define('LOG_PATH', $path);
        }
    }
}

// Remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', false);

// Specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

// Include all libraries
require DOC_ROOT . '/../vendor/autoload.php';

// Yii test framework
require_once DOC_ROOT . '/../vendor/yiisoft/yii/framework/yiit.php';

// Common components path
Yii::setPathOfAlias('common', DOC_ROOT . '/../common/');

// Setup config
$configMain = require_once DOC_ROOT . '/protected/config/test.php';
$configTest = require_once DOC_ROOT . '/protected/config/test-local.php';
$config = CMap::mergeArray($configMain, $configTest);

// Test set up
//require_once DOC_ROOT . '/protected/tests/WebTestCase.php';

// Run application
Yii::createWebApplication($config);
