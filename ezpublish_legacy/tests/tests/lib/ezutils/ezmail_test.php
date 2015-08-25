<?php
/**
 * File containing the eZMailTest class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package tests
 */

class eZMailTest extends ezpTestCase
{
    public static function imapIsEnabled()
    {
        return function_exists( 'imap_open' );
    }

    public function setUp()
    {
        parent::setUp();

        // Setup default settings, change these in each test when needed
        ezpINIHelper::setINISetting( 'site.ini', 'MailSettings', 'Transport', 'sendmail' );
        ezpINIHelper::setINISetting( 'site.ini', 'MailSettings', 'TransportServer', 'localhost' );
        ezpINIHelper::setINISetting( 'site.ini', 'MailSettings', 'TransportPort', 25 );
        ezpINIHelper::setINISetting( 'site.ini', 'MailSettings', 'TransportUser', '' );
        ezpINIHelper::setINISetting( 'site.ini', 'MailSettings', 'TransportPassword', '' );
        $ini = eZINI::instance( 'test_ezmail_plain.ini' );
        $adminEmail = $ini->variable( 'TestAccounts', 'AdminEmail' );
        ezpINIHelper::setINISetting( 'site.ini', 'MailSettings', 'AdminEmail', $adminEmail );
        ezpINIHelper::setINISetting( 'site.ini', 'MailSettings', 'EmailSender', $adminEmail );
        ezpINIHelper::setINISetting( 'site.ini', 'MailSettings', 'EmailReplyTo', $adminEmail );
        ezpINIHelper::setINISetting( 'site.ini', 'MailSettings', 'DebugSending', 'disabled' );
        ezpINIHelper::setINISetting( 'site.ini', 'MailSettings', 'DebugReceiverEmail', $adminEmail );
    }

    public function tearDown()
    {
        ezpINIHelper::restoreINISettings();

        parent::tearDown();
    }

    public static function providerTestValidate()
    {
        return array(
            array( 'kc@ez.no',      1 ),
            array( 'kc+list@ez.no', 1 ),
            array( "kc'@ez.no",     1 ),
            array( "k..c'@ez.no",   0 ),
            array( ".kc@ez.no",     0 ),

            array( 'johndoe@example.com', 1 ),
            array( 'johndoe@example.org', 1 ),
            array( 'johndoe@example.gov', 1 ),
            array( 'johndoe@example.biz', 1 ),
            array( 'johndoe@example.net', 1 ),
            array( 'johndoe@example.mil', 1 ),
            array( 'johndoe@example.xxx', 1 ),
            array( 'johndoe@example.info', 1 ),
            array( 'johndoe@example.aero', 1 ),
            array( 'johndoe@example.jobs', 1 ),
            array( 'johndoe@example.name', 1 ),
            array( 'johndoe@example.museum', 1 ),
            array( 'johndoe@example.solarspace', 1 ),
            array( 'johndoe@example.co.uk', 1 ),
            array( 'johndoe@e.x.a.m.p.l.e.com', 1 ),
            array( 'johndoe@e-x-a-m-p-l-e.com', 1 ),
            array( 'johndoe@e.x-a.m-p.l-e.com', 1 ),
            array( 'johndoe@example.xx', 1 ),
            array( 'johndoe@-example.com', 1 ),
            array( 'johndoe@example-.com', 1 ),
            array( 'johndoe@1example.com', 1 ),
            array( 'johndoe@example.c-m', 1 ),
            array( 'johndoe@1.aa', 1 ),

            // doma'in part as IP address
            array( 'johndoe@0.0.0.0', 1 ),
            array( 'johndoe@11.11.11.11', 1 ),
            array( 'johndoe@111.111.111.111', 1 ),
            array( 'johndoe@127.0.0.1', 1 ),
            array( 'johndoe@[127.0.0.1]', 1 ),
            array( 'johndoe@1.12.123.1', 1 ),
            array( 'johndoe@255.255.255.255', 1 ),

            array( 'a@example.com', 1 ),
            array( 'A@example.com', 1 ),
            array( '1@example.com', 1 ),

            array( '+@example.com', 1 ),
            array( '*@example.com', 1 ),
            array( '{@example.com', 1 ),
            array( '}@example.com', 1 ),
            array( '|@example.com', 1 ),
            array( '~@example.com', 1 ),
            array( '/@example.com', 1 ),
            array( '\'@example.com', 1 ),
            array( '-@example.com', 1 ),
            array( '_@example.com', 1 ),
            array( '`@example.com', 1 ),
            array( '^@example.com', 1 ),
            array( '$@example.com', 1 ),
            array( '%@example.com', 1 ),
            array( '&@example.com', 1 ),
            array( '!@example.com', 1 ),

            array( 'john+doe@example.com', 1 ),
            array( 'john*doe@example.com', 1 ),
            array( 'john{doe@example.com', 1 ),
            array( 'john}doe@example.com', 1 ),
            array( 'john|doe@example.com', 1 ),
            array( 'john~doe@example.com', 1 ),
            array( 'john/doe@example.com', 1 ),
            array( 'john\'doe@example.com', 1 ),
            array( 'john-doe@example.com', 1 ),
            array( 'john_doe@example.com', 1 ),
            array( 'john`doe@example.com', 1 ),
            array( 'john^doe@example.com', 1 ),
            array( 'john$doe@example.com', 1 ),
            array( 'john%doe@example.com', 1 ),
            array( 'john&doe@example.com', 1 ),
            array( 'john!doe@example.com', 1 ),

            array( 'johndoe+@example.com', 1 ),
            array( 'johndoe*@example.com', 1 ),
            array( 'johndoe{@example.com', 1 ),
            array( 'johndoe}@example.com', 1 ),
            array( 'johndoe|@example.com', 1 ),
            array( 'johndoe~@example.com', 1 ),
            array( 'johndoe/@example.com', 1 ),
            array( 'johndoe\'@example.com', 1 ),
            array( 'johndoe-@example.com', 1 ),
            array( 'johndoe_@example.com', 1 ),
            array( 'johndoe`@example.com', 1 ),
            array( 'johndoe^@example.com', 1 ),
            array( 'johndoe$@example.com', 1 ),
            array( 'johndoe%@example.com', 1 ),
            array( 'johndoe&@example.com', 1 ),
            array( 'johndoe!@example.com', 1 ),

            array( 'j.o.h.n.d.o.e@example.com', 1 ),
            array( 'john-doe@example.com', 1 ),
            array( 'j-o-h-n-d-o-e@example.com', 1 ),
            array( 'j._-oh.n---d.__--o.___---e@example.com', 1 ),
            array( 'john_doe@example.com', 1 ),
            array( 'john/doe@example.com', 1 ),
            array( 'j_o_h_n_d_o_e@example.com', 1 ),
            array( 'j.o_h-n.d_o-e@example.com', 1 ),
            array( 'johndoe1@example.com', 1 ),
            array( 'j1o2h3n4d5o6e7@example.com', 1 ),
            array( 'j1.o2_h3-n4.d5_o6-e7@example.com', 1 ),
            array( '1johndoe@example.com', 1 ),
            array( '+1~1+@example.com', 1 ),
            array( '{johndoe}@example.com', 1 ),
            array( '{_johndoe_}@example.com', 1 ),
            array( '|johndoe|@example.com', 1 ),
            array( '-johndoe-@example.com', 1 ),
            array( '`johndoe`@example.com', 1 ),
            array( '\'johndoe\'@example.com', 1 ),
            array( '"[[ johndoe ]]"@example.com', 1 ),
            array( '"john.\'doe\'"@example.com', 1 ),

            array( '"john doe"@example.com', 1 ),
            array( '"john\doe"@example.com', 1 ),
            array( '"john?doe"@example.com', 1 ),
            array( '"john,doe"@example.com', 1 ),
            array( '"john@doe"@example.com', 1 ),
            array( '"john=doe"@example.com', 1 ),
            array( '"john<doe"@example.com', 1 ),
            array( '"john>doe"@example.com', 1 ),
            array( '"john;doe"@example.com', 1 ),
            array( '"john:doe"@example.com', 1 ),
            array( '"john¢doe"@example.com', 1 ),
            array( '"john±doe"@example.com', 1 ),
            array( '"john³doe"@example.com', 1 ),
            array( '"johnµdoe"@example.com', 1 ),
            array( '"john¶doe"@example.com', 1 ),
            array( '"john·doe"@example.com', 1 ),
            array( '"john¸doe"@example.com', 1 ),
            array( '"john¹doe"@example.com', 1 ),
            array( '"john°doe"@example.com', 1 ),
            array( '"john½doe"@example.com', 1 ),
            array( '"john»doe"@example.com', 1 ),
            array( '"john§doe"@example.com', 1 ),
            array( '"john®doe"@example.com', 1 ),
            array( '"john¯doe"@example.com', 1 ),
            array( '"john¬doe"@example.com', 1 ),
            array( '"john¼doe"@example.com', 1 ),
            array( '"johnþdoe"@example.com', 1 ),
            array( '"john¡doe"@example.com', 1 ),
            array( '"john£doe"@example.com', 1 ),
            array( '"john¤doe"@example.com', 1 ),
            array( '"john¥doe"@example.com', 1 ),
            array( '"johnÞdoe"@example.com', 1 ),
            array( '"john¦doe"@example.com', 1 ),
            array( '"johnªdoe"@example.com', 1 ),
            array( '"john¨doe"@example.com', 1 ),
            array( '"john©doe"@example.com', 1 ),
            array( '"john¿doe"@example.com', 1 ),
            array( '"john¾doe"@example.com', 1 ),
            array( '"john¼doe"@example.com', 1 ),
            array( '"john«doe"@example.com', 1 ),

            // incorrect addresses
            array( 'name', 0 ),
            array( 'johndoe', 0 ),
            array( 'johndoe@', 0 ),
            array( 'johndoe@.', 0 ),
            array( 'johndoe@a.a', 0 ),
            array( 'johndoe@1.a', 0 ),
            array( 'johndoe@example', 0 ),
            array( 'johndoe@example.x', 0 ),
            array( 'johndoe@example.0', 0 ),
            array( 'johndoe@example.00', 0 ),
            array( 'johndoe@example.000', 0 ),
            array( 'johndoe@example,com', 0 ),
            array( 'johndoe@e$ample.com', 0 ),
            array( 'johndoe@e!ample.com', 0 ),
            array( 'johndoe@e?ample.com', 0 ),
            array( 'johndoe@e\'ample.com', 0 ),
            array( 'johndoe@e"ample.com', 0 ),
            array( 'johndoe@e^ample.com', 0 ),
            array( 'johndoe@e%ample.com', 0 ),
            array( 'johndoe@e~ample.com', 0 ),
            array( 'johndoe@e`ample.com', 0 ),
            array( 'johndoe@examp|e.com', 0 ),
            array( 'johndoe@e#ample.com', 0 ),
            array( 'johndoe@e ample.com', 0 ),
            array( 'johndoe@e_ample.com', 0 ),
            array( 'johndoe@e%20ample.com', 0 ),
            array( 'johndoe@example.c m', 0 ),
            array( 'johndoe@{example}.com', 0 ),
            array( 'johndoe@(example).com', 0 ),
            array( 'johndoe@[example].com', 0 ),
            array( 'johndoe@"example".com', 0 ),
            array( 'johndoe@\'example\'.com', 0 ),
            array( 'johndoe@example.$$$', 0 ),
            array( 'johndoe@example.!!!', 0 ),
            array( 'johndoe@example.???', 0 ),
            array( 'johndoe@example.###', 0 ),
            array( 'johndoe@example....', 0 ),
            array( 'johndoe@example.,,,', 0 ),
            array( 'johndoe@example.[]', 0 ),
            array( 'johndoe@example.{}', 0 ),
            array( 'johndoe@example.()', 0 ),
            array( 'johndoe@example.""', 0 ),
            array( 'johndoe@example.\'\'', 0 ),
            array( 'johndoe@example.||', 0 ),
            array( 'johndoe@`example.com', 0 ),
            array( 'johndoe@|example.com', 0 ),
            array( 'johndoe@,example.com', 0 ),
            array( 'johndoe@.example.com', 0 ),
            array( '@', 0 ),
            array( '@.', 0 ),

            // domain part as IP address
            array( 'johndoe@1111.111.11.1', 0 ),
            array( 'johndoe@256.256.256.256', 0 ),
            array( 'johndoe@FF.0F.FF.7A', 0 ),
            array( 'johndoe@1-7.0.0.1', 0 ),
            array( 'johndoe@127.0.0.[1]', 0 ),
            array( 'johndoe@(127.0.0.1)', 0 ),
            array( 'johndoe@{127.0.0.1}    ', 0 ),
            array( 'johndoe@"127.0.0.1"', 0 ),
            array( 'johndoe@\'127.0.0.1\'', 0 ),
            array( 'johndoe@|127.0.0.1|', 0 ),
            array( 'johndoe@`127.0.0.1`', 0 ),
            array( 'johndoe@127.0.0', 0 ),
            array( 'johndoe@127.0', 0 ),
            array( 'johndoe@127', 0 ),
            array( 'johndoe@0.00', 0 ),

            // localpart
            array( 'example.com', 0 ),
            array( '@example.com', 0 ),

            array( '.@example.com', 0 ),
            array( ',@example.com', 0 ),
            array( '\@example.com', 0 ),
            array( '"@example.com', 0 ),
            array( '=@example.com', 0 ),
            array( '?@example.com', 0 ),
            array( '<@example.com', 0 ),
            array( '>@example.com', 0 ),
            array( ':@example.com', 0 ),
            array( ';@example.com', 0 ),
            array( '¢@example.com', 0 ),
            array( '±@example.com', 0 ),
            array( '³@example.com', 0 ),
            array( 'µ@example.com', 0 ),
            array( '¶@example.com', 0 ),
            array( '·@example.com', 0 ),
            array( '¸@example.com', 0 ),
            array( '¹@example.com', 0 ),
            array( '°@example.com', 0 ),
            array( '½@example.com', 0 ),
            array( '»@example.com', 0 ),
            array( '§@example.com', 0 ),
            array( '®@example.com', 0 ),
            array( '¯@example.com', 0 ),
            array( '¬@example.com', 0 ),
            array( '¼@example.com', 0 ),
            array( 'þ@example.com', 0 ),
            array( '¡@example.com', 0 ),
            array( '£@example.com', 0 ),
            array( '¤@example.com', 0 ),
            array( '¥@example.com', 0 ),
            array( 'Þ@example.com', 0 ),
            array( '¦@example.com', 0 ),
            array( 'ª@example.com', 0 ),
            array( '¨@example.com', 0 ),
            array( '©@example.com', 0 ),
            array( '¿@example.com', 0 ),
            array( '¾@example.com', 0 ),
            array( '¼@example.com', 0 ),
            array( '«@example.com', 0 ),

            array( '.johndoe@example.com', 0 ),
            array( 'johndoe.@example.com', 0 ),
            array( 'johndoe,@example.com', 0 ),
            array( 'johndoe\@example.com', 0 ),
            array( 'johndoe"@example.com', 0 ),
            array( 'johndoe=@example.com', 0 ),
            array( 'johndoe?@example.com', 0 ),
            array( 'johndoe<@example.com', 0 ),
            array( 'johndoe>@example.com', 0 ),
            array( 'johndoe:@example.com', 0 ),
            array( 'johndoe;@example.com', 0 ),
            array( 'johndoe¢@example.com', 0 ),
            array( 'johndoe±@example.com', 0 ),
            array( 'johndoe³@example.com', 0 ),
            array( 'johndoeµ@example.com', 0 ),
            array( 'johndoe¶@example.com', 0 ),
            array( 'johndoe·@example.com', 0 ),
            array( 'johndoe¸@example.com', 0 ),
            array( 'johndoe¹@example.com', 0 ),
            array( 'johndoe°@example.com', 0 ),
            array( 'johndoe½@example.com', 0 ),
            array( 'johndoe»@example.com', 0 ),
            array( 'johndoe§@example.com', 0 ),
            array( 'johndoe®@example.com', 0 ),
            array( 'johndoe¯@example.com', 0 ),
            array( 'johndoe¬@example.com', 0 ),
            array( 'johndoe¼@example.com', 0 ),
            array( 'johndoeþ@example.com', 0 ),
            array( 'johndoe¡@example.com', 0 ),
            array( 'johndoe£@example.com', 0 ),
            array( 'johndoe¤@example.com', 0 ),
            array( 'johndoe¥@example.com', 0 ),
            array( 'johndoeÞ@example.com', 0 ),
            array( 'johndoe¦@example.com', 0 ),
            array( 'johndoeª@example.com', 0 ),
            array( 'johndoe¨@example.com', 0 ),
            array( 'johndoe©@example.com', 0 ),
            array( 'johndoe¿@example.com', 0 ),
            array( 'johndoe¾@example.com', 0 ),
            array( 'johndoe¼@example.com', 0 ),
            array( 'johndoe«@example.com', 0 ),
            array( 'john doe@example.com', 0 ),

            array( 'john,doe@example.com', 0 ),
            array( 'john"doe@example.com', 0 ),
            array( 'john@doe@example.com', 0 ),
            array( 'john\doe@example.com', 0 ),
            array( 'john=doe@example.com', 0 ),
            array( 'john?doe@example.com', 0 ),
            array( 'john<doe@example.com', 0 ),
            array( 'john>doe@example.com', 0 ),
            array( 'john;doe@example.com', 0 ),
            array( 'john:doe@example.com', 0 ),
            array( 'john¢doe@example.com', 0 ),
            array( 'john±doe@example.com', 0 ),
            array( 'john³doe@example.com', 0 ),
            array( 'johnµdoe@example.com', 0 ),
            array( 'john¶doe@example.com', 0 ),
            array( 'john·doe@example.com', 0 ),
            array( 'john¸doe@example.com', 0 ),
            array( 'john¹doe@example.com', 0 ),
            array( 'john°doe@example.com', 0 ),
            array( 'john½doe@example.com', 0 ),
            array( 'john»doe@example.com', 0 ),
            array( 'john§doe@example.com', 0 ),
            array( 'john®doe@example.com', 0 ),
            array( 'john¯doe@example.com', 0 ),
            array( 'john¬doe@example.com', 0 ),
            array( 'john¼doe@example.com', 0 ),
            array( 'johnþdoe@example.com', 0 ),
            array( 'john¡doe@example.com', 0 ),
            array( 'john£doe@example.com', 0 ),
            array( 'john¤doe@example.com', 0 ),
            array( 'john¥doe@example.com', 0 ),
            array( 'johnÞdoe@example.com', 0 ),
            array( 'john¦doe@example.com', 0 ),
            array( 'johnªdoe@example.com', 0 ),
            array( 'john¨doe@example.com', 0 ),
            array( 'john©doe@example.com', 0 ),
            array( 'john¿doe@example.com', 0 ),
            array( 'john¾doe@example.com', 0 ),
            array( 'john¼doe@example.com', 0 ),
            array( 'john«doe@example.com', 0 ),

            array( '- johndoe -@example.com', 0 ),
            array( '[johndoe]@example.com', 0 ),
            array( '(johndoe)@example.com', 0 ),
            array( '<johndoe>@example.com', 0 ),
        );
    }

    public static function providerTestExtractEmail()
    {
        return array(
                        array( 'John Doe <jdoe+subaddr@test.example.com>', 'John Doe', 'jdoe+subaddr@test.example.com' ),
                        array( 'John Doe <jdoe@test.example.com>', 'John Doe', 'jdoe@test.example.com' ),
                        array( 'John Doe <jdoe@example.com>', 'John Doe', 'jdoe@example.com' ),
                        array( '豆豆龍 <jdoe@example.com>', '豆豆龍', 'jdoe@example.com' ),
                        array( '小丁噹 <"小丁噹"@example.com>', '小丁噹', '"小丁噹"@example.com' ),
                    );
    }

    public static function providerTestStripEmail()
    {
        return array(
                        array( 'Bla bla bla bla "楊大葶" <user@example.com>  test test <anotheruser@example.com> test', 'user@example.com' ),
                        array( 'Bla bla bla bla "楊大葶"@example.com test <anotheruser@example.com> test test', '"楊大葶"@example.com' ),
                        array( 'Bla bla bla bla John Doe <jdoe+subaddr@test.example.com> test <anotheruser@example.com> test test', 'jdoe+subaddr@test.example.com' ),
                    );
    }

    public static function getTestAccounts()
    {
        $ini = eZINI::instance( 'test_ezmail_plain.ini' );
        $testAccounts = $ini->hasVariable( 'TestAccounts', 'Account' ) ? $ini->variable( 'TestAccounts', 'Account' ) : array();
        $accountResult = array();
        foreach( $testAccounts as $account )
        {
            $user = $ini->variable( 'TestAccounts', $account );
            $accountResult[ $user['index'] ] = $user;
        }
        return $accountResult;
    }

    public static function providerTestSendEmail()
    {
        $users = self::getTestAccounts();
        $endl = "\r\n";

        if ( empty( $users ) )
            return array( array( '', '' ) );

        /*
            Each entry in this array is an array consisting of two arrays.
            The first is the data that will be mailed.
            The second is the expected result. Since the result may be different for each recipient,
            this array is per recipient, using the email as array key.
        */
        return array(
            array( // Testing simple mail
                array( 'to' => array( $users['01'] ),
                       'replyTo' => null,
                       'sender' => $users['02'],
                       'cc' => null,
                       'bcc' => null,
                       'subject' => 'Luke',
                       'body' => 'Told you, I did. Reckless, is he. Now, matters are worse.'
                ),
                array(
                    $users['01']['email'] => array(
                        'messageCount' => 1,
                        'headers' => array( 'to' => array( array( 'email' => $users['01']['email'] ) ),
                                            'replyTo' => array( array( 'email' => $users['02']['email'],
                                                                       'name' => $users['02']['name'] ) ),
                                            'from' => array( array( 'email' => $users['02']['email'],
                                                                    'name' => $users['02']['name'] ) ),
                                            'subject' => 'Luke'
                        ),
                        'body' => 'Told you, I did. Reckless, is he. Now, matters are worse.' . $endl
                    )
                )
            ),
            array( // Testing multiple CC recipients
                array( 'to' => array( $users['01'] ),
                       'replyTo' => null,
                       'sender' => $users['02'],
                       'cc' => array( $users['03'], $users['04'] ),
                       'bcc' => null,
                       'subject' => 'Mos Eisley',
                       'body' => 'You will never find a more wretched hive of scum and villainy.'
                ),
                array(
                    $users['01']['email'] => array(
                        'messageCount' => 1,
                        'headers' => array( 'to' => array( array( 'email' => $users['01']['email'] ) ),
                                            'replyTo' => array( array( 'email' => $users['02']['email'],
                                                                       'name' => $users['02']['name'] ) ),
                                            'from' => array( array( 'email' => $users['02']['email'],
                                                                    'name' => $users['02']['name'] ) ),
                                            'cc' => array( array( 'email' => $users['03']['email'],
                                                                  'name' => $users['03']['name'] ),
                                                           array( 'email' => $users['04']['email'],
                                                                  'name' => $users['04']['name'] ) ),
                                            'subject' => 'Mos Eisley'
                        ),
                        'body' => 'You will never find a more wretched hive of scum and villainy.' . $endl
                    ),
                    $users['03']['email'] => array(
                        'messageCount' => 1,
                        'headers' => array( 'to' => array( array( 'email' => $users['01']['email'] ) ),
                                            'replyTo' => array( array( 'email' => $users['02']['email'],
                                                                       'name' => $users['02']['name'] ) ),
                                            'from' => array( array( 'email' => $users['02']['email'],
                                                                    'name' => $users['02']['name'] ) ),
                                            'cc' => array( array( 'email' => $users['03']['email'],
                                                                  'name' => $users['03']['name'] ),
                                                           array( 'email' => $users['04']['email'],
                                                                  'name' => $users['04']['name'] ) ),
                                            'subject' => 'Mos Eisley'
                        ),
                        'body' => 'You will never find a more wretched hive of scum and villainy.' . $endl
                    ),
                    $users['04']['email'] => array(
                        'messageCount' => 1,
                        'headers' => array( 'to' => array( array( 'email' => $users['01']['email'] ) ),
                                            'replyTo' => array( array( 'email' => $users['02']['email'],
                                                                       'name' => $users['02']['name'] ) ),
                                            'from' => array( array( 'email' => $users['02']['email'],
                                                                    'name' => $users['02']['name'] ) ),
                                            'cc' => array( array( 'email' => $users['03']['email'],
                                                                  'name' => $users['03']['name'] ),
                                                           array( 'email' => $users['04']['email'],
                                                                  'name' => $users['04']['name'] ) ),
                                            'subject' => 'Mos Eisley'
                        ),
                        'body' => 'You will never find a more wretched hive of scum and villainy.' . $endl
                    )
                )
            ),
            array( // Testing multiple BCC recipients
                array( 'to' => array( $users['01'] ),
                       'replyTo' => null,
                       'sender' => $users['01'],
                       'cc' => null,
                       'bcc' => array( $users['04'], $users['05'] ),
                       'subject' => 'Death Star',
                       'body' => 'Now witness the firepower of this fully armed and operational battle station!'
                ),
                array(
                    $users['01']['email'] => array(
                        'messageCount' => 1,
                        'headers' => array( 'to' => array( array( 'email' => $users['01']['email'] ) ),
                                            'replyTo' => array( array( 'email' => $users['01']['email'],
                                                                       'name' => $users['01']['name'] ) ),
                                            'from' => array( array( 'email' => $users['01']['email'],
                                                                    'name' => $users['01']['name'] ) ),
                                            'subject' => 'Death Star'
                        ),
                        'body' => 'Now witness the firepower of this fully armed and operational battle station!' . $endl
                    ),
                    $users['04']['email'] => array(
                        'messageCount' => 1,
                        'headers' => array( 'to' => array( array( 'email' => $users['01']['email'] ) ),
                                            'replyTo' => array( array( 'email' => $users['01']['email'],
                                                                       'name' => $users['01']['name'] ) ),
                                            'from' => array( array( 'email' => $users['01']['email'],
                                                                    'name' => $users['01']['name'] ) ),
                                            'subject' => 'Death Star'
                        ),
                        'body' => 'Now witness the firepower of this fully armed and operational battle station!' . $endl
                    ),
                    $users['05']['email'] => array(
                        'messageCount' => 1,
                        'headers' => array( 'to' => array( array( 'email' => $users['01']['email'] ) ),
                                            'replyTo' => array( array( 'email' => $users['01']['email'],
                                                                       'name' => $users['01']['name'] ) ),
                                            'from' => array( array( 'email' => $users['01']['email'],
                                                                    'name' => $users['01']['name'] ) ),
                                            'subject' => 'Death Star'
                        ),
                        'body' => 'Now witness the firepower of this fully armed and operational battle station!' . $endl
                    )
                )
            ),
            array( // Testing DebugSending = enabled with sendmail (cc and bcc headers must be stripped)
                array( 'to' => array( $users['02'], $users['03'] ),
                       'replyTo' => null,
                       'sender' => $users['01'],
                       'cc' => array( $users['04'] ),
                       'bcc' => array( $users['05'] ),
                       'subject' => 'That ancient religion',
                       'body' => 'I find your lack of faith disturbing.',
                       'DebugSending' => true
                ),
                array(
                    $users['01']['email'] => array(
                        'messageCount' => 1,
                        'headers' => array( 'to' => array( array( 'email' => $users['01']['email'] ) ),
                                            'replyTo' => array( array( 'email' => $users['01']['email'],
                                                                       'name' => $users['01']['name'] ) ),
                                            'from' => array( array( 'email' => $users['01']['email'],
                                                                    'name' => $users['01']['name'] ) ),
                                            'subject' => 'That ancient religion'
                        ),
                        'body' => 'I find your lack of faith disturbing.' . $endl
                    ),
                    $users['02']['email'] => array(
                        'messageCount' => 0
                    ),
                    $users['03']['email'] => array(
                        'messageCount' => 0
                    ),
                    $users['04']['email'] => array(
                        'messageCount' => 0
                    ),
                    $users['05']['email'] => array(
                        'messageCount' => 0
                    )
                )
            ),
            array( // Testing DebugSending = enabled with SMTP (cc is empty in debug mode)
                array( 'to' => array( $users['02'], $users['03'] ),
                       'replyTo' => null,
                       'sender' => $users['01'],
                       'cc' => array( $users['04'] ),
                       'bcc' => array( $users['05'] ),
                       'subject' => 'That ancient religion',
                       'body' => 'I find your lack of faith disturbing.',
                       'DebugSending' => true,
                       'Transport' => 'SMTP'
                ),
                array(
                    $users['01']['email'] => array(
                        'messageCount' => 1,
                        'headers' => array( 'to' => array( array( 'email' => $users['01']['email'] ) ),
                                            'replyTo' => array( array( 'email' => $users['01']['email'],
                                                                       'name' => $users['01']['name'] ) ),
                                            'from' => array( array( 'email' => $users['01']['email'],
                                                                    'name' => $users['01']['name'] ) ),
                                            'subject' => 'That ancient religion'
                        ),
                        'body' => 'I find your lack of faith disturbing.' . $endl
                    ),
                    $users['02']['email'] => array(
                        'messageCount' => 0
                    ),
                    $users['03']['email'] => array(
                        'messageCount' => 0
                    ),
                    $users['04']['email'] => array(
                        'messageCount' => 0
                    ),
                    $users['05']['email'] => array(
                        'messageCount' => 0
                    )
                )
            ),
            array( // Testing DebugSending = disabled with SMTP (cc headers are kept, bcc headers may be kept)
                array( 'to' => array( $users['02'], $users['03'] ),
                       'replyTo' => null,
                       'sender' => $users['01'],
                       'cc' => array( $users['04'] ),
                       'bcc' => array( $users['05'] ),
                       'subject' => 'That ancient religion',
                       'body' => 'I find your lack of faith disturbing.',
                       'DebugSending' => false,
                       'Transport' => 'SMTP'
                ),
                array(
                    $users['02']['email'] => array(
                        'messageCount' => 1,
                        'headers' => array( 'to' => array( array( 'email' => $users['02']['email'] ),
                                                           array( 'email' => $users['03']['email'] ) ),
                                            'replyTo' => array( array( 'email' => $users['01']['email'],
                                                                       'name' => $users['01']['name'] ) ),
                                            'from' => array( array( 'email' => $users['01']['email'],
                                                                    'name' => $users['01']['name'] ) ),
                                            'cc' => array( array( 'email' => $users['04']['email'],
                                                                  'name' => $users['04']['name'] ) ),
                                            'subject' => 'That ancient religion'
                        ),
                        'body' => 'I find your lack of faith disturbing.' . $endl
                    ),
                    $users['03']['email'] => array(
                        'messageCount' => 1,
                        'headers' => array( 'to' => array( array( 'email' => $users['02']['email'] ),
                                                           array( 'email' => $users['03']['email'] ) ),
                                            'replyTo' => array( array( 'email' => $users['01']['email'],
                                                                       'name' => $users['01']['name'] ) ),
                                            'from' => array( array( 'email' => $users['01']['email'],
                                                                    'name' => $users['01']['name'] ) ),
                                            'cc' => array( array( 'email' => $users['04']['email'],
                                                                  'name' => $users['04']['name'] ) ),
                                            'subject' => 'That ancient religion'
                        ),
                        'body' => 'I find your lack of faith disturbing.' . $endl
                    ),
                    $users['04']['email'] => array(
                        'messageCount' => 1,
                        'headers' => array( 'to' => array( array( 'email' => $users['02']['email'] ),
                                                           array( 'email' => $users['03']['email'] ) ),
                                            'replyTo' => array( array( 'email' => $users['01']['email'],
                                                                       'name' => $users['01']['name'] ) ),
                                            'from' => array( array( 'email' => $users['01']['email'],
                                                                    'name' => $users['01']['name'] ) ),
                                            'cc' => array( array( 'email' => $users['04']['email'],
                                                                  'name' => $users['04']['name'] ) ),
                                            'subject' => 'That ancient religion'
                        ),
                        'body' => 'I find your lack of faith disturbing.' . $endl
                    ),
                    $users['05']['email'] => array(
                        'messageCount' => 1,
                        'headers' => array( 'to' => array( array( 'email' => $users['02']['email'] ),
                                                           array( 'email' => $users['03']['email'] ) ),
                                            'replyTo' => array( array( 'email' => $users['01']['email'],
                                                                       'name' => $users['01']['name'] ) ),
                                            'from' => array( array( 'email' => $users['01']['email'],
                                                                    'name' => $users['01']['name'] ) ),
                                            'cc' => array( array( 'email' => $users['04']['email'],
                                                                  'name' => $users['04']['name'] ) ),
                                            'subject' => 'That ancient religion'
                        ),
                        'body' => 'I find your lack of faith disturbing.' . $endl
                    ),
                )
            )
        );
    }

    /**
     * @dataProvider providerTestValidate
     */
    public function testValidate( $email, $valid )
    {
        $this->assertEquals( $valid, eZMail::validate( $email ) );
    }

    /**
     * @dataProvider providerTestExtractEmail
     */
    public function testExtractEmail( $recipient, $name, $email )
    {
        eZMail::extractEmail( $recipient, $extractedEmail, $extractedName );
        self::assertEquals( $extractedEmail, $email );
        self::assertEquals( $extractedName, $name );
    }

    /**
     * @dataProvider providerTestStripEmail
     */
    public function testStripEmail( $text, $firstEmailAddress )
    {
    }

    /**
     * @dataProvider providerTestSendEmail
     */
    public function testSendEmail( $sendData, $expectedResult )
    {
        if( empty( $sendData ) )
        {
            $this->markTestSkipped( 'No $sendData from data provider.' );
        }
        if ( !self::imapIsEnabled() )
        {
            $this->markTestSkipped( 'IMAP is not loaded' );
            return;
        }

        $emailINI = eZINI::instance( 'test_ezmail_plain.ini' );
        $mboxString = $emailINI->variable( 'TestAccounts', 'MBoxString' );
        $recipients = array_merge( (array)$sendData['to'], (array)$sendData['cc'], (array)$sendData['bcc'] );

        if ( isset( $sendData['Transport'] ) and $sendData['Transport'] == 'SMTP' )
        {
            ezpINIHelper::setINISetting( 'site.ini', 'MailSettings', 'Transport', 'SMTP' );
            $mailINI = eZINI::instance( 'test_ezmail_plain.ini' );
            $mailSetting = $mailINI->group( 'MailSettings' );
            ezpINIHelper::setINISetting( 'site.ini', 'MailSettings', 'TransportServer', $mailSetting['TransportServer'] );
            ezpINIHelper::setINISetting( 'site.ini', 'MailSettings', 'TransportPort', $mailSetting['TransportPort'] );
            ezpINIHelper::setINISetting( 'site.ini', 'MailSettings', 'TransportUser', $mailSetting['TransportUser'] );
            ezpINIHelper::setINISetting( 'site.ini', 'MailSettings', 'TransportPassword', $mailSetting['TransportPassword'] );

        }

        if ( isset( $sendData['DebugSending'] ) and $sendData['DebugSending'] == true )
        {
            ezpINIHelper::setINISetting( 'site.ini', 'MailSettings', 'DebugSending', 'enabled' );
            $users = self::getTestAccounts();
            $recipients[] = $users['01'];
        }
        else
            ezpINIHelper::setINISetting( 'site.ini', 'MailSettings', 'DebugSending', 'disabled' );

        foreach ( $recipients as $recipient )
        {
            // Accept only testing accounts as recipients
            if ( preg_match( '/^ezp-unittests-\d\d\@mail\.ez\.no$/', $recipient['email'] ) != 1 )
            {
                $this->markTestSkipped( 'Refusing to use other than testing accounts' );
                return;
            }

            // Open mailbox and delete all existing emails in the account
            $mbox = @imap_open( $mboxString, $recipient['username'], $recipient['password'] );
            if ( !$mbox )
            {
                $this->markTestSkipped( 'Cannot open mailbox for ' . $recipient['username'] . ': ' . imap_last_error() );
                return;
            }

            $status = imap_status( $mbox, $mboxString, SA_MESSAGES );
            for ( $i = 1; $i <= $status->messages; $i++ )
            {
                imap_delete( $mbox, $i );
            }
            imap_expunge( $mbox );

            imap_close( $mbox );
        }

        // Create and send email
        $mail = new eZMail();

        if ( count( $sendData['to'] ) == 1 )
            $mail->setReceiver( $sendData['to'][0]['email'], $sendData['to'][0]['name'] );
        else
            $mail->setReceiverElements( $sendData['to'] );

        if ( $sendData['replyTo'] )
        {
            $mail->setReplyTo( $sendData['replyTo']['email'], $sendData['replyTo']['name'] );
        }

        $mail->setSender( $sendData['sender']['email'], $sendData['sender']['name'] );

        if ( $sendData['cc'] )
        {
            if ( count( $sendData['cc'] ) == 1 )
                $mail->addCc( $sendData['cc'][0]['email'], $sendData['cc'][0]['name'] );
            else
                $mail->setCcElements( $sendData['cc'] );
        }

        if ( $sendData['bcc'] )
        {
            if ( count( $sendData['bcc'] ) == 1 )
                $mail->addBcc( $sendData['bcc'][0]['email'], $sendData['bcc'][0]['name'] );
            else
                $mail->setBccElements( $sendData['bcc'] );
        }

        $mail->setSubject( $sendData['subject'] );
        $mail->setBody( $sendData['body'] );

        $sendResult = eZMailTransport::send( $mail );
        $this->assertEquals( true, $sendResult );

        // Wait for it...
        sleep( 2 );

        // Read emails
        foreach ( $recipients as $recipient )
        {
            $mbox = @imap_open( $mboxString, $recipient['username'], $recipient['password'] );
            if ( !$mbox )
            {
                $this->markTestSkipped( 'Cannot open mailbox for ' . $recipient['username'] . ': ' . imap_last_error() );
                return;
            }

            // Check message count before we try to open anything, in case nothing is there
            $status = imap_status( $mbox, $mboxString, SA_MESSAGES );
            $this->assertEquals( $expectedResult[ $recipient['email'] ]['messageCount'], $status->messages );

            // Build actual result array, and check against the expected result
            $actualResult = array( 'messageCount' => $status->messages );
            for ( $i = 1; $i <= $status->messages; $i++ )
            {
                $headers = imap_headerinfo( $mbox, $i );
                $actualResult['headers'] = array();

                $actualResult['headers']['to'] = array();
                foreach ( $headers->to as $item )
                {
                    $actualResult['headers']['to'][] = array( 'email' => $item->mailbox . '@' . $item->host );
                }

                $actualResult['headers']['replyTo'] = array();
                foreach ( $headers->reply_to as $item )
                {
                    $actualResult['headers']['replyTo'][] = array( 'email' => $item->mailbox . '@' . $item->host,
                                                                   'name' => $item->personal );
                }

                $actualResult['headers']['from'] = array();
                foreach ( $headers->from as $item )
                {
                    $actualResult['headers']['from'][] = array( 'email' => $item->mailbox . '@' . $item->host,
                                                                'name' => $item->personal );
                }

                if ( isset( $headers->cc ) )
                {
                    $actualResult['headers']['cc'] = array();
                    foreach ( $headers->cc as $item )
                    {
                        $actualResult['headers']['cc'][] = array( 'email' => $item->mailbox . '@' . $item->host,
                                                                  'name' => $item->personal );
                    }
                }

                $actualResult['headers']['subject'] = $headers->subject;

                $body = imap_body( $mbox, $i );
                $actualResult['body'] = $body;

                $this->assertEquals( $expectedResult[ $recipient['email'] ], $actualResult );
            }
            imap_close( $mbox );
        }
    }

    /**
     * See site.ini [MailSettings] ExcludeHeaders
     */
    public function testExcludeHaders()
    {
        self::markTestSkipped( "Tests needs to use other email addresses" );
        ezpINIHelper::setINISetting( 'site.ini', 'MailSettings', 'Transport', 'SMTP' );
        ezpINIHelper::setINISetting( 'site.ini', 'MailSettings', 'ExcludeHeaders', array( 'bcc' ) );

        $mail = new eZMail();
        $mail->setReceiver( 'johndoe@example.com', 'John Doe' );
        $mail->setSender( 'janedoe@example.com', 'Jane Doe' );
        $mail->addBcc( 'jimdoe@example.com', 'Jim Doe' );
        $mail->setSubject( 'Testing ExcludeHeaders' );
        $mail->setBody( 'Jim should not get this email.' );

        // BCC should be set at this point
        $this->assertTrue( strpos( $mail->Mail->generateHeaders(), 'Bcc: Jim Doe <jimdoe@example.com>' ) > 0 );

        // We don't care if the mail gets sent. What's important is what happens to the headers.
        eZMailTransport::send( $mail );

        // BCC should not be set anymore at this point, because of ExcludeHeaders
        $this->assertFalse( strpos( $mail->Mail->generateHeaders(), 'Bcc: Jim Doe <jimdoe@example.com>' ) > 0 );
    }

    public function testSSLSending()
    {
        // test SSL
        $ini = eZINI::instance( 'test_ezmail_ssl.ini' );
        $mailSetting = $ini->group( 'MailSettings' );
        //if SSL information is not set, skip this test
        if( !$mailSetting['TransportServer'] )
        {
            return;
        }
        $siteINI = eZINI::instance();
        $backupSetting = $siteINI->group( 'MailSettings' );
        $siteINI->setVariables( array( 'MailSettings' => $mailSetting ) );

        $mail = new eZMail();

        $mail->setReceiver( $mailSetting['TransportUser'], 'TEST RECEIVER' );
        $mail->setSender( $mailSetting['TransportUser'], 'TEST SENDER' );
        $mail->setSubject( 'SSL EMAIL TESTING' );
        $mail->setBody( 'This is a mail testing. TEST SSL in ' . __METHOD__ );
        $result = eZMailTransport::send( $mail );
        $this->assertTrue( $result );

        $siteINI->setVariables( array( 'MailSettings' => $backupSetting ) );

        //todo: delete the received mails in teardown.
    }
}

?>
