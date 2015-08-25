<?php
/**
 * File containing the eZContentObjectEditHandler class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  \class eZContentObjectEditHandler ezcontentobjectedithandler.php
  \brief The class eZContentObjectEditHandler provides a framework for handling
  content/edit view specific things in extensions.

*/

class eZContentObjectEditHandler
{
    /*!
     Constructor
    */
    function eZContentObjectEditHandler()
    {
    }

    /*!
     Override this function in the extension to handle edit input parameters.
    */
    function fetchInput( $http, &$module, &$class, $object, &$version, $contentObjectAttributes, $editVersion, $editLanguage, $fromLanguage )
    {
    }

    /*!
     Return list of HTTP postparameters which should trigger store action.
    */
    static function storeActionList()
    {
        return array();
    }

    /*!
     Do content object publish operations.
    */
    function publish( $contentObjectID, $contentObjectVersion )
    {
    }

    /*!
     Override this function in the extension to handle input validation.

     Result with warnings are expected in the following format:
     array( 'is_valid' => false, 'warnings' => array( array( 'text' => 'Input parameter <some_id> must be an integer.' ) ) );
    */
    function validateInput( $http, &$module, &$class, $object, &$version, $contentObjectAttributes, $editVersion, $editLanguage, $fromLanguage, $validationParameters )
    {
        $result = array( 'is_valid' => true, 'warnings' => array() );

        return $result;
    }

    /*!
     \static
     Initialize all extension input handler.
    */
    static function initialize()
    {
        $contentINI = eZINI::instance( 'content.ini' );
        foreach( array_unique( $contentINI->variable( 'EditSettings', 'ExtensionDirectories' ) ) as $extensionDirectory )
        {
            $fileName = eZExtension::baseDirectory() . '/' . $extensionDirectory . '/content/' . $extensionDirectory . 'handler.php';
            if ( file_exists( $fileName ) )
            {
                include_once( $fileName );
                $className = $extensionDirectory . 'Handler';
                $storeActionList = call_user_func_array( array( $className, 'storeActionList' ), array() );
                foreach( $storeActionList as $storeAction )
                {
                    eZContentObjectEditHandler::addStoreAction( $storeAction );
                }
            }
            else
            {
                eZDebug::writeError( 'Cound not find content object edit handler ( defined in content.ini ) : ' . $fileName );
            }
        }
    }

    /*!
     \static
     Execute handler $functionName function with given $params parameters
    */
    static function executeHandlerFunction( $functionName, $params )
    {
        $result = array();
        $contentINI = eZINI::instance( 'content.ini' );
        foreach( array_unique( $contentINI->variable( 'EditSettings', 'ExtensionDirectories' ) ) as $extensionDirectory )
        {
            $fileName = eZExtension::baseDirectory() . '/' . $extensionDirectory . '/content/' . $extensionDirectory . 'handler.php';
            if ( file_exists( $fileName ) )
            {
                include_once( $fileName );
                $className = $extensionDirectory . 'Handler';
                $inputHandler = new $className();
                $functionResult = call_user_func_array( array( $inputHandler, $functionName ), $params );
                $result[] = array( 'handler' => $className,
                                   'function' => array( 'name' => $functionName, 'value' => $functionResult ) );
            }
        }

        return $result;
    }

    /*!
     \static
     Calls all extension object edit input handler, and executes this the fetchInput function
    */
    static function executeInputHandlers( &$module, &$class, $object, &$version, $contentObjectAttributes, $editVersion, $editLanguage, $fromLanguage )
    {
        $http = eZHTTPTool::instance();
        $functionName = 'fetchInput';
        $params = array( $http,
                         &$module,
                         &$class,
                         $object,
                         &$version,
                         $contentObjectAttributes,
                         $editVersion,
                         $editLanguage,
                         $fromLanguage );

       self::executeHandlerFunction( $functionName, $params );
    }

    /*!
     \static
     Calls all publish functions.
    */
    static function executePublish( $contentObjectID, $contentObjectVersion )
    {
        $functionName = 'publish';
        $params = array( $contentObjectID, $contentObjectVersion );

        self::executeHandlerFunction( $functionName, $params );
    }

    /*!
     \static
     Calls all input validation functions.
    */
    static function validateInputHandlers( &$module, &$class, $object, &$version, $contentObjectAttributes, $editVersion, $editLanguage, $fromLanguage, $validationParameters )
    {
        $result = array( 'validated' => true, 'warnings' => array() );
        $validated =& $result['validated'];
        $warnings =& $result['warnings'];

        $http = eZHTTPTool::instance();

        $functionName = 'validateInput';
        $params = array( $http,
                         &$module,
                         &$class,
                         $object,
                         &$version,
                         $contentObjectAttributes,
                         $editVersion,
                         $editLanguage,
                         $fromLanguage,
                         $validationParameters );

        $validationResults = self::executeHandlerFunction( $functionName, $params );

        foreach( $validationResults as $validationResult )
        {
            $value = $validationResult['function']['value'];

            if ( $value['is_valid'] == false )
            {
                if ( $value['warnings'] )
                    $warnings = array_merge( $warnings, $value['warnings'] );

                $validated = false;
            }
        }

        return $result;
    }

    /*!
     \static
     Set custom HTTP post parameters which should trigger store acrtions.

     \param HTTP post parameter name
    */
    static function addStoreAction( $name )
    {
        if ( !isset( $GLOBALS['eZContentObjectEditHandler_StoreAction'] ) )
        {
            $GLOBALS['eZContentObjectEditHandler_StoreAction'] = array();
        }
        $GLOBALS['eZContentObjectEditHandler_StoreAction'][] = $name;
    }

    /*!
     \static
     Check if any HTTP input trigger store action
    */
    static function isStoreAction()
    {
        if ( !isset( $GLOBALS['eZContentObjectEditHandler_StoreAction'] ) )
            return 0;
        return count( array_intersect( array_keys( $_POST ), $GLOBALS['eZContentObjectEditHandler_StoreAction'] ) ) > 0;
    }
}

?>
