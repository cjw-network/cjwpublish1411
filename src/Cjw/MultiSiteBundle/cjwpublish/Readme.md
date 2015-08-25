ezpüpblish5 Multiseite setup

- Domain:  www.cjw-network.com
- SiteName = cjw-network

- SiteBundleName =  src/Cjw/SiteCjwNetworkBundle

-- liest die aktvierte sites durch
- SiteClassBaseName = CjwSiteCjwNetwork

- SiteKernelClassName = CjwSiteCjwNetworkKernel
- SiteKernelCacheName = CjwSiteCjwNetworkCache

- SiteKernelClassFile = src/Cjw/SiteCjwNetworkBundle/app/SiteCjwNetworkKernel.php
- SiteKernelCacheFile = src/Cjw/SiteCjwNetworkBundle/app/SiteCjwNetworkCache.php

- SiteCacheDir =  web/var/cjw-network/cache_ezp5
- SiteLogDir =    web/var/cjw-network/log_ezp5


ezp4:

site extension name:  site_cjw-network
dbname:               ez1311_cjw-network


Console:
========

für jedes Sitebundle muss ein symlink erstellt werden

cd ezroot/cjwpublish
ln -s console console-sitemame
ln -s console console-cjw-network

=> alle Symlinks der aktivene SiteBundles ( cjwpublish/config/cjwpublish.yml )
können mit folgendem Script generiert werden

php ./cjwpublish/console --create-symlinks




Aufruf der Site console

php cjwpublish/console-cjw-network


cjwpublish - server Installation
================================

1. copy CjwMultiSiteBundle into /src/Cjw/MultiSiteBundle
2. create root directory with MultiSiteKernel ezroot/cjwpublish and  ezroot/web/index.php which loads cjwpublish kernel

    sh src/Cjw/MultiSiteBundle/install/install_cjwpublish.sh

3. create a new SiteBundle
    src/Jac/JacSiteProjectNameBundle

4. activate SiteBundle in   cjwpublish/config/cjwpublish.yml

5. create symlink for all active Sitebundles

    php ./cjwpublish/console --create-symlinks

6. use console for your site to create all normal stuff e.g.

    php ./cjwpublish/console-project-name assets:install web --symlink