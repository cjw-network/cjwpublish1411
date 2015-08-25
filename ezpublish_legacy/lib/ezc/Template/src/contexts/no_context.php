<?php
/**
 * File containing the ezcTemplateNoContext class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The ezcTemplateNoContext class doesn't change the output. This makes
 * testing more easy.
 *
 * @package Template
 * @version //autogen//
 */
class ezcTemplateNoContext implements ezcTemplateOutputContext
{
    /**
     *  Doesn't change the output, and returns exactly the same node.
     *
     *  @param ezcTemplateAstNode $node
     *  @return ezcTemplateAstNode
     */
    public function transformOutput( ezcTemplateAstNode $node )
    {
        return $node;
    }

    /**
     * Returns the unique identifier for the context handler.
     *
     * @return string
     */
    public function identifier()
    {
        return 'no_context';
    }
}

?>
