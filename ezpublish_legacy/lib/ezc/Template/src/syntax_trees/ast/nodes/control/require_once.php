<?php
/**
 * File containing the ezcTemplateRequireOnceAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Represents a require_once control structure.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateRequireOnceAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The expression which, when evaluated, will return the filepath of the
     * include.
     * @var ezcTemplateAstNode
     */
    public $expression;

    /**
     * Initialize with function name code and optional arguments
     *
     * @param ezcTemplateAstNode $expression
     */
    public function __construct( ezcTemplateAstNode $expression = null )
    {
        parent::__construct();
        $this->expression = $expression;
    }
}
?>
