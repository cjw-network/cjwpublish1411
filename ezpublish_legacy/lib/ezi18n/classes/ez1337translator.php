<?php
/**
 * File containing the eZ1337Translator class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package lib
 */

/*!
  \class eZ1337Translator ez1337translator.php
  \ingroup eZTranslation
  \brief Translates text into the leet (1337) language

  It translates the following characters/strings
  - to - 2
  - for - 4
  - ate - 8
  - you - u
  - l - 1
  - e - 3
  - o - 0
  - a - 4
  - t - 7

*/

class eZ1337Translator extends eZTranslatorHandler
{
    /*!
     Construct the translator and loads the translation file $file if is set and exists.
    */
    function eZ1337Translator()
    {
        $this->eZTranslatorHandler( false );

        $this->Messages = array();
    }

    function findMessage( $context, $source, $comment = null )
    {
        $man = eZTranslatorManager::instance();
        $key = $man->createKey( $context, $source, $comment );

        if ( !isset( $this->Messages[$key] ) )
        {
            $translation = $this->leetify( $source );
            $this->Messages[$key] = $man->createMessage( $context, $source, $comment, $translation );
        }

        return $this->Messages[$key];
    }

    /*!
     Translates the text into 1337 code.
    */
    function leetify( $text )
    {
        $text = preg_replace( "/to/", "2", $text );
        $text = preg_replace( "/for/", "4", $text );
        $text = preg_replace( "/ate/", "8", $text );
        $text = preg_replace( "/you/", "u", $text );
        $text = preg_replace( array( "/l/",
                                     "/e/",
                                     "/o/",
                                     "/a/",
                                     "/t/" ),
                              array( "1",
                                     "3",
                                     "0",
                                     "4",
                                     "7" ), $text );
        return $text;
    }

    function translate( $context, $source, $comment = null )
    {
        $msg = $this->findMessage( $context, $source, $comment );
        if ( $msg !== null )
        {
            return $msg["translation"];
        }

        return null;
    }

    /*!
     \static
     Initialize the bork translator if this is not allready done.
    */
    static function initialize()
    {
        if ( !isset( $GLOBALS['eZ1337Translator'] ) ||
             !( $GLOBALS['eZ1337Translator'] instanceof eZ1337Translator ) )
        {
            $GLOBALS['eZ1337Translator'] = new eZ1337Translator();
        }

        $man = eZTranslatorManager::instance();
        $man->registerHandler( $GLOBALS['eZ1337Translator'] );
        return $GLOBALS['eZ1337Translator'];
    }

    /// \privatesection
    /// Contains the hash table with cached 1337 translations
    public $Messages;
}

?>
