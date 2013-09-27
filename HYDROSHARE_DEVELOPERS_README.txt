#--------------------------------------------------------------
#
#   These instructions set up a new Ubuntu 12.10 VM
#     as a development environment for HydroShare.
#
#--------------------------------------------------------------


# add to /etc/hosts
127.0.0.1    hydroshare.local

# install dependencies
sudo apt-get install apache2 php5 php5-mysql php5-gd mysql-server git

# set up required mysql user and database
mysql -u root -p
$ CREATE DATABASE drupal_hydroshare;
$ CREATE USER admin@localhost;
$ SET PASSWORD FOR admin@localhost=PASSWORD('water');
$ GRANT ALL PRIVILEGES ON drupal_hydroshare.* TO admin@localhost IDENTIFIED BY 'water';

# download hydroshare code
cd ~
git clone git@github.com:hydroshare/hydroshare.git hydroshare
git checkout development
cd hydroshare

# set up apache virtualhost
Create /etc/apache2/sites-available/hydroshare.local with:
<VirtualHost *:80>
        ServerName hydroshare.localhost
        DocumentRoot /home/<YOURUSERNAME>/hydroshare
        ErrorLog ${APACHE_LOG_DIR}/hydroshare.local-error.log
        CustomLog ${APACHE_LOG_DIR}/hydroshare.local-access.log combined
</VirtualHost>

# turn on new virtualhost
sudo a2ensite hydroshare.local
sudo service apache2 restart

# load hydroshare database
mysql -u admin -p water drupal_hydroshare < sites/default/hydroshare.sql

# load hydroshare settings file
cp sites/default/settings.php.hydroshare sites/default/settings.php

# load new site in browser
http://hydroshare.local

# check log files for interesting stuff during development
/var/log/apache2/hydroshare.local-access.log
/var/log/apache2/hydroshare.local-error.log

