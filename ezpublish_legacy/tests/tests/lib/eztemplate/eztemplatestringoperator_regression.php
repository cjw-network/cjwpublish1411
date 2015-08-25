<?php
/**
 * File containing tests for eZTemplateStringOperator
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package tests
 */

/**
 * Test scenario for issue #14927: simplify operator has a different behaviour depending on TemplateCompile settings
 *
 * Test Outline:
 * ---------------
 * 1.Use an test string to test the simplify operator: "for Germany           on the whole, resultin
 *
 *
 *Kohl and Fra  nçois
 *Mitterrand we   re the jo".
 *
 * 2.Invoke the method customMapTransformation, which means invoking the operator in template complication mode, check if the operation result equals to "for Germany on the whole, resultin
 *
 *
 * Kohl and Fra nçois
 * Mitterrand we re the jo".
 *
 * 3.Invoke the method modify, which means invoking the operator in parsing mode,check if the operation result equals to "for Germany on the whole, resultin
 *
 *
 * Kohl and Fra nçois
 * Mitterrand we re the jo".
 *
 * @result:
 * @expected:  step2 and step3 will pass
 * @link: http://issues.ez.no/14927
 */


 class eZTemplateStringOperatorRegression extends ezpTestCase
 {
    /**
     * templateStringOperation object
     * @var unknown_type
     */
    private $templateStringOperator;

    /**
     * test the modify method, which invokes the operation in template parsing mode
     * By default, the operator "simplify()" will only replace the two more consecutive space into one
     * @see tests/tests/lib/eztemplate/ezpTestCase#testModifySimplify()
     */
    public function testModifySimplify()
    {
        $testString="for Germany           on the whole, resultin


Kohl and Fra  nçois
Mitterrand we   re the jo";
        $expectedString="for Germany on the whole, resultin


Kohl and Fra nçois
Mitterrand we re the jo";
        $namedParameters=array("char"=>false);
        $this->templateStringOperator->modify(null,"simplify",
         null,null,null,$testString,$namedParameters,null);
        $this->assertEquals($testString,$expectedString);
    }

    /**
     * test the modify method, which invokes the operation in template parsing mode
     * The operator "simplify("\n")" will replace the two more consecutive "\n" into one
     * @see tests/tests/lib/eztemplate/ezpTestCase#testModifySimplify()
     */
    public function testModifySimplifyWithParam()
    {
        $testString="for Germany           on the whole, resultin



Kohl and Fra  nçois
Mitterrand we   re the jo";
        $expectedString="for Germany           on the whole, resultin
Kohl and Fra  nçois
Mitterrand we   re the jo";
        $namedParameters=array("char"=>"\n");
        $this->templateStringOperator->modify(null,"simplify",null,null,null,$testString,$namedParameters,null);
        $this->assertEquals($testString,$expectedString);
    }


    /**
     * initialize the context
     * @see tests/tests/lib/eztemplate/ezpTestCase#setUp()
     */
    public function setUp()
    {
        parent::setUp();
        $this->templateStringOperator=new eZTemplateStringOperator();
    }

  protected $backupGlobals = false;

 }

?>
