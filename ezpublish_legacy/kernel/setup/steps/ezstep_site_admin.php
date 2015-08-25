<?php
/**
 * File containing the eZStepSiteAdmin class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  \class eZStepSiteAdmin ezstep_site_admin.php
  \brief The class eZStepSiteAdmin does

*/

class eZStepSiteAdmin extends eZStepInstaller
{
    const PASSWORD_MISSMATCH = 1;
    const FIRST_NAME_MISSING = 2;
    const LAST_NAME_MISSING = 3;
    const EMAIL_MISSING = 4;
    const EMAIL_INVALID = 5;
    const PASSWORD_MISSING = 6;
    const PASSWORD_TOO_SHORT = 7;

    /*!
     Constructor
    */
    function eZStepSiteAdmin( $tpl, $http, $ini, &$persistenceList )
    {
        $this->eZStepInstaller( $tpl, $http, $ini, $persistenceList,
                                'site_admin', 'Site admin' );
    }

    function processPostData()
    {
        $user = array();

        $user['first_name'] = $this->Http->postVariable( 'eZSetup_site_templates_first_name' );
        $user['last_name'] = $this->Http->postVariable( 'eZSetup_site_templates_last_name' );
        $user['email'] = $this->Http->postVariable( 'eZSetup_site_templates_email' );
        if ( strlen( trim( $user['first_name'] ) ) == 0 )
        {
            $this->Error[] = self::FIRST_NAME_MISSING;
        }
        if ( strlen( trim( $user['last_name'] ) ) == 0 )
        {
            $this->Error[] = self::LAST_NAME_MISSING;
        }
        if ( strlen( trim( $user['email'] ) ) == 0 )
        {
            $this->Error[] = self::EMAIL_MISSING;
        }
        else if ( !eZMail::validate( trim( $user['email'] ) ) )
        {
            $this->Error[] = self::EMAIL_INVALID;
        }
        if ( strlen( trim( $this->Http->postVariable( 'eZSetup_site_templates_password1' ) ) ) == 0 )
        {
            $this->Error[] = self::PASSWORD_MISSING;
        }
        else if ( $this->Http->postVariable( 'eZSetup_site_templates_password1' ) != $this->Http->postVariable( 'eZSetup_site_templates_password2' ) )
        {
            $this->Error[] = self::PASSWORD_MISSMATCH;
        }
        else if ( !eZUser::validatePassword( trim( $this->Http->postVariable( 'eZSetup_site_templates_password1' ) ) ) )
        {
            $this->Error[] = self::PASSWORD_TOO_SHORT;
        }
        else
        {
            $user['password'] = $this->Http->postVariable( 'eZSetup_site_templates_password1' );
        }
        if ( !isset( $user['password'] ) )
            $user['password'] = '';
        $this->PersistenceList['admin'] = $user;

        return ( count( $this->Error ) == 0 );
    }

    function init()
    {
        $siteType = $this->chosenSiteType();
        if ( isset( $siteType['existing_database'] ) &&
             $siteType['existing_database'] == eZStepInstaller::DB_DATA_KEEP ) // Keep existing data in database, no need to reset admin user.
        {
            return true;
        }

        if ( $this->hasKickstartData() )
        {
            $data = $this->kickstartData();

            $adminUser = array( 'first_name' => 'Administrator',
                                'last_name' => 'User',
                                'email' => false,
                                'password' => false );

            if ( isset( $data['FirstName'] ) )
                $adminUser['first_name'] = $data['FirstName'];
            if ( isset( $data['LastName'] ) )
                $adminUser['last_name'] = $data['LastName'];
            if ( isset( $data['Email'] ) )
                $adminUser['email'] = $data['Email'];
            if ( isset( $data['Password'] ) )
                $adminUser['password'] = $data['Password'];

            $this->PersistenceList['admin'] = $adminUser;
            return $this->kickstartContinueNextStep();
        }

        // Set default values for admin user
        if ( !isset( $this->PersistenceList['admin'] ) )
        {
            $adminUser = array( 'first_name' => 'Administrator',
                                'last_name' => 'User',
                                'email' => false,
                                'password' => false );
            $this->PersistenceList['admin'] = $adminUser;
        }

        return false;
    }

    function display()
    {
        $this->Tpl->setVariable( 'first_name_missing', 0 );
        $this->Tpl->setVariable( 'last_name_missing', 0 );
        $this->Tpl->setVariable( 'email_missing', 0 );
        $this->Tpl->setVariable( 'email_invalid', 0 );
        $this->Tpl->setVariable( 'password_missmatch', 0 );
        $this->Tpl->setVariable( 'password_missing', 0 );
        $this->Tpl->setVariable( 'password_too_short', 0 );

        if ( isset( $this->Error[0] ) )
        {
            switch ( $this->Error[0] )
            {
                case self::FIRST_NAME_MISSING:
                {
                    $this->Tpl->setVariable( 'first_name_missing', 1 );
                } break;

                case self::LAST_NAME_MISSING:
                {
                    $this->Tpl->setVariable( 'last_name_missing', 1 );
                } break;

                case self::EMAIL_MISSING:
                {
                    $this->Tpl->setVariable( 'email_missing', 1 );
                } break;

                case self::EMAIL_INVALID:
                {
                    $this->Tpl->setVariable( 'email_invalid', 1 );
                } break;

                case self::PASSWORD_MISSMATCH:
                {
                    $this->Tpl->setVariable( 'password_missmatch', 1 );
                } break;

                case self::PASSWORD_MISSING:
                {
                    $this->Tpl->setVariable( 'password_missing', 1 );
                } break;

                case self::PASSWORD_TOO_SHORT:
                {
                    $this->Tpl->setVariable( 'password_too_short', 1 );
                } break;
            }
        }

        $this->Tpl->setVariable( 'has_errors', count( $this->Error ) > 0 );

        $adminUser = array( 'first_name' => false,
                            'last_name' => false,
                            'email' => false,
                            'password' => false );
        if ( isset( $this->PersistenceList['admin'] ) )
            $adminUser = $this->PersistenceList['admin'];

        $this->Tpl->setVariable( 'admin', $adminUser );

        // Return template and data to be shown
        $result = array();
        // Display template
        $result['content'] = $this->Tpl->fetch( 'design:setup/init/site_admin.tpl' );
        $result['path'] = array( array( 'text' => ezpI18n::tr( 'design/standard/setup/init',
                                                          'Site administrator' ),
                                        'url' => false ) );
        return $result;
    }

    public $Error = array();
}

?>
