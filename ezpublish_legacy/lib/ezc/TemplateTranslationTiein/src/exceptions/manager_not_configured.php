<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package TemplateTranslationTiein
 */

/**
 * Thrown when a required configuration setting was not made for a backend.
 *
 * @package TemplateTranslationTiein
 * @version //autogentag//
 */
class ezcTemplateTranslationManagerNotConfiguredException extends ezcTemplateTranslationTieinException
{
    /**
     * Constructs a new ezcTemplateTranslationManagerNotConfiguredException.
     *
     * @return void
     */
    function __construct()
    {
        parent::__construct( "The manager property of the ezcTemplateTranslationConfiguration has not been configured." );
    }
}
?>
