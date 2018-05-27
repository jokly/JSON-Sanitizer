#!/usr/bin/env bash

Update () {
    echo "-- Update packages --"
    sudo apt-get update
    sudo apt-get upgrade
}
Update

echo "-- Install tools and helpers --"
sudo apt-get install -y --force-yes python-software-properties vim htop curl git npm build-essential libssl-dev

echo "-- Install PPA's --"
sudo add-apt-repository ppa:ondrej/php
sudo add-apt-repository ppa:chris-lea/redis-server
Update

# echo "-- Install NodeJS --"
# curl -sL https://deb.nodesource.com/setup_8.x | sudo -E bash -

echo "-- Install packages --"
sudo apt-get install -y --force-yes apache2 git-core
sudo apt-get install -y --force-yes php7.1-common php7.1-dev php7.1-json php7.1-opcache php7.1-cli libapache2-mod-php7.1
sudo apt-get install -y --force-yes php7.1 php7.1-fpm php7.1-curl php7.1-gd php7.1-mcrypt php7.1-mbstring
sudo apt-get install -y --force-yes php7.1-bcmath php7.1-zip php7.1-xml
Update

echo "-- Configure PHP & Apache --"
sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/7.1/apache2/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php/7.1/apache2/php.ini
sudo a2enmod rewrite

echo "-- Creating virtual hosts --"
sudo ln -fs /vagrant/public/ /var/www/app
cat << EOF | sudo tee -a /etc/apache2/sites-available/default.conf
<Directory "/var/www/">
    AllowOverride All
</Directory>

<VirtualHost *:80>
    DocumentRoot /var/www/app
    ServerName app.local
</VirtualHost>
EOF
sudo a2ensite default.conf

echo "-- Restart Apache --"
sudo /etc/init.d/apache2 restart

echo "-- Install Composer --"
curl -s https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

echo "-- Install XDebug --"
git clone https://github.com/xdebug/xdebug.git
cd xdebug
phpize
./configure --enable-xdebug
make
sudo cp modules/xdebug.so /usr/lib/php/20160303/
sudo sh -c 'echo "zend_extension=xdebug.so" >> /etc/php/7.1/apache2/php.ini'
sudo sh -c 'echo "xdebug.remote_enable=1" >> /etc/php/7.1/apache2/php.ini'
sudo sh -c 'echo "xdebug.remote_connect_back=1" >> /etc/php/7.1/apache2/php.ini'
sudo sh -c 'echo "xdebug.remote_port=9000" >> /etc/php/7.1/apache2/php.ini'
sudo sh -c 'echo "xdebug.max_nesting_level=300" >> /etc/php/7.1/apache2/php.ini'
sudo sh -c 'echo "xdebug.remote_autostart=1" >> /etc/php/7.1/apache2/php.ini'
sudo sh -c 'echo "xdebug.scream=0" >> /etc/php/7.1/apache2/php.ini'
sudo sh -c 'echo "xdebug.cli_color=1" >> /etc/php/7.1/apache2/php.ini'
sudo sh -c 'echo "xdebug.show_local_vars=1" >> /etc/php/7.1/apache2/php.ini'
sudo sh -c 'echo "xdebug.remote_log=/var/log/xdebug.log" >> /etc/php/7.1/apache2/php.ini'
sudo sh -c 'echo "xdebug.remote_host=10.0.2.2" >> /etc/php/7.1/apache2/php.ini'
sudo service apache2 restart
sudo service php7.1-fpm restart
cd ..
rm -rf xdebug
