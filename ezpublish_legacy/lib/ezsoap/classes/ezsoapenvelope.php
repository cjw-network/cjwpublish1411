<?php
/**
 * File containing the eZSOAPEnvelope class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package lib
 */

/*! \defgroup eZSOAP SOAP communication library */

/*!
  \class eZSOAPEnvelope ezsoapenvelope.php
  \ingroup eZSOAP
  \brief SOAP envelope handling and definition

*/

class eZSOAPEnvelope
{
    const ENV = "http://schemas.xmlsoap.org/soap/envelope/";
    const ENC = "http://schemas.xmlsoap.org/soap/encoding/";
    const SCHEMA_INSTANCE = "http://www.w3.org/2001/XMLSchema-instance";
    const SCHEMA_DATA = "http://www.w3.org/2001/XMLSchema";

    const ENV_PREFIX = "SOAP-ENV";
    const ENC_PREFIX = "SOAP-ENC";
    const XSI_PREFIX = "xsi";
    const XSD_PREFIX = "xsd";

    const INT = 1;
    const STRING = 2;

    /*!
      Constructs a new SOAP envelope object.
    */
    function eZSOAPEnvelope( )
    {
        $this->Header = new eZSOAPHeader();
        $this->Body = new eZSOAPBody();
    }

    /// Contains the header object
    public $Header;

    /// Contains the body object
    public $Body;
}

?>
