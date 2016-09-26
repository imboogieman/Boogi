Boogi App
==========================================================

Social network for promoters


Installation:
----------------------------------------------------------

For app installation you can use install scripts (/utils/install.sh). 
Currently these scripts in beta. If you will have errors please use instructions bellow.


1. Install LAMP stack (script may be outdated):

        $ ./utils/lamp.sh

2. Clone source:

        $ git clone git@bitbucket.org:manti_by/boogi.git /var/www/boogi/

3. Run composer to install general dependencies:
    
        $ composer install --no-dev

    *How to install composer please read [www.getcomposer.org](http://getcomposer.org/doc/00-intro.md)*

4. Run install script OR manually create local files and dirs:

    4.1 Run install script:

        $ ./utils/install.sh

    4.2 Or create local config files:
    
        $ cd front/protected/config/
        $ cp main.php main-local.php
        
        $ cd admin/protected/config/
        $ cp main.php main-local.php
        $ cp console.php console-local.php

    4.3 Update main-local.php, console-local.php with your environment settings
    
    4.4 Create image directories:
    
        $ cd front/images/
        $ mkdir storage
        $ cd front/images/storage/
        $ mkdir artist gig promoter temp venue
        $ cd front/images/
        $ chmod -r 777 storage/

        $ cd admin/
        $ mkdir assets
        $ chmod 777 assets/

    4.5 Create runtime directories:
    
        $ cd front/protected/
        $ mkdir runtime
        $ chmod 777 runtime/

        $ cd admin/protected/
        $ mkdir runtime
        $ chmod 777 runtime/

    4.6 Create index file (choose dev or prod extension for file):

        $ cd front/protected/
        $ cp index.php.dev index.php
        $ chmod 777 runtime/

5. Run migrations to setup DB:
    
        $ ./admin/protected/yiic migrate

    *Also you can use latest database script from docs directory*
    
        $ cd docs/database/
        $ mysql -u root -p
        $ create database boogi;
        $ use boogi;
        $ source latest.sql;
    
6. Add following cron jobs:
    
        # Get events
        0 3 * * *       /path_to_project_source/src/admin/protected/yiic Bandsintown UpdateEvents
        30 3 * * *      /path_to_project_source/src/admin/protected/yiic Facebook UpdateEvents
        
        # Merge and clean Venues
        30 5 * * *      /path_to_project_source/src/admin/protected/yiic System UpdateVenues
        
        # Validate base objects
        10 0 1 * *      /path_to_project_source/src/admin/protected/yiic System ValidateObjects
        
        # Run Mailer queue
        1/60 * * * *    /path_to_project_source/src/admin/protected/yiic Mailer SendEventEmails


Setup Test Environment
----------------------------------------------------------

1. Install test packages (currently works only on unix platforms):

        $ composer install --dev
        
2. Download latest [Chrome Driver](http://chromedriver.storage.googleapis.com/index.html)

3. Copy driver to global bin path (typically for Linux)

        $ sudo cp chromedriver /usr/local/bin/
        $ sudo chmod +x /usr/local/bin/chromedriver

4. Install Google Chrome web browser and its dependencies

        $ sudo apt-get install -f -y libappindicator1 libxss1 libpango1.0-0 xdg-utils
        $ sudo dpkg -i google-chrome-stable_current_amd64.deb

5. Install GUI wrapper for browser support

        $ sudo apt-get install Xvfb
        
6. Run Xvfb wrapper and configure display

        $ Xvfb :15 -ac -screen 0 1024x768x8 &
        $ google-chrome

7. Run Selenium server

        $ ./utils/seserver

8. Make PHPUnit executable system wide (optional)

        $ sudo cp ./vendor/phpunit/phpunit/phpunit /usr/local/bin/
        $ sudo chmod +x /usr/local/bin/phpunit
        
9. Add to hosts file link to local domain

        $ sudo vim /etc/hosts
        $ 127.0.0.1 local.boogi.co

10. Run tests

        $ cd ./front/protected/tests
        $ phpunit functional


Code Guidelines:
----------------------------------------------------------

Please use [PEAR code standards](http://pear.php.net/manual/en/standards.php)
