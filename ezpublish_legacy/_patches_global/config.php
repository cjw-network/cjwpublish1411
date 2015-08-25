<?php
/*
   WHAT THIS FILE IS ABOUT - READ CAREFULLY
   ----------------------------------------
   This file contains a documented list of the few configuration points
   available from config.php. The proposed default values below are meant
   to be the most optimized ones, or meaningful examples of what can be achieved.

   In order to have the present settings taken into account, you will need to
   rename this file into config.php, and keep it placed at the root of eZ Publish,
   where config.php-RECOMMENDED is currently placed. Plus, you will need to
   *uncomment* the proposed settings.
*/


/*
   PATH TO THE EZCOMPONENTS
   ------------------------
   config.php can set the components path like:
*/
//ini_set( 'include_path', ini_get( 'include_path' ). PATH_SEPARATOR . '../ezcomponents/trunk' );

/*
    USING BUNDLED COMPONENTS
    ------------------------
    If you are using a distribution of eZ Publish with which the necessary
    eZ Components are bundled (in lib/ezc), then you can use this setting to
    control if the bundled eZ Components should be used (true) or not (false).
    By default, when this setting is not present and the bundled eZ Components are
    present, they will be used. If you're using the bundled eZ Components it's recommended
    to define EZP_USE_BUNDLED_COMPONENTS as a boolean true anyway, for optimal speed.
*/
define( 'EZP_USE_BUNDLED_COMPONENTS', true );


/*
   If you are not using the bundled eZ Components, then for optimal speed it is
   recommended to set EZC_BASE_PATH to either ezc/Base/base.php or Base/src/base.php,
   depending on how you installed the eZ Components. By default, if this setting
   is not present, eZ Publish first tries to include ezc/Base/base.php in the standard
   php include path. If that fails Base/src/base.php is included.
*/
//define( 'EZC_BASE_PATH', '/usr/lib/ezc/Base/base.php' );

/*
   TIMEZONES
   ---------
   The recommended way of setting timezones is via php.ini.
   However you can set the default timezone for your eZ Publish application as shown below.
   More on supported timezones : http://www.php.net/manual/en/timezones.php
*/
//date_default_timezone_set( 'Europe/Paris' );
date_default_timezone_set( 'Europe/Berlin' );

/*
    INI FILES OPTIMIZATIONS
    -----------------------
    This new setting controls whether eZINI should check if the settings have
    been updated in the *.ini-files*. If this check is disabled eZ Publish
    will always used the cached values, lowering the amount of stat-calls to
    the file system, and thus increasing performance.

    Set EZP_INI_FILEMTIME_CHECK constant to false to improve performance by
    not checking modified time on ini files. You can also set it to a string, the name
    of a ini file you still want to check modified time on, best example would be to
    set it to 'site.ini' to make the system still check that but not the rest.
*/
//define( 'EZP_INI_FILEMTIME_CHECK', false );
define( 'EZP_INI_FILEMTIME_CHECK', 'site.ini' );


/*
    KERNEL OVERRIDES
    ----------------
    This setting controls if eZ Publish's autoload system should allow, and
    load classes, which override kernel classes from extensions.
*/
//define( 'EZP_AUTOLOAD_ALLOW_KERNEL_OVERRIDE', true );


/*
    Set EZP_INI_FILE_PERMISSION constant to the permissions you want saved
    ini and cache files to have. This setting also applies to generated autoload files.
    Do keep an octal number as value here ( meaning it starts by a 0 ).
*/
define( 'EZP_INI_FILE_PERMISSION', 0666 );



/*
   CUSTOM AUTOLOAD MECHANISM
   -------------------------
   It is also possible to push a custom autoload method to the autoload
   function stack. Remember to check for class prefixes in such a method, if it
   will not serve classes from eZ Publish and eZ Components.
   Here is an example code snippet to be placed right in this file, in the case
   you would be using your custom Foo framework, in which all PHP classes would be
   prefixed by 'Foo' :

   <code>
       ini_set( 'include_path', ini_get( 'include_path' ). ':/usr/lib/FooFramework/' );
       require 'Foo/ClassLoader.php';

       function fooAutoload( $className )
       {
          if ( 'Foo' == substr( $className, 0, 3 ) )
          {
              FooClassLoader::loadClass( $className );
          }
       }
       spl_autoload_register( 'fooAutoload' );
   </code>
*/

/*
CLUSTERING
----------

In order to serve binary files over HTTP, eZ Publish needs informations about your cluster backend.
Most of these settings will duplicate those found in your file.ini.append.php.
You can optionnaly define those constants in config.cluster.php
*/

/**
* Storage backend. Possible values:
* - dbmysqli (DB cluster, mysqli based)
* - dbmysql (DB cluster, mysql based) DEPRECATED as of 4.7
* - dfsmysqli (DFS cluster, mysqli based)
* - dfsmysql (DFS cluster, mysql based) DEPRECATED as of 4.7)
* - dfspostgres (DFS cluster, postgresql based)
* - dboracle (with appropriate extension),
* - dfsoracle (with appropriate extension)
*/
// define( 'CLUSTER_STORAGE_BACKEND', 'dfsmysqli'  );

/**
* Custom cluster storage backend
* Root relative path to the custom clustering backend. When provided, the gateway filename won't be built based
* on the default path + CLUSTER_STORAGE_BACKEND.
*
* Example: define( 'CLUSTER_STORAGE_GATEWAY_PATH', 'extension/ezoracle/clusterfilehandlers/gateway/dfs.php' );
*/
// define( 'CLUSTER_STORAGE_GATEWAY_PATH', 'extension/name/path/to/gateway.php' );

/**
* Cluster storage host.
* Required.
*/
// define( 'CLUSTER_STORAGE_HOST', 'localhost' );

/**
* Cluster storage port.
* Optional: the default RDBMS port will be used if set to false
*/
// define( 'CLUSTER_STORAGE_PORT', 3306 );

/**
* Cluster storage user
* Required
*/
// define( 'CLUSTER_STORAGE_USER', 'dbuser' );

/**
* Cluster storage password
* Required
*/
// define( 'CLUSTER_STORAGE_PASS', 'dbpassword' );

/**
* Database name
* Required for most RDBMS
*/
// define( 'CLUSTER_STORAGE_DB', 'ezpcluster' );

/**
* Charset to use when communicating with the database.
* Must match the value in file.ini
*/
// define( 'CLUSTER_STORAGE_CHARSET', 'utf8' );

/**
* NFS share path.
* Required ONLY for DFS based clusters
*/
// define( 'CLUSTER_MOUNT_POINT_PATH', '/media/nfs' );

/**
* Enable persistent database connections, for backends with support (currently: Oracle, with appropriate extension)
* Optional. Defaults to false.
*/
// define( 'CLUSTER_PERSISTENT_CONNECTION', false );

/**
* Allow cluster index debugging.
* This MAY reveal internal details, and should not be used in a production environnement.
* Optional. Defaults to false.
*/
// define( 'CLUSTER_ENABLE_DEBUG', true );

/**
* Enable HTTP cache features: if-modified-since & eTags
* Optional. Defaults to true.
*/
// define( 'CLUSTER_ENABLE_HTTP_CACHE', false );

/**
* Enable HTTP range support (partial HTTP downloads)
* Optional. Defaults to true.
* NOTE: This feature is NOT available for DB based cluster handlers, only DFS ones.
*       Thus this constant should be set to false is using eZDB.
*/
// define( 'CLUSTER_ENABLE_HTTP_RANGE', true );

/**
* Enable usage of "Expires" headers.
* Optional. Defaults to 86400 (one day).
* Possible values: false (disable), or a TTL in seconds.
* Can be set to a VERY high value (315569260 for 10 years) as long as you enable
* ezjscore.ini/[Packer]/AppendLastModifiedTime so that the generation timestamp is appended
* to ezjscore pack files
*/
// define( 'CLUSTER_EXPIRY_TIMEOUT', 86400 );

/**
* Enable usage of "X-Powered-By" headers.
* Optional. Defaults to true.
*/
// define( 'CLUSTER_HEADER_X_POWERED_BY', true );




// ###JAC_PATCH_G_04_EZ_2014.11###
// remove all site_ extensions from $GLOBALS['eZINIOverrideDirList'] after activating the current siteaccess
// so we minimise the calls for ini location => file_exists dramatically  fore each .ini and site_extension 3 times
// lib/ezutils/classes/ezextension.php eZExtension::prependSiteAccess
//define( 'JAC_PATCH_JAC_SITE_STRUCTURE_EZ_INI_OVERRIDE_DIR_LIST', true );

// ###JAC_PATCH_G_44_EZ_2014.11###
// if true use separate folder for project logfiles ezroot/var/project/log => ezroot/var_log/prjoect_log
//define( 'JAC_PATCH_USE_EXTRA_FOLDER_VAR_LOG', true );

// if true use separate folder for project cachefiles ezroot/var/project/cache => ezroot/var_cache/prjoect_log
//define( 'JAC_PATCH_USE_EXTRA_FOLDER_VAR_CACHE', true );

// if true put  var/$project/cache/expiry.php into /var/cache/expiry_$project.php so you can leave var/log on hdd and var_cache into RAM
// The expiry.php handle the regeneration of cache and imagealiase in ezplegacy
//define( 'JAC_PATCH_PUT_EXPIRY_TO_GLOBAL_DIR_VAR_CACHE', true );

?>
