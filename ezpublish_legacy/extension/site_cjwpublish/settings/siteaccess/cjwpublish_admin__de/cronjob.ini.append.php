<?php /* #?ini charset="utf-8"?

[CronjobSettings]
ExtensionDirectories[]=site_cjwpublish

[linkCheckSettings]
SiteURL[]=http://www.cjwpublish.com

# override ez default settings
[CronjobPart-infrequent]
Scripts[]
#Scripts[]=basket_cleanup.php
#Scripts[]=linkcheck.php

# override ez default settings
[CronjobPart-frequent]
Scripts[]
#Scripts[]=notification.php
#Scripts[]=workflow.php

[CronjobPart-hourly]
Scripts[]
#Scripts[]=cjw_newsletter_mailqueue_create.php
#Scripts[]=cjw_newsletter_mailqueue_process.php
#Scripts[]=workflow.php
#Scripts[]=notification.php
#Scripts[]=hide.php

[CronjobPart-daily]
Scripts[]
#Scripts[]=internal_drafts_cleanup.php
#Scripts[]=old_drafts_cleanup.php
#Scripts[]=jactools_session_cleanup.php

[CronjobPart-weekly]
Scripts[]
#Scripts[]=linkcheck.php

*/ ?>
