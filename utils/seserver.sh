#!/usr/bin/env bash
ROOT_PATH="$(dirname "$(pwd)")"
java -jar $ROOT_PATH/vendor/se/selenium-server-standalone/composer/bin/selenium-server-standalone.jar -Dwebdriver.chrome.driver=/usr/local/bin/chromedriver
