<?php
/**
 * File containing the eZSOAPServer class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package lib
 */

/*!
  \class eZSOAPServer ezsoapserver.php
  \ingroup eZSOAP
  \brief The class eZSOAPServer handles SOAP server requensts

  Sample code for a SOAP server with one function, addNumbers.
  \code

$server = new eZSOAPServer( );
$server->registerFunction( "addNumbers", array( "valueA" => "integer", "valueB" => "integer" ) );
$server->registerObject( "Collection" );
$server->processRequest();

function addNumbers( $valueA, $valueB )
{
    $return = $valueA + $valueB;
    settype( $return, "integer" );
    return $return;
}

class Collection
{
    function Collection ()
    {

    }
    function subNumbers( $valueA, $valueB )
    {
        $return = $valueA - $valueB;
        settype( $return, "integer" );
        return $return;
    }
}
  \endcode
  \sa eZSOAPClient eZSOAPRequest eZSOAPResponse

*/

class eZSOAPServer
{
    /*!
      Creates a new eZSOAPServer object.
    */
    function eZSOAPServer()
    {
        global $HTTP_RAW_POST_DATA;
        $this->RawPostData = $HTTP_RAW_POST_DATA;
    }


    function showResponse( $functionName, $namespaceURI, $value )
    {
        // Convert input data to XML
        $response = new eZSOAPResponse( $functionName, $namespaceURI );
        $response->setValue( $value );

        $payload = $response->payload();

        header( "SOAPServer: eZ soap" );
        header( "Content-Type: text/xml; charset=\"UTF-8\"" );
        Header( "Content-Length: " . strlen( $payload ) );

        if ( ob_get_length() )
            ob_end_clean();

        print( $payload );
    }

    /*!
      Registers all functions of an object on the server.

      Returns false if the object could not be registered.
    */
    function registerObject( $objectName, $includeFile = null )
    {
        if ( file_exists( $includeFile ) )
            include_once( $includeFile );

        if ( class_exists( $objectName ) )
        {
            $methods = get_class_methods( $objectName );
            foreach ( $methods as $method)
            {
                if ( strcasecmp ( $objectName, $method ) )
                    $this->registerFunction( $objectName."::".$method );
            }
            return true;
        }
        else
        {
            return false;
        }
    }

    /*!
      Processes the SOAP request and prints out the
      propper response.
    */
    function processRequest()
    {
        global $HTTP_SERVER_VARS;

        if ( $_SERVER["REQUEST_METHOD"] != "POST" )
        {
            print( "Error: this web page does only understand POST methods" );
            exit();
        }

        $xmlData = $this->stripHTTPHeader( $this->RawPostData );

        $dom = new DOMDocument( '1.0', 'utf-8' );
        $dom->preserveWhiteSpace = false;
        $success = $dom->loadXML( $xmlData );

        // Check for non-parsing XML, to avoid call to non-object error.
        if ( !$success )
        {
            $this->showResponse( 'unknown_function_name', 'unknown_namespace_uri',
                                 new eZSOAPFault( 'Server Error',
                                                  'Bad XML' ) );
            return;
        }

        // add namespace fetching on body
        // get the SOAP body
        $body = $dom->getElementsByTagName( "Body" );

        $children = $body->item( 0 )->childNodes;

        if ( $children->length == 1 )
        {
            $requestNode = $children->item( 0 );
            // get target namespace for request
            $functionName = $requestNode->localName;
            $namespaceURI = $requestNode->namespaceURI;

            $params = array();
            // check parameters
            foreach ( $requestNode->childNodes as $parameterNode )
            {
                $params[] = eZSOAPResponse::decodeDataTypes( $parameterNode );
            }

            list( $objectName, $objectFunctionName ) = preg_split('/::/', $functionName, 2, PREG_SPLIT_NO_EMPTY);
            if ( !$objectFunctionName and in_array( $functionName, $this->FunctionList ) &&
                 function_exists( $functionName ) )
            {
                $this->showResponse( $functionName, $namespaceURI,
                                     call_user_func_array( $functionName, $params ) );
            }
            else if ( $objectName and $objectFunctionName )
            {
                if ( !class_exists( $objectName ) )
                {
                    $this->showResponse( $functionName, $namespaceURI,
                                         new eZSOAPFault( 'Server Error',
                                                          'Object not found' ) );
                }
                else
                {
                    $object = new $objectName();
                    if ( !method_exists( $object, $objectFunctionName ) )
                    {
                        $this->showResponse( $functionName, $namespaceURI,
                                             new eZSOAPFault( 'Server Error',
                                                              'Objectmethod not found' ) );
                    }
                    else
                    {
                        $this->showResponse( $functionName, $namespaceURI,
                                             call_user_func_array( array( $object, $objectFunctionName ), $params ) );
                    }
                }
            }
            else
            {
                $this->showResponse( $functionName, $namespaceURI,
                                     new eZSOAPFault( 'Server Error',
                                                      'Method not found' ) );
            }
        }
        else
        {
            // error
            $this->showResponse( $functionName, $namespaceURI,
                                 new eZSOAPFault( 'Server Error',
                                                  '"Body" element in the request '.
                                                  'has wrong number of children' ) );

        }
    }

    /*!
      Registers a new function on the server.

      Returns false if the function could not be registered.
    */
    function registerFunction( $name, $params=array() )
    {
        $this->FunctionList[] = $name;
    }


    /*!
      \static
      \private
      Strips the header information from the HTTP raw response.
    */
    function stripHTTPHeader( $data )
    {
        $start = strpos( $data, "<?xml version=\"1.0\"?>" );
        return substr( $data, $start, strlen( $data ) - $start );
    }

    /// Contains a list over registered functions
    public $FunctionList;
    /// Contains the RAW HTTP post data information
    public $RawPostData;
}

?>
