<?php
/**
 * File containing the eZWizardBaseClassLoader class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package lib
 */

/*!
  \class eZWizardBaseClassLoader ezwizardbaseclassloader.php
  \brief The class eZWizardBaseClassLoader does

*/

class eZWizardBaseClassLoader
{
    /*!
     \static
     Create new specified class
    */
    static function createClass( $tpl,
                                 $module,
                                 $stepArray,
                                 $basePath,
                                 $storageName = false,
                                 $metaData = false )
    {
        if ( !$storageName )
        {
            $storageName = 'eZWizard';
        }

        if ( !$metaData )
        {
            $http = eZHTTPTool::instance();
            $metaData = $http->sessionVariable( $storageName . '_meta' );
        }

        if ( !isset( $metaData['current_step'] ) ||
             $metaData['current_step'] < 0 )
        {
            $metaData['current_step'] = 0;
            eZDebug::writeNotice( 'Setting wizard step to : ' . $metaData['current_step'], __METHOD__ );
        }
        $currentStep = $metaData['current_step'];

        if ( count( $stepArray ) <= $currentStep )
        {
            eZDebug::writeError( 'Invalid wizard step count: ' . $currentStep, __METHOD__ );
            return false;
        }

        $filePath = $basePath . $stepArray[$currentStep]['file'];
        if ( !file_exists( $filePath ) )
        {
            eZDebug::writeError( 'Wizard file not found : ' . $filePath, __METHOD__ );
            return false;
        }

        include_once( $filePath );

        $className = $stepArray[$currentStep]['class'];
        eZDebug::writeNotice( 'Creating class : ' . $className, __METHOD__ );
        $returnClass =  new $className( $tpl, $module, $storageName );

        if ( isset( $stepArray[$currentStep]['operation'] ) )
        {
            $operation = $stepArray[$currentStep]['operation'];
            return $returnClass->$operation();
            eZDebug::writeNotice( 'Running : "' . $className . '->' . $operation . '()". Specified in StepArray', __METHOD__ );
        }

        if ( isset( $metaData['current_stage'] ) )
        {
            $returnClass->setMetaData( 'current_stage', $metaData['current_stage'] );
            eZDebug::writeNotice( 'Setting wizard stage to : ' . $metaData['current_stage'], __METHOD__ );
        }

        return $returnClass;
    }
}

?>
