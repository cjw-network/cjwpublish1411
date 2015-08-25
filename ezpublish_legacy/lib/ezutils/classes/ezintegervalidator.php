<?php
/**
 * File containing the eZIntegerValidator class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package lib
 */

/*!
  \class eZIntegerValidator ezintegervalidator.php
  \brief The class eZIntegerValidator does

*/

class eZIntegerValidator extends eZRegExpValidator
{
    /*!
     Constructor
    */
    function eZIntegerValidator( $min = false, $max = false )
    {
        $rule = array( "accepted" => "/^-?[0-9]+$/",
                       "intermediate" => "/(-?[0-9]+)/",
                       "fixup" => "" );
        $this->eZRegExpValidator( $rule );
        $this->MinValue = $min;
        $this->MaxValue = $max;
        if ( $max !== false and $min !== false )
            $this->MaxValue = max( $min, $max );
    }

    function setRange( $min, $max )
    {
        $this->MinValue = $min;
        $this->MaxValue = $max;
        if ( $max !== false and $min !== false )
            $this->MaxValue = max( $min, $max );
    }

    function validate( $text )
    {
        $state = eZRegExpValidator::validate( $text );
        if ( $state == eZInputValidator::STATE_ACCEPTED )
        {
            if ( ( $this->MinValue !== false and $text < $this->MinValue ) or
                 ( $this->MaxValue !== false and $text > $this->MaxValue ) )
                $state = eZInputValidator::STATE_INTERMEDIATE;
        }
        return $state;
    }

    function fixup( $text )
    {
        if ( preg_match( $this->RegExpRule["intermediate"], $text, $regs ) )
            $text = $regs[1];
        if ( $this->MinValue !== false and $text < $this->MinValue )
            $text = $this->MinValue;
        else if ( $this->MaxValue !== false and $text > $this->MaxValue )
            $text = $this->MaxValue;
        return $text;
    }

    /// \privatesection
    public $MinValue;
    public $MaxValue;
}

?>
