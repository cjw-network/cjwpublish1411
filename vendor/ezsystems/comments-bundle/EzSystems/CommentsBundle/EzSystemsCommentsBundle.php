<?php
/**
 * File containing the EzSystemsCommentsBundle class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace EzSystems\CommentsBundle;

use EzSystems\CommentsBundle\DependencyInjection\Compiler\ProviderPass;
use EzSystems\CommentsBundle\DependencyInjection\Configuration\Parser\Common;
use EzSystems\CommentsBundle\DependencyInjection\Configuration\Parser\Facebook;
use EzSystems\CommentsBundle\DependencyInjection\EzSystemsCommentsExtension;
use EzSystems\CommentsBundle\DependencyInjection\Configuration\Parser\Disqus as DisqusConfigParser;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EzSystemsCommentsBundle extends Bundle
{
    public function build( ContainerBuilder $container )
    {
        $container->addCompilerPass( new ProviderPass() );
        parent::build( $container );
    }

    public function getContainerExtension()
    {
        return new EzSystemsCommentsExtension();
    }
}
