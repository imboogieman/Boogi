<?php

// Default constants
defined('DOC_ROOT') or define('DOC_ROOT', dirname(__FILE__));
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

// Log path
if (!defined('LOG_PATH')) {
    $path = realpath(DOC_ROOT . '/../../log_dev/');
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

// Remove the following lines after update Yii to version >1.1.14
// For more info please see https://github.com/yiisoft/yii/issues/2642
require DOC_ROOT . '/../vendor/yiisoft/yii/framework/yii.php';

// Common components path
Yii::setPathOfAlias('common', DOC_ROOT . '/../common/');

// Setup config
$configMain = require_once DOC_ROOT . '/protected/config/main.php';
$configLocal = require_once DOC_ROOT . '/protected/config/main-local.php';
$config = CMap::mergeArray($configMain, $configLocal);

// Run application
Yii::createWebApplication($config)->run();
