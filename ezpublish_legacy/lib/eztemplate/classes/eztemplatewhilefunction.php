<?php
/**
 * File containing the eZTemplateWhileFunction class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package lib
 */

/*!
  \class eZTemplateWhileFunction eztemplatewhilefunction.php
  \ingroup eZTemplateFunctions
  \brief WHILE loop

  Syntax:
\code
    {while <condition> [sequence <array> as $seqVar] }
        [{delimiter}...{/delimiter}]
        [{break}]
        [{continue}]
        [{skip}]
    {/while}
\endcode

  Example:
\code
    {while ne( $var, false() ) }
        I like big trucks
    {/while}
\endcode
*/

class eZTemplateWhileFunction
{
    const FUNCTION_NAME = 'while';

    /*!
     * Returns an array of the function names, required for eZTemplate::registerFunctions.
     */
    function functionList()
    {
        $functionList = array( eZTemplateWhileFunction::FUNCTION_NAME );
        return $functionList;
    }

    /*!
     * Returns the attribute list.
     * key:   parameter name
     * value: can have children
     */
    function attributeList()
    {
        return array( 'delimiter' => true,
                      'break'     => false,
                      'continue'  => false,
                      'skip'      => false );
    }


    /*!
     * Returns the array with hits for the template compiler.
     */
    function functionTemplateHints()
    {
        return array( eZTemplateWhileFunction::FUNCTION_NAME => array( 'parameters' => true,
                                                                'static' => false,
                                                                'transform-parameters' => true,
                                                                'tree-transformation' => true ) );
    }

    /*!
     * Compiles the function and its children into PHP code.
     */
    function templateNodeTransformation( $functionName, &$node,
                                         $tpl, &$parameters, $privateData )
    {
        // {while <condition> [sequence <sequence_array> as $<sequence_var>]}

        $tpl->WhileCounter++;
        $newNodes      = array();
        $nodePlacement = eZTemplateNodeTool::extractFunctionNodePlacement( $node );
        $uniqid        =  md5( $nodePlacement[2] ) . "_" . $tpl->WhileCounter;

        $loop = new eZTemplateCompiledLoop( eZTemplateWhileFunction::FUNCTION_NAME,
                                            $newNodes, $parameters, $nodePlacement, $uniqid,
                                            $node, $tpl, $privateData );


        $loop->initVars();

        // loop header
        $newNodes[] = eZTemplateNodeTool::createCodePieceNode( "while ( 1 ) // while\n{" );
        $newNodes[] = eZTemplateNodeTool::createSpacingIncreaseNode();
        $newNodes[] = eZTemplateNodeTool::createVariableNode( false, $parameters['condition'], $nodePlacement, array( 'treat-value-as-non-object' => true ),
                                                              "while_cond" );
        $newNodes[] = eZTemplateNodeTool::createCodePieceNode( "if ( ! \$while_cond ) break;\n" );

        $loop->processBody();

        // loop footer
        $newNodes[] = eZTemplateNodeTool::createSpacingDecreaseNode();
        $newNodes[] = eZTemplateNodeTool::createCodePieceNode( "} // end of while\n" );
        $newNodes[] = eZTemplateNodeTool::createVariableUnsetNode( 'while_cond' );
        $loop->cleanup();

        return $newNodes;
    }

    /*!
     * Actually executes the function and its children (in processed mode).
     */
    function process( $tpl, &$textElements, $functionName, $functionChildren, $functionParameters, $functionPlacement, $rootNamespace, $currentNamespace )
    {
        if ( count( $functionParameters ) == 0 )
        {
            eZDebug::writeError( "Not enough arguments passed to 'while' function." );
            return;
        }

        $loop = new eZTemplateLoop( eZTemplateWhileFunction::FUNCTION_NAME,
                                    $functionParameters, $functionChildren, $functionPlacement,
                                    $tpl, $textElements, $rootNamespace, $currentNamespace );

        if ( !$loop->initialized() )
            return;

        while ( $tpl->elementValue( $functionParameters['condition'], $rootNamespace, $currentNamespace, $functionPlacement ) )
        {
            $loop->setSequenceVar(); // set sequence variable (if specified)
            $loop->processDelimiter();
            $loop->resetIteration();

            if ( $loop->processChildren() )
                break;

            $loop->incrementSequence();
        }

        $loop->cleanup();
    }

    /*!
     * Returns true, telling the template parser that the function can have children.
     */
    function hasChildren()
    {
        return true;
    }
}

?>
