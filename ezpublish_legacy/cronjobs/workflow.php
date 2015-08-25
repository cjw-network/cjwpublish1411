<?php
/**
 * File containing the workflow.php cronjob
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$runInBrowser = true;
if ( isset( $webOutput ) )
    $runInBrowser = $webOutput;

$db = eZDB::instance();

$workflowProcessList = eZWorkflowProcess::fetchForStatus( eZWorkflow::STATUS_DEFERRED_TO_CRON );

$cli->output( "Checking for workflow processes"  );
$removedProcessCount = 0;
$processCount = 0;
$statusMap = array();
foreach( $workflowProcessList as $process )
{
    $db->begin();

    $workflow = eZWorkflow::fetch( $process->attribute( "workflow_id" ) );

    if ( $process->attribute( "event_id" ) != 0 )
        $workflowEvent = eZWorkflowEvent::fetch( $process->attribute( "event_id" ) );
    $process->run( $workflow, $workflowEvent, $eventLog );
// Store changes to process

    ++$processCount;
    $status = $process->attribute( 'status' );
    if ( !isset( $statusMap[$status] ) )
        $statusMap[$status] = 0;
    ++$statusMap[$status];

    if ( $process->attribute( 'status' ) != eZWorkflow::STATUS_DONE )
    {
        if ( $process->attribute( 'status' ) == eZWorkflow::STATUS_RESET ||
             $process->attribute( 'status' ) == eZWorkflow::STATUS_FAILED ||
             $process->attribute( 'status' ) == eZWorkflow::STATUS_NONE ||
             $process->attribute( 'status' ) == eZWorkflow::STATUS_CANCELLED ||
             $process->attribute( 'status' ) == eZWorkflow::STATUS_BUSY
           )
        {
            if ( $bodyMemento = eZOperationMemento::fetchMain( $process->attribute( 'memento_key' ) ) )
                $bodyMemento->remove();

            foreach ( eZOperationMemento::fetchList( $process->attribute( 'memento_key' ) ) as $memento )
            {
                $memento->remove();
            }
        }

        if ( $process->attribute( 'status' ) == eZWorkflow::STATUS_CANCELLED )
        {
            ++$removedProcessCount;
            $process->removeThis();
        }
        else
        {
            $process->store();
        }
    }
    else
    {   //restore memento and run it
        $bodyMemento = eZOperationMemento::fetchChild( $process->attribute( 'memento_key' ) );
        if ( $bodyMemento === null )
        {
            eZDebug::writeError( $bodyMemento, "Empty body memento in workflow.php" );
            $db->commit();
            continue;
        }
        $bodyMementoData = $bodyMemento->data();
        $mainMemento = $bodyMemento->attribute( 'main_memento' );
        if ( !$mainMemento )
        {
            $db->commit();
            continue;
        }

        $mementoData = $bodyMemento->data();
        $mainMementoData = $mainMemento->data();
        $mementoData['main_memento'] = $mainMemento;
        $mementoData['skip_trigger'] = true;
        $mementoData['memento_key'] = $process->attribute( 'memento_key' );
        $bodyMemento->remove();
        $operationParameters = array();
        if ( isset( $mementoData['parameters'] ) )
            $operationParameters = $mementoData['parameters'];
        $operationResult = eZOperationHandler::execute( $mementoData['module_name'], $mementoData['operation_name'], $operationParameters, $mementoData );
        ++$removedProcessCount;
        $process->removeThis();
    }

    $db->commit();

    eZStaticCache::executeActions();
}
if ( !$isQuiet )
{
    $cli->output( $cli->stylize( 'emphasize', "Status list" ) );
    $statusTextList = array();
    $maxStatusTextLength = 0;
    foreach ( $statusMap as $statusID => $statusCount )
    {
        $statusName = eZWorkflow::statusName( $statusID );
        $statusText = "$statusName($statusID)";
        $statusTextList[] = array( 'text' => $statusText,
                                   'count' => $statusCount );
        if ( strlen( $statusText ) > $maxStatusTextLength )
            $maxStatusTextLength = strlen( $statusText );
    }
    foreach ( $statusTextList as $item )
    {
        $text = $item['text'];
        $count = $item['count'];
        $cli->output( $cli->stylize( 'success', $text ) . ': ' . str_repeat( ' ', $maxStatusTextLength - strlen( $text ) ) . $cli->stylize( 'emphasize', $count )  );
    }
    $cli->output();
    $cli->output( $cli->stylize( 'emphasize', $removedProcessCount ) . " out of " . $cli->stylize( 'emphasize', $processCount ) . " processes was finished"  );
}

?>
