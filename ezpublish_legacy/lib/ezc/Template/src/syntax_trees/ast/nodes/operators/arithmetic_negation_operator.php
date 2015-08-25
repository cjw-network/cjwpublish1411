<?php
/**
 * File containing the ezcTemplateArithmeticNegationOperatorAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Represents the PHP arithmetic negation operator -
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateArithmeticNegationOperatorAstNode extends ezcTemplateOperatorAstNode
{
    /**
     * Initialize operator code constructor with 1 parameter (binary) and mark as pre-operator.
     *
     * @param ezcTemplateAstNode $parameter The code element to use as first parameter.
     */
    public function __construct( ezcTemplateAstNode $parameter = null )
    {
        parent::__construct( self::OPERATOR_TYPE_UNARY, true );
        if ( $parameter )
        {
            $this->appendParameter( $parameter );
        }
    }

    /**
     * Returns a text string representing the PHP operator.
     * @return string
     */
    public function getOperatorPHPSymbol()
    {
        return '-';
    }
}
?>
