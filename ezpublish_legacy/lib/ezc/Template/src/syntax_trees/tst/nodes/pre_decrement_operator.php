<?php
/**
 * File containing the ezcTemplatePreDecrementOperatorTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Fetching of property value in an expression.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplatePreDecrementOperatorTstNode extends ezcTemplateModifyingOperatorTstNode
{
    /**
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end,
                             10, 1, self::NON_ASSOCIATIVE,
                             '--' );
        $this->maxParameterCount = 1;
    }
}
?>
