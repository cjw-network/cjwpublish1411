<?php
/**
 * File containing the eZDateType class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  \class eZDateType ezdatetype.php
  \ingroup eZDatatype
  \brief Stores a date value

*/

class eZDateType extends eZDataType
{
    const DATA_TYPE_STRING = "ezdate";

    const DEFAULT_FIELD = 'data_int1';

    const DEFAULT_EMTPY = 0;

    const DEFAULT_CURRENT_DATE = 1;

    function eZDateType()
    {
        $this->eZDataType( self::DATA_TYPE_STRING, ezpI18n::tr( 'kernel/classes/datatypes', "Date", 'Datatype name' ),
                           array( 'serialize_supported' => true ) );
    }


    function validateDateTimeHTTPInput( $day, $month, $year, $contentObjectAttribute )
    {
        $state = eZDateTimeValidator::validateDate( $day, $month, $year );
        if ( $state == eZInputValidator::STATE_INVALID )
        {
            $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes',
                                                                 'Date is not valid.' ) );
            return eZInputValidator::STATE_INVALID;
        }
        return $state;
    }
    /*!
     Validates the input and returns true if the input was
     valid for this datatype.
    */
    function validateObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        $classAttribute = $contentObjectAttribute->contentClassAttribute();

        if ( $http->hasPostVariable( $base . '_date_year_' . $contentObjectAttribute->attribute( 'id' ) ) and
             $http->hasPostVariable( $base . '_date_month_' . $contentObjectAttribute->attribute( 'id' ) ) and
             $http->hasPostVariable( $base . '_date_day_' . $contentObjectAttribute->attribute( 'id' ) ) )
        {
            $year  = $http->postVariable( $base . '_date_year_' . $contentObjectAttribute->attribute( 'id' ) );
            $month = $http->postVariable( $base . '_date_month_' . $contentObjectAttribute->attribute( 'id' ) );
            $day   = $http->postVariable( $base . '_date_day_' . $contentObjectAttribute->attribute( 'id' ) );

            if ( $year == '' or $month == '' or $day == '' )
            {
                if ( !( $year == '' and $month == '' and $day == '' ) or
                     ( !$classAttribute->attribute( 'is_information_collector' ) and
                       $contentObjectAttribute->validateIsRequired() ) )
                {
                    $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes',
                                                                         'Missing date input.' ) );
                    return eZInputValidator::STATE_INVALID;
                }
                else
                    return eZInputValidator::STATE_ACCEPTED;
            }
            else
            {
                return $this->validateDateTimeHTTPInput( $day, $month, $year, $contentObjectAttribute );
            }
        }
        else if ( !$classAttribute->attribute( 'is_information_collector' ) and $contentObjectAttribute->validateIsRequired() )
        {
            $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes', 'Missing date input.' ) );
            return eZInputValidator::STATE_INVALID;
        }

        return eZInputValidator::STATE_ACCEPTED;
    }

    /*!
     Fetches the http post var integer input and stores it in the data instance.
    */
    function fetchObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        if ( $http->hasPostVariable( $base . '_date_year_' . $contentObjectAttribute->attribute( 'id' ) ) and
             $http->hasPostVariable( $base . '_date_month_' . $contentObjectAttribute->attribute( 'id' ) ) and
             $http->hasPostVariable( $base . '_date_day_' . $contentObjectAttribute->attribute( 'id' ) ) )
        {

            $year  = $http->postVariable( $base . '_date_year_' . $contentObjectAttribute->attribute( 'id' ) );
            $month = $http->postVariable( $base . '_date_month_' . $contentObjectAttribute->attribute( 'id' ) );
            $day   = $http->postVariable( $base . '_date_day_' . $contentObjectAttribute->attribute( 'id' ) );
            $contentClassAttribute = $contentObjectAttribute->contentClassAttribute();

            if ( ( $year == '' and $month == '' and $day == '' ) or
                 !checkdate( $month, $day, $year ) )
            {
                $stamp = null;
            }
            else
            {
                $date = new eZDate();
                $date->setMDY( $month, $day, $year );
                $stamp = $date->timeStamp();
            }

            $contentObjectAttribute->setAttribute( 'data_int', $stamp );
            return true;
        }
        return false;
    }

    function validateCollectionAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        if ( $http->hasPostVariable( $base . '_date_year_' . $contentObjectAttribute->attribute( 'id' ) ) and
             $http->hasPostVariable( $base . '_date_month_' . $contentObjectAttribute->attribute( 'id' ) ) and
             $http->hasPostVariable( $base . '_date_day_' . $contentObjectAttribute->attribute( 'id' ) ) )
        {
            $year  = $http->postVariable( $base . '_date_year_' . $contentObjectAttribute->attribute( 'id' ) );
            $month = $http->postVariable( $base . '_date_month_' . $contentObjectAttribute->attribute( 'id' ) );
            $day   = $http->postVariable( $base . '_date_day_' . $contentObjectAttribute->attribute( 'id' ) );
            $classAttribute = $contentObjectAttribute->contentClassAttribute();

            if ( $year == '' or $month == '' or $day == '' )
            {
                if ( !( $year == '' and $month == '' and $day == '' ) or
                     $contentObjectAttribute->validateIsRequired() )
                {
                    $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes',
                                                                         'Missing date input.' ) );
                    return eZInputValidator::STATE_INVALID;
                }
                else
                    return eZInputValidator::STATE_ACCEPTED;
            }
            else
            {
                return $this->validateDateTimeHTTPInput( $day, $month, $year, $contentObjectAttribute );
            }
        }
        else
            return eZInputValidator::STATE_INVALID;
    }

    /*!
     Fetches the http post variables for collected information
    */
    function fetchCollectionAttributeHTTPInput( $collection, $collectionAttribute, $http, $base, $contentObjectAttribute )
    {
        if ( $http->hasPostVariable( $base . '_date_year_' . $contentObjectAttribute->attribute( 'id' ) ) and
             $http->hasPostVariable( $base . '_date_month_' . $contentObjectAttribute->attribute( 'id' ) ) and
             $http->hasPostVariable( $base . '_date_day_' . $contentObjectAttribute->attribute( 'id' ) ) )
        {

            $year  = $http->postVariable( $base . '_date_year_' . $contentObjectAttribute->attribute( 'id' ) );
            $month = $http->postVariable( $base . '_date_month_' . $contentObjectAttribute->attribute( 'id' ) );
            $day   = $http->postVariable( $base . '_date_day_' . $contentObjectAttribute->attribute( 'id' ) );
            $contentClassAttribute = $contentObjectAttribute->contentClassAttribute();

            if ( ( $year == '' and $month == '' and $day == '' ) or
                 !checkdate( $month, $day, $year ) )
            {
                $stamp = null;
            }
            else
            {
                $date = new eZDate();
                $date->setMDY( $month, $day, $year );
                $stamp = $date->timeStamp();
            }

            $collectionAttribute->setAttribute( 'data_int', $stamp );
            return true;
        }
        return false;
    }

    /*!
     Returns the content.
    */
    function objectAttributeContent( $contentObjectAttribute )
    {
        $date = new eZDate( );
        $stamp = $contentObjectAttribute->attribute( 'data_int' );
        $date->setTimeStamp( $stamp );
        return $date;
    }

    /*!
     Set class attribute value for template version
    */
    function initializeClassAttribute( $classAttribute )
    {
        if ( $classAttribute->attribute( self::DEFAULT_FIELD ) == null )
            $classAttribute->setAttribute( self::DEFAULT_FIELD, 0 );
        $classAttribute->store();
    }

    /*!
     Sets the default value.
    */
    function initializeObjectAttribute( $contentObjectAttribute, $currentVersion, $originalContentObjectAttribute )
    {
        if ( $currentVersion != false )
        {
            $dataInt = $originalContentObjectAttribute->attribute( "data_int" );
            $contentObjectAttribute->setAttribute( "data_int", $dataInt );
        }
        else
        {
            $contentClassAttribute = $contentObjectAttribute->contentClassAttribute();
            $defaultType = $contentClassAttribute->attribute( self::DEFAULT_FIELD );
            if ( $defaultType == 1 )
                $contentObjectAttribute->setAttribute( "data_int", time() );
        }
    }

    function fetchClassAttributeHTTPInput( $http, $base, $classAttribute )
    {
        $default = $base . "_ezdate_default_" . $classAttribute->attribute( 'id' );
        if ( $http->hasPostVariable( $default ) )
        {
            $defaultValue = $http->postVariable( $default );
            $classAttribute->setAttribute( self::DEFAULT_FIELD,  $defaultValue );
        }
        return true;
    }

    function isIndexable()
    {
        return true;
    }

    function isInformationCollector()
    {
        return true;
    }

    /*!
     Returns the meta data used for storing search indeces.
    */
    function metaData( $contentObjectAttribute )
    {
        return (int)$contentObjectAttribute->attribute( 'data_int' );
    }

    /*!
     \return string representation of an contentobjectattribute data for simplified export

    */
    function toString( $contentObjectAttribute )
    {
        $stamp = $contentObjectAttribute->attribute( 'data_int' );
        return $stamp === null ? '' : $stamp;
    }

    function fromString( $contentObjectAttribute, $string )
    {
        if ( empty( $string ) )
        {
            $string = null;
        }

        return $contentObjectAttribute->setAttribute( 'data_int', $string );
    }

    /*!
     Returns the date.
    */
    function title( $contentObjectAttribute, $name = null )
    {
        $locale = eZLocale::instance();
        $retVal = $contentObjectAttribute->attribute( "data_int" ) === null ? '' : $locale->formatDate( $contentObjectAttribute->attribute( "data_int" ) );
        return $retVal;
    }

    function hasObjectAttributeContent( $contentObjectAttribute )
    {
        return $contentObjectAttribute->attribute( "data_int" ) !== null;
    }

    function sortKey( $contentObjectAttribute )
    {
        return (int)$contentObjectAttribute->attribute( 'data_int' );
    }

    function sortKeyType()
    {
        return 'int';
    }

    function serializeContentClassAttribute( $classAttribute, $attributeNode, $attributeParametersNode )
    {
        $dom = $attributeParametersNode->ownerDocument;

        $defaultValue = $classAttribute->attribute( self::DEFAULT_FIELD );
        $defaultValueNode = $dom->createElement( 'default-value' );
        switch ( $defaultValue )
        {
            case self::DEFAULT_EMTPY:
                $defaultValueNode->setAttribute( 'type', 'empty' );
                break;

            case self::DEFAULT_CURRENT_DATE:
                $defaultValueNode->setAttribute( 'type', 'current-date' );
                break;
        }
        $attributeParametersNode->appendChild( $defaultValueNode );
    }

    function unserializeContentClassAttribute( $classAttribute, $attributeNode, $attributeParametersNode )
    {
        $defaultNode = $attributeParametersNode->getElementsByTagName( 'default-value' )->item( 0 );
        $defaultValue = strtolower( $defaultNode->getAttribute( 'type' ) );
        switch ( $defaultValue )
        {
            case 'empty':
            {
                $classAttribute->setAttribute( self::DEFAULT_FIELD, self::DEFAULT_EMTPY );
            } break;
            case 'current-date':
            {
                $classAttribute->setAttribute( self::DEFAULT_FIELD, self::DEFAULT_CURRENT_DATE );
            } break;
        }
    }

    function serializeContentObjectAttribute( $package, $objectAttribute )
    {
        $node = $this->createContentObjectAttributeDOMNode( $objectAttribute );

        $stamp = $objectAttribute->attribute( 'data_int' );

        if ( $stamp !== null )
        {
            $dom = $node->ownerDocument;
            $dateNode = $dom->createElement( 'date' );
            $dateNode->appendChild( $dom->createTextNode( eZDateUtils::rfc1123Date( $stamp ) ) );
            $node->appendChild( $dateNode );
        }
        return $node;
    }

    function unserializeContentObjectAttribute( $package, $objectAttribute, $attributeNode )
    {
        $dateNode = $attributeNode->getElementsByTagName( 'date' )->item( 0 );
        if ( is_object( $dateNode ) )
        {
            $timestamp = eZDateUtils::textToDate( $dateNode->textContent );
            $objectAttribute->setAttribute( 'data_int', $timestamp );
        }
    }

    function supportsBatchInitializeObjectAttribute()
    {
        return true;
    }

    function batchInitializeObjectAttributeData( $classAttribute )
    {
        $defaultType = $classAttribute->attribute( self::DEFAULT_FIELD );
        if ( $defaultType == 1 )
        {
            $default = time();
            return array( 'data_int'     => $default,
                          'sort_key_int' => $default );
        }
        else
        {
            return array();
        }
    }
}

eZDataType::register( eZDateType::DATA_TYPE_STRING, "eZDateType" );

?>
