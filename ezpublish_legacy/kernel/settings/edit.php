<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$settingTypeArray = array( 'array' => 'Array',
                           'true/false' => 'True/False',
                           'enable/disable' => 'Enabled/Disabled',
                           'string' => 'String',
                           'numeric' => 'Numeric' );

$tpl = eZTemplate::factory();
$http = eZHTTPTool::instance();
//$ini = eZINI::instance();

if ( $Params['INIFile'] )
    $iniFile = $Params['INIFile'];

if ( $Params['SiteAccess'] )
    $siteAccess = $Params['SiteAccess'];

if ( $Params['Block'] )
    $block = $Params['Block'];

if ( $Params['Setting'] )
    $settingName = $Params['Setting'];

if ( $Params['Placement'] )
    $settingPlacement = $Params['Placement'];

if ( $http->hasPostVariable( 'INIFile' ) )
    $iniFile = $http->variable( "INIFile" );

if ( $http->hasPostVariable( 'SiteAccess' ) )
    $siteAccess = $http->postVariable( 'SiteAccess' );

if ( $http->hasPostVariable( 'Block' ) )
    $block = trim( $http->postVariable( 'Block' ) );

if ( $http->hasPostVariable( 'SettingType' ) )
    $settingType = trim( $http->postVariable( 'SettingType' ) );

if ( $http->hasPostVariable( 'SettingName' ) )
    $settingName = trim( $http->postVariable( 'SettingName' ) );

if ( $http->hasPostVariable( 'SettingPlacement' ) )
    $settingPlacement = trim( $http->postVariable( 'SettingPlacement' ) );

if ( $http->hasPostVariable( 'Value' ) )
    $valueToWrite = trim( $http->postVariable( 'Value' ) );

if ( !isset( $settingName ) )
    $settingName = '';

if ( !isset( $settingPlacement ) )
    $settingPlacement = 'siteaccess';

if ( $http->hasPostVariable( 'WriteSetting' ) )
{
    $path = 'settings/override';
    if ( $settingPlacement == 'siteaccess' )
        $path = "settings/siteaccess/$siteAccess";
    elseif ( $settingPlacement != 'override' )
        $path = "extension/$settingPlacement/settings";

    $ini = new eZINI( $iniFile . '.append', $path, null, null, null, true, true );

    $hasValidationError = false;
    require 'kernel/settings/validation.php';
    $validationResult = validate( array( 'Name' => $settingName,
                                         'Value' => $valueToWrite ),
                                  array( 'name', $settingType ), true );
    if ( $validationResult['hasValidationError'] )
    {
        $tpl->setVariable( 'validation_field', $validationResult['fieldContainingError'] );
        $hasValidationError = true;
    }

    if ( !$hasValidationError )
    {
        if ( $settingType == 'array' )
        {
            $valueArray = explode( "\n", $valueToWrite );
            $valuesToWriteArray = array();

            $settingCount = 0;
            foreach( $valueArray as $value )
            {
                if ( preg_match( "/^\[(.+)\]\=(.+)$/", $value, $matches ) )
                {
                    $valuesToWriteArray[$matches[1]] = trim( $matches[2], "\r\n" );
                }
                else
                {
                    $value = substr( strchr( $value, '=' ), 1 );
                    if ( $value == "" )
                    {
                        if ( $settingCount == 0 )
                            $valuesToWriteArray[] = NULL;
                    }
                    else
                    {
                        $valuesToWriteArray[] = trim( $value, "\r\n" );
                    }
                }
                ++$settingCount;
            }

            $ini->setVariable( $block, $settingName, $valuesToWriteArray );
        }
        else
        {
            $ini->setVariable( $block, $settingName, $valueToWrite );
        }
        $writeOk = $ini->save(); // false, false, false, false, true, true );

        if ( !$writeOk )
        {
            $tpl->setVariable( 'validation_error', true );
            $tpl->setVariable( 'validation_error_type', 'write_error' );
            $tpl->setVariable( 'path', $path );
            $tpl->setVariable( 'filename',  $iniFile . '.append.php' );
        }
        else
        {
            return $Module->redirectTo( '/settings/view/' . $siteAccess . '/' . $iniFile );
        }
    }
    else // found validation errors...
    {
        $tpl->setVariable( 'validation_error', true );
        $tpl->setVariable( 'validation_error_type', $validationResult['type'] );
        $tpl->setVariable( 'validation_error_message', $validationResult['message'] );
    }
}
else
{
    $tpl->setVariable( 'validation_error', false );
    $tpl->setVariable( 'validation_error_type', false );
    $tpl->setVariable( 'validation_error_message', false );
}

if ( $http->hasPostVariable( 'Cancel' ) )
{
    return $Module->redirectTo( '/settings/view/' . $siteAccess . '/' . $iniFile );
}

function parseArrayToStr( $value, $separator )
{
    if ( !is_array( $value ) )
        return $value;

    $valueArray = array();

    foreach( $value as $param=>$key )
    {
        if ( !is_numeric( $param ) )
        {
            $valueArray[] = "[$param]=$key";
        }
        else
        {
            $valueArray[] = "=$key";
        }
    }

    $value = implode( $separator, $valueArray );
    return $value;
}

function getVariable( $block, $settingName, $iniFile, $path )
{
    $ini = new eZINI( $iniFile, $path, null, null, null, true, true );
    $result = $ini->hasVariable( $block, $settingName ) ? $ini->variable( $block, $settingName ) : false;
    $result = parseArrayToStr( $result, '<br>' );
    return $result;
}

$ini = eZSiteAccess::getIni( $siteAccess, $iniFile );
$value = $settingName != '' ? $ini->variable( $block, $settingName ) : '';

// Do modifications to the value before it's sent to the template
if ( ( is_array( $value ) || $value ) and !isset( $settingType ) )
{
    $settingType = $ini->settingType( $value );
    if ( $settingType == 'array' )
    {
        $value = parseArrayToStr( $value, "\n" );
    }

}
// Init value from ini (default\override\extensions\siteaccess)
$values = array();
$values['default'] = getVariable( $block, $settingName, $iniFile, 'settings/' );
$values['siteaccess'] = getVariable( $block, $settingName, $iniFile, "settings/siteaccess/$siteAccess" );
$values['override'] = getVariable( $block, $settingName, $iniFile, "settings/override/" );
// Get values from extensions
$ini = eZINI::instance();
$extensions = $ini->hasVariable( 'ExtensionSettings','ActiveExtensions' ) ? $ini->variable( 'ExtensionSettings','ActiveExtensions' ) : array();
$extensionDir = $ini->hasVariable( 'ExtensionSettings','ExtensionDirectory' ) ? $ini->variable( 'ExtensionSettings','ExtensionDirectory' ) : 'extension';
foreach ( $extensions as $extension )
{
    $extValue = getVariable( $block, $settingName, $iniFile, "$extensionDir/$extension/settings" );
    $values['extensions'][$extension] = $extValue;
}

if ( !isset( $settingType ) )
    $settingType = 'string';

$tpl->setVariable( 'setting_name', $settingName );
$tpl->setVariable( 'current_siteaccess', $siteAccess );
$tpl->setVariable( 'setting_type_array', $settingTypeArray );
$tpl->setVariable( 'setting_type', $settingType );
$tpl->setVariable( 'ini_file', $iniFile );
$tpl->setVariable( 'block', $block );
$tpl->setVariable( 'value', $value );
$tpl->setVariable( 'values', $values );
$tpl->setVariable( 'placement', $settingPlacement );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:settings/edit.tpl' );
$Result['path'] = array( array( 'text' => ezpI18n::tr( 'settings/edit', 'Settings' ),
                                'url' => false ),
                         array( 'text' => ezpI18n::tr( 'settings/edit', 'Edit' ),
                                'url' => false ) );
?>
