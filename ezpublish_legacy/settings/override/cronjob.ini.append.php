<?php /* #?ini charset="utf8"?
# the following cronjob parts are available on this system
# only define this settings in the amdin siteaccess cronjob.ini.append.php

[CronjobPart-infrequent]

[CronjobPart-frequent]

[CronjobPart-hourly]

[CronjobPart-daily]

[CronjobPart-weekly]

# JAC PATCH - special settings for runcronjobs-multiple.php
[GlobalCronjobMultipleSettings]

# if enabled for every Cronpart and SiteAccess a separate logFile will be created
CreateExtendedLogFiles=enabled

# the php cli interpreter for execute commandline scripts
PhpCli=/usr/bin/php

# which siteaccesses should be use to run execute the cronjob
# CronjobSiteAccessCronPartArray[$siteacess]=frequent;hourly;daily;weekly

*/ ?>