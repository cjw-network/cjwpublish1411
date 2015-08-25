<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$Module = $Params['Module'];

// $execStack = eZExecutionStack::instance();
// $execStack->clear();
// $execStack->addEntry( $Module->functionURI( 'list' ),
//                       $Module->attribute( 'name' ), 'list' );

$http = eZHTTPTool::instance();

if ( $http->hasPostVariable( 'NewGroupButton' ) )
    return $Module->run( 'groupedit', array() );
if ( $http->hasPostVariable( 'NewWorkflowButton' ) )
    return $Module->run( 'edit', array() );

if ( $http->hasPostVariable( 'DeleteButton' ) and
     $http->hasPostVariable( 'Workflow_id_checked' ) )
{
    eZWorkflow::setIsEnabled( false, $http->postVariable( 'Workflow_id_checked' ) );
}

$groupList = eZWorkflowGroup::fetchList();
$workflows = eZWorkflow::fetchList();
$workflowList = array();
foreach( $workflows as $workflow )
{
    $workflowList[$workflow->attribute( 'id' )] = $workflow;
}

$Module->setTitle( 'Workflow list' );


$tpl = eZTemplate::factory();

$tpl->setVariable( 'workflow_list', $workflowList );
$tpl->setVariable( 'group_list', $groupList );
$tpl->setVariable( 'module', $Module );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:workflow/list.tpl' );
$Result['path'] = array( array( 'url' => '/workflow/list/',
                                'text' => ezpI18n::tr( 'kernel/workflow', 'Workflow list' ) ) );

?>
