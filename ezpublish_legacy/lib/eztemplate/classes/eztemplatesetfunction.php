<?php
/**
 * File containing the eZTemplateSetFunction class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package lib
 */

/*!
  \class eZTemplateSetFunction eztemplatesetfunction.php
  \ingroup eZTemplateFunctions
  \brief Sets template variables code using function 'set'

  Allows for setting template variables from templates using
  a template function. This is mainly used for optimizations.

  The let function will define new variables and initialize them with
  a value while set only sets values to existing variables.
  The let function is also scoped with children which means that the
  variables are unset when the children are processed.

\code
// Example template code
{let object=$item1 some_text='abc' integer=1}
  {set object=$item2 some_text='def'}

{/let}

{set name=NewNamespace place='/etc/test.tpl'}

\endcode
*/

class eZTemplateSetFunction
{
    const SCOPE_RELATIVE = 1;
    const SCOPE_ROOT = 2;
    const SCOPE_GLOBAL = 3;

    /*!
     Initializes the function with the function names $setName and $letName.
    */
    function eZTemplateSetFunction( $setName = 'set', $letName = 'let', $defaultName = 'default' )
    {
        $this->SetName = $setName;
        $this->LetName = $letName;
        $this->DefaultName = $defaultName;
    }

    /*!
     Returns an array of the function names, required for eZTemplate::registerFunctions.
    */
    function functionList()
    {
        return array( $this->SetName, $this->LetName, $this->DefaultName );
    }

    function functionTemplateHints()
    {
        return array( $this->LetName => array( 'parameters' => true,
                                               'static' => false,
                                               'tree-transformation' => true,
                                               'transform-children' => true,
                                               'transform-parameters' => true ),
                      $this->SetName => array( 'parameters' => true,
                                               'static' => false,
                                               'tree-transformation' => true,
                                               'transform-children' => true,
                                               'transform-parameters' => true ),
                      $this->DefaultName => array( 'parameters' => true,
                                                   'static' => false,
                                                   'tree-transformation' => true,
                                                   'transform-children' => true,
                                                   'transform-parameters' => true ) );
    }

    function templateNodeTransformation( $functionName, &$node,
                                         $tpl, $parameters, $privateData )
    {
        switch( $functionName )
        {
            case $this->SetName:
            case $this->DefaultName:
            case $this->LetName:
            {
                $scope = eZTemplate::NAMESPACE_SCOPE_RELATIVE;
                if ( isset( $parameters['-scope'] ) )
                {
                    if ( !eZTemplateNodeTool::isConstantElement( $parameters['-scope'] ) )
                        return false;
                    $scopeText = eZTemplateNodeTool::elementConstantValue( $parameters['-scope'] );
                    if ( $scopeText == 'relative' )
                        $scope = eZTemplate::NAMESPACE_SCOPE_RELATIVE;
                    else if ( $scopeText == 'root' )
                        $scope = eZTemplate::NAMESPACE_SCOPE_LOCAL;
                    else if ( $scopeText == 'global' )
                        $scope = eZTemplate::NAMESPACE_SCOPE_GLOBAL;
                }

                $parameters = eZTemplateNodeTool::extractFunctionNodeParameters( $node );
                $namespaceValue = false;
                if ( isset( $parameters['-name'] ) )
                {
                    if ( !eZTemplateNodeTool::isConstantElement( $parameters['-name'] ) )
                    {
                        return false;
                    }

                    $namespaceValue = eZTemplateNodeTool::elementConstantValue( $parameters['-name'] );
                }

                $variableList = array();
                $setVarNodes = array();
                foreach ( array_keys( $parameters ) as $parameterName )
                {
                    if ( $parameterName == '-name' or $parameterName == '-scope'  )
                    {
                        continue;
                    }

                    $parameterData =& $parameters[$parameterName];

                    $setVarNodes[] = eZTemplateNodeTool::createVariableNode(
                            false, $parameterData, eZTemplateNodeTool::extractFunctionNodePlacement( $node ),
                            array(), array( $namespaceValue, $scope, $parameterName ),
                            ( $functionName == $this->SetName ), ( $functionName != $this->DefaultName ),
                            false, ( $functionName == $this->DefaultName ) );

                    if ( $functionName == $this->LetName or $functionName == $this->DefaultName )
                    {
                        $variableList[] = $parameterName;
                    }
                }

                if ( ( $functionName == $this->LetName or $functionName == $this->DefaultName ) and
                     $namespaceValue )
                {
                    $setVarNodes[] = eZTemplateNodeTool::createNamespaceChangeNode( $namespaceValue );
                }

                if ( $functionName == $this->LetName or $functionName == $this->DefaultName )
                {
                    $childNodes = eZTemplateNodeTool::extractFunctionNodeChildren( $node );
                    if ( !is_array( $childNodes ) )
                    {
                        $childNodes = array();
                    }
                }
                else
                {
                    $childNodes = array();
                }

                $unsetVarNodes = array();

                if ( ( $functionName == $this->LetName or $functionName == $this->DefaultName ) and
                     $namespaceValue )
                {
                    $unsetVarNodes[] = eZTemplateNodeTool::createNamespaceRestoreNode();
                }

                if ( $functionName == $this->LetName or $functionName == $this->DefaultName )
                {
                    foreach( $variableList as $parameterName )
                    {
                        $unsetVarNodes[] = eZTemplateNodeTool::createVariableUnsetNode( array( $namespaceValue,
                                                                                               eZTemplate::NAMESPACE_SCOPE_RELATIVE,
                                                                                               $parameterName ),
                                                                                        array( 'remember_set' => $functionName == $this->DefaultName ) );
                    }
                }

                return array_merge( $setVarNodes, $childNodes, $unsetVarNodes );
            } break;
        }

    }

    function templateHookProcess( $functionName, $functionHookName, $functionHook,
                                  $tpl, $functionParameters, $functionPlacement, $rootNamespace, $currentNamespace )
    {
    }

    function defineVariables( $tpl, $functionParameters, $functionPlacement, $name, $rootNamespace, &$currentNamespace )
    {
        $oldCurrentNamespace = $currentNamespace;
        $definedVariables = array();
        foreach ( array_keys( $functionParameters ) as $key )
        {
            $item =& $functionParameters[$key];
            switch ( $key )
            {
                case '-name':
                    break;

                default:
                {
                    if ( !$tpl->hasVariable( $key, $name ) )
                    {
                        $itemValue = $tpl->elementValue( $item, $rootNamespace, $currentNamespace, $functionPlacement );
                        $tpl->setVariable( $key, $itemValue, $name );
                        $definedVariables[] = $key;
                    }
                    else
                    {
                        $varname = $key;
                        if ( $name != '' )
                            $varname = "$name:$varname";
                        $tpl->warning( $this->SetName, "Variable '$varname' already exists, cannot define" );
                    }
                } break;
            }
        }
        $currentNamespace = $name;
        return array( $definedVariables,
                      $oldCurrentNamespace );
    }

    function createDefaultVariables( $tpl, $functionParameters, $functionPlacement, $name, $rootNamespace, &$currentNamespace )
    {
        $oldCurrentNamespace = $currentNamespace;
        $definedVariables = array();
        foreach ( array_keys( $functionParameters ) as $key )
        {
            $item =& $functionParameters[$key];
            switch ( $key )
            {
                case '-name':
                    break;

                default:
                {
                    if ( !$tpl->hasVariable( $key, $name ) )
                    {
                        $itemValue = $tpl->elementValue( $item, $rootNamespace, $currentNamespace, $functionPlacement );
                        $tpl->setVariable( $key, $itemValue, $name );
                        $definedVariables[] = $key;
                    }
                } break;
            }
        }
        $currentNamespace = $name;
        return array( $definedVariables,
                      $oldCurrentNamespace );
    }

    function cleanupVariables( $tpl, $rootNamespace, &$currentNamespace, $setData )
    {
        $definedVariables = $setData[0];
        foreach ( $definedVariables as $variable )
        {
            $tpl->unsetVariable( $variable, $currentNamespace );
        }
        $currentNamespace = $setData[1];
    }

    /*!
     Loads the file specified in the parameter 'uri' with namespace 'name'.
    */
    function process( $tpl, &$textElements, $functionName, $functionChildren, $functionParameters, $functionPlacement, $rootNamespace, $currentNamespace )
    {
        if ( $functionName != $this->SetName and
             $functionName != $this->LetName and
             $functionName != $this->DefaultName )
            return null;

        $children = $functionChildren;
        $parameters = $functionParameters;

        $scope = eZTemplateSetFunction::SCOPE_RELATIVE;
        if ( isset( $parameters['-scope'] ) )
        {
            $scopeText = $tpl->elementValue( $parameters['-scope'], $rootNamespace, $currentNamespace, $functionPlacement );
            if ( $scopeText == 'relative' )
                $scope = eZTemplateSetFunction::SCOPE_RELATIVE;
            else if ( $scopeText == 'root' )
                $scope = eZTemplateSetFunction::SCOPE_ROOT;
            else if ( $scopeText == 'global' )
                $scope = eZTemplateSetFunction::SCOPE_GLOBAL;
            else
                $tpl->warning( $functionName, "Scope value '$scopeText' is not valid, use either 'relative', 'root' or 'global'" );
        }

        $name = null;
        if ( isset( $parameters['-name'] ) )
            $name = $tpl->elementValue( $parameters['-name'], $rootNamespace, $currentNamespace, $functionPlacement );
        if ( $name === null )
        {
            if ( $scope == eZTemplateSetFunction::SCOPE_RELATIVE )
                $name = $currentNamespace;
            else if ( $scope == eZTemplateSetFunction::SCOPE_ROOT )
                $name = $rootNamespace;
            else
                $name = '';
        }
        else
        {
            if ( $scope == eZTemplateSetFunction::SCOPE_RELATIVE and
                 $currentNamespace != '' )
                $name = "$currentNamespace:$name";
            else if ( $scope == eZTemplateSetFunction::SCOPE_ROOT and
                      $rootNamespace != '' )
                $name = "$rootNamespace:$name";
        }

        $definedVariables = array();
        if ( $functionName == $this->SetName )
        {
            foreach ( array_keys( $functionParameters ) as $key )
            {
                $item =& $functionParameters[$key];
                switch ( $key )
                {
                    case '-name':
                    case '-scope':
                        break;

                    default:
                    {
                        if ( $tpl->hasVariable( $key, $name ) )
                        {
                            unset( $itemValue );
                            $itemValue = $tpl->elementValue( $item, $rootNamespace, $currentNamespace, $functionPlacement );
                            $tpl->setVariable( $key, $itemValue, $name );
                        }
                        else
                        {
                            $varname = $key;
                            if ( $name != '' )
                                $varname = "$name:$varname";
                            $tpl->warning( $functionName, "Variable '$varname' doesn't exist, cannot set" );
                        }
                    } break;
                }
            }
        }
        else if ( $functionName == $this->DefaultName )
        {
            $definedVariables = eZTemplateSetFunction::createDefaultVariables( $tpl, $functionParameters, $functionPlacement, $name, $rootNamespace, $currentNamespace );
        }
        else
        {
            $definedVariables = eZTemplateSetFunction::defineVariables( $tpl, $functionParameters, $functionPlacement, $name, $rootNamespace, $currentNamespace );
        }
        if ( $functionName == $this->LetName or
             $functionName == $this->DefaultName )
        {
            if ( is_array( $functionChildren ) )
            {
                foreach ( array_keys( $functionChildren ) as $childKey )
                {
                    $child =& $functionChildren[$childKey];
                    $tpl->processNode( $child, $textElements, $rootNamespace, $name );
                }
            }
            eZTemplateSetFunction::cleanupVariables( $tpl, $rootNamespace, $currentNamespace, $definedVariables );
        }
    }

    /*!
     Returns false, telling the template parser that this is a single tag.
    */
    function hasChildren()
    {
        return array( $this->SetName => false,
                      $this->LetName => true,
                      $this->DefaultName => true );
    }

    /// The name of the set function
    public $SetName;
    public $LetName;
    public $DefaultName;
}

?>
