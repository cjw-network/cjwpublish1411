<?php
/**
 * File containing the ezcTemplateArrayRangeOperatorTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Operator for comparing two values using PHPs ==.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateArrayRangeOperatorTstNode extends ezcTemplateOperatorTstNode
{
    /**
     * Initialise operator with source and cursor positions.
     *
     * @param ezcTemplateSourceCode $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        // TODO change this.
        parent::__construct( $source, $start, $end,
                             6, 5, self::NON_ASSOCIATIVE,
                             '..' );
    }
}
?>
