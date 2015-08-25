<?php /* #?ini charset="utf-8"?

# globale einstellungen überschreiben alle inis auch die in den site_extenssions
[DatabaseSettings]
Server=localhost
#Socket=/var/lib/mysql/mysql.sock
DatabaseImplementation=ezmysql
#UsePersistentConnection=enabled
UsePersistentConnection=disabled

#User=
#Password=

DatabasePrefix=ez1411_
#DatabasePostfix=_devel

# This controls if the queries should have an analysis done
# for the debug output (Requires SQLOutput=enabled)
# NOTE: Currently this only works for MySQL.
#QueryAnalysisOutput=enabled

SQLOutput=disabled

# When this setting is larger than 0 the Queries would only be shown in the
# SQLOutput if the execution time took more than <setting> miliseconds.

SlowQueriesOutput=10

[SSLZoneSettings]
SSLZones=disabled

#[SiteSettings]
#SSLPort=8443

[ExtensionSettings]
ActiveExtensions[]

# TODO jac_admin nicht auf github veröffentlichen
ActiveExtensions[]=jac_admin

# enabele gzip compression for all sites
#ActiveExtensions[]=cjw_outputcompression

# Site-Extensions -> Bitte in alpabetischer Reihenfolge

#
## ezp5 site extensions *.cjwpublish1411.*
#

# e.g.  Felix Woldt    => fw.lokal
#       Ekkehard Dörre => ed.lokal
#       Donat Fritschy => df.lokal
#
# www.cjwpublish.com/en
# www.cjwpublish.com.cjwpublish1411.fw.lokal/en
# www.cjwpublish.com.cjwpublish1411.ed.lokal/en
# www.cjwpublish.com.cjwpublish1411.df.lokal/en

ActiveExtensions[]=site_cjwpublish

#
## pure ezpublish_legacy extensions  *.cjwpublish1411l.*
#  directly use  ezroot/ezpublish_legacy as webserverroot
#

# e.g.  Felix Woldt    => fw.lokal
#       Ekkehard Dörre => ed.lokal
#       Donat Fritschy => df.lokal
#
# www.cjwpublish.com/en
# www.cjwpublish.com.cjwpublish1411l.fw.lokal/en
# www.cjwpublish.com.cjwpublish1411l.ed.lokal/en
# www.cjwpublish.com.cjwpublish1411l.df.lokal/en

# ActiveExtensions[]=site_cjwpublish_legacy_only


[Session]
SessionNameHandler=custom

[SiteAccessSettings]

#DefaultAccess=what you want

CheckValidity=false
#RequireUserLogin=true
#RequireUserLogin=false
ForceVirtualHost=true

MatchOrder=host_uri;host;uri
HostMatchType=map
HostUriMatchMethodDefault=start

# nicht setzen, da ansonsten die Einstellungen aus den siteaccess überschrieben werden
# HostMatchMapItems[]
# HostURIMatchMapItems[]
# DefaultHostURIMatchMapItems[]


# JacSecondLevelDomainItems und JacThirdLevelDomainItems werden vom JacToolsHostOperator verwendet

JacSecondLevelDomainItems[]
# felix woldt
JacSecondLevelDomainItems[]=fw
# ekkehard dörre
JacSecondLevelDomainItems[]=ed
# donat fritschy
JacSecondLevelDomainItems[]=df

JacThirdLevelDomainItems[]
JacThirdLevelDomainItems[]=cjwpublish1411


[FileSettings]
StorageFilePermissions=0666

# Store LogFiles globaly or by site.ini Settings
# enabled - all sitaccesses use var/log as LogDir
# disabled - the LogDir is set from site.ini /$VarDir/$LogDir
UseGlobalLogDir=disabled

[MailSettings]
#Mail Debug auf Festplatte var/log/mail/
#! Default = file
#!Transport=file
Transport=file
#Transport=sendmail

#Transport=sendmail
# email should be set in siteaccess
#AdminEmail=xxx@email.de
#EmailSender=Administrator

[ContentSettings]
# Whether to use view caching or not

# ViewCaching muss im eZ5 admin (legacy) aktiviert sein, damit Stash- und HTTP-Cache automatisch
# aktualisiert wird, wenn ein Objekt z.B. bearbeitet wird
#ViewCaching=disabled
ViewCaching=enabled

[SearchSettings]
AllowEmptySearch=true
EnableWildcard=true

[DebugSettings]
#  inline oder popup im siteaccess überschreiben
#Einstellungen in site_extensions vornehmen
Debug=inline
#Debug=popup
DebugOutput=enabled
#DebugOutput=disabled
#DebugRedirection=disabled
#DebugRedirection=enabled
DebugAccess=enabled
DisplayDebugWarnings=disabled
AlwaysLog[]
#DebugByIP=disabled
DebugByIP=enabled

DebugIPList[]=127.0.0.1
DebugIPList[]=127.0.0.2
ScriptDebugOutput=enabled

[TemplateSettings]
#Debug=enabled
ShowXHTMLCode=enabled
ShowUsedTemplates=enabled

DevelopmentMode=enabled

#TemplateCompile=disabled
#TemplateCache=disabled

TemplateCache=enabled


*/ ?>
