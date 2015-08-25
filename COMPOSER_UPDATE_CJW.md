COMPOSER_UPDATE.md  - alle Änderungen vom standard ez Paket hier dokumentiert
=============================================================================

20141211 -  fwoldt: neues Paket  doctrine/orm in composer.json hinzugefügt            

             "doctrine/orm" : "2.4.6"        
        
        ... dann
             
        ./composer.phar update doctrine/orm --no-dev
        
        oder
        
        php ./composer.phar require doctrine/orm 2.4.6 --update-no-dev
        

        