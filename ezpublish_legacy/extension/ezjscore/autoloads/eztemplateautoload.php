<?php
/**
 * Template autoload definition for eZ JS Core
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 *
 */

/**
 * Look in the operator files for documentation on use and parameters definition.
 *
 * @var array $eZTemplateOperatorArray
 */

$eZTemplateOperatorArray = array();
$eZTemplateOperatorArray[] = array( 'script' => 'extension/ezjscore/autoloads/ezjscpackertemplatefunctions.php',
                                    'class' => 'ezjscPackerTemplateFunctions',
                                    'operator_names' => array( 'ezscript',
                                                               'ezscript_require',
                                                               'ezscript_load',
                                                               'ezscriptfiles',
                                                               'ezcss',
                                                               'ezcss_require',
                                                               'ezcss_load',
                                                               'ezcssfiles' ) );

$eZTemplateOperatorArray[] = array( 'script' => 'extension/ezjscore/autoloads/ezjscencodingtemplatefunctions.php',
                                    'class' => 'ezjscEncodingTemplateFunctions',
                                    'operator_names' => array( 'json_encode',
                                                               'xml_encode',
                                                               'node_encode',
) );

$eZTemplateOperatorArray[] = array( 'script' => 'extension/ezjscore/autoloads/ezjscaccesstemplatefunctions.php',
                                    'class' => 'ezjscAccessTemplateFunctions',
                                    'operator_names' => array( 'has_access_to_limitation',
) );


?>
