<?php
/**
 * File containing the eZSITestSuite class
 *
 * @copyright Copyright (C) eZ Systems AS.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @package tests
 */

class eZSITestSuite extends ezpTestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( "eZSI Test Suite" );

        $this->addTestSuite( 'eZSIBlockFunctionTest' );
    }

    public static function suite()
    {
        return new self();
    }
}

?>