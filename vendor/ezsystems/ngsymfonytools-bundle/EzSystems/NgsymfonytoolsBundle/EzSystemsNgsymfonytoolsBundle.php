<?php

namespace EzSystems\NgsymfonytoolsBundle;

use eZ\Bundle\EzPublishLegacyBundle\LegacyBundles\LegacyBundleInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EzSystemsNgsymfonytoolsBundle extends Bundle implements LegacyBundleInterface
{
    public function getLegacyExtensionsNames()
    {
        return array( 'ngsymfonytools' );
    }
}
