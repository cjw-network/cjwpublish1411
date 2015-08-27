#!/bin/sh

# script for installing  SiteCjwpublishBundle - creating Mysql Database 'ez1411_cjwpublish'
#
# if vhost is configured correctly + dns or you local hosts file
#
# 127.0.0.1 www.cjwpublish.com.cjwpublish1411.fw.lokal www.cjwpublish.com.cjwpublish1411dev.fw.lokal www.cjwpublish.com.cjwpublish1411l.fw.lokal
#
# you can access the new site with
# www.cjwpublish.com.cjwpublish1411.fw.lokal

# http://www.cjwpublish.com.cjwpublish1411dev.fw.lokal/  english site (default)
# http://www.cjwpublish.com.cjwpublish1411dev.fw.lokal/en  english site
# http://www.cjwpublish.com.cjwpublish1411dev.fw.lokal/de  german site
# http://www.cjwpublish.com.cjwpublish1411dev.fw.lokal/admin_en/   english admininterface
# http://www.cjwpublish.com.cjwpublish1411dev.fw.lokal/admin_de/   german admininterface

# cd src/Cjw/SiteCjwpublishBundle
# sh install.sh

CURRENT_DIR=`pwd`

cd ..
cd ..
cd ..

EZROOT=`pwd`


echo "# INSTALL - SiteCjwpublishBundle #"

echo "- you should execute this script as root! #"


# make sure that the bundle is activated in ezroot/cjwpublish/config/cjwpublish.yml

# cjwpublish:
#    active_site_bundles:
#        - Cjw/SiteCjwpublishBundle

echo "#1# mysql user root: creating MYSQL User 'cjwpublish' with password 'cjwpublish' and empty Database 'ez1411_cjwpublish'"
echo "mysql -uroot -p < src/Cjw/SiteCjwpublishBundle/data/mysql/create_db_ez1411_cjwpublish.sql"
mysql -uroot -p < src/Cjw/SiteCjwpublishBundle/data/mysql/create_db_ez1411_cjwpublish.sql


echo "#2# importing demo data into ez1411_cjwpublish"
echo "mysql -uroot -p ez1411_cjwpublish < src/Cjw/SiteCjwpublishBundle/data/mysql/ez1411_cjwpublish.sql"
mysql -uroot -p ez1411_cjwpublish < src/Cjw/SiteCjwpublishBundle/data/mysql/ez1411_cjwpublish.sql


echo "#3# copy var folder of cjwpublish demo site "
echo "unzip -u src/Cjw/SiteCjwpublishBundle/data/cjwpublish.zip -d 'ezpublish_legacy/var'"
unzip -u src/Cjw/SiteCjwpublishBundle/data/cjwpublish.zip -d 'ezpublish_legacy/var'


echo "#4# clearing cache, create symlinks, set filesystemrights"

# delete cjwpublish sitecache so  SiteCjwpublishBundle will be activate correctly
rm -Rf ezpublish_legacy/var/cache_ezp5/cjwpublish

# evtl. fehlenden symlink für console script für das SiteBundle erzeugen
php cjwpublish/console --create-symlinks

# ezpublish_legacy teil installaieren
# php cjwpublish/console-cjwpublish ezpublish:legacybundles:install_extensions --relative

# public folder vom Bundles als symlink unter web/bundles anlegen
php cjwpublish/console-cjwpublish assets:install web --symlink --relative

# symlinks  web/~design ~extension ~share ~var setzen
# this is done already in master setup
#echo "## set relative symlinks  web/~design ~extension ~share ~var"
#php ezpublish/console ezpublish:legacy:assets_install --symlink --relative web   => macht  ../ezpublish/../ezpublish_legacy/design
#ln -s ../ezpublish_legacy/design/ web/design
#ln -s ../ezpublish_legacy/extension/ web/extension
#ln -s ../ezpublish_legacy/share/ web/share
#ln -s ../ezpublish_legacy/var/ web/var

#echo "## ln -s ../ezpublish_legacy/var_cache/ web/var_cache";
#ln -s ../ezpublish_legacy/var_cache/ web/var_cache


# assetics für dev + prod anlegen
php cjwpublish/console-cjwpublish assetic:dump --env="dev"
php cjwpublish/console-cjwpublish assetic:dump --env="prod"


# var_cache/ test-felix / dev löschen => nichts neu erzeugen
php cjwpublish/console-cjwpublish cache:clear --no-warmup --env="dev"

# var_cache/ test-felix / prod löschen => nichts neu erzeugen
php cjwpublish/console-cjwpublish cache:clear --no-warmup --env="prod"


# set filesystem rights => 777 is not for production ;-)
chmod -R 777 web/bundles
chmod -R 777 web/bundles

chmod -R 777 ezpublish_legacy/var/cache
chmod -R 777 ezpublish_legacy/var/cache_ezp5
chmod -R 777 ezpublish_legacy/var/log
chmod -R 777 ezpublish_legacy/var_log

chmod -R 777 ezpublish_legacy/var_log
chmod -R 777 ezpublish_legacy/var_cache

chmod -R 777 ezpublish_legacy/var

echo ""

echo "END of Installation of SiteCjwpublishBundle"

echo "##  Have fun using cjwpublish :-) ###"
cd $CURRENT_DIR
