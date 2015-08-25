<?php
/**
 * File containing the eZTranslatorManager class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package lib
 */

/*! \defgroup eZTranslation Translation
    \ingroup eZI18N
*/


/*!
  \class eZTranslatorManager eztranslatormanager.php
  \ingroup eZTranslation
  \brief This provides internationalization support for text output

  Each message consists of:
   - context - the context of the translation
   - source - the source string
   - comment - a variation of the context/source
   - key - the uniquely generated key taken from context, source and eventually comment


*/

class eZTranslatorManager
{
    const DYNAMIC_TRANSLATIONS_ENABLED = 'eZTMDynamicTranslationsEnabled';

    function eZTranslatorManager()
    {
        $this->Handlers = array();
    }

    /*!
     Tries to find the translation message that matches \a $key in all it's handlers
     and returns it. If no message could be found it either means that none of the
     handlers have a translation for the key or that some of the handlers are not key based,
     for instance realtime translators.
     In the latter case an extra call to findMessage() or translate() is required.

     Use keyTranslate if you only want to translate a message.

     \sa findMessage, keyTranslate
    */
    function findKey( $key )
    {
        $msg = null;
        for ( $i = 0; $i < count( $this->Handlers ) and $msg === null; ++$i )
        {
            $handler = $this->Handlers[$i];
            if ( $handler->isKeyBased() )
                $msg = $handler->findKey( $key );
        }
        return $msg;
    }

    /*!
     Tries to find the translation message that matches \a $context, \a $source and
     \a $comment. If that fails it tries \a $context and \a $source only.
     The message is then returned or null if no translation message could be found/generated for it.

     Use translate if you only want to translate a message.

     \sa findKey, translate
    */
    function findMessage( $context, $source, $comment = null )
    {
        if ( !is_string( $context ) or $context == "" )
            $context = "default";
        $msg = null;
        for ( $i = 0; $i < count( $this->Handlers ) and $msg === null; ++$i )
        {
            $handler = $this->Handlers[$i];
            $msg = $handler->findMessage( $context, $source, $comment );
        }
        return $msg;
    }

    /*!
     \return the translation string for \a $key.

     Note this returns the exact translation for the given key, use translate()
     instead if you want to have variable comment support.

     \sa findKey, translate
    */
    function keyTranslate( $key )
    {
        $trans = null;
        for ( $i = 0; $i < count( $this->Handlers ) and $trans === null; ++$i )
        {
            $handler = $this->Handlers[$i];
            if ( $handler->isKeyBased() )
                $trans = $handler->keyTranslate( $key );
        }
        return $trans;
    }

    /*!
     \return the translation string for \a $source and \a $context or null if the key does not exist.

     \sa findMessage, findKey
    */
    function translate( $context, $source, $comment = null )
    {
        if ( !is_string( $context ) or $context == "" )
            $context = "default";
        $trans = null;
        for ( $i = 0; $i < count( $this->Handlers ) and $trans === null; ++$i )
        {
            $handler = $this->Handlers[$i];
            $trans = $handler->translate( $context, $source, $comment );
        }
        return $trans;
    }

    /**
     * Returns a shared instance of the eZTranslatorManager class.
     *
     * @return eZTranslatorManager
     */
    static function instance()
    {
        if ( empty( $GLOBALS['eZTranslatorManagerInstance'] ) )
        {
            $GLOBALS['eZTranslatorManagerInstance'] = new eZTranslatorManager();
        }
        return $GLOBALS['eZTranslatorManagerInstance'];
    }

    /*!
     \static
     Registers the handler object \a $handler.
    */
    static function registerHandler( $handler )
    {
        $instance = eZTranslatorManager::instance();
        $instance->Handlers[] = $handler;
    }

    /*!
     \static
     Creates an md5 key based on the \a $context, \a $source and \a $comment and returns it.
    */
    static function createKey( $context, $source, $comment = null )
    {
        if ( $comment === null )
            $comment = "";
        return md5( "$context\n$source\n$comment" );
    }

    /*!
     \static
     Creates a message structure out of \a $context, \a $source and \a $comment
     and returns it.
    */
    static function createMessage( $context, $source, $comment = null, $translation = null )
    {
        $msg = array( "context" => $context,
                      "source" => $source,
                      "comment" => $comment,
                      "translation" => $translation );
        return $msg;
    }

    /*!
     \static
    */
    static function resetGlobals()
    {
        unset( $GLOBALS["eZTranslatorManagerInstance"] );
    }

    /*!
     \static
    */
    static function resetTranslations()
    {
        eZTranslatorManager::resetGlobals();
        eZTSTranslator::resetGlobals();
        eZLocale::resetGlobals();
        eZTranslationCache::resetGlobals();
    }

    /*!
     \static
    */
    static function dynamicTranslationsEnabled()
    {
        return isset( $GLOBALS[self::DYNAMIC_TRANSLATIONS_ENABLED] );
    }

    /*!
     \static
    */
    static function enableDynamicTranslations( $enable = true )
    {
        if ( $enable )
        {
            $GLOBALS[self::DYNAMIC_TRANSLATIONS_ENABLED] = true;
        }
        else
        {
            unset( $GLOBALS[self::DYNAMIC_TRANSLATIONS_ENABLED] );
        }
    }

    /*!
     \static
    */
    static function setActiveTranslation( $locale, $permanently = true )
    {
        if( !eZTranslatorManager::dynamicTranslationsEnabled() )
            return;

        if ( $permanently )
            $siteINI = eZINI::instance( 'site.ini.append', 'settings/override', null, null, false, true );
        else
            $siteINI = eZINI::instance();

        $siteINI->setVariable( 'RegionalSettings', 'Locale', $locale );
        $siteINI->setVariable( 'RegionalSettings', 'TextTranslation', 'enabled' );

        if ( $permanently )
        {
            $siteINI->save( 'site.ini.append', '.php', false, false );
            eZINI::resetInstance( "site.ini" );
        }

        eZTranslatorManager::resetTranslations();
    }



    /// \privatesection
    /// The array of handler objects
    public $Handlers;
}

?>
