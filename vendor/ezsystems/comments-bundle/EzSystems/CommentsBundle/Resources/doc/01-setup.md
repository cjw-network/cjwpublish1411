# EzSystemsCommentsBundle installation

# A) Download and install EzSystemsCommentsBundle

To install EzSystemsCommentsBundle run the following command

```bash
$ php composer.phar require ezsystems/comments-bundle
```

# B) Enable the bundle

Enable EzSystemsCommentsBundle in the kernel:

```php
// ezpublish/EzPublishKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new EzSystems\CommentsBundle\EzSystemsCommentsBundle(),
    );
}
```

# C) Clear your legacy caches

The CommentsBundle integrates into the legacy backoffice using the [LegacyBundles] feature. It integrates an ezcommentsbundle extension, automatically enabled, that adds a contextual comment tab to content in the backoffice. This tab will render the comments form, as configured with CommentsBundle, and allow moderation of comments, or posting of new ones (suppport depends on the active driver).

To enable this tab, make sure you clear the legacy cache after you have registered the bundles:
`php app/console ezpublish:legacy:script bin/php/ezcache.php --clear-all`

[LegacyBundles]: https://confluence.ez.no/display/EZP/Legacy+code+and+features#Legacycodeandfeatures-Legacybundles

### Continue to the next step
When you're done you can start configuring your comments providers:
[Step 2: Configure your comments providers](02-configuration.md).
