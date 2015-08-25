<?php
/**
 * File containing the CjwNewsletterFunctionCollection class
 *
 * @copyright Copyright (C) 2007-2012 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package cjw_newsletter
 * @subpackage modules
 * @filesource
 */
/**
 * Class description here
 *
 * @version //autogentag//
 * @package cjw_newsletter
 * @subpackage modules
 */
class CjwNewsletterFunctionCollection
{
    /**
     * Constructor
     *
     * @return void
     */
    function CjwNewsletterFunctionCollection()
    {

    }

    /**
     * @param integer $listContentobjectId
     * @param integer $limit
     * @param integer $offset
     * @param boolean $asObject
     * @return array
     */
    static function fetchSubscriptionList( $listContentObjectId, $listContentObjectVersion, $status, $limit, $offset, $asObject )
    {

        switch( $status )
        {
            case 'pending':
                $statusId = CjwNewsletterSubscription::STATUS_PENDING;
                break;
            case 'confirmed':
                $statusId = CjwNewsletterSubscription::STATUS_CONFIRMED;
                break;
            case 'approved':
                $statusId = CjwNewsletterSubscription::STATUS_APPROVED;
                break;
            case 'removed':
                $statusId = array( CjwNewsletterSubscription::STATUS_REMOVED_ADMIN, CjwNewsletterSubscription::STATUS_REMOVED_SELF );
                break;
            case 'bounced':
                $statusId = array( CjwNewsletterSubscription::STATUS_BOUNCED_SOFT, CjwNewsletterSubscription::STATUS_BOUNCED_HARD );
                break;
            case 'blacklisted':
                $statusId = CjwNewsletterSubscription::STATUS_BLACKLISTED;
                break;
            default:
                // default is approved
                // $statusId = CjwNewsletterSubscription::STATUS_APPROVED;
                $statusId = false;
                break;

        }

        $objectList = array();
        $listObject = CjwNewsletterList::fetchByListObjectVersion( $listContentObjectId, $listContentObjectVersion );

        if ( is_object( $listObject ) )
        {
            //$objectList = CjwNewsletterSubscription::fetchSubscriptionListByListId( $listContentObjectId, $statusId, $limit, $offset, $asObject );
            $objectList = $listObject->getSubscriptionObjectArray( $statusId, $limit, $offset, $asObject );
        }
        else
        {
            eZDebug::writeError( "CjwNewsletterFunctinCollection::fetchSubscriptionList - no object found for ObjectId: $listContentObjectId $Version: $listContentObjectVersion" );
        }

        return array( 'result' => $objectList );
    }

    /**
     *
     * @param integer $listContentobjectId
     * @return array
     */
    static function fetchSubscriptionListCount( $listContentObjectId, $listContentObjectVersion, $status )
    {
        $statusId = false;

        switch( $status )
        {
            case 'pending':
                $statusId = CjwNewsletterSubscription::STATUS_PENDING;
                break;
            case 'confirmed':
                $statusId = CjwNewsletterSubscription::STATUS_CONFIRMED;
                break;
            case 'approved':
                $statusId = CjwNewsletterSubscription::STATUS_APPROVED;
                break;
            case 'removed':
                $statusId = array( CjwNewsletterSubscription::STATUS_REMOVED_ADMIN, CjwNewsletterSubscription::STATUS_REMOVED_SELF );
                break;
            case 'bounced':
                $statusId = array( CjwNewsletterSubscription::STATUS_BOUNCED_SOFT, CjwNewsletterSubscription::STATUS_BOUNCED_HARD );
                break;
            case 'blacklisted':
                $statusId = CjwNewsletterSubscription::STATUS_BLACKLISTED;
                break;
            default:
                // default is approved
                $statusId = CjwNewsletterSubscription::STATUS_APPROVED;
                break;

        }

        $objectCount = 0;
        $listObject = CjwNewsletterList::fetchByListObjectVersion( $listContentObjectId, $listContentObjectVersion );

        if ( is_object( $listObject ) )
        {
            //$objectCount = CjwNewsletterSubscription::fetchSubscriptionListByListIdCount( $listContentobjectId, $statusId );
            $objectCount = $listObject->getSubscriptionObjectCount( $statusId );
        }
        else
        {
            eZDebug::writeError( "CjwNewsletterFunctinCollection::fetchSubscriptionListCount - no object found for ObjectId: $listContentObjectId $Version: $listContentObjectVersion" );
        }


        return array( 'result' => $objectCount );
    }

    /**
     * fetch all subscriptions with import_id
     * @param integer $importId
     * @param integer $limit
     * @param integer $offset
     * @param boolean $asObject
     * @return array
     */
    static function fetchImportSubscriptionList( $importId, $limit, $offset, $asObject )
    {
        $objectList = CjwNewsletterSubscription::fetchSubscriptionListByImportId( $importId, $limit, $offset, $asObject );

        return array( 'result' => $objectList );
    }

    /**
     * count all subscriptions with import_id
     * @param integer $importId
     * @return array
     */
    static function fetchImportSubscriptionListCount( $importId )
    {
        $objectCount = CjwNewsletterSubscription::fetchSubscriptionListByImportIdCount( $importId );
        return array( 'result' => $objectCount );
    }

    /**
     *
     * @param integer $limit
     * @param integer $offset
     * @param string $email
     * @param boolean $asObject
     * @return array
     */
    static function fetchUserList( $limit, $offset, $email, $asObject )
    {
        $objectList = CjwNewsletterUser::fetchList( $limit, $offset, $email, $asObject );

        return array( 'result' => $objectList );
    }

    /**
     *
     * @param unknown_type $emailSearch
     * @return array
     */
    static function fetchUserListCount( $emailSearch )
    {
        $count = CjwNewsletterUser::fetchListCount( $emailSearch );

        return array( 'result' => $count );
    }

    /**
     *
     * @param integer $limit
     * @param integer $offset
     * @param integer $newsletterUserId
     * @param boolean $asObject
     * @return array
     */
    static function fetchEditonSendItemList( $limit, $offset, $newsletterUserId, $asObject )
    {
        $objectList = CjwNewsletterEditionSendItem::fetchListByNewsletterUserId( $limit, $offset, $newsletterUserId, $asObject );

        return array( 'result' => $objectList );
    }

    /**
     *
     * @param integer $newsletterUserId
     * @return array
     */
    static function fetchEditonSendItemListCount( $newsletterUserId )
    {
        $count = CjwNewsletterEditionSendItem::fetchListByNewsletterIdCount( $newsletterUserId );

        return array( 'result' => $count );
    }

}

?>
