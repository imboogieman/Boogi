#!/bin/sh
ROOT_PATH="$(dirname "$(pwd)")"

DEFAULT_ENVIRONMENT="dev"
CURRENT_ENVIRONMENT=${1:-"echo $DEFAULT_ENVIRONMENT"}

echo "Create front image directories"
cd $ROOT_PATH/front/images/
mkdir storage
cd $ROOT_PATH/front/images/storage/
mkdir artist gig promoter temp venue
cd $ROOT_PATH/front/images/
chmod 777 -r $ROOT_PATH/front/images/storage/
echo ""

echo "Create front css cache, apply write for lock file"
cd $ROOT_PATH/front/
mkdir cache
cd $ROOT_PATH/front/cache/
touch css.lock
touch js.lock
mkdir css js
chmod 777 -r $ROOT_PATH/front/cache/
echo ""

echo "Create front runtime directory"
cd $ROOT_PATH/front/protected/
mkdir runtime
chmod 777 runtime/
echo ""

echo "Create front local config"
cd $ROOT_PATH/front/protected/config/
cp main-local.php.example main-local.php
echo ""

echo "Create front index file"
cd $ROOT_PATH/front/protected/
cp index.php.$CURRENT_ENVIRONMENT index.php
echo ""

echo "Create admin image directories"
cd $ROOT_PATH/admin/
mkdir assets
chmod 777 assets/
echo ""

echo "Create admin runtime directory"
cd $ROOT_PATH/admin/protected/
mkdir runtime
chmod 777 runtime/
echo ""

echo "Create admin local configs"
cd $ROOT_PATH/admin/protected/config/
cp main-local.php.example main-local.php
cp console-local.php.example console-local.php
echo ""

echo "Check composer in your system"
command -v composer >/dev/null 2>&1 || {
    echo "Trying to install composer"
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
}
echo ""

echo "Run composer"
cd $ROOT_PATH
composer install
echo ""

echo "All done"