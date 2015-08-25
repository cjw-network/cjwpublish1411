<?php
/**
 * File containing the ezpContentPublishingBehaviour class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package
 */

/**
 * This class allows for customization of
 * @property bool disableAsynchronousPublishing
 * @property bool isTemporary if set to true, this behaviour will be used once, and will be reset afterwards
 */
class ezpContentPublishingBehaviour extends ezcBaseOptions
{
    public function __construct( array $options = array() )
    {
        $this->disableAsynchronousPublishing = true;
        $this->isTemporary = false;
        parent::__construct( $options );
    }

    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'disableAsynchronousPublishing':
            case 'isTemporary':
                if ( !is_bool( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'bool' );
                }
                $this->properties[$name] = $value;
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Sets the publishing behaviour
     *
     * @param ezpContentPublishingBehaviour $behaviour
     * @return void
     */
    public static function setBehaviour( ezpContentPublishingBehaviour $behaviour )
    {
        self::$behaviour = $behaviour;
    }

    /**
     * Get the currently set behaviour. Returns the default one if one ain't set
     *
     * @return ezpContentPublishingBehaviour
     */
    public static function getBehaviour()
    {
        if ( self::$behaviour === null )
        {
            $return = new ezpContentPublishingBehaviour;
        }
        else
        {
            $return = clone self::$behaviour;
            if ( self::$behaviour->isTemporary )
            {
                self::$behaviour = null;
            }
        }
        return $return;
    }

    /**
     * @var ezpContentPublishingBehaviour
     */
    private static $behaviour = null;
}
?>
