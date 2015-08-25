<?php
/**
 * File containing the ezjscServerFunctionsPublishingQueue class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 * @subpackage content
 */

/**
 * This class handles AJAX calls for the publishing queue system
 * @package kernel
 * @subpackage content
 */
class ezjscServerFunctionsPublishingQueue extends ezjscServerFunctions
{
    public static function status( $args )
    {
        if ( count( $args ) != 2 )
        {
            throw new ezcBaseFunctionalityNotSupportedException( 'status', 'Missing argument(s)' );
        }

        list( $contentObjectId, $version ) = $args;

        $process = ezpContentPublishingProcess::fetchByContentObjectVersion( $contentObjectId, $version );

        // No process: check if the object's still a draft
        // @todo Change to a PENDING check when applied (operation => step 2)
        if ( $process instanceof ezpContentPublishingProcess )
        {
            $return = array();
            $status = $process->attribute( 'status' ) == ezpContentPublishingProcess::STATUS_WORKING ? 'working' : 'finished';
            switch( $process->attribute( 'status' ) )
            {
                case ezpContentPublishingProcess::STATUS_WORKING:
                    $status = 'working';
                    break;

                case ezpContentPublishingProcess::STATUS_FINISHED:
                    $status = 'finished';
                    $objectVersion = $process->attribute( 'version' );
                    $object = $objectVersion->attribute( 'contentobject' );
                    $node = $object->attribute( 'main_node' );
                    $uri = $node->attribute( 'url_alias' );
                    eZURI::transformURI( $uri );
                    $return['node_uri'] = $uri;
                    break;

                case ezpContentPublishingProcess::STATUS_PENDING:
                    $status = 'pending';
                    break;

                case ezpContentPublishingProcess::STATUS_DEFERRED:
                    $status = 'deferred';
                    $versionViewUri = "content/versionview/{$contentObjectId}/{$version}";
                    eZURI::transformURI( $versionViewUri );
                    $return['versionview_uri'] = $versionViewUri;
                    break;
            }
            $return['status'] = $status;
        }
        else
        {
            $version = eZContentObjectVersion::fetchVersion( $version, $contentObjectId );
            if ( !$version )
                throw new ezcBaseFunctionalityNotSupportedException( 'status', 'Object version not found' );
            else
                $return = array( 'status' =>  'queued' );
        }

        return $return;
    }
}
?>