#!/usr/bin/env php
<?php
/**
 * File containing the convertezenumtoezselection.php script.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

require_once 'autoload.php';

$cli = eZCLI::instance();

$scriptSettings = array();
$scriptSettings['description'] = 'Convert attributes of the type ezenum to ezselection';
$scriptSettings['use-session'] = true;
$scriptSettings['use-modules'] = true;
$scriptSettings['use-extensions'] = true;

$script = eZScript::instance( $scriptSettings );
$script->startup();

$config = '[preview]';
$argumentConfig = '[ATTRIBUTE_ID]';
$optionHelp = array( 'preview' => 'show a preview, do not really make changes' );
$arguments = false;
$useStandardOptions = true;

$options = $script->getOptions( $config, $argumentConfig, $optionHelp, $arguments, $useStandardOptions );
$script->initialize();

if ( count( $options['arguments'] ) != 1 )
{
    $script->shutdown( 1, 'wrong argument count' );
}

$preview = $options['preview'] !== null;

$attributeID = $options['arguments'][0];

if ( !is_numeric( $attributeID ) )
{
    $attributeID = eZContentObjectTreeNode::classAttributeIDByIdentifier( $attributeID );

    if ( $attributeID === false )
    {
        $script->shutdown( 2, 'unknown attribute identifier' );
    }
}

$classAttribute = eZContentClassAttribute::fetch( $attributeID );

if ( !is_object( $classAttribute ) )
{
    $script->shutdown( 3, 'could not find a class attribute with the specified ID' );
}

$enum = $classAttribute->attribute( 'content' );

// both datatypes use data_int1 for the multiple flag, so the following code is not necessary
/*
$isMultiple = $enum->attribute( 'enum_ismultiple' );
$classAttribute->setAttribute( 'data_int1', $isMultiple );
*/

//var_dump( $enum );

$enumValues = $enum->attribute( 'enum_list' );

$oldOptions = array();
$oldToNewIDMap = array();

foreach ( $enumValues as $enumValue )
{
    $element = $enumValue->attribute( 'enumelement' );
    $id = $enumValue->attribute( 'id' );
    $oldOptions[$id] = $element;
}

$doc = new DOMDocument( '1.0', 'utf-8' );
$root = $doc->createElement( "ezselection" );
$doc->appendChild( $root );

$options = $doc->createElement( "options" );

$root->appendChild( $options );
$i = 0;
foreach ( $oldOptions as $enumValueID => $name )
{
    $optionNode = $doc->createElement( "option" );
    $optionNode->setAttribute( 'id', $i );
    $optionNode->setAttribute( 'name', $name );
    $oldToNewIDMap[$enumValueID] = $i;
    $i ++;

    $options->appendChild( $optionNode );
}

$xml = $doc->saveXML();

$db = eZDB::instance();
$db->begin();

$classAttribute->setAttribute( 'data_text5', $xml );
$classAttribute->setAttribute( 'data_type_string', 'ezselection' );
$classAttribute->store();

$attributes = eZContentObjectAttribute::fetchSameClassAttributeIDList( $classAttribute->attribute( 'id' ) );

$count = count( $attributes );
$cli->output( 'number of object attributes to convert: ' . $count );

$script->setIterationData( '.', '~' );
$script->resetIteration( $count );
for ( $i = 0; $i < $count; $i++ )
{
    $objectAttributeID = $attributes[$i]->attribute( 'id' );
    $objectAttributeVersion = $attributes[$i]->attribute( 'version' );

    $selectOptions = array();
    $enumContent = $attributes[$i]->attribute( 'content' );
    $enumObjectValues = $enumContent->attribute( 'enumobject_list' );

    foreach ( $enumObjectValues as $enumObjectValue )
    {
        $value = $enumObjectValue->attribute( 'enumvalue' );
        $element = $enumObjectValue->attribute( 'enumelement' );
        $enumValueID = $enumObjectValue->attribute( 'enumid' );
        if ( !array_key_exists( $enumValueID, $oldToNewIDMap ) )
        {
            $cli->error( 'old enum element ' . $element . ' with value ' . $value . ' does not exist in current options' );
            $db->rollback();
            $script->shutdown( 4 );
        }

        $selectOptions[] = $oldToNewIDMap[$enumValueID];
    }

    $idString = ( is_array( $selectOptions ) ? implode( '-', $selectOptions ) : "" );
    //eZDebug::writeDebug( $idString, 'id string' );

    // reset object attribute's virtual content attribute
    $attributes[$i]->Content = null;

    if ( !$preview )
    {
        $attributes[$i]->setAttribute( 'data_type_string', 'ezselection' );
        $attributes[$i]->setAttribute( 'data_text', $idString );
        $attributes[$i]->store();
    }

    $status = true;
    $text = 'converted attribute in object ' . $attributes[$i]->attribute( 'contentobject_id' ) . ', version ' . $attributes[$i]->attribute( 'version' );

    if ( !$preview )
    {
        $db->query( "DELETE FROM ezenumobjectvalue WHERE contentobject_attribute_id=$objectAttributeID AND contentobject_attribute_version=$objectAttributeVersion" );
    }

    $script->iterate( $cli, $status, $text );
}

if ( !$preview )
{
    $db->query( "DELETE FROM ezenumvalue WHERE contentclass_attribute_id=$attributeID" );
    $db->commit();
}
else
{
    $db->rollback();
}

$script->shutdown( 0 );

?>
