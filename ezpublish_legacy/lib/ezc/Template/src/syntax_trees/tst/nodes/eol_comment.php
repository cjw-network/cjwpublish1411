<?php
/**
 * File containing the ezcTemplateEolCommentTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Inline EOL comments in parser trees.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateEolCommentTstNode extends ezcTemplateExpressionTstNode
{
    /**
     * The parsed comment text without the start marker.
     *
     * @var string
     */
    public $commentText;

    /**
     * Constructs a new ezcTemplateEolCommentTstNode.
     *
     * @param ezcTemplateSourceCode $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
        $this->commentText = null;
    }

    /**
     * Returns the tree properties.
     *
     * @return array(string=>mixed)
     */
    public function getTreeProperties()
    {
        return array( 'commentText' => $this->commentText );
    }
}
?>
