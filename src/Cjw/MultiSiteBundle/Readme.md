


fieldtypes.ezxml.custom_xsl fixing rootDir  app/../vendor => app/../../../../vendor
===================================================================================


yaml setting hat defautl setting in
/vendor/ezsystems/ezpublish-kernel/eZ/Bundle/EzPublishCoreBundle/Resources/config/fieldtypes.yml

    parameters:

        # FieldType settings
        # Default XSL stylesheets for XmlText rendering to HTML5.
        # Built-in stylesheets are treated as custom for the sake of extensibility.
        ezsettings.default.fieldtypes.ezxml.custom_xsl:
            -
                path: %kernel.root_dir%/../vendor/ezsystems/ezpublish-kernel/eZ/Publish/Core/FieldType/XmlText/Input/Resources/stylesheets/eZXml2Html5_core.xsl
                priority: 0
            -
                path: %kernel.root_dir%/../vendor/ezsystems/ezpublish-kernel/eZ/Publish/Core/FieldType/XmlText/Input/Resources/stylesheets/eZXml2Html5_custom.xsl
                priority: 0

nicht überschrieben sondern nur erweitert. Die falschen Pfade können mit Überschreibung des Yaml Files nicht korrigiert werden

    ezpublish:
        system:
            my_siteaccess_group:

                fieldtypes:
                    ezxml:
                        custom_tags:
                            - { path: %kernel.root_dir%/../../../../vendor/ezsystems/ezpublish-kernel/eZ/Publish/Core/FieldType/XmlText/Input/Resources/stylesheets/eZXml2Html5_core.xsl, priority: 10 }
                            - { path: %kernel.root_dir%/../../../../vendor/ezsystems/ezpublish-kernel/eZ/Publish/Core/FieldType/XmlText/Input/Resources/stylesheets/eZXml2Html5_custom.xsl, priority: 10 }


Darum den Html5 converter von eZ überschrieben und die Pfade korrigiert


/src/Cjw/MultiSiteBundle/Resources/config/services.yml

    #
    # /vendor/ezsystems/ezpublish-kernel/eZ/Bundle/EzPublishCoreBundle/Resources/config/fieldtypes.yml
    ## ezpublish.fieldType.ezxmltext.converter.html5.class: eZ\Bundle\EzPublishCoreBundle\FieldType\XmlText\Converter\Html5
    ## fixing root_dir for fieldtypes.ezxml.custom_xsl value
    ## app/../vendor => app/../../../../vendor bcause we move the kernel (app) into SiteBundle
    ezpublish.fieldType.ezxmltext.converter.html5.class: Cjw\MultiSiteBundle\FieldType\XmlText\Converter\Html5

/src/Cjw/MultiSiteBundle/FieldType/XmlText/Converter/Html5.php

---------

/cjwpublish/config/config.yml

DBName Prefix definieren um global den Prefix zu setzen:

parameters:
    database_prefix: 'ez1411_'


    => der Parameter kann dann zum Bilder des dbnamens genutzt werden:
    src/Jac/SiteTestFelixBundle/app/config/config.yml
    
    doctrine:
        dbal:
            default_connection: ezp_connection
            connections:
                ezp_connection:
                    driver:   pdo_mysql
                    host:     %database_host%
                    port:     %database_port%
                    dbname:   %database_prefix%%cjwsite.name.project%

---------

2 neue kernel Variablen den yml files zur Verfügung stellen
    
    %cjw_kernel.site_name%  =>  test-project
    %cjw_kernel.bundle_name% => SiteTestProjectBundle


TODOs
=====

- session.save_path  ändern session nicht unter cache speichern sondern eine ebene höher


      session:
          save_path: "%kernel.root_dir%/sessions"
          #The session name defined here will be overridden by the one defined in your ezpublish.yml, for your siteaccess.
          #Defaut session name is "eZSESSID{siteaccess_hash}" (unique session name per siteaccess).
          #See ezpublish.yml.example for an example on how to configure this.


- custom Map\Host der begins with prüft

        https://doc.ez.no/display/EZP/How+to+implement+a+Custom+Tag+for+XMLText+FieldType
        Every custom matcher can be specified with a fully qualified class name (e.g. \My\SiteAccess\Matcher) or by a service identifier prefixed by @ (e.g. @my_matcher_service).