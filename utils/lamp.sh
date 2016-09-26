#!/bin/sh
CURR_USER="$(sudo sh -c 'echo $SUDO_USER')"

echo "Installing NGINX web server"
sudo apt-get install -y nginx nginx-extras
echo ""

echo "Installing PHP5 with required extensions"
sudo apt-get install -y php5-fpm php5-cgi php5-cli php5-common php-pear php5-gd php5-curl php5-intl php5-json php5-mcrypt php5-memcache php5-mysqlnd php5-xsl
echo ""

echo "Installing MySQL server"
sudo apt-get install -y mysql-server
echo ""

echo "Installing Memcache Server"
sudo apt-get install -y memcached
echo ""

echo "Installing JAVA and GIT"
sudo apt-get install -y git default-jre default-jdk
echo ""

echo "Create directories"
if [ ! -d "/var/www/boogi/" ]; then
    sudo mkdir /var/www/boogi/
    sudo chown $CURR_USER /var/www/boogi/
    sudo chgrp $CURR_USER /var/www/boogi/
fi
if [ ! -d "/var/log/boogi/" ]; then
    sudo mkdir /var/log/boogi/
    sudo chmod 777 /var/log/boogi/
    sudo chown $CURR_USER /var/log/boogi/
    sudo chgrp $CURR_USER /var/log/boogi/
fi
if [ ! -d "/tmp/boogi/" ]; then
    sudo mkdir /tmp/boogi/
    sudo chmod 777 /tmp/boogi/
    sudo chown $CURR_USER /var/log/boogi/
    sudo chgrp $CURR_USER /var/log/boogi/
fi
echo ""

echo "Copy config files"
sudo cp confs/nginx.conf /etc/nginx/sites-available/default
echo ""

echo "Restarting services"
sudo service php5-fpm restart
sudo service nginx restart
echo ""