<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

function makeTriggerArray( $triggerList )
{
    $triggerArray = array();
    foreach ( $triggerList as $trigger )
    {
        $newKey = $trigger->attribute( 'module_name' ) . '_' . $trigger->attribute( 'function_name' ) . '_' . $trigger->attribute( 'connect_type' );
        $triggerArray[$newKey] = $trigger;
    }
    return $triggerArray;
}


$http = eZHTTPTool::instance();

$Module = $Params['Module'];

$possibleTriggers = array();

$triggers = makeTriggerArray( eZTrigger::fetchList() );

foreach ( array_unique( eZINI::instance( 'workflow.ini' )->variable( 'OperationSettings', 'AvailableOperationList' ) ) as $operation )
{
    if ( $operation == '' )
    {
        continue;
    }
    $trigger = array();

    // the operation string has either two or three underscore characters.
    // Eg: shop_checkout, before_shop_checkout, after_shop_checkout.
    // Only the strings before and after are allowed in front of the module.
    $explodedOperation = explode ('_', $operation);
    $i = 0;

    if (sizeof ($explodedOperation) >= 3)
    {
        if (strcmp($explodedOperation[$i], "before") == 0 || strcmp($explodedOperation[$i], "after") == 0)
            $moduleParts = array ($explodedOperation[$i++]);
    }
    else
    {
        $moduleParts = array ("before", "after");
    }

    foreach ($moduleParts as $trigger['connect_type'])
    {
        $trigger['module'] = $explodedOperation[$i]; // $i is either 0 or 1
        $trigger['operation'] = $explodedOperation[$i + 1];
        $trigger['workflow_id'] = 0;
        $trigger['key'] = $trigger['module'] . '_' . $trigger['operation'] . '_' . $trigger['connect_type'][0];
        $trigger['allowed_workflows'] = eZWorkflow::fetchLimited( $trigger['module'], $trigger['operation'], $trigger['connect_type'] );

        foreach ( $triggers as $existendTrigger )
        {
            if ( $existendTrigger->attribute( 'module_name' ) == $trigger['module'] &&
                 $existendTrigger->attribute( 'function_name' ) == $trigger['operation'] &&
                 $existendTrigger->attribute( 'connect_type' ) == $trigger['connect_type'][0] )
            {
                 $trigger['workflow_id'] = $existendTrigger->attribute( 'workflow_id' );
            }
        }

        $possibleTriggers[] = $trigger;
    }
}

if ( $http->hasPostVariable( 'StoreButton' )  )
{
    $db = eZDB::instance();
    $db->begin();
    foreach ( $possibleTriggers as $trigger )
    {
        if ( $http->hasPostVariable( 'WorkflowID_' . $trigger['key'] ) )
        {
            $workflowID = $http->postVariable( 'WorkflowID_' . $trigger['key'] );
            if( $workflowID != -1 )
            {
                if ( !array_key_exists( $trigger['key'], $triggers ) )
                {
                    //create trigger
                    if ( $trigger['connect_type'] == 'before' )
                    {
                        $connectType = 'b';
                    }
                    else
                    {
                        $connectType = 'a';
                    }
                    $newTrigger = eZTrigger::createNew( $trigger['module'], $trigger['operation'], $connectType, $workflowID );
                }
                else
                {
                    $existendTrigger = $triggers[$trigger['key']];
                    if ( $existendTrigger->attribute( 'workflow_id' ) != $workflowID )
                    {
                        $existendTrigger = $triggers[$trigger['key']];
                        $existendTrigger->setAttribute( 'workflow_id', $workflowID );
                        $existendTrigger->store();
                    }
                    // update trigger
                }
            }
            else if ( array_key_exists( $trigger['key'], $triggers ) )
            {
                $existendTrigger = $triggers[$trigger['key']];
                $existendTrigger->remove();
                //remove trigger
            }
        }
    }
    $db->commit();
    $Module->redirectToView( 'list' );

}

$moduleName='*';
$functionName='*';

if ( $http->hasPostVariable( 'RemoveButton' )  )
{
    if ( $http->hasPostVariable( 'DeleteIDArray' ) )
    {
        $deleteIDArray = $http->postVariable( 'DeleteIDArray' );

        $db = eZDB::instance();
        $db->begin();
        foreach ( $deleteIDArray as $deleteID )
        {
            eZTrigger::remove( $deleteID );
        }
        $db->commit();
    }
}

$tpl = eZTemplate::factory();

$triggers = eZTrigger::fetchList( array(
                                       'module' => $moduleName,
                                       'function' => $functionName
                                       ) );
$showModuleList = false;
$showFunctionList = false;
$functionList = array();
$moduleList = array();
if ( $moduleName == '*' )
{
    $showModuleList = true;
    $ini = eZINI::instance( 'module.ini' );
    $moduleList = $ini->variable( 'ModuleSettings', 'ModuleList' );
}
elseif( $functionName == '*' )
{
    $mod = eZModule::exists( $moduleName );
    $functionList = array_keys( $mod->attribute( 'available_functions' ) );
    eZDebug::writeNotice( $functionList, "functions" );
    $showFunctionList = true;
}

$tpl->setVariable( 'current_module', $moduleName );
$tpl->setVariable( 'current_function', $functionName );
$tpl->setVariable( 'show_functions', $showFunctionList );
$tpl->setVariable( 'show_modules', $showModuleList );

$tpl->setVariable( 'possible_triggers', $possibleTriggers );

$tpl->setVariable( 'modules', $moduleList );
$tpl->setVariable( 'functions', $functionList );

$tpl->setVariable( 'triggers', $triggers );
$tpl->setVariable( 'module', $Module );

$Result['content'] = $tpl->fetch( 'design:trigger/list.tpl' );
$Result['path'] = array( array( 'text' => ezpI18n::tr( 'kernel/trigger', 'Trigger' ),
                                'url' => false ),
                         array( 'text' => ezpI18n::tr( 'kernel/trigger', 'List' ),
                                'url' => false ) );


?>
