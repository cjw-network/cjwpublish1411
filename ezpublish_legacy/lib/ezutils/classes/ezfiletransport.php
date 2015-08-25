<?php
/**
 * File containing the eZFileTransport class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package lib
 */

/*!
  \class eZFileTransport ezfiletransport.php
  \brief Sends the email message to a file.

*/

class eZFileTransport extends eZMailTransport
{
    /*!
     Constructor
    */
    function eZFileTransport()
    {
    }

    function sendMail( eZMail $mail )
    {
        $ini = eZINI::instance();
        $sendmailOptions = '';
        $emailFrom = $mail->sender();
        $emailSender = $emailFrom['email'];
        if ( !$emailSender || count( $emailSender) <= 0 )
            $emailSender = $ini->variable( 'MailSettings', 'EmailSender' );
        if ( !$emailSender )
            $emailSender = $ini->variable( 'MailSettings', 'AdminEmail' );
        if ( !eZMail::validate( $emailSender ) )
            $emailSender = false;

        $isSafeMode = ini_get( 'safe_mode' );
        if ( $isSafeMode and
             $emailSender and
             $mail->sender() == false )
            $mail->setSenderText( $emailSender );

        $filename = time() . '-' . mt_rand() . '.mail';

        $data = preg_replace('/(\r\n|\r|\n)/', "\r\n", $mail->headerText() . "\n" . $mail->body() );
        $returnedValue = eZFile::create( $filename, 'var/log/mail', $data );
        if ( $returnedValue === false )
        {
            eZDebug::writeError( 'An error occurred writing the e-mail file in var/log/mail', __METHOD__ );
        }

        return $returnedValue;
    }
}

?>
