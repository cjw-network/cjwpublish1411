<?php
/**
 * Definition of eZTemplate benchmark
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$MarkDefinition = array( 'name' => 'eZTemplate',
                         'marks' => array() );

$MarkDefinition['marks'][] = array( 'name' => 'Template Compiler',
                                    'file' => 'ezmarktemplatecompiler.php',
                                    'class' => 'eZMarkTemplateCompiler' );

?>
