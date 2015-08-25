<?php
/**
 * File containing the eZDateTimeValidator class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package lib
 */

/*!
  \class eZDateTimeValidator ezdatetimevalidator.php
  \brief The class eZDateTimeValidator does

*/

class eZDateTimeValidator extends eZInputValidator
{
    /*!
     Constructor
    */
    function eZDateTimeValidator()
    {
    }

    static function validateDate( $day, $month, $year )
    {
        $check = checkdate( $month, $day, $year );
        $datetime = mktime( 0, 0, 0, $month, $day, $year );
        if ( !$check or
             $datetime === false )
        {
            return eZInputValidator::STATE_INVALID;
        }
        return eZInputValidator::STATE_ACCEPTED;
    }

    static function validateTime( $hour, $minute, $second = 0 )
    {
        if ( preg_match( '/\d+/', trim( $hour )   ) &&
             preg_match( '/\d+/', trim( $minute ) ) &&
             preg_match( '/\d+/', trim( $second ) ) &&
             $hour >= 0 && $minute >= 0 && $second >= 0 &&
             $hour < 24 && $minute < 60 && $second < 60 )
        {
            return eZInputValidator::STATE_ACCEPTED;
        }
        return eZInputValidator::STATE_INVALID;
    }

    static function validateDateTime( $day, $month, $year, $hour, $minute, $second = 0 )
    {
        $check = checkdate( $month, $day, $year );
        $datetime = mktime( $hour, $minute, $second, $month, $day, $year );
        if ( !$check or
             $datetime === false or
             eZDateTimeValidator::validateTime( $hour, $minute ) == eZInputValidator::STATE_INVALID )
        {
            return eZInputValidator::STATE_INVALID;
        }
        return eZInputValidator::STATE_ACCEPTED;
    }

    /// \privatesection
}

?>
