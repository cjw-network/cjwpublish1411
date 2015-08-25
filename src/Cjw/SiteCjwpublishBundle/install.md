# Kurzinstallation für Site  cjwpublish  => Cjw/SiteCjwpublishBundle

you can use the install.sh script to create database and user

cd src/Cjw/SiteCjwpublishBundle
sh install.sh


------------------------------------------------------


## 1 - run the following command to create the database

    mysql -u root -p -e 'CREATE DATABASE `ez1411_cjwpublish` CHARACTER SET utf8 COLLATE utf8_general_ci;'

## 2- run the following command to import the data database

    mysql -u root -p ez1411_cjwpublish  < ./data/mysql/ez1411_cjwpublish.sql

## 3- how to activate the site

to activate the site goto  'cjwpublish/config/cjwpublish.yml' and register: 

 Cjw/SiteCjwpublishBundle

## 4- activate the extension:

go to 'ezpublish_legacy/settings/override/site.ini.append.php' and register

    ActiveExtensions[]=site_cjwpublish

## 5- how to open the site:

visit 

    www.cjwpublish.de.cjwpublish1411.[tm|gw|mw|fw|jm|dm].lokal

after the bundle has been activated

## console symlink generieren

    php cjwpublish/console --create-symlinks
    
## legacy symlink erstellen wenn legacy part im Bundle unter ezpublish_legacy liegt

    php cjwpublish/console-cjwpublish ezpublish:legacybundles:install_extensions
    
## assetic generieren wenn erforderlich

    php cjwpublish/console-cjwpublish assetic:dump --env="dev"
    php cjwpublish/console-cjwpublish assetic:dump --env="prod"    
    
## assets css / js / image link auf public folder

    php cjwpublish/console-cjwpublish assets:install web --symlink

## cache löschen

    php cjwpublish/console-cjwpublish/console cache:clear    