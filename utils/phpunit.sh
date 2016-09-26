#!/bin/sh
ROOT_PATH="$(dirname "$(pwd)")"
php -f $ROOT_PATH/vendor/phpunit/phpunit/phpunit %1
