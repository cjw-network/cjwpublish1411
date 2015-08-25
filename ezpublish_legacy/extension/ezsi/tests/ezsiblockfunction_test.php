<?php
/**
 * File containing the eZSIBlockFunctionTest class
 *
 * @copyright Copyright (C) eZ Systems AS.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @package tests
 */

class eZSIBlockFunctionTest extends ezpTestCase
{
    const SI_BLOCK_FUNCTION_NAME = 'si-block';
    const SI_BLOCK_TABLE_NAME    = 'ezsi_files';
    const SI_BLOCK_STORAGE_DIR   = './var/si-block/';
    const SI_CONF_FILE_PATH      = 'extension/ezsi/settings/';
    const SI_CONF_FILE_NAME      = 'ezsi.ini.append.php';

    private $templateResource;
    private $rootNamespace;
    private $currentNamespace;
    private $textElements;
    private $functionChildren;
    private $functionParameters;
    private $functionPlacement;

    public function __construct()
    {
        parent::__construct();

        $this->setName( "eZSIBlockFunctionTest" );

        $this->templateResource   = eZTemplate::factory();
        $this->rootNamespace      = '';
        $this->currentNamespace   = '';
        $this->textElements       = array();
        $this->functionChildren   = array();
        $this->functionParameters = array();
        $this->functionPlacement  = $this->initFunctionPlacement();
    }

    protected function setUp()
    {
        // truncates the ezsi_file table
        $db = eZDB::instance();
        $sql = 'TRUNCATE TABLE ' . self::SI_BLOCK_TABLE_NAME;
        if( !$db->query( $sql ) )
            return false;

        // removes files in the si-block directory
        if( is_dir( realpath( self::SI_BLOCK_STORAGE_DIR ) ) )
        {
            try {
                ezcBaseFile::removeRecursive( self::SI_BLOCK_STORAGE_DIR );
            } catch ( Exception $e ) {
                echo 'Got Exception message : ' . $e->getMessage() . "\n";
                return false;
            }
        }
    }

    protected function tearDown()
    {
        $this->setUp();
    }

    /*
     * Returns an array with fake informations about the
     * function placement in the template
     *
     * @return array
     *
     */
    private function initFunctionPlacement()
    {
        return array ( 0 => array ( 0 => 2,
                                    1 => 0,
                                    2 => 75 ),
                       1 => array ( 0 => 2,
                                    1 => 8,
                                    2 => 83 ),
                       2 => 'extension/ezsi/design/standard/templates/ezsi/test.tpl' );
    }

    /*
     * Calls eZSIBlockFunction::keyIsValid and returns the result
     *
     * @return bool
     */
    private function processKeyIsValidFunction( $key )
    {
        $eZSIBlock = new eZSIBlockFunction();

        $ttl = '1s';
        $functionParameters = $this->buildFunctionParameters( $key, $ttl );

        return $eZSIBlock->keyIsValid( $this->templateResource,
                                       $this->textElements,
                                       $this->functionChildren,
                                       $functionParameters,
                                       $this->functionPlacement,
                                       $this->rootNamespace,
                                       $this->currentNamespace );
    }

    /*
     * Calls eZSIBlockFunction::ttlIsValid and returns the result
     *
     * @return bool
     */
    private function processTTLIsValidFunction( $ttl )
    {
        $eZSIBlock = new eZSIBlockFunction();

        $key = 'dummykey';
        $functionParameters = $this->buildFunctionParameters( $key, $ttl );

        return $eZSIBlock->ttlIsValid( $this->templateResource,
                                       $this->textElements,
                                       $this->functionChildren,
                                       $functionParameters,
                                       $this->functionPlacement,
                                       $this->rootNamespace,
                                       $this->currentNamespace );

    }

    /*
     * Calls eZSIBlockFunction::process and returns the result
     */
    private function processSIBlockTemplateFunction( $key, $ttl )
    {
        $functionParameters = $this->buildFunctionParameters( $key, $ttl );

        return $this->templateResource->processFunction( self::SI_BLOCK_FUNCTION_NAME,
                                                         $this->textElements,
                                                         $this->functionChildren,
                                                         $functionParameters,
                                                         $this->functionPlacement,
                                                         $this->rootNamespace,
                                                         $this->currentNamespace );
    }

    /*
     * Builds an eZTemplate engine compatible array with
     * $key and $ttl defined as argument
     *
     * @param mixed  key The si-block's key
     * @param string ttl The si-block's TTL
     *
     * @return array The eZTemplate $functionParameters array
     */
    private function buildFunctionParameters( $key, $ttl )
    {
        return array ( 'key' => array ( 0 => array ( 0 => 1,
                                                     1 => $key,
                                                     2 => false ) ),

                       'ttl' => array ( 0 => array ( 0 => 1,
                                                     1 => $ttl,
                                                     2 => false ) )
                     );
    }

    // Testing key
    public function testNoKey()
    {
        $key = null;

        $result = $this->processKeyIsValidFunction( $key );

        $this->assertFalse( $result, 'an non existent key should make {si-block} break' );
    }

    public function testEmptyKey()
    {
        $key = '';

        $result = $this->processKeyIsValidFunction( $key );

        $this->assertFalse( $result, 'an empty key should make {si-block} break' );
    }

    public function testValidKeyAsString()
    {
        $key = 'key';

        $result = $this->processKeyIsValidFunction( $key );

        $this->assertTrue( $result, 'a key as a string should be valid' );

    }

    public function testValidKeyAsArray()
    {
        $key = array( 'one', 'two' );

        $result = $this->processKeyIsValidFunction( $key );

        $this->assertTrue( $result, 'a key as an array should be valid' );

    }

    public function testValidKeyAsHash()
    {
        $key = array( 'one' => 'two', 'two' => 'three' );

        $result = $this->processKeyIsValidFunction( $key );

        $this->assertTrue( $result, 'a key as an array should be valid' );

    }

    // Testing TTL
    public function testNoTTL()
    {
        $ttl = null;

        $result = $this->processTTLIsValidFunction( $ttl );

        $this->assertFalse( $result, 'an non existent ttl should make {si-block} break' );
    }

    public function testEmptyTTL()
    {
        $ttl = '';

        $result = $this->processTTLIsValidFunction( $ttl );

        $this->assertFalse( $result, 'an empty ttl should make {si-block} break' );
    }

    public function testTTLAsInvalidString2Chars()
    {
        $ttl = 'lo';

        $result = $this->processTTLIsValidFunction( $ttl );

        $this->assertFalse( $result, 'a string ttl should make {si-block} break' );
    }

    public function testTTLAsInvalidStringMoreThan2Chars()
    {
        $ttl = 'loremipsum';

        $result = $this->processTTLIsValidFunction( $ttl );

        $this->assertFalse( $result, 'a string ttl should make {si-block} break' );
    }

    public function testTTLAsInvalidInteger()
    {
        $ttl = '12345';

        $result = $this->processTTLIsValidFunction( $ttl);

        $this->assertFalse( $result, 'an invalid integer ttl should make {si-block} break' );
    }

    /**
     Testing ESI block tag generation
     @bug will not work on Oracle
    */
    public function testESIBlockGeneration()
    {
        $key = 'dummykey';
        $ttl = '1s';

        $ini = eZINI::instance( 'ezsi.ini' );
        $blockHandler = strtolower( $ini->variable( 'SIBlockSettings', 'BlockHandler' ) );

        $patternList = array( 'esi' => '#^<esi:include src="[a-z0-9-_/.]+" ttl="'.$ttl.'" onerror="continue"/>$#',
                              'ssi' => '@<!--#include file="[a-z0-9-_/.]+" -->@' );

        $pattern = $patternList[$blockHandler];

        $this->textElements = '';
        $this->processSIBlockTemplateFunction( $key, $ttl );

        $this->assertRegexp( $pattern, $this->textElements[0] );
        $this->textElements = '';

        if( $ini->variable( 'SIFilesSettings', 'FileHandler' ) == 'FS' )
        {
            $db = eZDB::instance();
            $sql = 'SELECT filepath FROM ezsi_files LIMIT 0, 1';
            $rows = $db->arrayQuery( $sql );

            $this->assertEquals( 1, count( $rows ) );
            $this->assertFileExists( $rows[0]['filepath'] );
        }
    }
}
?>