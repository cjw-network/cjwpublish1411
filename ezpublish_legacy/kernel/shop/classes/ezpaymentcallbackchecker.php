<?php
/**
 * File containing the eZPaymentCallbackChecker class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  \class eZPaymentCallbackChecker ezpaymentcallbackchecker.php
  \brief Routines for support callback(postbacks) in redirectional
  payment gateways.
*/


class eZPaymentCallbackChecker
{
    /*!
        Constructor.
    */
    function eZPaymentCallbackChecker( $iniFile )
    {
        $this->logger   = eZPaymentLogger::CreateForAdd( 'var/log/eZPaymentChecker.log' );
        $this->ini      = eZINI::instance( $iniFile );
    }

    /*!
        Parses 'POST' response and create array with received data.
    */
    function createDataFromPOST()
    {
        $this->logger->writeTimedString( 'createDataFromPOST' );
        $this->callbackData = array();

        foreach( $_POST as $key => $value )
        {
            $this->callbackData[$key] = $value;
            $this->logger->writeTimedString( "$key = $value" );
        }

        return ( count( $this->callbackData ) > 0 );
    }

    /*!
        Parses 'GET' response and create array with received data.
    */
    function createDataFromGET()
    {
        $this->logger->writeTimedString( 'createDataFromGET' );
        $this->callbackData = array();

        $query_string = eZSys::serverVariable( 'QUERY_STRING' );
        if( $query_string )
        {
            $key_value_pairs = explode( '&', $query_string );

            foreach( $key_value_pairs as $key_value )
            {
                $data = explode( '=', $key_value );
                $this->callbackData[$data[0]] = $data[1];
                $this->logger->writeTimedString( "$data[0] = $data[1]" );
            }
        }

        return ( count( $this->callbackData ) > 0 );
    }


    /*!
        Sends POST request.
    */
    function sendPOSTRequest( $server, $port, $serverMethod, $request, $timeout=30)
    {
        $pos = strpos($server, '://');
        if( $pos !== false )
            $server = substr($server, $pos+3);

        $fp = fsockopen( $server, $port, $errno, $errstr, $timeout );

        if( $fp )
        {
            $theCall    =   "POST $serverMethod HTTP/1.0\r\n"                       .
                            "Host: $server\r\n"                                   .
                            "Content-Type: application/x-www-form-urlencoded\r\n"   .
                            "Content-Length: ".strlen( $request )."\r\n\r\n"     .
                            $request."\r\n\r\n";

            if ( !fputs( $fp, "$theCall", strlen( $theCall ) ) )
            {
                $this->logger->writeTimedString( "Could not write to server socket: $server:$port", 'sendPOSTRequest failed' );
                return null;
            }

            return $this->handleResponse( $fp );
        }

        $this->logger->writeTimedString( "Unable to open socket on $server:$port. errno = $errno, errstr = $errstr", 'sendPOSTRequest failed' );
        return null;
    }

    /*!
        Asks paypal's server to validate callback.
    */
    function requestValidation()
    {
        return false;
    }

    /*!
        Creates order and payment objects by orderID.
        After this 'checkAmount', 'checkCurrency' can be called.
    */
    function setupOrderAndPaymentObject( $orderID )
    {
        if ( isset( $orderID ) && $orderID > 0 )
        {
            $this->paymentObject = eZPaymentObject::fetchByOrderID( $orderID );
            if ( isset( $this->paymentObject ) )
            {
                $this->order = eZOrder::fetch( $orderID );
                if ( isset( $this->order ) )
                {
                    return true;
                }
                $this->logger->writeTimedString( "Unable to fetch order object with orderID=$orderID", 'setupOrderAndPaymentObject failed' );
                return false;
            }
            $this->logger->writeTimedString( "Unable to fetch payment object with orderID=$orderID", 'setupOrderAndPaymentObject failed' );
            return false;
        }
        $this->logger->writeTimedString( "Invalid orderID=$orderID", 'setupOrderAndPaymentObject failed' );
        return false;
    }

    /*!
        Approves payment and continues workflow.
    */
    function approvePayment( $continueWorkflow=true )
    {
        if( $this->paymentObject )
        {
            $this->paymentObject->approve();
            $this->paymentObject->store();

            $this->logger->writeTimedString( 'payment was approved' );

            return ( $continueWorkflow ? $this->continueWorkflow() : null );
        }

        $this->logger->writeTimedString( "payment object is not set", 'approvePayment failed' );
        return null;
    }

    /*!
        Continues workflow.
    */
    function continueWorkflow()
    {
        if( $this->paymentObject )
        {
            $workflowID = $this->paymentObject->attribute( 'workflowprocess_id' );
            if( $workflowID )
            {
                return eZPaymentObject::continueWorkflow( $workflowID );
            }

            $this->logger->writeTimedString( "workflowID is not set", 'continueWorkflow failed' );
            return null;
        }

        $this->logger->writeTimedString( "payment object is not set", 'continueWorkflow failed' );
        return null;
    }

    /*!
        Returns value of specified field.
    */
    function getFieldValue( $field )
    {
        if ( isset( $this->callbackData[$field] ) )
        {
            return $this->callbackData[ $field ];
        }

        $this->logger->writeTimedString( "field $field does not exist.", 'getFieldValue failed' );
        return null;
    }

    /*!
        Reads ip list from ini file and searches in it
        server's ip.
    */
    function checkServerIP()
    {
        $remoteHostIP   = eZSys::clientIP();
        $serverIPList   = $this->ini->variable( 'ServerSettings', 'ServerIP');

        if ( $serverIPList === false )
        {
            $this->logger->writeTimedString( "Skipped the IP check because ServerIP is not set in the settings. Remote host is: $remoteHostIP.", 'checkServerIP' );
            return true;
        }


        if ( is_array( $serverIPList ) && in_array( $remoteHostIP, $serverIPList ) )
        {
            return true;
        }

        $this->logger->writeTimedString( "server with ip = $remoteHostIP does not exist.", 'checkServerIP failed' );
        $this->logger->writeTimedString( $serverIPList, 'serverIPList from ini file is' );

        return false;
    }

    /*!
        Simple amount checking.
    */
    function checkAmount( $amount )
    {
        $orderAmount = $this->order->attribute( 'total_inc_vat' );

        // To avoid floating errors, round the value down before checking.
        $shopINI = eZINI::instance( 'shop.ini' );
        $precisionValue = (int)$shopINI->variable( 'MathSettings', 'RoundingPrecision' );
        if ( round( $orderAmount, $precisionValue ) === round( $amount, $precisionValue ) )
        {
            return true;
        }

        $this->logger->writeTimedString( "Order amount ($orderAmount) and received amount ($amount) do not match.", 'checkAmount failed' );
        return false;
    }

    /*!
      Simple currency checking. It's up to the payment solution to use the currency that
      are set in the product collection for the order.
    */
    function checkCurrency( $currency )
    {
        //get the order currency
        $productCollection = $this->order->productCollection();
        $orderCurrency = $productCollection->attribute( 'currency_code' );

        if ( $orderCurrency == $currency )
        {
            return true;
        }

        $this->logger->writeTimedString( "Order currency ($orderCurrency) and received currency ($currency).", 'checkCurrency failed' );
        return false;
    }

    function checkDataField( $field, $value )
    {
        $isValid = false;

        if( isset( $this->callbackData[$field] ) )
        {
            $isValid = ( $this->callbackData[$field] == $value );
        }

        //__DEBUG__
            if( !$isValid )
            {
                $this->logger->writeTimedString('check Field ----');
                $this->logger->writeTimedString("ERROR - receiving value doesn't match!!!");
                $this->logger->writeTimedString("Field          :".$field);
                $this->logger->writeTimedString("Value          :".$this->callbackData[$field]);
                $this->logger->writeTimedString("Expected value :".$value);
                $this->logger->writeTimedString('----');
            }
        //___end____

        return $isValid;
    }

    // you must override below
    /*!
        Postback request which will be sent to payment server.
    */
    function buildRequestString()
    {
        $this->logger->writeTimedString( 'You must override this function.', 'buildRequestString failed' );
        return null;
    }

    /*!
        Handles server response.
    */
    function handleResponse( $socket )
    {
        $this->logger->writeTimedString( 'You must override this function.', 'handlePOSTResponse failed' );
        return null;
    }

    public $logger;
    public $ini;
    public $callbackData;
    public $paymentObject;
    public $order;
}

?>
