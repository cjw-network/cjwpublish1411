<?php
/**
 * File containing the eZBorkTranslator class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package lib
 */

/*!
  \class eZBorkTranslator ezborktranslator.php
  \ingroup eZTranslation
  \brief Translates text into the Bork language (Mock Swedish)

  This translation is adapted from the Mock Swedish translation in Qt Quarterly 3/2002:
  http://doc.trolltech.com/qq/qq03-swedish-chef.html

  It translates the following characters/strings:
  (The "|" sign stands for a word boundary, and "-" stands for mid-word.)

  a-    -> e
  an    -> un
  au    -> oo
  en|   -> ee
  -ew   -> oo
  -f    -> ff
  -i    -> ee
  -ir   -> ur
  |o    -> oo
  ow    -> oo
  ph    -> f
  th|   -> t
  -tion -> shun
  -u    -> oo
  |U-   -> Oo
  y|    -> ai
  v     -> f
  w     -> v

  Words that are not changed by these rules will have "-a" appended to them.

*/

class eZBorkTranslator extends eZTranslatorHandler
{
    /*!
     Construct the translator.
    */
    function eZBorkTranslator()
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
            $translation = $this->borkify( $source );
            $this->Messages[$key] = $man->createMessage( $context, $source, $comment, $translation );
        }

        return $this->Messages[$key];
    }

    /*!
     Translates the text into bork code.
    */
    function borkify( $text )
    {
        $textBlocks = preg_split( "/(%[^ ]+)/", $text, -1, PREG_SPLIT_DELIM_CAPTURE );
        $newTextBlocks = array();
        foreach ( $textBlocks as $text )
        {
            if ( $text[0] == '%' )
            {
                $newTextBlocks[] = $text;
                continue;
            }
            $orgtext = $text;
            $text = preg_replace( "/a\B/", "e", $text );
            $text = preg_replace( "/an/", "un", $text );
            $text = preg_replace( "/au/", "oo", $text );
            $text = preg_replace( "/en\b/", "ee", $text );
            $text = preg_replace( "/\Bew/", "oo", $text );
            $text = preg_replace( "/\Bf/", "ff", $text );
            $text = preg_replace( "/\Bi/", "ee", $text );
            $text = preg_replace( "/\Bir/", "ur", $text );
            $text = preg_replace( "/\bo/", "oo", $text );
            $text = preg_replace( "/ow/", "oo", $text );
            $text = preg_replace( "/ph/", "f", $text );
            $text = preg_replace( "/th\b/", "t", $text );
            $text = preg_replace( "/\Btion/", "shun", $text );
            $text = preg_replace( "/\Bu/", "oo", $text );
            $text = preg_replace( "/\bU/", "Oo", $text );
            $text = preg_replace( "/y\b/", "ai", $text );
            $text = preg_replace( "/v/", "f", $text );
            $text = preg_replace( "/w/", "v", $text );
            $text = preg_replace( "/ooo/", "oo", $text );
            if ( $orgtext == $text )
                $text = $text . "-a";
            $newTextBlocks[] = $text;
        }
        $text = implode( '', $newTextBlocks );
        $text = preg_replace( "/([:.?!])(.*)/", "\\2\\1", $text );
        $text = "[" . $text . "]";
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
        if ( !isset( $GLOBALS['eZBorkTranslator'] ) ||
             !( $GLOBALS['eZBorkTranslator'] instanceof eZBorkTranslator ) )
        {
            $GLOBALS['eZBorkTranslator'] = new eZBorkTranslator();
        }

        $man = eZTranslatorManager::instance();
        $man->registerHandler( $GLOBALS['eZBorkTranslator'] );
        return $GLOBALS['eZBorkTranslator'];
    }

    /// \privatesection
    /// Contains the hash table with cached bork translations
    public $Messages;
}

?>
