<?php
/**
 * File containing the ezcTemplateTranslationContextTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Control structure: tr_context.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateTranslationContextTstNode extends ezcTemplateBlockTstNode
{
    /**
     * The context variable.
     *
     * @var ezcTemplateExpressionTstNode
     */
    public $context;

    /**
     * Constructs a new ezcTemplateForeachLoopTstNode.
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
        $this->context = null;
        $this->name = 'tr_context';
        $this->isNestingBlock = false;
    }

    /**
     * Returns the tree properties.
     *
     * @return array(string=>mixed)
     */
    public function getTreeProperties()
    {
        return array( 'context' => $this->context );
    }
}
?>
