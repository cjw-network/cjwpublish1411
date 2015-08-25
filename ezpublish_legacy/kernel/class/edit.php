<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$Module = $Params['Module'];
$ClassID = $Params['ClassID'];
$GroupID = $Params['GroupID'];
$GroupName = $Params['GroupName'];
$EditLanguage = $Params['Language'];
$FromLanguage = false;
$ClassVersion = null;
$mainGroupID = false;
$lastChangedID = false;


switch ( $Params['FunctionName'] )
{
    case 'edit':
    {
    } break;
    default:
    {
        eZDebug::writeError( 'Undefined function: ' . $params['Function'] );
        $Module->setExitStatus( eZModule::STATUS_FAILED );
        return;
    }
}

$http = eZHTTPTool::instance();
if ( $http->hasPostVariable( 'CancelConflictButton' ) )
{
    $Module->redirectToView( 'grouplist' );
}

if ( $http->hasPostVariable( 'EditLanguage' ) )
{
    $EditLanguage = $http->postVariable( 'EditLanguage' );
}

if ( is_numeric( $ClassID ) )
{
    $class = eZContentClass::fetch( $ClassID, true, eZContentClass::VERSION_STATUS_MODIFIED );
    if ( is_object( $class ) )
    {
        $tpl = eZTemplate::factory();
        $tpl->setVariable( 'class', $class );
        $tpl->setVariable( "access_type", $GLOBALS['eZCurrentAccess'] );

        return array( 'content' => $tpl->fetch( 'design:class/edit_locked.tpl' ),
                      'path' => array( array( 'url' => '/class/grouplist/',
                                              'text' => ezpI18n::tr( 'kernel/class', 'Class list' ) ) ) );
    }

    $class = eZContentClass::fetch( $ClassID, true, eZContentClass::VERSION_STATUS_TEMPORARY );

    // If temporary version does not exist fetch the current and add temperory class to corresponding group
    if ( !is_object( $class ) or $class->attribute( 'id' ) == null )
    {
        $class = eZContentClass::fetch( $ClassID, true, eZContentClass::VERSION_STATUS_DEFINED );
        if( $class === null ) // Class does not exist
        {
            return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );
        }
        $classGroups = eZContentClassClassGroup::fetchGroupList( $ClassID, eZContentClass::VERSION_STATUS_DEFINED );
        foreach ( $classGroups as $classGroup )
        {
            $groupID = $classGroup->attribute( 'group_id' );
            $groupName = $classGroup->attribute( 'group_name' );
            $ingroup = eZContentClassClassGroup::create( $ClassID, eZContentClass::VERSION_STATUS_TEMPORARY, $groupID, $groupName );
            $ingroup->store();
        }
        if ( count( $classGroups ) > 0 )
        {
            $mainGroupID = $classGroups[0]->attribute( 'group_id' );
            $mainGroupName = $classGroups[0]->attribute( 'group_name' );
        }
    }
    else
    {
        $user = eZUser::currentUser();
        $contentIni = eZINI::instance( 'content.ini' );
        $timeOut = $contentIni->variable( 'ClassSettings', 'DraftTimeout' );

        $groupList = $class->fetchGroupList();
        if ( count( $groupList ) > 0 )
        {
            $mainGroupID = $groupList[0]->attribute( 'group_id' );
            $mainGroupName = $groupList[0]->attribute( 'group_name' );
        }

        if ( $class->attribute( 'modifier_id' ) != $user->attribute( 'contentobject_id' ) &&
             $class->attribute( 'modified' ) + $timeOut > time() )
        {
            $tpl = eZTemplate::factory();

            $res = eZTemplateDesignResource::instance();
            $res->setKeys( array( array( 'class', $class->attribute( 'id' ) ) ) ); // Class ID
            $tpl->setVariable( 'class', $class );
            $tpl->setVariable( 'lock_timeout', $timeOut );

            $Result = array();
            $Result['content'] = $tpl->fetch( 'design:class/edit_denied.tpl' );
            $Result['path'] = array( array( 'url' => '/class/grouplist/',
                                            'text' => ezpI18n::tr( 'kernel/class', 'Class groups' ) ) );
            if ( $mainGroupID !== false )
            {
                $Result['path'][] = array( 'url' => '/class/classlist/' . $mainGroupID,
                                           'text' => $mainGroupName );
            }
            $Result['path'][] = array( 'url' => false,
                                       'text' => $class->attribute( 'name' ) );
            return $Result;
        }
    }
}
else
{
    if ( !$EditLanguage )
    {
        $language = eZContentLanguage::topPriorityLanguage();
        if ( $language )
        {
            $EditLanguage = $language->attribute( 'locale' );
        }
        else
        {
            eZDebug::writeError( 'Undefined default language', 'class/edit.php' );
            $Module->setExitStatus( eZModule::STATUS_FAILED );
            return;
        }
    }

    if ( is_numeric( $GroupID ) and is_string( $GroupName ) and $GroupName != '' )
    {
        $user = eZUser::currentUser();
        $user_id = $user->attribute( 'contentobject_id' );
        $class = eZContentClass::create( $user_id, array(), $EditLanguage );
        $class->setName( ezpI18n::tr( 'kernel/class/edit', 'New Class' ), $EditLanguage );
        $class->store();
        $editLanguageID = eZContentLanguage::idByLocale( $EditLanguage );
        $class->setAlwaysAvailableLanguageID( $editLanguageID );
        $ClassID = $class->attribute( 'id' );
        $ClassVersion = $class->attribute( 'version' );
        $ingroup = eZContentClassClassGroup::create( $ClassID, $ClassVersion, $GroupID, $GroupName );
        $ingroup->store();
        $Module->redirectTo( $Module->functionURI( 'edit' ) . '/' . $ClassID . '/(language)/' . $EditLanguage );
        return;
    }
    else
    {
        $errorResponseGroupName = ( $GroupName == '' ) ? '<Empty name>' : $GroupName;
        $errorResponseGroupID = ( !is_numeric( $GroupID ) ) ? '<Empty ID>' : $GroupID;
        eZDebug::writeError( "Unknown class group: {$errorResponseGroupName} (ID: {$errorResponseGroupID})", 'Kernel - Class - Edit' );
        $Module->setExitStatus( eZModule::STATUS_FAILED );
        return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );
    }
}


$contentClassHasInput = true;
if ( $http->hasPostVariable( 'ContentClassHasInput' ) )
    $contentClassHasInput = $http->postVariable( 'ContentClassHasInput' );

// Find out the group where class is created or edited from.
if ( $http->hasSessionVariable( 'FromGroupID' ) )
{
    $fromGroupID = $http->sessionVariable( 'FromGroupID' );
}
else
{
    $fromGroupID = false;
}
$ClassID = $class->attribute( 'id' );
$ClassVersion = $class->attribute( 'version' );

$validation = array( 'processed' => false,
                     'groups' => array(),
                     'attributes' => array(),
                     'class_errors' => array() );
$unvalidatedAttributes = array();

if ( $http->hasPostVariable( 'DiscardButton' ) )
{
    $http->removeSessionVariable( 'ClassCanStoreTicket' );
    $class->setVersion( eZContentClass::VERSION_STATUS_TEMPORARY );
    $class->remove( true, eZContentClass::VERSION_STATUS_TEMPORARY );
    eZContentClassClassGroup::removeClassMembers( $ClassID, eZContentClass::VERSION_STATUS_TEMPORARY );
    if ( $fromGroupID === false )
    {
        $Module->redirectToView( 'grouplist' );
    }
    else
    {
        $Module->redirectTo( $Module->functionURI( 'classlist' ) . '/' . $fromGroupID . '/' );
    }
    return;
}
if ( $http->hasPostVariable( 'AddGroupButton' ) && $http->hasPostVariable( 'ContentClass_group' ) )
{
    eZClassFunctions::addGroup( $ClassID, $ClassVersion, $http->postVariable( 'ContentClass_group' ) );
    $lastChangedID = 'group';
}
if ( $http->hasPostVariable( 'RemoveGroupButton' ) && $http->hasPostVariable( 'group_id_checked' ) )
{
    if ( !eZClassFunctions::removeGroup( $ClassID, $ClassVersion, $http->postVariable( 'group_id_checked' ) ) )
    {
        $validation['groups'][] = array( 'text' => ezpI18n::tr( 'kernel/class', 'You have to have at least one group that the class belongs to!' ) );
        $validation['processed'] = true;
    }
}


// Ajax actions (normal ones have $contentClassHasInput == 1 and are fixed up
// later in $dataType->fixupClassAttributeHTTPInput)
if ( $contentClassHasInput == 0 && $http->hasPostVariable( 'MoveUp' ) )
{
    $attribute = eZContentClassAttribute::fetch( $http->postVariable( 'MoveUp' ), true, eZContentClass::VERSION_STATUS_TEMPORARY,
                                                  array( 'contentclass_id', 'version', 'placement' ) );
    if ( $attribute instanceof eZContentClassAttribute )
        $attribute->move( false );
    else
        header( $_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request' );
    eZDB::checkTransactionCounter();
    eZExecution::cleanExit();
}
else if ( $contentClassHasInput == 0 && $http->hasPostVariable( 'MoveDown' ) )
{
    $attribute = eZContentClassAttribute::fetch( $http->postVariable( 'MoveDown' ), true, eZContentClass::VERSION_STATUS_TEMPORARY,
                                                  array( 'contentclass_id', 'version', 'placement' ) );
    if ( $attribute instanceof eZContentClassAttribute )
        $attribute->move( true );
    else
        header( $_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request' );
    eZDB::checkTransactionCounter();
    eZExecution::cleanExit();
}

// Fetch attributes and definitions
$attributes = $class->fetchAttributes();

if ( $http->hasPostVariable( 'SelectLanguageButton' ) && $http->hasPostVariable( 'EditLanguage' ) )
{
    $EditLanguage = $http->postVariable( 'EditLanguage' );

    $FromLanguage = 'None';
    if ( $http->hasPostVariable( 'FromLanguage' ) )
        $FromLanguage = $http->postVariable( 'FromLanguage' );

    foreach ( array_keys( $attributes ) as $key )
    {
        $name = '';
        $description = '';
        $i18nDataText = '';
        if ( $FromLanguage != 'None' )
        {
            $name         = $attributes[$key]->name( $FromLanguage );
            $description  = $attributes[$key]->description( $FromLanguage );
            $i18nDataText = $attributes[$key]->dataTextI18n( $FromLanguage );
        }
        $attributes[$key]->setName( $name, $EditLanguage );
        $attributes[$key]->setDescription( $description, $EditLanguage );
        $attributes[$key]->setDataTextI18n( $i18nDataText, $EditLanguage );
    }

    $name = '';
    $description = '';
    if ( $FromLanguage != 'None' )
    {
        $name = $class->name( $FromLanguage );
        $description = $class->description( $FromLanguage );
    }

    $class->setName( $name, $EditLanguage );
    $class->setDescription( $description, $EditLanguage );
}

// No language was specified in the URL, we need to figure out
// the language to use.
if ( !$EditLanguage )
{
    // Check number of languages
    $languages = eZContentLanguage::fetchList();
    // If there is only one language we choose it for the user.
    if ( count( $languages ) == 1 )
    {
        $language = array_shift( $languages );
        $EditLanguage = $language->attribute( 'locale' );
    }
    else
    {
        $canCreateLanguages = $class->attribute( 'can_create_languages' );
        if ( count( $canCreateLanguages ) == 0)
        {
            $EditLanguage = $class->attribute( 'top_priority_language_locale' );
        }
        else
        {
            $tpl = eZTemplate::factory();

            $res = eZTemplateDesignResource::instance();
            $res->setKeys( array( array( 'class', $class->attribute( 'id' ) ) ) ); // Class ID

            $tpl->setVariable( 'module', $Module );
            $tpl->setVariable( 'class', $class );

            $Result = array();
            $Result['content'] = $tpl->fetch( 'design:class/select_language.tpl' );
            $Result['path'] = array( array( 'url' => '/class/grouplist/',
                                            'text' => ezpI18n::tr( 'kernel/class', 'Class groups' ) ) );
            if ( $mainGroupID !== false )
            {
                $Result['path'][] = array( 'url' => '/class/classlist/' . $mainGroupID,
                                           'text' => $mainGroupName );
            }
            $Result['path'][] = array( 'url' => false,
                                       'text' => $class->attribute( 'name' ) );
            return $Result;
        }
    }
}

eZDataType::loadAndRegisterAllTypes();
$datatypes = eZDataType::registeredDataTypes();

$customAction = false;
$customActionAttributeID = null;
// Check for custom actions
if ( $http->hasPostVariable( 'CustomActionButton' ) )
{
    $customActionArray = $http->postVariable( 'CustomActionButton' );
    $customActionString = key( $customActionArray );

    $customActionAttributeID = preg_match( "#^([0-9]+)_(.*)$#", $customActionString, $matchArray );

    $customActionAttributeID = $matchArray[1];
    $customAction = $matchArray[2];
}


// Validate input
$storeActions = array( 'MoveUp',
                       'MoveDown',
                       'StoreButton',
                       'ApplyButton',
                       'NewButton',
                       'CustomActionButton');
$validationRequired = false;
foreach( $storeActions as $storeAction )
{
    if ( $http->hasPostVariable( $storeAction ) )
    {
        $validationRequired = true;
        break;
    }
}

$canStore = true;
$requireFixup = false;
if ( $contentClassHasInput )
{
    if ( $validationRequired )
    {
        foreach ( $attributes as $key => $attribute )
        {
            // set locale for use by datatype while storing data
            $attributes[$key]->setEditLocale( $EditLanguage );
            $dataType = $attribute->dataType();
            $status = $dataType->validateClassAttributeHTTPInput( $http, 'ContentClass', $attribute );
            if ( $status == eZInputValidator::STATE_INTERMEDIATE )
                $requireFixup = true;
            else if ( $status == eZInputValidator::STATE_INVALID )
            {
                $canStore = false;
                $attributeName = $dataType->attribute( 'information' );
                $attributeName = $attributeName['name'];
                $unvalidatedAttributes[] = array( 'id' => $attribute->attribute( 'id' ),
                                                  'identifier' => $attribute->attribute( 'identifier' ) ? $attribute->attribute( 'identifier' ) : $attribute->attribute( 'name' ),
                                                  'name' => $attributeName );
            }
        }
        $validation['processed']          = true;
        $validation['attributes']         = $unvalidatedAttributes;
        $requireVariable                  = 'ContentAttribute_is_required_checked';
        $searchableVariable               = 'ContentAttribute_is_searchable_checked';
        $informationCollectorVariable     = 'ContentAttribute_is_information_collector_checked';
        $canTranslateVariable             = 'ContentAttribute_can_translate_checked';
        $categoryArray                    = array();
        $requireCheckedArray              = array();
        $searchableCheckedArray           = array();
        $informationCollectorCheckedArray = array();
        $canTranslateCheckedArray         = array();

        if ( $http->hasPostVariable( $requireVariable ) )
            $requireCheckedArray = $http->postVariable( $requireVariable );
        if ( $http->hasPostVariable( $searchableVariable ) )
            $searchableCheckedArray = $http->postVariable( $searchableVariable );
        if ( $http->hasPostVariable( $informationCollectorVariable ) )
            $informationCollectorCheckedArray = $http->postVariable( $informationCollectorVariable );
        if ( $http->hasPostVariable( $canTranslateVariable ) )
            $canTranslateCheckedArray = $http->postVariable( $canTranslateVariable );

        if ( $http->hasPostVariable( 'ContentAttribute_priority' ) )
            $placementArray = $http->postVariable( 'ContentAttribute_priority' );

        if ( $http->hasPostVariable( 'ContentAttribute_category_select' ) )
            $categoryArray = $http->postVariable( 'ContentAttribute_category_select' );

        foreach ( $attributes as $attribute )
        {
            $attributeID = $attribute->attribute( 'id' );
            $attribute->setAttribute( 'is_required', in_array( $attributeID, $requireCheckedArray ) );
            $attribute->setAttribute( 'is_searchable', in_array( $attributeID, $searchableCheckedArray ) );
            $attribute->setAttribute( 'is_information_collector', in_array( $attributeID, $informationCollectorCheckedArray ) );
            // Set can_translate to 0 if user has clicked Disable translation in GUI
            $attribute->setAttribute( 'can_translate', !in_array( $attributeID, $canTranslateCheckedArray ) && $attribute->dataType()->isTranslatable() );
            // check if the category is set for this attribute key, may not be the case when using old admin and new attributes
            // if this is not set at all, it gets a default value from the DB
            // if it is set, we want to leave it like that of course
            if ( isset( $categoryArray[$attributeID] ) )
            {
                $attribute->setAttribute( 'category', $categoryArray[$attributeID] );
            }
        }
    }
}

// Fixup input
if ( $requireFixup )
{
    foreach( $attributes as $attribute )
    {
        $dataType = $attribute->dataType();
        $status = $dataType->fixupClassAttributeHTTPInput( $http, 'ContentClass', $attribute );
    }
}

$cur_datatype = 'ezstring';
// Apply HTTP POST variables
if ( $contentClassHasInput )
{
    eZHTTPPersistence::fetch( 'ContentAttribute', eZContentClassAttribute::definition(), $attributes, $http, true, 'id' );
    if ( $http->hasPostVariable( 'ContentAttribute_name' ) )
    {
        $attributeNames = $http->postVariable( 'ContentAttribute_name' );
        foreach ( $attributes as $attribute )
        {
            $key = $attribute->attribute( 'id' );
            if ( isset( $attributeNames[$key] ) )
            {
                $attribute->setName( $attributeNames[$key], $EditLanguage );
            }
        }
    }

    if ( $http->hasPostVariable( 'ContentAttribute_description' ) )
    {
        $attributeNames = $http->postVariable( 'ContentAttribute_description' );
        foreach ( $attributes as $attribute )
        {
            $key = $attribute->attribute( 'id' );
            if ( isset( $attributeNames[$key] ) )
            {
                $attribute->setDescription( $attributeNames[$key], $EditLanguage );
            }
        }
    }

    eZHTTPPersistence::fetch( 'ContentClass', eZContentClass::definition(), $class, $http, false );
    if ( $http->hasPostVariable( 'ContentClass_name' ) )
    {
        $class->setName( $http->postVariable( 'ContentClass_name' ), $EditLanguage );
    }

    if ( $http->hasPostVariable( 'ContentClass_description' ) )
    {
        $class->setDescription( $http->postVariable( 'ContentClass_description' ), $EditLanguage );
    }

    if ( $http->hasVariable( 'ContentClass_is_container_exists' ) )
    {
        if ( $http->hasVariable( 'ContentClass_is_container_checked' ) )
        {
            $class->setAttribute( "is_container", 1 );
        }
        else
        {
            $class->setAttribute( "is_container", 0 );
        }
    }

    if ( $http->hasVariable( 'ContentClass_always_available_exists' ) )
    {
        if ( $http->hasVariable( 'ContentClass_always_available' ) )
        {
            $class->setAttribute( 'always_available', 1 );
        }
        else
        {
            $class->setAttribute( 'always_available', 0 );
        }
    }

    if ( $http->hasVariable( 'ContentClass_default_sorting_exists' ) )
    {
        if ( $http->hasVariable( 'ContentClass_default_sorting_field' ) )
        {
            $sortingField = $http->variable( 'ContentClass_default_sorting_field' );
            $class->setAttribute( 'sort_field', $sortingField );
        }
        if ( $http->hasVariable( 'ContentClass_default_sorting_order' ) )
        {
            $sortingOrder = $http->variable( 'ContentClass_default_sorting_order' );
            $class->setAttribute( 'sort_order', $sortingOrder );
        }
    }

    if ( $http->hasPostVariable( 'DataTypeString' ) )
        $cur_datatype = $http->postVariable( 'DataTypeString' );
}

$class->setAttribute( 'version', eZContentClass::VERSION_STATUS_TEMPORARY );
$class->NameList->setHasDirtyData();

$trans = eZCharTransform::instance();

if ( $contentClassHasInput && $validationRequired )
{
    // check for duplicate attribute identifiers and placements in the input
    $placementMap = array();
    $identifierMap = array();
    foreach ( $attributes as $attribute )
    {
        $id = $attribute->attribute( "id" );
        $placement = (int)$placementArray[$id];
        $identifier = $attribute->attribute( "identifier" );

        if ( isset( $placementMap[$placement] ) )
        {
            $validation["attributes"][] = array(
                "identifier" => $identifier,
                "name" => $attribute->attribute( "name" ),
                "id" => $id,
                "reason" => array ( 'text' => ezpI18n::tr( "kernel/class", "duplicate attribute placement" ) )
            );
            $canStore = false;
        }
        $placementMap[$placement] = $attribute;

        if ( isset( $identifierMap[$identifier] ) )
        {
            $validation["attributes"][] = array(
                "identifier" => $identifier,
                "name" => $attribute->attribute( "name" ),
                "id" => $id,
                "reason" => array ( 'text' => ezpI18n::tr( "kernel/class", "duplicate attribute identifier" ) )
            );
            $canStore = false;
        }
        $identifierMap[$identifier] = true;
    }

    if ( $canStore )
    {
        // Reaffecting correct placement numbers here
        // This is required to be done before the call to:
        //     $dataType->initializeClassAttribute( $attribute );
        // since some data types are calling $attribute->store();
        // which will store the raw input position number before it has been
        // modified by eZContentClass::adjustAttributePlacements()
        // @see EZP-19876
        ksort( $placementMap );
        foreach ( array_values( $placementMap ) as $i => $attribute )
        {
            $attribute->setAttribute( "placement", $i + 1 );
        }
    }

    unset( $placementMap, $identifierMap, $id, $placement );
}

// Fixed identifiers to only contain a-z0-9_
foreach( $attributes as $attribute )
{
    $attribute->setAttribute( 'version', eZContentClass::VERSION_STATUS_TEMPORARY );
    $identifier = $attribute->attribute( 'identifier' );
    if ( $identifier == '' )
        $identifier = $attribute->attribute( 'name' );

    $identifier = $trans->transformByGroup( $identifier, 'identifier' );
    $attribute->setAttribute( 'identifier', $identifier );
    if ( $dataType = $attribute->dataType() )
    {
        $dataType->initializeClassAttribute( $attribute );
    }
}

// Fixed class identifier to only contain a-z0-9_
$identifier = $class->attribute( 'identifier' );
if ( $identifier == '' )
    $identifier = $class->attribute( 'name' );
$identifier = $trans->transformByGroup( $identifier, 'identifier' );
$class->setAttribute( 'identifier', $identifier );

// Run custom actions if any
if ( $customAction )
{
    foreach( $attributes as $attribute )
    {
        if ( $customActionAttributeID == $attribute->attribute( 'id' ) )
        {
            $attribute->customHTTPAction( $Module, $http, $customAction );
        }
    }
}
// Set new modification date
$date_time = time();
$class->setAttribute( 'modified', $date_time );
$user = eZUser::currentUser();
$user_id = $user->attribute( 'contentobject_id' );
$class->setAttribute( 'modifier_id', $user_id );

// Remove attributes which are to be deleted
if ( $http->hasPostVariable( 'RemoveButton' ) )
{
    $validation['processed'] = true;
    if ( eZHTTPPersistence::splitSelected( 'ContentAttribute', $attributes,
                                           $http, 'id',
                                           $keepers, $rejects ) )
    {
        $attributes = $keepers;
        foreach ( $rejects as $reject )
        {
            if ( !$reject->removeThis( true ) )
            {
                $dataType = $reject->dataType();
                $removeInfo = $dataType->classAttributeRemovableInformation( $reject );
                if ( $removeInfo !== false )
                {
                    $validation['attributes'] = array( array( 'id' => $reject->attribute( 'id' ),
                                                              'identifier' => $reject->attribute( 'identifier' ),
                                                              'reason' => $removeInfo ) );
                }
            }
        }
    }
}

// Fetch HTTP input
$datatypeValidation = array();
if ( $contentClassHasInput )
{
    foreach( $attributes as $attribute )
    {
        if ( $dataType = $attribute->dataType() )
        {
            $dataType->fetchClassAttributeHTTPInput( $http, 'ContentClass', $attribute );
        }
        else
        {
            $datatypeValidation['processed'] = 1;
            $datatypeValidation['attributes'][] =
                array( 'reason' => array( 'text' => ezpI18n::tr( 'kernel/class', 'Could not load datatype: ' ).
                                           $attribute->attribute( 'data_type_string' )."\n".
                                           ezpI18n::tr( 'kernel/class', 'Editing this content class may cause data corruption in your system.' ).'<br>'.
                                           ezpI18n::tr( 'kernel/class', 'Press "Cancel" to safely exit this operation.').'<br>'.
                                           ezpI18n::tr( 'kernel/class', 'Please contact your eZ Publish administrator to solve this problem.').'<br>' ),
                       'item' => $attribute->attribute( 'data_type_string' ),
                       'identifier' => $attribute->attribute( 'data_type_string' ),
                       'id' => $key );
        }
    }
}

// Store version 0 and discard version 1
if ( $http->hasPostVariable( 'StoreButton' ) && $canStore )
{

    $newClassAttributes = $class->fetchAttributes( );

    // validate class name and identifier; check presence of class attributes
    // FIXME: object pattern name is never validated

    $basicClassPropertiesValid = true;
    $className       = $class->attribute( 'name' );
    $classIdentifier = $class->attribute( 'identifier' );
    $classID         = $class->attribute( 'id' );

    // validate class name
    if( trim( $className ) == '' )
    {
        $validation['class_errors'][] = array( 'text' => ezpI18n::tr( 'kernel/class', 'The class should have nonempty \'Name\' attribute.' ) );
        $basicClassPropertiesValid = false;
    }

    // check presence of attributes
    if ( count( $newClassAttributes ) == 0 )
    {
        $validation['class_errors'][] = array( 'text' => ezpI18n::tr( 'kernel/class', 'The class should have at least one attribute.' ) );
        $basicClassPropertiesValid = false;
    }

    // validate class identifier

    $db = eZDB::instance();
    $db->begin();
    $classCount = $db->arrayQuery( "SELECT COUNT(*) AS count FROM ezcontentclass WHERE  identifier='$classIdentifier' AND version=" . eZContentClass::VERSION_STATUS_DEFINED . " AND id <> $classID" );
    if ( $classCount[0]['count'] > 0 )
    {
        $validation['class_errors'][] = array( 'text' => ezpI18n::tr( 'kernel/class', 'There is a class already having the same identifier.' ) );
        $basicClassPropertiesValid = false;
    }
    unset( $classList );

    if ( !$basicClassPropertiesValid )
    {
        $db->commit();
        $canStore = false;
        $validation['processed'] = false;
    }
    else
    {
        if ( !$http->hasSessionVariable( 'ClassCanStoreTicket' ) )
        {
            $db->commit();
            return $Module->redirectToView( 'view', array( $ClassID ), array( 'Language' => $EditLanguage ) );
        }

        $unorderedParameters = array( 'Language' => $EditLanguage );

        // Is there existing objects of this content class?
        if ( eZContentObject::fetchSameClassListCount( $ClassID ) > 0 )
        {
            eZExtension::getHandlerClass( new ezpExtensionOptions( array( 'iniFile' => 'site.ini',
                                                                          'iniSection'   => 'ContentSettings',
                                                                          'iniVariable'  => 'ContentClassEditHandler' ) ) )
                    ->store( $class, $attributes, $unorderedParameters );
        }
        else
        {
            $unorderedParameters['ScheduledScriptID'] = 0;
            $class->storeVersioned( $attributes, eZContentClass::VERSION_STATUS_DEFINED );
        }

        $db->commit();
        $http->removeSessionVariable( 'ClassCanStoreTicket' );
        ezpEvent::getInstance()->notify( 'content/class/cache', array( $ClassID ) );
        return $Module->redirectToView( 'view', array( $ClassID ), $unorderedParameters );
    }
}

// Store changes
if ( $canStore )
    $class->store( $attributes );

if ( $http->hasPostVariable( 'NewButton' ) )
{
    $newAttribute = eZContentClassAttribute::create( $ClassID, $cur_datatype, array(), $EditLanguage );
    $attrcnt = count( $attributes ) + 1;
    $newAttribute->setName( ezpI18n::tr( 'kernel/class/edit', 'new attribute' ) . $attrcnt, $EditLanguage );
    $dataType = $newAttribute->dataType();
    $dataType->initializeClassAttribute( $newAttribute );
    $newAttribute->store();
    $attributes[] = $newAttribute;
    $lastChangedID = $newAttribute->attribute('id');
}
else if ( $http->hasPostVariable( 'MoveUp' ) )
{
    $attribute = eZContentClassAttribute::fetch( $http->postVariable( 'MoveUp' ), true, eZContentClass::VERSION_STATUS_TEMPORARY,
                                                  array( 'contentclass_id', 'version', 'placement' ) );
    $attribute->move( false );
    $Module->redirectTo( $Module->functionURI( 'edit' ) . '/' . $ClassID . '/(language)/' . $EditLanguage );
    return;
}
else if ( $http->hasPostVariable( 'MoveDown' ) )
{
    $attribute = eZContentClassAttribute::fetch( $http->postVariable( 'MoveDown' ), true, eZContentClass::VERSION_STATUS_TEMPORARY,
                                                  array( 'contentclass_id', 'version', 'placement' ) );
    $attribute->move( true );
    $Module->redirectTo( $Module->functionURI( 'edit' ) . '/' . $ClassID . '/(language)/' . $EditLanguage );
    return;
}

$Module->setTitle( 'Edit class ' . $class->attribute( 'name' ) );

// set session to allow current user to store class (to avoid direct post edit actions to this view)
if ( !$http->hasSessionVariable( 'ClassCanStoreTicket' ) )
{
    $http->setSessionVariable( 'ClassCanStoreTicket', 1 );
}

// Fetch updated attributes
$attributes = $class->fetchAttributes();
$validation = array_merge( $validation, $datatypeValidation );

// Template handling
$tpl = eZTemplate::factory();
$res = eZTemplateDesignResource::instance();
$res->setKeys( array( array( 'class', $class->attribute( 'id' ) ) ) ); // Class ID
$tpl->setVariable( 'http', $http );
$tpl->setVariable( 'validation', $validation );
$tpl->setVariable( 'can_store', $canStore );
$tpl->setVariable( 'require_fixup', $requireFixup );
$tpl->setVariable( 'module', $Module );
$tpl->setVariable( 'class', $class );
$tpl->setVariable( 'attributes', $attributes );
$tpl->setVariable( 'datatypes', $datatypes );
$tpl->setVariable( 'datatype', $cur_datatype );
$tpl->setVariable( 'language_code', $EditLanguage );
$tpl->setVariable( 'last_changed_id', $lastChangedID );


$Result = array();
$Result['content'] = $tpl->fetch( 'design:class/edit.tpl' );
$Result['path'] = array( array( 'url' => '/class/grouplist/',
                                'text' => ezpI18n::tr( 'kernel/class', 'Class groups' ) ) );
if ( $mainGroupID !== false )
{
    $Result['path'][] = array( 'url' => '/class/classlist/' . $mainGroupID,
                               'text' => $mainGroupName );
}
$Result['path'][] = array( 'url' => false,
                           'text' => $class->attribute( 'name' ) );

?>
