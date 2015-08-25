<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$http = eZHTTPTool::instance();

$module = $Params['Module'];
$packageName = $Params['PackageName'];
$installer = false;
$currentItem = 0;
$displayStep = false;

if ( $http->hasSessionVariable( 'eZPackageInstallerData' ) )
{
    $persistentData = $http->sessionVariable( 'eZPackageInstallerData' );
    if ( isset( $persistentData['currentItem'] ) )
        $currentItem = $persistentData['currentItem'];
    $packageName = $persistentData['package_name'];
}
else
{
    $persistentData = array();
    $persistentData['package_name'] = $packageName;
    $persistentData['currentItem'] = $currentItem;
    $persistentData['doItemInstall'] = false;
    $persistentData['error'] = array();
    $persistentData['error_default_actions'] = array();
}

if ( !eZPackage::canUsePolicyFunction( 'install' ) )
    return $module->handleError( eZError::KERNEL_ACCESS_DENIED, 'kernel' );

$package = eZPackage::fetch( $packageName );
if ( !$package )
    return $module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );

$installItemArray = $package->installItemsList( false, eZSys::osType() );

$tpl = eZTemplate::factory();

if ( $module->isCurrentAction( 'SkipPackage' ) )
{
    $http->removeSessionVariable( 'eZPackageInstallerData' );
    return $module->redirectToView( 'view', array( 'full', $package->attribute( 'name' ) ) );
}
elseif ( $module->isCurrentAction( 'InstallPackage' ) )
{
    $persistentData['doItemInstall'] = true;
}
elseif ( $module->isCurrentAction( 'HandleError' ) )
{
    $persistentData['doItemInstall'] = true;

    // Choosing error action
    if ( $module->hasActionParameter( 'ActionID' ) )
    {
        $choosenAction = $module->actionParameter( 'ActionID' );

        $persistentData['error']['choosen_action'] = $choosenAction;
        if ( $module->hasActionParameter( 'RememberAction' ) )
        {
            $errorCode = $persistentData['error']['error_code'];
            $itemType = $installItemArray[$currentItem]['type'];
            if ( !isset( $persistentData['error_default_actions'][$itemType] ) )
                $persistentData['error_default_actions'][$itemType] = array();
            $persistentData['error_default_actions'][$itemType][$errorCode] = $choosenAction;
        }
    }
    elseif ( !isset( $persistentData['error']['error_code'] ) )
    {
        // If this is an unhandled error, we are skipping this item
        $currentItem++;
    }
}
elseif ( $module->isCurrentAction( 'PackageStep' ) && !$persistentData['doItemInstall'] )
{
    $installItem = $installItemArray[$currentItem];
    $installerType = $module->actionParameter( 'InstallerType' );
    $installer = eZPackageInstallationHandler::instance( $package, $installerType, $installItem );
    $installer->generateStepMap( $package, $persistentData );
    $displayStep = true;
}
elseif ( !$persistentData['doItemInstall'] )
{
    // Displaying a list of items to install
    $installElements = array();
    foreach ( $installItemArray as $installItem )
    {
        $handler = eZPackage::packageHandler( $installItem['type'] );
        if ( $handler )
        {
            $installElement = $handler->explainInstallItem( $package, $installItem );
            if ( $installElement )
            {
                if ( isset( $installElement[0] ) )
                    $installElements = array_merge( $installElements, $installElement );
                else
                    $installElements[] = $installElement;
            }
        }
    }
    $tpl->setVariable( 'install_elements', $installElements );

    $templateName = 'design:package/install.tpl';
}

if ( $persistentData['doItemInstall'] )
{
    $persistentData['language_map'] = $package->defaultLanguageMap();

    while( $currentItem < count( $installItemArray ) )
    {
        $installItem = $installItemArray[$currentItem];
        $installer = eZPackageInstallationHandler::instance( $package, $installItem['type'], $installItem );

        if ( !$installer || isset( $persistentData['error']['choosen_action'] ) )
        {
            $result = $package->installItem( $installItem, $persistentData );

            if ( !$result )
            {
                $templateName = "design:package/install_error.tpl";
                break;
            }
            else
            {
                $persistentData['error'] = array();
                $currentItem++;
            }
        }
        else
        {
            $persistentData['doItemInstall'] = false;
            $installer->generateStepMap( $package, $persistentData );
            $displayStep = true;
            break;
        }
    }
}

//$templateName = 'design:package/install.tpl';
if ( $displayStep )
{
    $currentStepID = false;
    if ( $module->hasActionParameter( 'InstallStepID' ) )
        $currentStepID = $module->actionParameter( 'InstallStepID' );
    $steps =& $installer->stepMap();
    if ( !isset( $steps['map'][$currentStepID] ) )
        $currentStepID = $steps['first']['id'];
    $errorList = array();
    $hasAdvanced = false;

    $lastStepID = $currentStepID;
    if ( $module->hasActionParameter( 'NextStep' ) )
    {
        $hasAdvanced = true;
        $currentStepID = $installer->validateStep( $package, $http, $currentStepID, $steps, $persistentData, $errorList );
        if ( $currentStepID != $lastStepID )
        {
            $lastStep =& $steps['map'][$lastStepID];
            $installer->commitStep( $package, $http, $lastStep, $persistentData, $tpl );
        }
    }

    if ( $currentStepID )
    {
        $currentStep =& $steps['map'][$currentStepID];

        $stepTemplate = $installer->stepTemplate( $package, $installItem, $currentStep );
        $stepTemplateName = $stepTemplate['name'];
        $stepTemplatePath = $stepTemplate['path'];

        $installer->initializeStep( $package, $http, $currentStep, $persistentData, $tpl, $module );

        //if ( $package )
        //    $persistentData['package_name'] = $package->attribute( 'name' );

        //$http->setSessionVariable( 'eZPackageInstallerData', $persistentData );

        $tpl->setVariable( 'installer', $installer );
        $tpl->setVariable( 'current_step', $currentStep );
        //$tpl->setVariable( 'persistent_data', $persistentData );
        $tpl->setVariable( 'error_list', $errorList );
        $tpl->setVariable( 'package', $package );

        $templateName = "$stepTemplatePath/$stepTemplateName";
    }
    else
    {
        $persistentData['doItemInstall'] = true;
        $installItem = $installItemArray[$currentItem];
        $result = $package->installItem( $installItem, $persistentData );
        if ( !$result )
        {
            $templateName = "design:package/install_error.tpl";
        }
        else
        {
            $currentItem++;
            if ( $currentItem < count( $installItemArray ) )
            {
                $persistentData['error'] = array();
                $persistentData['currentItem'] = $currentItem;
                $http->setSessionVariable( 'eZPackageInstallerData', $persistentData );
                return $module->redirectToView( 'install', array( $packageName ) );
            }
        }
    }
}

// Installation complete (all items are installed)
if ( $currentItem >= count( $installItemArray ) )
{
    $package->setInstalled();
    $http->removeSessionVariable( 'eZPackageInstallerData' );
    return $module->redirectToView( 'view', array( 'full', $package->attribute( 'name' ) ) );
}

$persistentData['currentItem'] = $currentItem;
$http->setSessionVariable( 'eZPackageInstallerData', $persistentData );
$tpl->setVariable( 'persistent_data', $persistentData );
$tpl->setVariable( 'package', $package );

$Result = array();
$Result['content'] = $tpl->fetch( $templateName );
$Result['path'] = array( array( 'url' => 'package/list',
                                'text' => ezpI18n::tr( 'kernel/package', 'Packages' ) ),
                         array( 'url' => false,
                                'text' => ezpI18n::tr( 'kernel/package', 'Install' ) ) );

?>
