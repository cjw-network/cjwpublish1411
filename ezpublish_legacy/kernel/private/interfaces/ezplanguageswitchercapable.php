<?php
/**
 * File containing the ezpLanguageSwitcherCapable interface
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/**
 * Interface for classes providing language switcher functionality.
 *
 * @package kernel
 */
interface ezpLanguageSwitcherCapable
{
    /**
     * Constructs a ezpLanguageSwitcherCapable object.
     *
     * The $params array is the module-params array returned in the switchlanguage/to
     * view. In addition, the value in $params['QueryString'] might also be taken
     * into account (if present) to keep the query string while redirecting to
     * another language.
     * This is used to construct the destination URL.
     *
     * @param array $params
     * @return ezpLanguageSwitcherCapable
     */
    public function __construct( $params = null );

    /**
     * Sets the name of the destination translation siteaccess.
     *
     * This name is picked up and passed on in the switchlanguage module.
     *
     * @param string $destinationSiteAccess
     * @return void
     */
    public function setDestinationSiteAccess( $destinationSiteAccess );

    /**
     * This is added to serve as a hook, and can be used as seen fit.
     *
     * The default implementation perform some initialisation logic here.
     *
     * @return void
     */
    public function process();

    /**
     * Calculates the full destination URL.
     *
     * The returned URL consists of correct hostname and URL alias for
     * translated content.
     *
     * @return string
     */
    public function destinationUrl();

    /**
     * Creates array structure for iterating over language switcher URLs in
     * templates.
     *
     * This method uses the site.ini.[RegionalSettings].TranslationSA setting
     * to build an array of the defined translation siteaccess, their language
     * switcher URL and chosen text string representing that translation.
     *
     * Example return value:
     * <code>
     *     Array
     *    (
     *        [eng] => Array
     *            (
     *                [url] => /switchlanguage/to/eng/Demo-content
     *                [text] => Eng
     *            )
     *
     *        [nor] => Array
     *            (
     *                [url] => /switchlanguage/to/nor/Demo-content
     *                [text] => Nor
     *            )
     *    )
     *
     * </code>
     *
     * @param string $url
     * @return mixed
     */
    public static function setupTranslationSAList( $url = null );
}
?>
