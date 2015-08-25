<?php
/**
 * File containing the eZContentLanguageRegression class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package tests
 */

/**
 * @group ezcontentlanguage
 */
class eZContentLanguageRegression extends ezpDatabaseTestCase
{
    protected $backupGlobals = false;

    public function __construct( $name = NULL, array $data = array(), $dataName = '' )
    {
        parent::__construct( $name, $data, $dataName );
        $this->setName( "eZContentLanguage Regression Tests" );
    }

    public function setUp()
    {
        parent::setUp();
        eZContentLanguage::addLanguage( 'nno-NO', 'Nynorsk' );
    }

    public function tearDown()
    {
        $nor = eZContentLanguage::fetchByLocale( 'nno-NO' );
        $dan = eZContentLanguage::fetchByLocale( 'dan-DK' );
        if ( $nor )
            $nor->removeThis();
        if ( $dan )
            $dan->removeThis();
        parent::tearDown();
    }

    /**
     * Test that fetching the language listing, works after languages
     * have been altered in database, and then later refetched.
     *
     * @link http://issues.ez.no/15484
     */
    public function testMapLanguage()
    {
        $db = eZDB::instance();

        eZContentLanguage::addLanguage( 'nno-NO', 'Nynorsk' );
        $localeToChangeInto = 'dan-DK';
        $languageNameToChangeInto = 'Danish';

        $langObject = eZContentLanguage::fetchByLocale( 'nno-NO' );
        $langId = (int)$langObject->attribute( 'id' );
        $updateSql = <<<END
UPDATE ezcontent_language
SET
locale='$localeToChangeInto',
name='$languageNameToChangeInto'
WHERE
id=$langId
END;

        $db->query( $updateSql );

        eZContentLanguage::expireCache();
        $newLangObject = eZContentLanguage::fetchByLocale( $localeToChangeInto );

        if ( !( $newLangObject instanceof eZContentLanguage ) )
        {
            self::fail( "Language object not returned. Old version provided by cache?" );
        }

        $newLangId = (int)$newLangObject->attribute( 'id' );

        self::assertEquals( $langId, $newLangId, "New language not mapped to existing language" );
    }

    /**
     * Regression test for issue #18613 :
     * Empty ezcontentlanguage_cache.php not being regenerated.
     * This cache file should always exist, but if for some reason it's empty (lost sync with cluster for instance),
     * it should be at least properly regenerated
     *
     * @link http://issues.ez.no/18613
     * @group issue18613
     */
    public function testFetchListWithBlankCacheFile()
    {
        // First simulate a problem generating the language cache file (make it blank)
        $cachePath = eZSys::cacheDirectory() . '/ezcontentlanguage_cache.php';
        $clusterFileHandler = eZClusterFileHandler::instance( $cachePath );
        $clusterFileHandler->storeContents( '', 'content', 'php' );
        unset( $GLOBALS['eZContentLanguageList'] );

        // Language list should never be empty
        self::assertNotEmpty( eZContentLanguage::fetchList() );

        // Remove the test language cache file
        $clusterFileHandler->delete();
        $clusterFileHandler->purge();
    }
}
?>
