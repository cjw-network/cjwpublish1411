<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$tpl = eZTemplate::factory();

$module = $Params['Module'];
$errorType = $Params['Type'];
$errorNumber = $Params['Number'];
$extraErrorParameters = $Params['ExtraParameters'];
$httpErrorCode = null;
$httpErrorName = null;

$tpl->setVariable( 'parameters', $extraErrorParameters );


$siteBasics = $GLOBALS['eZSiteBasics'];
$userObjectRequired = $siteBasics['user-object-required'];

$ini = eZINI::instance();

if ( $userObjectRequired )
{
    // include user class
    $currentUser = eZUser::currentUser();
    $tpl->setVariable( "current_user", $currentUser );
    $tpl->setVariable( "anonymous_user_id", $ini->variable( 'UserSettings', 'AnonymousUserID' ) );
}
else
{
    $tpl->setVariable( "current_user", false );
    $tpl->setVariable( "anonymous_user_id", false );
}

$embedContent = false;

$GLOBALS["eZRequestError"] = true;

// if ( $errorType == 'kernel' )
{
    $errorINI = eZINI::instance( 'error.ini' );

    // Redirect if error.ini tells us to
    $errorHandlerList = $errorINI->variable( 'ErrorSettings-' . $errorType, 'ErrorHandler' );
    $redirectURLList = $errorINI->variable( 'ErrorSettings-' . $errorType, 'RedirectURL' );
    $rerunURLList = $errorINI->variable( 'ErrorSettings-' . $errorType, 'RerunURL' );
    $embedURLList = $errorINI->variable( 'ErrorSettings-' . $errorType, 'EmbedURL' );

    $errorHandlerType = $errorINI->variable( 'ErrorSettings', 'DefaultErrorHandler' );
    if ( isset( $errorHandlerList[$errorNumber] ) )
        $errorHandlerType = $errorHandlerList[$errorNumber];

    if ( $errorHandlerType != 'redirect' )
    {
        // Set apache error headers if error.ini tells us to
        if ( $errorINI->hasVariable( 'ErrorSettings-' . $errorType, 'HTTPError' ) )
        {
            $errorMap = $errorINI->variable( 'ErrorSettings-' . $errorType, 'HTTPError' );
            if ( isset( $errorMap[$errorNumber] ) )
            {
                $httpErrorCode = $errorMap[$errorNumber];
                if ( $errorINI->hasVariable( 'HTTPError-' . $httpErrorCode, 'HTTPName' ) )
                {
                    $httpErrorName = $errorINI->variable( 'HTTPError-' . $httpErrorCode, 'HTTPName' );
                    $httpErrorString = "$httpErrorCode $httpErrorName";
                    if ( $errorNumber == eZError::KERNEL_MOVED )
                    {
                        $module->redirectTo( $extraErrorParameters['new_location'] );
                        $module->setRedirectStatus( $httpErrorString );
                        return array(); // $Result of this view
                    }
                    else
                    {
                        // we need to store the header so that they are listed in view cache data ()
                        $responseHeaders = array(
                            eZSys::serverVariable( 'SERVER_PROTOCOL' ) . " $httpErrorString",
                            "Status: $httpErrorString"
                        );
                        header( $responseHeaders[0] );
                        header( $responseHeaders[1] );
                    }
                }
            }
        }
    }

    eZDebug::writeError( "Error ocurred using URI: " . $_SERVER['REQUEST_URI'] , "error/view.php" );

    if ( $errorHandlerType == 'redirect' )
    {
        $errorRedirectURL = $errorINI->variable( 'ErrorSettings', 'DefaultRedirectURL' );
        if ( isset( $redirectURLList[$errorNumber] ) )
            $errorRedirectURL = $redirectURLList[$errorNumber];
        return $module->redirectTo( $errorRedirectURL );
    }
    else if ( $errorHandlerType == 'rerun' )
    {
        $errorRerunURL = $errorINI->variable( 'ErrorSettings', 'DefaultRerunURL' );
        if ( isset( $rerunURLList[$errorNumber] ) )
            $errorRerunURL = $rerunURLList[$errorNumber];
        $Result = array();
        $Result['content'] = false;
        $Result['rerun_uri'] = $errorRerunURL;
        $module->setExitStatus( eZModule::STATUS_RERUN );
        return $Result;
    }
    else if ( $errorHandlerType == 'embed' )
    {
        $errorEmbedURL = $errorINI->variable( 'ErrorSettings', 'DefaultEmbedURL' );
        if ( isset( $embedURLList[$errorNumber] ) )
            $errorEmbedURL = $embedURLList[$errorNumber];
        $uri = new eZURI( $errorEmbedURL );
        $moduleName = $uri->element();
        $embedModule = eZModule::exists( $moduleName );
        if ( $module instanceof eZModule )
        {
            $uri->increase();
            $viewName = false;
            if ( !$embedModule->singleFunction() )
            {
                $viewName = $uri->element();
                $uri->increase();
            }
            $embedParameters = $uri->elements( false );
            $embedResult = $embedModule->run( $viewName, $embedParameters );
            $embedContent = $embedResult['content'];
        }

        // write reason to debug
//        $accessMessage = print_r($Params['ExtraParameters']['AccessList']['FunctionRequired'], true);
        // Function required
        if ( isset( $Params['ExtraParameters']['AccessList'] ) )
        {
            $accessMessage = "Function required:\n";
            if ( is_array( $Params['ExtraParameters']['AccessList']['FunctionRequired'] ) )
            {
                foreach ( array_keys ( $Params['ExtraParameters']['AccessList']['FunctionRequired'] ) as $key )
                {
                    $accessMessage .= " $key : " . $Params['ExtraParameters']['AccessList']['FunctionRequired'][$key] . "\n" ;
                }
            }
            $accessMessage .= "Policies that didn't match:\n";
            if ( is_array( $Params['ExtraParameters']['AccessList']['PolicyList'] ) )
            {
                foreach ( $Params['ExtraParameters']['AccessList']['PolicyList'] as $policy )
                {
                    $accessMessage .= " PolicyID : " . $policy['PolicyID'] . "\n" ;
                    $accessMessage .= "  Limitation : " . $policy['LimitationList']['Limitation'] . "\n" ;
                    $accessMessage .= "  Required : " . implode( ', ', $policy['LimitationList']['Required'] ) . "\n";
                }
            }

            eZDebug::writeWarning($accessMessage, "Insufficient permissions", "kernel/error/view.php");
        }

    }
}


$userRedirectURI = '';
$requestedURI = $GLOBALS['eZRequestedURI'];
if ( $requestedURI instanceof eZURI )
{
    $userRedirectURI = $requestedURI->uriString( true );
}
$tpl->setVariable( 'redirect_uri', $userRedirectURI );
$tpl->setVariable( 'embed_content', $embedContent );

if ( (isset( $Params['ExtraParameters']['AccessList'] ) ) and  ( $ini->variable( 'RoleSettings', 'ShowAccessDeniedReason' ) === "enabled" ) )
{
    $tpl->setVariable( 'module_required', $Params['ExtraParameters']['AccessList']['FunctionRequired']['Module'] );
    $tpl->setVariable( 'function_required', $Params['ExtraParameters']['AccessList']['FunctionRequired']['Function'] );
}

$res = eZTemplateDesignResource::instance();
$res->setKeys( array( array( 'error_type', $errorType ), array( 'error_number', $errorNumber ) ) );

$Result = array();
$Result['content'] = $tpl->fetch( "design:error/$errorType/$errorNumber.tpl" );
$Result['path'] = array( array( 'text' => ezpI18n::tr( 'kernel/error', 'Error' ),
                                'url' => false ),
                         array( 'text' => "$errorType ($errorNumber)",
                                'url' => false ) );
$Result['errorCode'] = $httpErrorCode;
$Result['errorMessage'] = $httpErrorName;
$Result['errorType'] = $errorType;
$Result['errorNumber'] = $errorNumber;

if ( isset( $responseHeaders ) )
    $Result['responseHeaders'] = $responseHeaders;
