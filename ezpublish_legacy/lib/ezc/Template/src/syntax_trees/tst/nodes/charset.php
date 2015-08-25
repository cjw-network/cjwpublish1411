<?php
/**
 * File containing the ezcTemplateCharsetTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateCharsetTstNode extends ezcTemplateBlockTstNode
{
    public $name;

    /**
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end)
    {
        parent::__construct( $source, $start, $end );
        $this->isNestingBlock = false;
    }

    public function getTreeProperties()
    {
        return array( 'name'  => $this->name);
    }
    
}
?>
