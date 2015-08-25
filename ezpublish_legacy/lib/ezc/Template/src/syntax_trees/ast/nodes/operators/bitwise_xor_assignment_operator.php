<?php
/**
 * File containing the ezcTemplateBitwiseXorAssignmentOperatorAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Represents the PHP bitwise xor assignment operator ^=
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateBitwiseXorAssignmentOperatorAstNode extends ezcTemplateBinaryOperatorAstNode
{
    /**
     * Returns a text string representing the PHP operator.
     * @return string
     */
    public function getOperatorPHPSymbol()
    {
        return '^=';
    }
}
?>
