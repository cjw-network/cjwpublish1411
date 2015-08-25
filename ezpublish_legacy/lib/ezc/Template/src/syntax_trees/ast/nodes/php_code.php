<?php
/**
 * File containing the ezcTemplatePHPCodeAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Contains a node with raw PHP code.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplatePhpCodeAstNode extends ezcTemplateStatementAstNode
{
    /**
     * Code that needs to be output.
     *
     * @var string
     */
    public $code;

    /**
     * Constructs a new php code node.
     *
     * @param string $code
     */
    public function __construct( $code = null )
    {
        parent::__construct();
        $this->code = $code;
    }
}
?>
