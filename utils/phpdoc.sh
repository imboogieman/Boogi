#!/bin/sh
ROOT_PATH="$(dirname "$(pwd)")"
$ROOT_PATH/vendor/phpdocumentor/phpdocumentor/bin/phpdoc project:run --directory=$ROOT_PATH/front --target=$ROOT_PATH/docs/phpdoc
