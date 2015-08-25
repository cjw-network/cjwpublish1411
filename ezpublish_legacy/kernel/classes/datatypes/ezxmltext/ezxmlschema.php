<?php
/**
 * File containing the eZXMLSchema class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

class eZXMLSchema
{
    public $Schema = array(
        'section'   => array( 'blockChildrenAllowed' => array( 'header', 'paragraph', 'section' ),
                              'inlineChildrenAllowed' => false,
                              'childrenRequired' => false,
                              'isInline' => false,
                              'attributes' => array( 'xmlns:image', 'xmlns:xhtml', 'xmlns:custom', 'xmlns:tmp' ) ),

        'embed'     => array( 'blockChildrenAllowed' => false,
                              'inlineChildrenAllowed' => false,
                              'childrenRequired' => null,
                              'isInline' => true,
                              'attributes' => array( 'object_id', 'node_id', 'show_path', 'size',
                                                     'align', 'view', 'xhtml:id', 'class', 'target' ),
                              'attributesDefaults' => array( 'align' => '', 'view' => 'embed', 'class' => '' ) ),

        'embed-inline' => array( 'blockChildrenAllowed' => false,
                              'inlineChildrenAllowed' => false,
                              'childrenRequired' => null,
                              'isInline' => true,
                              'attributes' => array( 'object_id', 'node_id', 'show_path', 'size',
                                                     'align', 'view', 'xhtml:id', 'class', 'target' ),
                              'attributesDefaults' => array( 'align' => '', 'view' => 'embed-inline', 'class' => '' ) ),

        'table'     => array( 'blockChildrenAllowed' => array( 'tr' ),
                              'inlineChildrenAllowed' => false,
                              'childrenRequired' => true,
                              'isInline' => false,
                              'attributes' => array( 'class', 'width', 'border', 'align' ) ),

        'tr'        => array( 'blockChildrenAllowed' => array( 'td', 'th' ),
                              'inlineChildrenAllowed' => false,
                              'childrenRequired' => false,
                              'isInline' => false,
                              'attributes' => array( 'class' ) ),

        'td'        => array( 'blockChildrenAllowed' => array( 'header', 'paragraph', 'section', 'table' ),
                              'inlineChildrenAllowed' => false,
                              'childrenRequired' => false,
                              'isInline' => false,
                              'attributes' => array( 'class', 'align', 'xhtml:width', 'xhtml:colspan', 'xhtml:rowspan' ) ),

        'th'        => array( 'blockChildrenAllowed' => array( 'header', 'paragraph', 'section', 'table' ),
                              'inlineChildrenAllowed' => false,
                              'childrenRequired' => false,
                              'isInline' => false,
                              'attributes' => array( 'class', 'align', 'xhtml:width', 'xhtml:colspan', 'xhtml:rowspan' ) ),

        'ol'        => array( 'blockChildrenAllowed' => array( 'li' ),
                              'inlineChildrenAllowed' => false,
                              'childrenRequired' => true,
                              'isInline' => false,
                              'attributes' => array( 'class' ) ),

        'ul'        => array( 'blockChildrenAllowed' => array( 'li' ),
                              'inlineChildrenAllowed' => false,
                              'childrenRequired' => true,
                              'isInline' => false,
                              'attributes' => array( 'class' ) ),

        'li'        => array( 'blockChildrenAllowed' => array( 'paragraph' ),
                              'inlineChildrenAllowed' => false,
                              'childrenRequired' => true,
                              'isInline' => false,
                              'attributes' => array( 'class' ) ),

        'header'    => array( 'blockChildrenAllowed' => array( 'line' ),
                              'inlineChildrenAllowed' => true,
                              'childrenRequired' => true,
                              'isInline' => false,
                              'attributes' => array( 'class', 'anchor_name', 'align' ) ),

        'paragraph' => array( 'blockChildrenAllowed' => array( 'line', 'link', 'embed', 'table', 'ol', 'ul', 'custom', 'literal' ),
                              'inlineChildrenAllowed' => true,
                              'childrenRequired' => true,
                              'isInline' => false,
                              'attributes' => array( 'class', 'align' ) ),

        'line'      => array( 'blockChildrenAllowed' => false,
                              'inlineChildrenAllowed' => true,
                              'childrenRequired' => true,
                              'isInline' => false,
                              'attributes' => false ),

        'literal'   => array( 'blockChildrenAllowed' => false,
                              'inlineChildrenAllowed' => array( '#text' ),
                              'childrenRequired' => true,
                              'isInline' => false,
                              'attributes' => array( 'class' ) ),

        'strong'    => array( 'blockChildrenAllowed' => false,
                              'inlineChildrenAllowed' => true,
                              'childrenRequired' => true,
                              'isInline' => true,
                              'attributes' => array( 'class' ) ),

        'emphasize' => array( 'blockChildrenAllowed' => false,
                              'inlineChildrenAllowed' => true,
                              'childrenRequired' => true,
                              'isInline' => true,
                              'attributes' => array( 'class' ) ),

        'link'      => array( 'blockChildrenAllowed' => false,
                              'inlineChildrenAllowed' => true,
                              'childrenRequired' => true,
                              'isInline' => true,
                              'attributes' => array( 'class', 'xhtml:id', 'target', 'xhtml:title',
                                                     'object_id', 'node_id', 'show_path', 'anchor_name',
                                                     'url_id', 'id', 'view' ),
                              'attributesDefaults' => array( 'target' => '_self' ) ),

        'anchor'    => array( 'blockChildrenAllowed' => false,
                              'inlineChildrenAllowed' => false,
                              'childrenRequired' => false,
                              'isInline' => true,
                              'attributes' => array( 'name' ) ),

        'custom'    => array( 'blockChildrenAllowed' => true,
                              'inlineChildrenAllowed' => true,
                              'childrenRequired' => false,
                              'isInline' => null,
                              'attributes' => array( 'name', 'align' ) ),

        '#text'     => array( 'blockChildrenAllowed' => false,
                              'inlineChildrenAllowed' => false,
                              'childrenRequired' => false,
                              'isInline' => true,
                              'attributes' => false )
    );

    function eZXMLSchema()
    {
        $ini = eZINI::instance( 'content.ini' );

        // Get inline custom tags list
        $this->Schema['custom']['isInline'] = $ini->variable( 'CustomTagSettings', 'IsInline' );
        if ( !is_array( $this->Schema['custom']['isInline'] ) )
            $this->Schema['custom']['isInline'] = array();

        $this->Schema['custom']['tagList'] = $ini->variable( 'CustomTagSettings', 'AvailableCustomTags' );
        if ( !is_array( $this->Schema['custom']['tagList'] ) )
            $this->Schema['custom']['tagList'] = array();

        $eZPublishVersion = eZPublishSDK::majorVersion() + eZPublishSDK::minorVersion() * 0.1;

        // Get all tags available classes list
        foreach( array_keys( $this->Schema ) as $tagName )
        {
            if ( $ini->hasVariable( $tagName, 'AvailableClasses' ) )
            {
                $avail = $ini->variable( $tagName, 'AvailableClasses' );
                if ( is_array( $avail ) && count( $avail ) )
                    $this->Schema[$tagName]['classesList'] = $avail;
                else
                    $this->Schema[$tagName]['classesList'] = array();
            }
            else
                $this->Schema[$tagName]['classesList'] = array();
        }


        // Fix for empty paragraphs setting
        $allowEmptyParagraph = $ini->variable( 'paragraph', 'AllowEmpty' );
        $this->Schema['paragraph']['childrenRequired'] = $allowEmptyParagraph == 'true' ? false : true;

        // Get all tags custom attributes list
        $ini = eZINI::instance( 'content.ini' );
        foreach( array_keys( $this->Schema ) as $tagName )
        {
            if ( $tagName == 'custom' )
            {
                // Custom attributes of custom tags
                foreach( $this->Schema['custom']['tagList'] as $customTagName )
                {
                    if ( $ini->hasVariable( $customTagName, 'CustomAttributes' ) )
                    {
                        $avail = $ini->variable( $customTagName, 'CustomAttributes' );
                        if ( is_array( $avail ) && count( $avail ) )
                            $this->Schema['custom']['customAttributes'][$customTagName] = $avail;
                        else
                            $this->Schema['custom']['customAttributes'][$customTagName] = array();
                    }
                    else
                        $this->Schema['custom']['customAttributes'][$customTagName] = array();
                }
            }
            else
            {
                // Custom attributes of regular tags
                if ( $ini->hasVariable( $tagName, 'CustomAttributes' ) )
                {
                    $avail = $ini->variable( $tagName, 'CustomAttributes' );
                    if ( is_array( $avail ) && count( $avail ) )
                        $this->Schema[$tagName]['customAttributes'] = $avail;
                    else
                        $this->Schema[$tagName]['customAttributes'] = array();
                }
                else
                    $this->Schema[$tagName]['customAttributes'] = array();
            }
        }
    }

    /**
     * Returns a shared instance of the eZXMLSchema class.
     *
     * @return eZXMLSchema
     */
    static function instance()
    {
        if ( empty( $GLOBALS["eZXMLSchemaGlobalInstance"] ) )
        {
            $GLOBALS["eZXMLSchemaGlobalInstance"] = new eZXMLSchema();
        }

        return $GLOBALS["eZXMLSchemaGlobalInstance"];
    }

    // Determines if the tag is inline
    function isInline( $element )
    {
        if ( is_string( $element ) )
            $elementName = $element;
        else
            $elementName = $element->nodeName;

        $isInline = $this->Schema[$elementName]['isInline'];

        // Special workaround for custom tags.
        if ( is_array( $isInline ) && !is_string( $element ) )
        {
            $isInline = false;
            $name = $element->getAttribute( 'name' );

            if ( isset( $this->Schema['custom']['isInline'][$name] ) )
            {
                if ( $this->Schema['custom']['isInline'][$name] != 'false' )
                    $isInline = true;
            }
        }
        return $isInline;
    }

    /*!
       Checks if one element is allowed to be a child of another

       \param $parent   parent element: DOMNode or string
       \param $child    child element: DOMNode or string

       \return true  if elements match schema
       \return false if elements don't match schema
       \return null  in case of errors
    */

    function check( $parent, $child )
    {
        if ( is_string( $parent ) )
            $parentName = $parent;
        else
            $parentName = $parent->nodeName;

        if ( is_string( $child ) )
            $childName = $child;
        else
            $childName = $child->nodeName;

        if ( isset( $this->Schema[$childName] ) )
        {
            $isInline = $this->isInline( $child );

            if ( $isInline === true )
            {
                $allowed = $this->Schema[$parentName]['inlineChildrenAllowed'];
            }
            elseif ( $isInline === false )
            {
                // Special workaround for custom tags.
                if ( $parentName == 'custom' && !is_string( $parent ) &&
                     $parent->getAttribute( 'inline' ) != 'true' )
                {
                    $allowed = true;
                }
                else
                    $allowed = $this->Schema[$parentName]['blockChildrenAllowed'];
            }
            else
                return true;

            if ( is_array( $allowed ) )
                $allowed = in_array( $childName, $allowed );

            if ( !$allowed )
                return false;
        }
        else
        {
            return null;
        }
        return true;
    }

    function childrenRequired( $element )
    {
        //if ( !isset( $this->Schema[$element->nodeName] ) )
        //    return false;

        return $this->Schema[$element->nodeName]['childrenRequired'];
    }

    function hasAttributes( $element )
    {
        //if ( !isset( $this->Schema[$element->nodeName] ) )
        //    return false;

        return ( $this->Schema[$element->nodeName]['attributes'] != false );
    }

    function attributes( $element )
    {
        return $this->Schema[$element->nodeName]['attributes'];
    }

    function customAttributes( $element )
    {
        if ( is_string( $element ) )
        {
            return $this->Schema[$element]['customAttributes'];
        }
        else
        {
            if ( $element->nodeName == 'custom' )
            {
                $name = $element->getAttribute( 'name' );
                if ( $name )
                    return $this->Schema['custom']['customAttributes'][$name];
            }
            else
            {
                return $this->Schema[$element->nodeName]['customAttributes'];
            }
        }
        return array();
    }

    function attrDefaultValue( $tagName, $attrName )
    {
        if ( isset( $this->Schema[$tagName]['attributesDefaults'][$attrName] ) )
            return $this->Schema[$tagName]['attributesDefaults'][$attrName];
        else
            return array();
    }

    function attrDefaultValues( $tagName )
    {
        if ( isset( $this->Schema[$tagName]['attributesDefaults'] ) )
            return $this->Schema[$tagName]['attributesDefaults'];
        else
            return array();
    }

    function exists( $element )
    {
        if ( is_string( $element ) )
        {
            return isset( $this->Schema[$element] );
        }
        else
        {
            if ( $element->nodeName == 'custom' )
            {
                $name = $element->getAttribute( 'name' );
                if ( $name )
                    return in_array( $name, $this->Schema['custom']['tagList'] );
            }
            else
            {
                return isset( $this->Schema[$element->nodeName] );
            }
        }
        return false;
    }

    function availableElements()
    {
        return array_keys( $this->Schema );
    }

    function getClassesList( $tagName )
    {
        if ( isset( $this->Schema[$tagName]['classesList'] ) )
            return $this->Schema[$tagName]['classesList'];
        else
            return array();
    }

    function addAvailableClass( $tagName, $class )
    {
        if ( !isset( $this->Schema[$tagName]['classesList'] ) )
            $this->Schema[$tagName]['classesList'] = array();

        $this->Schema[$tagName]['classesList'][] = $class;
    }

    function addCustomAttribute( $element, $attrName )
    {
        if ( is_string( $element ) )
        {
            $this->Schema[$element]['customAttributes'][] = $attrName;
        }
        else
        {
            if ( $element->nodeName == 'custom' )
            {
                $name = $element->getAttribute( 'name' );
                if ( $name )
                    $this->Schema['custom']['customAttributes'][$name][] = $attrName;
            }
            else
            {
                $this->Schema[$element->nodeName]['customAttributes'][] = $attrName;
            }
        }
    }
}
?>
