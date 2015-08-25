<?php
/**
 * File containing the ezcTemplateDoWhileAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Represents a while control structure.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateDoWhileAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The expression which makes up the condition and body of the do/while
     * statement.
     * @var ezcTemplateConditionBodyAstNode
     */
    public $conditionBody;

    /**
     * Initialize with function name code and optional arguments
     *
     * @param ezcTemplateConditionBodyAstNode $conditionBody
     */
    public function __construct( ezcTemplateConditionBodyAstNode $conditionBody = null )
    {
        parent::__construct();
        $this->conditionBody = $conditionBody;
    }
}
?>
