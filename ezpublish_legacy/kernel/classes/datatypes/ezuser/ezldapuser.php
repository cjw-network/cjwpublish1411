<?php
/**
 * File containing the eZLDAPUser class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  \class eZLDAPUser ezldapuser.php
  \ingroup eZDatatype
  \brief The class eZLDAPUser does

*/
class eZLDAPUser extends eZUser
{
    /*!
     Constructor
    */
    function eZLDAPUser()
    {
    }

    /*!
    \static
     Logs in the user if applied username and password is
     valid. The userID is returned if succesful, false if not.
    */
    static function loginUser( $login, $password, $authenticationMatch = false )
    {
        $http = eZHTTPTool::instance();
        $db = eZDB::instance();

        if ( $authenticationMatch === false )
            $authenticationMatch = eZUser::authenticationMatch();

        $loginEscaped = $db->escapeString( $login );
        $passwordEscaped = $db->escapeString( $password );

        $loginLdapEscaped = self::ldap_escape( $login );

        $loginArray = array();
        if ( $authenticationMatch & eZUser::AUTHENTICATE_LOGIN )
            $loginArray[] = "login='$loginEscaped'";
        if ( $authenticationMatch & eZUser::AUTHENTICATE_EMAIL )
            $loginArray[] = "email='$loginEscaped'";
        if ( count( $loginArray ) == 0 )
            $loginArray[] = "login='$loginEscaped'";
        $loginText = implode( ' OR ', $loginArray );

        $contentObjectStatus = eZContentObject::STATUS_PUBLISHED;

        $ini = eZINI::instance();
        $LDAPIni = eZINI::instance( 'ldap.ini' );
        $databaseName = $db->databaseName();
        // if mysql
        if ( $databaseName === 'mysql' )
        {
            $query = "SELECT contentobject_id, password_hash, password_hash_type, email, login
                      FROM ezuser, ezcontentobject
                      WHERE ( $loginText ) AND
                            ezcontentobject.status='$contentObjectStatus' AND
                            ( ezcontentobject.id=contentobject_id OR ( password_hash_type=4 AND ( $loginText ) AND password_hash=PASSWORD('$passwordEscaped') ) )";
        }
        else
        {
            $query = "SELECT contentobject_id, password_hash, password_hash_type, email, login
                      FROM ezuser, ezcontentobject
                      WHERE ( $loginText ) AND
                            ezcontentobject.status='$contentObjectStatus' AND
                            ezcontentobject.id=contentobject_id";
        }

        $users = $db->arrayQuery( $query );
        $exists = false;
        if ( count( $users ) >= 1 )
        {
            foreach ( $users as $userRow )
            {
                $userID = $userRow['contentobject_id'];
                $hashType = $userRow['password_hash_type'];
                $hash = $userRow['password_hash'];
                $exists = eZUser::authenticateHash( $userRow['login'], $password, eZUser::site(),
                                                    $hashType,
                                                    $hash );

                // If hash type is MySql
                if ( $hashType == eZUser::PASSWORD_HASH_MYSQL and $databaseName === 'mysql' )
                {
                    $queryMysqlUser = "SELECT contentobject_id, password_hash, password_hash_type, email, login
                                       FROM ezuser, ezcontentobject
                                       WHERE ezcontentobject.status='$contentObjectStatus' AND
                                             password_hash_type=4 AND ( $loginText ) AND password_hash=PASSWORD('$passwordEscaped') ";
                    $mysqlUsers = $db->arrayQuery( $queryMysqlUser );
                    if ( count( $mysqlUsers ) >= 1 )
                        $exists = true;
                }

                eZDebugSetting::writeDebug( 'kernel-user', eZUser::createHash( $userRow['login'], $password, eZUser::site(),
                                                                               $hashType ), "check hash" );
                eZDebugSetting::writeDebug( 'kernel-user', $hash, "stored hash" );
                 // If current user has been disabled after a few failed login attempts.
                $canLogin = eZUser::isEnabledAfterFailedLogin( $userID );

                if ( $exists )
                {
                    // We should store userID for warning message.
                    $GLOBALS['eZFailedLoginAttemptUserID'] = $userID;

                    $userSetting = eZUserSetting::fetch( $userID );
                    $isEnabled = $userSetting->attribute( "is_enabled" );
                    if ( $hashType != eZUser::hashType() and
                         strtolower( $ini->variable( 'UserSettings', 'UpdateHash' ) ) == 'true' )
                    {
                        $hashType = eZUser::hashType();
                        $hash = eZUser::createHash( $login, $password, eZUser::site(),
                                                    $hashType );
                        $db->query( "UPDATE ezuser SET password_hash='$hash', password_hash_type='$hashType' WHERE contentobject_id='$userID'" );
                    }
                    break;
                }
            }
        }
        if ( $exists and $isEnabled and $canLogin )
        {
            eZDebugSetting::writeDebug( 'kernel-user', $userRow, 'user row' );
            $user = new eZUser( $userRow );
            eZDebugSetting::writeDebug( 'kernel-user', $user, 'user' );
            $userID = $user->attribute( 'contentobject_id' );

            eZUser::updateLastVisit( $userID );
            eZUser::setCurrentlyLoggedInUser( $user, $userID );

            // Reset number of failed login attempts
            eZUser::setFailedLoginAttempts( $userID, 0 );

            return $user;
        }
        else if ( $LDAPIni->variable( 'LDAPSettings', 'LDAPEnabled' ) === 'true' )
        {
            // read LDAP ini settings
            // and then try to bind to the ldap server

            $LDAPDebugTrace         = $LDAPIni->variable( 'LDAPSettings', 'LDAPDebugTrace' ) === 'enabled';
            $LDAPVersion            = $LDAPIni->variable( 'LDAPSettings', 'LDAPVersion' );
            $LDAPServer             = $LDAPIni->variable( 'LDAPSettings', 'LDAPServer' );
            $LDAPPort               = $LDAPIni->variable( 'LDAPSettings', 'LDAPPort' );
            $LDAPFollowReferrals    = (int) $LDAPIni->variable( 'LDAPSettings', 'LDAPFollowReferrals' );
            $LDAPBaseDN             = $LDAPIni->variable( 'LDAPSettings', 'LDAPBaseDn' );
            $LDAPBindUser           = $LDAPIni->variable( 'LDAPSettings', 'LDAPBindUser' );
            $LDAPBindPassword       = $LDAPIni->variable( 'LDAPSettings', 'LDAPBindPassword' );
            $LDAPSearchScope        = $LDAPIni->variable( 'LDAPSettings', 'LDAPSearchScope' );

            $LDAPLoginAttribute     = strtolower( $LDAPIni->variable( 'LDAPSettings', 'LDAPLoginAttribute' ) );
            $LDAPFirstNameAttribute = strtolower( $LDAPIni->variable( 'LDAPSettings', 'LDAPFirstNameAttribute' ) );
            $LDAPFirstNameIsCN      = $LDAPIni->variable( 'LDAPSettings', 'LDAPFirstNameIsCommonName' ) === 'true';
            $LDAPLastNameAttribute  = strtolower( $LDAPIni->variable( 'LDAPSettings', 'LDAPLastNameAttribute' ) );
            $LDAPEmailAttribute     = strtolower( $LDAPIni->variable( 'LDAPSettings', 'LDAPEmailAttribute' ) );

            $defaultUserPlacement   = $ini->variable( "UserSettings", "DefaultUserPlacement" );

            $LDAPUserGroupAttributeType = strtolower( $LDAPIni->variable( 'LDAPSettings', 'LDAPUserGroupAttributeType' ) );
            $LDAPUserGroupAttribute     = strtolower( $LDAPIni->variable( 'LDAPSettings', 'LDAPUserGroupAttribute' ) );

            if ( $LDAPIni->hasVariable( 'LDAPSettings', 'Utf8Encoding' ) )
            {
                $Utf8Encoding = $LDAPIni->variable( 'LDAPSettings', 'Utf8Encoding' );
                if ( $Utf8Encoding == "true" )
                    $isUtf8Encoding = true;
                else
                    $isUtf8Encoding = false;
            }
            else
            {
                $isUtf8Encoding = false;
            }

            if ( $LDAPIni->hasVariable( 'LDAPSettings', 'LDAPSearchFilters' ) )
            {
                $LDAPFilters = $LDAPIni->variable( 'LDAPSettings', 'LDAPSearchFilters' );
            }
            if ( $LDAPIni->hasVariable( 'LDAPSettings', 'LDAPUserGroupType' ) and  $LDAPIni->hasVariable( 'LDAPSettings', 'LDAPUserGroup' ) )
            {
                $LDAPUserGroupType = $LDAPIni->variable( 'LDAPSettings', 'LDAPUserGroupType' );
                $LDAPUserGroup = $LDAPIni->variable( 'LDAPSettings', 'LDAPUserGroup' );
            }

            $LDAPFilter = "( &";
            if ( count( $LDAPFilters ) > 0 )
            {
                foreach ( array_keys( $LDAPFilters ) as $key )
                {
                    $LDAPFilter .= "(" . $LDAPFilters[$key] . ")";
                }
            }
            $LDAPEqualSign = trim($LDAPIni->variable( 'LDAPSettings', "LDAPEqualSign" ) );
            $LDAPBaseDN    = str_replace( $LDAPEqualSign, "=", $LDAPBaseDN );
            $LDAPFilter    = str_replace( $LDAPEqualSign, "=", $LDAPFilter );
            $LDAPBindUser  = str_replace( $LDAPEqualSign, "=", $LDAPBindUser );

            if ( $LDAPDebugTrace )
            {
                $debugArray = array( 'stage' => '1/5: Connecting and Binding to LDAP server',
                                     'LDAPServer' => $LDAPServer,
                                     'LDAPPort' => $LDAPPort,
                                     'LDAPBindUser' => $LDAPBindUser,
                                     'LDAPVersion' => $LDAPVersion
                );
                // Set debug trace mode for ldap connections
                if ( function_exists( 'ldap_set_option' ) )
                    ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);
                eZDebug::writeNotice( var_export( $debugArray, true ), __METHOD__ );
            }

            if ( function_exists( 'ldap_connect' ) )
                $ds = ldap_connect( $LDAPServer, $LDAPPort );
            else
                $ds = false;

            if ( $ds )
            {
                ldap_set_option( $ds, LDAP_OPT_PROTOCOL_VERSION, $LDAPVersion );
                ldap_set_option( $ds, LDAP_OPT_REFERRALS, $LDAPFollowReferrals );
                if ( $LDAPBindUser == '' )
                {
                    $r = ldap_bind( $ds );
                }
                else
                {
                    $r = ldap_bind( $ds, $LDAPBindUser, $LDAPBindPassword );
                }
                if ( !$r )
                {
                    // Increase number of failed login attempts.
                    eZDebug::writeError( 'Cannot bind to LDAP server, might be something wronge with connetion or bind user!', __METHOD__ );
                    if ( isset( $userID ) )
                        eZUser::setFailedLoginAttempts( $userID );

                    $user = false;
                    return $user;
                }

                $LDAPFilter .= "($LDAPLoginAttribute=$loginLdapEscaped)";
                $LDAPFilter .= ")";

                ldap_set_option( $ds, LDAP_OPT_SIZELIMIT, 0 );
                ldap_set_option( $ds, LDAP_OPT_TIMELIMIT, 0 );

                $retrieveAttributes = array( $LDAPLoginAttribute,
                                             $LDAPFirstNameAttribute,
                                             $LDAPLastNameAttribute,
                                             $LDAPEmailAttribute );
                if ( $LDAPUserGroupAttributeType )
                    $retrieveAttributes[] = $LDAPUserGroupAttribute;

                if ( $LDAPDebugTrace )
                {
                    $debugArray = array( 'stage' => '2/5: finding user',
                                         'LDAPFilter' => $LDAPFilter,
                                         'retrieveAttributes' => $retrieveAttributes,
                                         'LDAPSearchScope' => $LDAPSearchScope,
                                         'LDAPBaseDN' => $LDAPBaseDN
                    );
                    eZDebug::writeNotice( var_export( $debugArray, true ), __METHOD__ );
                }

                if ( $LDAPSearchScope == "one" )
                    $sr = ldap_list( $ds, $LDAPBaseDN, $LDAPFilter, $retrieveAttributes );
                else if ( $LDAPSearchScope == "base" )
                    $sr = ldap_read( $ds, $LDAPBaseDN, $LDAPFilter, $retrieveAttributes );
                else
                    $sr = ldap_search( $ds, $LDAPBaseDN, $LDAPFilter, $retrieveAttributes );

                $info = ldap_get_entries( $ds, $sr ) ;
                if ( $info['count'] > 1 )
                {
                    // More than one user with same uid, not allow login.
                    eZDebug::writeWarning( 'More then one user with same uid, not allowed to login!', __METHOD__ );
                    $user = false;
                    return $user;
                }
                else if ( $info['count'] < 1 )
                {
                    // Increase number of failed login attempts.
                    if ( isset( $userID ) )
                        eZUser::setFailedLoginAttempts( $userID );

                    // user DN was not found
                    eZDebug::writeWarning( 'User DN was not found!', __METHOD__ );
                    $user = false;
                    return $user;
                }
                else if ( $LDAPDebugTrace )
                {
                    $debugArray = array( 'stage' => '3/5: real authentication of user',
                                         'info' => $info
                    );
                    eZDebug::writeNotice( var_export( $debugArray, true ), __METHOD__ );
                }

                if( !$password )
                {
                    $password = crypt( microtime() );
                }

                // is it real authenticated LDAP user?
                if  ( !@ldap_bind( $ds, $info[0]['dn'], $password ) )
                {
                    // Increase number of failed login attempts.
                    if ( isset( $userID ) )
                        eZUser::setFailedLoginAttempts( $userID );

                    eZDebug::writeWarning( "User $userID failed to login!", __METHOD__ );
                    $user = false;
                    return $user;
                }

                $extraNodeAssignments = array();
                $userGroupClassID = $ini->variable( "UserSettings", "UserGroupClassID" );

                // default user group assigning
                if ( $LDAPUserGroupType != null )
                {
                    if ( $LDAPUserGroupType == "name" )
                    {
                        if ( is_array( $LDAPUserGroup ) )
                        {
                            foreach ( array_keys( $LDAPUserGroup ) as $key )
                            {
                                $groupName = $db->escapeString( $LDAPUserGroup[$key] );
                                $groupQuery = "SELECT ezcontentobject_tree.node_id
                                                 FROM ezcontentobject, ezcontentobject_tree
                                                WHERE ezcontentobject.name like '$groupName'
                                                  AND ezcontentobject.id=ezcontentobject_tree.contentobject_id
                                                  AND ezcontentobject.contentclass_id=$userGroupClassID";
                                $groupObject = $db->arrayQuery( $groupQuery );
                                if ( count( $groupObject ) > 0 and $key == 0 )
                                {
                                    $defaultUserPlacement = $groupObject[0]['node_id'];
                                }
                                else if ( count( $groupObject ) > 0 )
                                {
                                    $extraNodeAssignments[] = $groupObject[0]['node_id'];
                                }
                            }
                        }
                        else
                        {
                            $groupName = $db->escapeString( $LDAPUserGroup );
                            $groupQuery = "SELECT ezcontentobject_tree.node_id
                                             FROM ezcontentobject, ezcontentobject_tree
                                            WHERE ezcontentobject.name like '$groupName'
                                              AND ezcontentobject.id=ezcontentobject_tree.contentobject_id
                                              AND ezcontentobject.contentclass_id=$userGroupClassID";
                            $groupObject = $db->arrayQuery( $groupQuery );

                            if ( count( $groupObject ) > 0  )
                            {
                                $defaultUserPlacement = $groupObject[0]['node_id'];
                            }
                        }
                    }
                    else if ( $LDAPUserGroupType == "id" )
                    {
                        if ( is_array( $LDAPUserGroup ) )
                        {
                            foreach ( array_keys( $LDAPUserGroup ) as $key )
                            {
                                $groupID = $LDAPUserGroup[$key];
                                $groupQuery = "SELECT ezcontentobject_tree.node_id
                                                 FROM ezcontentobject, ezcontentobject_tree
                                                WHERE ezcontentobject.id='$groupID'
                                                  AND ezcontentobject.id=ezcontentobject_tree.contentobject_id
                                                  AND ezcontentobject.contentclass_id=$userGroupClassID";
                                $groupObject = $db->arrayQuery( $groupQuery );
                                if ( count( $groupObject ) > 0 and $key == 0 )
                                {
                                    $defaultUserPlacement = $groupObject[0]['node_id'];
                                }
                                else if ( count( $groupObject ) > 0 )
                                {
                                    $extraNodeAssignments[] = $groupObject[0]['node_id'];
                                }
                            }
                        }
                        else
                        {
                            $groupID = $LDAPUserGroup;
                            $groupQuery = "SELECT ezcontentobject_tree.node_id
                                             FROM ezcontentobject, ezcontentobject_tree
                                            WHERE ezcontentobject.id='$groupID'
                                              AND ezcontentobject.id=ezcontentobject_tree.contentobject_id
                                              AND ezcontentobject.contentclass_id=$userGroupClassID";
                            $groupObject = $db->arrayQuery( $groupQuery );

                            if ( count( $groupObject ) > 0  )
                            {
                                $defaultUserPlacement = $groupObject[0]['node_id'];
                            }
                        }
                    }
                }

                // read group mapping LDAP settings
                $LDAPGroupMappingType = $LDAPIni->variable( 'LDAPSettings', 'LDAPGroupMappingType' );
                $LDAPUserGroupMap     = $LDAPIni->variable( 'LDAPSettings', 'LDAPUserGroupMap' );

                if ( !is_array( $LDAPUserGroupMap ) )
                    $LDAPUserGroupMap = array();

                // group mapping constants
                $ByMemberAttribute             = 'SimpleMapping'; // by group's member attributes (with mapping)
                $ByMemberAttributeHierarhicaly = 'GetGroupsTree'; // by group's member attributes hierarhically
                $ByGroupAttribute              = 'UseGroupAttribute'; // by user's group attribute (old style)
                $groupMappingTypes = array( $ByMemberAttribute,
                                            $ByMemberAttributeHierarhicaly,
                                            $ByGroupAttribute);

                $userData =& $info[ 0 ];

                // default mapping using old style
                if ( !in_array( $LDAPGroupMappingType, $groupMappingTypes ) )
                {
                    $LDAPGroupMappingType = $ByGroupAttribute;
                }

                if ( $LDAPDebugTrace )
                {
                    $debugArray = array( 'stage' => '4/5: group mapping init',
                                         'LDAPUserGroupType' => $LDAPUserGroupType,
                                         'LDAPGroupMappingType' => $LDAPGroupMappingType,
                                         'LDAPUserGroup' => $LDAPUserGroup,
                                         'defaultUserPlacement' => $defaultUserPlacement,
                                         'extraNodeAssignments' => $extraNodeAssignments
                    );
                    eZDebug::writeNotice( var_export( $debugArray, true ), __METHOD__ );
                }

                if ( $LDAPGroupMappingType == $ByMemberAttribute or
                     $LDAPGroupMappingType == $ByMemberAttributeHierarhicaly )
                {
                    $LDAPGroupBaseDN          = $LDAPIni->variable( 'LDAPSettings', 'LDAPGroupBaseDN' );
                    $LDAPGroupBaseDN          = str_replace( $LDAPEqualSign, '=', $LDAPGroupBaseDN );
                    $LDAPGroupClass           = $LDAPIni->variable( 'LDAPSettings', 'LDAPGroupClass' );

                    $LDAPGroupNameAttribute   = strtolower( $LDAPIni->variable( 'LDAPSettings', 'LDAPGroupNameAttribute' ) );
                    $LDAPGroupMemberAttribute = strtolower( $LDAPIni->variable( 'LDAPSettings', 'LDAPGroupMemberAttribute' ) );
                    $LDAPGroupDescriptionAttribute = strtolower( $LDAPIni->variable( 'LDAPSettings', 'LDAPGroupDescriptionAttribute' ) );

                    $groupSearchingDepth = ( $LDAPGroupMappingType == '1' ) ? 1 : 1000;

                    // now, get all parents for currently ldap authenticated user
                    $requiredParams = array();
                    $requiredParams[ 'LDAPLoginAttribute' ]       = $LDAPLoginAttribute;
                    $requiredParams[ 'LDAPGroupBaseDN' ]          = $LDAPGroupBaseDN;
                    $requiredParams[ 'LDAPGroupClass' ]           = $LDAPGroupClass;
                    $requiredParams[ 'LDAPGroupNameAttribute' ]   = $LDAPGroupNameAttribute;
                    $requiredParams[ 'LDAPGroupMemberAttribute' ] = $LDAPGroupMemberAttribute;
                    $requiredParams[ 'LDAPGroupDescriptionAttribute' ] = $LDAPGroupDescriptionAttribute;
                    $requiredParams[ 'ds' ] =& $ds;
                    if ( $LDAPIni->variable( 'LDAPSettings', 'LDAPGroupRootNodeId' ) !== '' )
                        $requiredParams[ 'TopUserGroupNodeID' ] = $LDAPIni->variable( 'LDAPSettings', 'LDAPGroupRootNodeId' );
                    else
                        $requiredParams[ 'TopUserGroupNodeID' ] = 5;

                    $groupsTree = array();
                    $stack = array();
                    $newfilter = '(&(objectClass=' . $LDAPGroupClass . ')(' . $LDAPGroupMemberAttribute . '=' . $userData['dn'] . '))';

                    $groupsTree[ $userData['dn'] ] = array( 'data' => & $userData,
                                                                'parents' => array(),
                                                                'children' => array() );

                    eZLDAPUser::getUserGroupsTree( $requiredParams, $newfilter, $userData['dn'], $groupsTree, $stack, $groupSearchingDepth );
                    $userRecord =& $groupsTree[ $userData['dn'] ];

                    if ( $LDAPGroupMappingType == $ByMemberAttribute )
                    {
                        if ( count( $userRecord[ 'parents' ] ) > 0 )
                        {
                            $remappedGroupNames = array();
                            foreach ( array_keys( $userRecord[ 'parents' ] ) as $key )
                            {
                                $parentGroup =& $userRecord[ 'parents' ][ $key ];
                                if ( isset( $parentGroup[ 'data' ][ $LDAPGroupNameAttribute ] ) )
                                {
                                    $ldapGroupName = $parentGroup[ 'data' ][ $LDAPGroupNameAttribute ];
                                    if ( is_array( $ldapGroupName ) )
                                    {
                                        $ldapGroupName = ( $ldapGroupName[ 'count' ] > 0 ) ? $ldapGroupName[ 0 ] : '';
                                    }

                                    // remap group name and check that group exists
                                    if ( array_key_exists( $ldapGroupName, $LDAPUserGroupMap ) )
                                    {
                                        $remmapedGroupName = $db->escapeString( $LDAPUserGroupMap[ $ldapGroupName ] );
                                        $groupQuery = "SELECT ezcontentobject_tree.node_id
                                                         FROM ezcontentobject, ezcontentobject_tree
                                                        WHERE ezcontentobject.name like '$remmapedGroupName'
                                                          AND ezcontentobject.id=ezcontentobject_tree.contentobject_id
                                                          AND ezcontentobject.contentclass_id=$userGroupClassID";
                                        $groupRow = $db->arrayQuery( $groupQuery );

                                        if ( count( $groupRow ) > 0 )
                                        {
                                            $userRecord['new_parents'][] = $groupRow[ 0 ][ 'node_id' ];
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else if ( $LDAPGroupMappingType == $ByMemberAttributeHierarhicaly )
                    {
                        $stack = array();
                        self::goAndPublishGroups( $requiredParams, $userData['dn'], $groupsTree, $stack, $groupSearchingDepth, true );
                    }
                    if ( isset( $userRecord['new_parents'] ) and
                         count( $userRecord['new_parents'] ) > 0 )
                    {
                        $defaultUserPlacement = $userRecord['new_parents'][0];
                        $extraNodeAssignments = array_merge( $extraNodeAssignments, $userRecord['new_parents'] );
                    }
                }
                else if ( $LDAPGroupMappingType == $ByGroupAttribute ) // old style mapping by group (employeetype) attribute
                {
                    if ( $LDAPUserGroupAttributeType )
                    {
                        // Should we create user groups that are specified in LDAP, but not found in eZ Publish?
                        $createMissingGroups = ( $LDAPIni->variable( 'LDAPSettings', 'LDAPCreateMissingGroups' ) === 'enabled' );
                        if ( $LDAPIni->variable( 'LDAPSettings', 'LDAPGroupRootNodeId' ) !== '' )
                            $parentNodeID = $LDAPIni->variable( 'LDAPSettings', 'LDAPGroupRootNodeId' );
                        else
                            $parentNodeID = 5;

                        $groupAttributeCount = $info[0][$LDAPUserGroupAttribute]['count'];
                        if ( $LDAPUserGroupAttributeType == "name" )
                        {
                            for ( $i = 0; $i < $groupAttributeCount; $i++ )
                            {
                                if ( $isUtf8Encoding )
                                {
                                    $groupName = utf8_decode( $info[0][$LDAPUserGroupAttribute][$i] );
                                }
                                else
                                {
                                    $groupName = $info[0][$LDAPUserGroupAttribute][$i];
                                }

                                // Save group node id to either defaultUserPlacement or extraNodeAssignments
                                self::getNodeAssignmentsForGroupName( $groupName, ($i == 0), $defaultUserPlacement, $extraNodeAssignments,
                                                                      $createMissingGroups, $parentNodeID );
                            }
                        }
                        else if ( $LDAPUserGroupAttributeType == "id" )
                        {
                            for ( $i = 0; $i < $groupAttributeCount; $i++ )
                            {
                                if ( $isUtf8Encoding )
                                {
                                    $groupID = utf8_decode( $info[0][$LDAPUserGroupAttribute][$i] );
                                }
                                else
                                {
                                    $groupID = $info[0][$LDAPUserGroupAttribute][$i];
                                }
                                $groupName = "LDAP $groupID";

                                // Save group node id to either defaultUserPlacement or extraNodeAssignments
                                self::getNodeAssignmentsForGroupName( $groupName, ($i == 0), $defaultUserPlacement, $extraNodeAssignments,
                                                                      $createMissingGroups, $parentNodeID );
                            }
                        }
                        else if ( $LDAPUserGroupAttributeType == "dn" )
                        {
                            for ( $i = 0; $i < $groupAttributeCount; $i++ )
                            {
                                $groupDN = $info[0][$LDAPUserGroupAttribute][$i];
                                $groupName = self::getGroupNameByDN( $ds, $groupDN );

                                if ( $groupName )
                                {
                                    // Save group node id to either defaultUserPlacement or extraNodeAssignments
                                    self::getNodeAssignmentsForGroupName( $groupName, ($i == 0), $defaultUserPlacement, $extraNodeAssignments,
                                                                          $createMissingGroups, $parentNodeID );
                                }
                            }
                        }
                        else
                        {
                            eZDebug::writeError( "Bad LDAPUserGroupAttributeType '$LDAPUserGroupAttributeType'. It must be either 'name', 'id' or 'dn'.", __METHOD__ );
                            $user = false;
                            return $user;
                        }
                    }
                }

                // remove ' last_name' from first_name if cn is used for first name
                if ( $LDAPFirstNameIsCN && isset( $userData[ $LDAPFirstNameAttribute ] ) && isset( $userData[ $LDAPLastNameAttribute ] ) )
                {
                    $userData[ $LDAPFirstNameAttribute ][0] = str_replace( ' ' . $userData[ $LDAPLastNameAttribute ][0], '', $userData[ $LDAPFirstNameAttribute ][0] );
                }

                if ( isset( $userData[ $LDAPEmailAttribute ] ) )
                    $LDAPuserEmail = $userData[ $LDAPEmailAttribute ][0];
                else if( trim( $LDAPIni->variable( 'LDAPSettings', 'LDAPEmailEmptyAttributeSuffix' ) ) )
                    $LDAPuserEmail = $login . $LDAPIni->variable( 'LDAPSettings', 'LDAPEmailEmptyAttributeSuffix' );
                else
                    $LDAPuserEmail = false;


                $userAttributes = array( 'login'      => $login,
                                         'first_name' => isset( $userData[ $LDAPFirstNameAttribute ] ) ? $userData[ $LDAPFirstNameAttribute ][0] : false,
                                         'last_name'  => isset( $userData[ $LDAPLastNameAttribute ] ) ? $userData[ $LDAPLastNameAttribute ][0] : false,
                                         'email'      => $LDAPuserEmail );

                if ( $LDAPDebugTrace )
                {
                    $debugArray = array( 'stage' => '5/5: storing user',
                                         'userAttributes' => $userAttributes,
                                         'isUtf8Encoding' => $isUtf8Encoding,
                                         'defaultUserPlacement' => $defaultUserPlacement,
                                         'extraNodeAssignments' => $extraNodeAssignments
                    );
                    eZDebug::writeNotice( var_export( $debugArray, true ), __METHOD__ );
                }

                $oldUser = clone eZUser::currentUser();
                $existingUser = eZLDAPUser::publishUpdateUser( $extraNodeAssignments, $defaultUserPlacement, $userAttributes, $isUtf8Encoding );

                if ( is_object( $existingUser ) )
                {
                    eZUser::setCurrentlyLoggedInUser( $existingUser, $existingUser->attribute( 'contentobject_id' ) );
                }
                else
                {
                    eZUser::setCurrentlyLoggedInUser( $oldUser, $oldUser->attribute( 'contentobject_id' ) );
                }

                ldap_close( $ds );
                return $existingUser;
            }
            else
            {
                eZDebug::writeError( 'Cannot initialize connection for LDAP server', __METHOD__ );
                $user = false;
                return $user;
            }
        }
        else
        {
            // Increase number of failed login attempts.
            if ( isset( $userID ) )
                eZUser::setFailedLoginAttempts( $userID );

            eZDebug::writeWarning( 'User does not exist or LDAP is not enabled in php', __METHOD__ );
            $user = false;
            return $user;
        }
    }

    /*
        Static method, for internal usage only.
        Publishes new or update existing user
    */
    static function publishUpdateUser( $parentNodeIDs, $defaultUserPlacement, $userAttributes, $isUtf8Encoding = false )
    {
        if ( !is_array( $userAttributes ) or
             !isset( $userAttributes[ 'login' ] ) or empty( $userAttributes[ 'login' ] ) )
        {
            eZDebug::writeWarning( 'Empty user login passed.', __METHOD__ );
            return false;
        }

        if ( ( !is_array( $parentNodeIDs ) or count( $parentNodeIDs ) < 1 ) and
             !is_numeric( $defaultUserPlacement ) )
        {
            eZDebug::writeWarning( 'No one parent node IDs was passed for publishing new user (login = "' .
                                   $userAttributes[ 'login' ] . '")',
                                   __METHOD__ );
            return false;
        }
        $parentNodeIDs[] = $defaultUserPlacement;
        $parentNodeIDs = array_unique( $parentNodeIDs );


        $login      = $userAttributes[ 'login' ];
        $first_name = $userAttributes[ 'first_name' ];
        $last_name  = $userAttributes[ 'last_name' ];
        $email      = $userAttributes[ 'email' ];

        if ( $isUtf8Encoding )
        {
            $first_name = utf8_decode( $first_name );
            $last_name = utf8_decode( $last_name );
        }

        $user = eZUser::fetchByName( $login );
        $createNewUser = ( is_object( $user ) ) ? false : true;

        if ( $createNewUser )
        {
            if ( !isset( $first_name ) or empty( $first_name ) or
                 !isset( $last_name ) or empty( $last_name ) or
                 !isset( $email ) or empty( $email ) )
            {
                eZDebug::writeWarning( 'Cannot create user with empty first name (last name or email).', __METHOD__ );
                return false;
            }

            $ini = eZINI::instance();
            $userClassID = $ini->variable( "UserSettings", "UserClassID" );
            $userCreatorID = $ini->variable( "UserSettings", "UserCreatorID" );
            $defaultSectionID = $ini->variable( "UserSettings", "DefaultSectionID" );

            $class = eZContentClass::fetch( $userClassID );
            $contentObject = $class->instantiate( $userCreatorID, $defaultSectionID );

            $contentObject->store();

            $userID = $contentObjectID = $contentObject->attribute( 'id' );

            $version = $contentObject->version( 1 );
            $version->setAttribute( 'modified', time() );
            $version->setAttribute( 'status', eZContentObjectVersion::STATUS_DRAFT );
            $version->store();

            $user = eZLDAPUser::create( $userID );
            $user->setAttribute( 'login', $login );
        }
        else
        {
            $userID = $contentObjectID = $user->attribute( 'contentobject_id' );
            $contentObject = eZContentObject::fetch( $userID );
            $version = $contentObject->attribute( 'current' );
        }

        //================= common part 1: start ========================
        $contentObjectAttributes = $version->contentObjectAttributes();

        // find and set 'name' and 'description' attributes (as standard user group class)
        $firstNameIdentifier = 'first_name';
        $lastNameIdentifier = 'last_name';
        $firstNameAttribute = null;
        $lastNameAttribute = null;

        foreach ( $contentObjectAttributes as $attribute )
        {
            if ( $attribute->attribute( 'contentclass_attribute_identifier' ) == $firstNameIdentifier )
            {
                $firstNameAttribute = $attribute;
            }
            else if ( $attribute->attribute( 'contentclass_attribute_identifier' ) == $lastNameIdentifier )
            {
                $lastNameAttribute = $attribute;
            }
        }
        //================= common part 1: end ==========================

        // If we are updating an existing user, we must find out if some data should be changed.
        // In that case, we must create a new version and publish it.
        if ( !$createNewUser )
        {
            $userDataChanged = false;
            $firstNameChanged = false;
            $lastNameChanged = false;
            $emailChanged = false;

            if ( $firstNameAttribute and $firstNameAttribute->attribute( 'data_text' ) != $first_name )
            {
                $firstNameChanged = true;
            }
            $firstNameAttribute = false; // We will load this again from the new version we will create, if it has changed
            if ( $lastNameAttribute and $lastNameAttribute->attribute( 'data_text' ) != $last_name )
            {
                $lastNameChanged = true;
            }
            $lastNameAttribute = false; // We will load this again from the new version we will create, if it has changed
            if ( $user->attribute( 'email' ) != $email )
            {
                $emailChanged = true;
            }

            if ( $firstNameChanged or $lastNameChanged or $emailChanged )
            {
                $userDataChanged = true;
                // Create new version
                $version = $contentObject->createNewVersion();
                $contentObjectAttributes = $version->contentObjectAttributes();
                foreach ( $contentObjectAttributes as $attribute )
                {
                    if ( $attribute->attribute( 'contentclass_attribute_identifier' ) == $firstNameIdentifier )
                    {
                        $firstNameAttribute = $attribute;
                    }
                    else if ( $attribute->attribute( 'contentclass_attribute_identifier' ) == $lastNameIdentifier )
                    {
                        $lastNameAttribute = $attribute;
                    }
                }
            }
        }

        //================= common part 2: start ========================
        if ( $firstNameAttribute )
        {
            $firstNameAttribute->setAttribute( 'data_text', $first_name );
            $firstNameAttribute->store();
        }
        if ( $lastNameAttribute )
        {
            $lastNameAttribute->setAttribute( 'data_text', $last_name );
            $lastNameAttribute->store();
        }

        if ( !isset( $userDataChanged ) or $userDataChanged === true )
        {
            $contentClass = $contentObject->attribute( 'content_class' );
            $name = $contentClass->contentObjectName( $contentObject );
            $contentObject->setName( $name );
        }

        if ( !isset( $emailChanged ) or $emailChanged === true )
        {
            $user->setAttribute( 'email', $email );
        }

        $user->setAttribute( 'password_hash', "" );
        $user->setAttribute( 'password_hash_type', 0 );
        $user->store();

        $debugArray = array( 'Updating user data',
                             'createNewUser' => $createNewUser,
                             'userDataChanged' => isset( $userDataChanged ) ? $userDataChanged : null,
                             'login' => $login,
                             'first_name' => $first_name,
                             'last_name' => $last_name,
                             'email' => $email,
                             'firstNameAttribute is_object' => is_object( $firstNameAttribute ),
                             'lastNameAttribute is_object' => is_object( $lastNameAttribute ),
                             'content object id' => $contentObjectID,
                             'version id' => $version->attribute( 'version' )
        );
        eZDebug::writeNotice( var_export( $debugArray, true ), __METHOD__ );
        //================= common part 2: end ==========================

        if ( $createNewUser )
        {
            reset( $parentNodeIDs );
            // prepare node assignments for publishing new user
            foreach( $parentNodeIDs as $parentNodeID )
            {
                $newNodeAssignment = eZNodeAssignment::create( array( 'contentobject_id' => $contentObjectID,
                                                                      'contentobject_version' => 1,
                                                                      'parent_node' => $parentNodeID,
                                                                      // parent_remote_id in node assignment holds remote id of the tree node,
                                                                      // not of the parent location or of the node assignment itself
                                                                      'parent_remote_id' => uniqid( 'LDAP_' ),
                                                                      'is_main' => ( $defaultUserPlacement == $parentNodeID ? 1 : 0 ) ) );
                $newNodeAssignment->store();
            }

            $operationResult = eZOperationHandler::execute( 'content', 'publish', array( 'object_id' => $contentObjectID,
                                                                                         'version' => 1 ) );
        }
        else
        {
            if ( $userDataChanged )
            {
                // Publish object
                $operationResult = eZOperationHandler::execute( 'content', 'publish', array( 'object_id' => $contentObjectID,
                                                                                             'version' => $version->attribute( 'version' ) ) );
                // Refetch object
                $contentObject = eZContentObject::fetch( $contentObjectID );
                $version = $contentObject->attribute( 'current' );
            }

            $LDAPIni = eZINI::instance( 'ldap.ini' );
            $keepGroupAssignment = ( $LDAPIni->hasVariable( 'LDAPSettings', 'KeepGroupAssignment' ) ) ?
                ( $LDAPIni->variable( 'LDAPSettings', 'KeepGroupAssignment' ) == "enabled" ) : false;

            if ( $keepGroupAssignment == false )
            {
                $objectIsChanged = false;

                $db = eZDB::instance();
                $db->begin();

                // First check existing assignments, remove any that should not exist
                $assignedNodesList = $contentObject->assignedNodes();
                $existingParentNodeIDs = array();
                foreach ( $assignedNodesList as $node )
                {
                    $parentNodeID = $node->attribute( 'parent_node_id' );
                    if ( !in_array( $parentNodeID, $parentNodeIDs ) )
                    {
                        $node->removeThis();
                        $objectIsChanged = true;
                    }
                    else
                    {
                        $existingParentNodeIDs[] = $parentNodeID;
                    }
                }

                // Then check assignments that should exist, add them if they are missing
                foreach( $parentNodeIDs as $parentNodeID )
                {
                    if ( !in_array( $parentNodeID, $existingParentNodeIDs ) )
                    {
                        $newNode = $contentObject->addLocation( $parentNodeID, true );
                        $newNode->updateSubTreePath();
                        $newNode->setAttribute( 'contentobject_is_published', 1 );
                        $newNode->sync();
                        $existingParentNodeIDs[] = $parentNodeID;
                        $objectIsChanged = true;
                    }
                }

                // Then ensure that the main node is correct
                $currentMainParentNodeID = $contentObject->attribute( 'main_parent_node_id' );
                if ( $currentMainParentNodeID != $defaultUserPlacement )
                {
                    $existingNode = eZContentObjectTreeNode::fetchNode( $contentObjectID, $defaultUserPlacement );
                    if ( !is_object( $existingNode ) )
                    {
                        eZDebug::writeError( "Cannot find assigned node as $defaultUserPlacement's child.", __METHOD__ );
                    }
                    else
                    {
                        $existingNodeID = $existingNode->attribute( 'node_id' );
                        $versionNum = $version->attribute( 'version' );
                        eZContentObjectTreeNode::updateMainNodeID( $existingNodeID, $contentObjectID, $versionNum, $defaultUserPlacement );
                        $objectIsChanged = true;
                    }
                }

                $db->commit();

                // Finally, clear object view cache if something was changed
                if ( $objectIsChanged )
                {
                    eZContentCacheManager::clearObjectViewCache( $contentObjectID, true );
                }
            }
        }

        eZUser::updateLastVisit( $userID );
        //eZUser::setCurrentlyLoggedInUser( $user, $userID );
        // Reset number of failed login attempts
        eZUser::setFailedLoginAttempts( $userID, 0 );
        return $user;
    }

    /*
        Static method, for internal usage only.
        Note: used user group class (see 'UserGroupClassID' ini setting, in 'UserSettings' section)
              must have name attribute with indentifier equal 'name'
    */
    static function publishNewUserGroup( $parentNodeIDs, $newGroupAttributes, $isUtf8Encoding = false )
    {
        $newNodeIDs = array();

        if ( !is_array( $newGroupAttributes ) or
             !isset( $newGroupAttributes[ 'name' ] ) or
             empty( $newGroupAttributes[ 'name' ] ) )
        {
            eZDebug::writeWarning( 'Cannot create user group with empty name.', __METHOD__ );
            return $newNodeIDs;
        }
        if ( !is_array( $parentNodeIDs ) or count( $parentNodeIDs ) < 1 )
        {
            eZDebug::writeWarning( 'No one parent node IDs was passed for publishing new group (group name = "' .
                                   $newGroupAttributes[ 'name' ] . '")',
                                   __METHOD__ );
            return $newNodeIDs;
        }

        $ini = eZINI::instance();
        $userGroupClassID = $ini->variable( "UserSettings", "UserGroupClassID" );
        $userCreatorID = $ini->variable( "UserSettings", "UserCreatorID" );
        $defaultSectionID = $ini->variable( "UserSettings", "DefaultSectionID" );

        $userGroupClass = eZContentClass::fetch( $userGroupClassID );
        $contentObject = $userGroupClass->instantiate( $userCreatorID, $defaultSectionID );

        $contentObject->store();

        $contentObjectID = $contentObject->attribute( 'id' );

        reset( $parentNodeIDs );
        $defaultPlacement = current( $parentNodeIDs );
        array_shift( $parentNodeIDs );

        $nodeAssignment = eZNodeAssignment::create( array( 'contentobject_id' => $contentObjectID,
                                                           'contentobject_version' => 1,
                                                           'parent_node' => $defaultPlacement,
                                                           // parent_remote_id in node assignment holds remote id of the tree node,
                                                           // not of the parent location or of the node assignment itself
                                                           'parent_remote_id' => uniqid( 'LDAP_' ),
                                                           'is_main' => 1 ) );
        $nodeAssignment->store();

        foreach( $parentNodeIDs as $parentNodeID )
        {
            $newNodeAssignment = eZNodeAssignment::create( array( 'contentobject_id' => $contentObjectID,
                                                                  'contentobject_version' => 1,
                                                                  'parent_node' => $parentNodeID,
                                                                  // parent_remote_id in node assignment holds remote id of the tree node,
                                                                  // not of the parent location or of the node assignment itself
                                                                  'parent_remote_id' => uniqid( 'LDAP_' ),
                                                                  'is_main' => 0 ) );
            $newNodeAssignment->store();
        }

        $version = $contentObject->version( 1 );
        $version->setAttribute( 'modified', time() );
        $version->setAttribute( 'status', eZContentObjectVersion::STATUS_DRAFT );
        $version->store();

        $contentObjectAttributes = $version->contentObjectAttributes();

        // find ant set 'name' and 'description' attributes (as standard user group class)
        $nameIdentifier = 'name';
        $descIdentifier = 'description';
        $nameContentAttribute = null;
        $descContentAttribute = null;
        foreach( $contentObjectAttributes as $attribute )
        {
            if ( $attribute->attribute( 'contentclass_attribute_identifier' ) == $nameIdentifier )
            {
                $nameContentAttribute = $attribute;
            }
            else if ( $attribute->attribute( 'contentclass_attribute_identifier' ) == $descIdentifier )
            {
                $descContentAttribute = $attribute;
            }
        }
        if ( $nameContentAttribute )
        {
            if ( $isUtf8Encoding )
                $newGroupAttributes[ 'name' ] = utf8_decode( $newGroupAttributes[ 'name' ] );
            $nameContentAttribute->setAttribute( 'data_text', $newGroupAttributes[ 'name' ] );
            $nameContentAttribute->store();
        }
        if ( $descContentAttribute and
             isset( $newGroupAttributes[ 'description' ] ) )
        {
            if ( $isUtf8Encoding )
                $newGroupAttributes[ 'description' ] = utf8_decode( $newGroupAttributes[ 'description' ] );
            $descContentAttribute->setAttribute( 'data_text', $newGroupAttributes[ 'description' ] );
            $descContentAttribute->store();
        }

        $operationResult = eZOperationHandler::execute( 'content', 'publish', array( 'object_id' => $contentObjectID,
                                                                                     'version' => 1 ) );
        $newNodes = eZContentObjectTreeNode::fetchByContentObjectID( $contentObjectID, true, 1 );
        foreach ( $newNodes as $newNode )
        {
            $newNodeIDs[] = $newNode->attribute( 'node_id' );
        }

        return $newNodeIDs;
    }

    /*
        Static method, for internal usage only.
        Recursive, publishes groups by prepared tree of groups returned by getUserGroupsTree() method
    */
    static function goAndPublishGroups( &$requiredParams,
                                 $curDN,
                                 &$groupsTree,
                                 &$stack,
                                 $depth,
                                 $isUser = false )
    {
        if ( !isset( $groupsTree[ $curDN ] ) )
        {
            eZDebug::writeError( 'Passed $curDN is not in result tree array.', __METHOD__ );
            return false;
        }

        array_push( $stack, $curDN );
        $current =& $groupsTree[ $curDN ];

        // check the name
        if ( $isUser )
        {
            $currentName = $current[ 'data' ][ $requiredParams[ 'LDAPLoginAttribute' ] ];
        }
        else
        {
            $currentName = $current[ 'data' ][ $requiredParams[ 'LDAPGroupNameAttribute' ] ];
        }

        if ( is_array( $currentName ) and //count( $currentName ) > 1 and
             isset( $currentName[ 'count' ] ) and $currentName[ 'count' ] > 0 )
        {
            $currentName = $currentName[ 0 ];
        }

        if ( empty( $currentName ) )
        {
            eZDebug::writeWarning( "Cannot create/use group with empty name (dn = $curDN)", __METHOD__ );
            return false;
        }

        // go through parents
        if ( is_array( $current['parents'] ) and count( $current['parents'] ) > 0 )
        {
            foreach( array_keys( $current['parents'] ) as $key )
            {
                $parent =& $groupsTree[ $key ];

                if ( in_array( $parent['data']['dn'], $stack ) )
                {
                    $groupsTree[ '_recursion_detected_' ] = true;
                    eZDebug::writeError( 'Recursion is detected in the user-groups tree while getting parent groups for ' . $curDN, __METHOD__ );
                    return false;
                }
                if ( isset( $parent[ 'nodes' ] ) and count( $parent[ 'nodes' ] ) > 0 )
                {
                    continue;
                }
                $ret = self::goAndPublishGroups( $requiredParams,
                                                 $parent['data']['dn'],
                                                 $groupsTree,
                                                 $stack,
                                                 $depth - 1 );
                if ( isset( $groupsTree[ '_recursion_detected_' ] ) and $groupsTree[ '_recursion_detected_' ] )
                {
                    return false;
                }
            }
        }
        else
        {
            // We've reached a top node
            if ( !isset( $groupsTree[ 'root' ] ) )
            {
                $groupsTree[ 'root' ] = array( 'data' => null,
                                               'parents' => null,
                                               'children' => array(),
                                               'nodes' => array( $requiredParams[ 'TopUserGroupNodeID' ] ) );
            }
            if ( !isset( $groupsTree[ 'root' ][ 'children' ][ $curDN ] ) )
                $groupsTree[ 'root' ][ 'children' ][ $curDN ] =& $current;
            if ( !isset( $current[ 'parents' ][ 'root' ] ) )
                $current[ 'parents' ][ 'root' ] =& $groupsTree[ 'root' ];
        }

        if ( !isset( $current[ 'nodes' ] ) )
            $current[ 'nodes' ] = array();

        $parentNodesForNew = array();
        foreach( array_keys( $current[ 'parents' ] ) as $key )
        {
            $parent =& $groupsTree[ $key ];
            if ( is_array( $parent[ 'nodes' ] ) and count( $parent[ 'nodes' ] ) > 0 )
            {
                foreach ( $parent[ 'nodes' ] as $parentNodeID )
                {
                    // fetch current parent node
                    $parentNode = eZContentObjectTreeNode::fetch( $parentNodeID );
                    if ( is_object( $parentNode ) )
                    {
                        $params = array( 'AttributeFilter' => array( array( 'name', '=', $currentName ) ),
                                         'Limitation' => array() );
                        $nodes = eZContentObjectTreeNode::subTreeByNodeID( $params, $parentNodeID );

                        if ( is_array( $nodes ) and count( $nodes ) > 0 and !$isUser )
                        {
                            // if group with given name already exist under $parentNode then get fetch
                            // group node and remember its ID
                            $node =& $nodes[ 0 ];
                            $nodeID = $node->attribute( 'node_id' );
                            $current[ 'nodes' ][] = $nodeID;
                        }
                        else
                        {
                            // if not exist then remember $parentNodeID to publish a new one
                            $parentNodesForNew[] = $parentNodeID;
                        }
                    }
                    else
                    {
                        eZDebug::writeError( 'Cannot fetch parent node for creating new user group ' . $parentNodeID, __METHOD__ );
                    }
                }
            }
            else
            {
                eZDebug::writeError( "Cannot get any published parent group for group/user with name = '$currentName'" .
                                     " (dn = '" . $current[ 'data' ]['dn'] . "')",
                                     __METHOD__ );
            }
        }

        if ( count( $parentNodesForNew ) > 0 )
        {
            if ( $isUser )
            {
                $current[ 'new_parents' ] = $parentNodesForNew;
                $newNodeIDs = array();
            }
            else
            {
                $newNodeIDs = eZLDAPUser::publishNewUserGroup( $parentNodesForNew, array( 'name' => $currentName,
                                                                                          'description' => '' ) );
            }
            $current[ 'nodes' ] = array_merge( $current[ 'nodes' ], $newNodeIDs );
        }

        array_pop( $stack );
        return true;
    }

    /*
        Static method, for internal usage only
        Recursive method, which parses tree of groups from ldap server
    */
    static function getUserGroupsTree( &$requiredParams,
                                $filter,
                                $curDN,
                                &$groupsTree,
                                &$stack,            // stack for recursion checking
                                $depth = 0 )
    {
        if ( $depth == 0 )
        {
            return false;
        }

        if ( !isset( $requiredParams[ 'LDAPGroupBaseDN' ] ) or empty( $requiredParams[ 'LDAPGroupBaseDN' ] ) or
             !isset( $requiredParams[ 'LDAPGroupClass' ] ) or empty( $requiredParams[ 'LDAPGroupClass' ] ) or
             !isset( $requiredParams[ 'LDAPGroupNameAttribute' ] ) or empty( $requiredParams[ 'LDAPGroupNameAttribute' ] ) or
             !isset( $requiredParams[ 'LDAPGroupMemberAttribute' ] ) or empty( $requiredParams[ 'LDAPGroupMemberAttribute' ] ) or
             !isset( $requiredParams[ 'ds' ] ) or !$requiredParams[ 'ds' ] )
        {
            eZDebug::writeError( 'Missing one of required parameters.', __METHOD__ );
            return false;
        }
        if ( !isset( $groupsTree[ $curDN ] ) )
        {
            eZDebug::writeError( 'Passed $curDN is not in result tree array. Algorithm\'s usage error.', __METHOD__ );
            return false;
        }
        array_push( $stack, $curDN );

        $LDAPGroupBaseDN          =& $requiredParams[ 'LDAPGroupBaseDN' ];
        $LDAPGroupClass           =& $requiredParams[ 'LDAPGroupClass' ];
        $LDAPGroupNameAttribute   =& $requiredParams[ 'LDAPGroupNameAttribute' ];
        $LDAPGroupMemberAttribute =& $requiredParams[ 'LDAPGroupMemberAttribute' ];
        $LDAPGroupDescriptionAttribute =& $requiredParams[ 'LDAPGroupDescriptionAttribute' ];
        $ds                       =& $requiredParams[ 'ds' ];

        $current =& $groupsTree[ $curDN ];

        $retrieveAttributes = array( $LDAPGroupNameAttribute,
                                     $LDAPGroupMemberAttribute );
        $sr = ldap_search( $ds, $LDAPGroupBaseDN, $filter, $retrieveAttributes );
        $entries = ldap_get_entries( $ds, $sr );

        if ( is_array( $entries ) and
             isset( $entries[ 'count' ] ) and $entries[ 'count' ] > 0 )
        {
            $newfilter = '(&(objectClass=' . $LDAPGroupClass . ')';

            for ( $i = 0; $i < $entries[ 'count' ]; $i++ )
            {
                $parent =& $entries[ $i ];
                if ( $parent === null )
                   continue;

                $parentDN =& $parent['dn'];
                if ( in_array( $parentDN, $stack ) )
                {
                    $requiredParams[ 'LDAPGroupNameAttribute' ];

                    eZDebug::writeError( 'Recursion is detected in the user-groups tree while getting parent groups for ' . $curDN, __METHOD__ );
                    $groupsTree[ '_recursion_detected_' ] = true;
                    return false;
                }

                if ( !isset( $groupsTree[ $parentDN ] ) )
                {
                    $groupsTree[ $parentDN ] = array( 'data' => $parent,
                                                      'parents' => array(),
                                                      'children' => array() );
                }
                $groupsTree[ $parentDN ][ 'children' ][ $curDN ] =& $current;
                $current[ 'parents' ][ $parentDN ] =& $groupsTree[ $parentDN ];
                $newfilter1 = $newfilter . '(' . $LDAPGroupMemberAttribute . '=' . $parentDN . '))';
                $ret = eZLDAPUser::getUserGroupsTree( $requiredParams,
                                                      $newfilter1,
                                                      $parentDN,
                                                      $groupsTree,
                                                      $stack,
                                                      $depth - 1 );
                if ( isset( $groupsTree[ '_recursion_detected_' ] ) and
                     $groupsTree[ '_recursion_detected_' ] )
                {
                    return false;
                }
            }
        }
        else
        {
            // We've reached a top node
            if ( !isset( $groupsTree[ 'root' ] ) )
            {
                $groupsTree[ 'root' ] = array( 'data' => null,
                                               'parents' => null,
                                               'children' => array(),
                                               'nodes' => array( $requiredParams[ 'TopUserGroupNodeID' ] ) );
            }
            if ( !isset( $groupsTree[ 'root' ][ 'children' ][ $curDN ] ) )
                $groupsTree[ 'root' ][ 'children' ][ $curDN ] =& $current;
            if ( !isset( $current[ 'parents' ][ 'root' ] ) )
                $current[ 'parents' ][ 'root' ] =& $groupsTree[ 'root' ];
        }

        array_pop( $stack );
        return true;
    }

    /*
        Static method, for internal usage only
        Finds a user group with the given name and remembers the node ID for it. The first match is always used.
        If $createMissingGroups is true, it will create any groups it does not find.
    */
    static function getNodeAssignmentsForGroupName( $groupName,
                                $isFirstGroupAssignment,
                                &$defaultUserPlacement,
                                &$extraNodeAssignments,
                                $createMissingGroups,
                                $parentNodeID )
    {
        if ( !is_string( $groupName ) or $groupName === '' )
        {
            eZDebug::writeError( 'The groupName must be a non empty string. Bad groupName: ' . $groupName, __METHOD__ );
            return;
        }

        $db = eZDB::instance();
        $ini = eZINI::instance();
        $userGroupClassID = $ini->variable( "UserSettings", "UserGroupClassID" );

        $groupNameEscaped = $db->escapeString( $groupName );
        $groupQuery = "SELECT ezcontentobject_tree.node_id
                       FROM ezcontentobject, ezcontentobject_tree
                       WHERE ezcontentobject.name like '$groupNameEscaped'
                       AND ezcontentobject.id = ezcontentobject_tree.contentobject_id
                       AND ezcontentobject.contentclass_id = $userGroupClassID";
        $groupRows = $db->arrayQuery( $groupQuery );

        if ( count( $groupRows ) > 0 and $isFirstGroupAssignment )
        {
            $defaultUserPlacement = $groupRows[0]['node_id'];
            return;
        }
        else if ( count( $groupRows ) > 0 )
        {
            $extraNodeAssignments[] = $groupRows[0]['node_id'];
            return;
        }

        // Should we create user groups that are specified in LDAP, but not found in eZ Publish?
        if ( !$createMissingGroups )
        {
            return;
        }

        $newNodeIDs = self::publishNewUserGroup( array( $parentNodeID ), array( 'name' => $groupName ) );

        if ( count( $newNodeIDs ) > 0 and $isFirstGroupAssignment )
        {
            $defaultUserPlacement = $newNodeIDs[0]; // We only supplied one parent to publishNewUserGroup(), so there is only one node
        }
        else if ( count( $newNodeIDs ) > 0 )
        {
            $extraNodeAssignments[] = $newNodeIDs[0]; // We only supplied one parent to publishNewUserGroup(), so there is only one node
        }
    }

    /*
        Static method, for internal usage only
        Fetch the LDAP group object given by the DN, and return its name
    */
    static function getGroupNameByDN( $ds, $groupDN )
    {
        $LDAPIni = eZINI::instance( 'ldap.ini' );
        $LDAPGroupNameAttribute = $LDAPIni->variable( 'LDAPSettings', 'LDAPGroupNameAttribute' );

        // First, try to see if the $LDAPGroupNameAttribute is contained within the DN, in that case we can read it directly
        $groupDNParts = ldap_explode_dn( $groupDN, 0 );
        list( $firstName, $firstValue ) = explode( '=', $groupDNParts[0] );

        if ( $firstName = $LDAPGroupNameAttribute ) // Read the group name attribute directly from the group DN
        {
            $groupName = $firstValue;
        }
        else // Read the LDAP group object, get the group name attribute from it
        {
            $sr = ldap_read( $ds, $groupDN, "($LDAPGroupNameAttribute=*)", array( $LDAPGroupNameAttribute ) );
            $info = ldap_get_entries( $ds, $sr );

            if ( $info['count'] < 1 or $info[0]['count'] < 1 )
            {
                eZDebug::writeWarning( 'LDAP group not found, tried DN: ' . $groupDN, __METHOD__ );
                return false;
            }

            $groupName = $info[0][$LDAPGroupNameAttribute];
            if ( is_array( $groupName ) ) // This may be a string or an array of strings, depending on LDAP setup
                $groupName = $groupName[0]; // At least one must exist, since we specified it in the search filter
        }

        return $groupName;
    }

    /*
        Based on a similar function suggested at: http://php.net/manual/en/function.ldap-search.php
    */
    static function ldap_escape( $str, $for_dn = false )
    {
        // see: RFC2254
        // http://msdn.microsoft.com/en-us/library/ms675768(VS.85).aspx
        // http://www-03.ibm.com/systems/i/software/ldap/underdn.html

        if ( $for_dn )
        {
            $metaChars = array( ',', '=', '+', '<', '>', ';', '\\', '"', '#' );
            $quotedMetaChars = array( '\2c', '\3d', '\2b', '\3c', '\3e', '\3b', '\5c', '\22', '\23' );
        }
        else
        {
            $metaChars = array( '*', '(', ')', '\\', chr(0) );
            $quotedMetaChars = array( '\2a', '\28', '\29', '\5c', '\00' );
        }

        return str_replace( $metaChars, $quotedMetaChars, $str );
    }

}

?>
