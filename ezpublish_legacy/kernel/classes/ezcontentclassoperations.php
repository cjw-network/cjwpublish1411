<?php
/**
 * File containing the eZContentClassOperations class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  \class eZContentClassOperations ezcontentclassoperations.php
  \brief The class eZContentClassOperations is a place where
         content class operations are encapsulated.
  We move them out from eZContentClass because they may content code
  which is not directly related to content classes (e.g. clearing caches, etc).
*/

class eZContentClassOperations
{
    /*!
     Removes content class and all data associated with it.
     \static
    */
    static function remove( $classID )
    {
        $contentClass = eZContentClass::fetch( $classID );

        if ( $contentClass == null or !$contentClass->isRemovable() )
            return false;

        // Remove all objects
        $contentObjects = eZContentObject::fetchSameClassList( $classID );
        foreach ( $contentObjects as $contentObject )
        {
            eZContentObjectOperations::remove( $contentObject->attribute( 'id' ) );
        }

        if ( count( $contentObjects ) == 0 )
            eZContentObject::expireAllViewCache();

        eZContentClassClassGroup::removeClassMembers( $classID, 0 );
        eZContentClassClassGroup::removeClassMembers( $classID, 1 );

        // Fetch real version and remove it
        $contentClass->remove( true );

        // Fetch temp version and remove it
        $tempDeleteClass = eZContentClass::fetch( $classID, true, 1 );
        if ( $tempDeleteClass != null )
            $tempDeleteClass->remove( true, 1 );

        return true;
    }
}


?>
