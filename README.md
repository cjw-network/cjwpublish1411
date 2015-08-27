#CjwPublish MultiSite Demo Installation based on eZ Publish 2014.11

Copyright (C) 2007-2015 by CJW Network [www.cjw-network.com](http://www.cjw-network.com)

coolscreen.de - enterprise internet - [coolscreen.de](http://coolscreen.de)
JAC Systeme -  [www.jac-systeme.de](http://www.jac-systeme.de)
Webmanufaktur - [www.webmanufaktur.ch](http://www.webmanufaktur.ch)

License: GPL v2

***

## Features of this installation

- MultiSite eZ Publish Setup (for pure ezpublish 5 sites or/and ezpublish legacy sites) 
- Using of CjwPublishToolsBundle for easy development of ezpublish 5 sites (fetches, pagenavigator, feedback_form ...)


***

## Installation of DemoSite SiteCjwpublishBundle:

DemoBundle is located in src/Cjw/SiteCjwpublishBundle

see https://github.com/cjw-network/cjwpublish1411/blob/master/src/Cjw/SiteCjwpublishBundle/README.md for details

1. get cjwpublish1411 from github 

        git clone https://github.com/cjw-network/cjwpublish1411
 
2. login as root

3. Install demo mysql database: 'ez1411_cjwpublish' and mysql user: 'cjwpublish' pwd: 'cjwpublish' and setup all symlinks in the process you will ask for your root mysql user to create the database 

        cd cjwpublish1411/src/Cjw/SiteCjwpublishBundle
        sh install.sh  

4. setup vhost for *.cjwpublish1411.* *.cjwpublish1411dev.* *.cjwpublish1411l.*
     
    - nginx:
     
    @see example https://github.com/cjw-network/cjwpublish1411/blob/master/_vhost/nginx/etc/nginx/conf.d/cjwpublish1411.conf
    
    @see example https://github.com/cjw-network/cjwpublish1411/blob/master/_vhost/nginx/etc/nginx/conf.d/cjwpublish1411dev.conf
 
    @see example https://github.com/cjw-network/cjwpublish1411/blob/master/_vhost/nginx/etc/nginx/conf.d/cjwpublish1411l.conf
    
    - apache: @see https://github.com/cjw-network/cjwpublish1411/blob/master/doc/apache2/Readme.md
 
5. Accessing your installation 

        http://www.cjwpublish.com.cjwpublish1411.computer.local/    => en
        http://www.cjwpublish.com.cjwpublish1411.computer.local/en  
        http://www.cjwpublish.com.cjwpublish1411.computer.local/de
    
    
    Admin User: 'admin' Password: 'publish'
    
        http://www.cjwpublish.com.cjwpublish1411.computer.local/admin_en
        http://www.cjwpublish.com.cjwpublish1411.computer.local/admin_de   


6. Accessing console of MulitSite DemoBundle

        cd cjwpublish1411
        php cjwpublish/console-cjwpublish

7. enjoy the ezpublish multisite setup for ezpublish 5 and ezpublish_legacy and the simple DemoSite


***

CjwPublishToolsBundle is used for easy development of the Demo Bundle
It can be used in every ezpublish 5 setup and should only located in src/Cjw/PublishToolsBundle

see https://github.com/cjw-network/CjwPublishToolsBundle/blob/master/README.md for details

***
