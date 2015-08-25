<?php

require_once __DIR__ . '/../../../../cjwpublish/CjwPublishKernel.php';

class CjwSiteCjwpublishKernel extends CjwPublishKernel
{
    /**
     * This method can be used to load additional bundles.
     * It should call parent::registerBundles in order to load all Bundles required to run EzPublish.
     *
     * @return array|\Symfony\Component\HttpKernel\Bundle\Bundle[]
     */
    public function registerBundles()
    {
        $bundles = parent::registerBundles();

        $bundles[] = new Cjw\PublishToolsBundle\CjwPublishToolsBundle();
        $bundles[] = new Cjw\SiteCjwpublishBundle\CjwSiteCjwpublishBundle();

        return $bundles;
    }
}