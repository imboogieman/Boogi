echo off
echo.

echo Create front image directories
cd ../front/images
mkdir artist gig promoter temp venue
echo.

echo Create cache
cd ../front
mkdir cache
cd cache
type NUL > css.lock
type NUL > js.lock
mkdir css js
echo.

echo Create runtime directory
cd ../../protected
mkdir runtime
echo.

echo Create local config
cd ./config
copy main-local.php.example main-local.php
echo.

echo Create admin assets directories
cd ../../../admin
mkdir assets
echo.

echo Create admin runtime directory
cd ./protected
mkdir runtime
echo.

echo Create admin local configs
cd ./config
copy main-local.php.example main-local.php
copy onsole-local.php.example console-local.php
echo.

echo Run composer
cd ../../../
composer install
echo.

echo All done, please update app config with your local params

echo.
pause