<?php
/**
 * File containing the eZMatrixType class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  \class eZMatrixType ezmatrixtype.php
  \ingroup eZDatatype
  \brief The class eZMatrixType does

*/

class eZMatrixType extends eZDataType
{
    const DEFAULT_NAME_VARIABLE = '_ezmatrix_default_name_';

    const NUM_COLUMNS_VARIABLE = '_ezmatrix_default_num_columns_';
    const NUM_ROWS_VARIABLE = '_ezmatrix_default_num_rows_';
    const CELL_VARIABLE = '_ezmatrix_cell_';
    const DATA_TYPE_STRING = 'ezmatrix';

    /*!
     Constructor
    */
    function eZMatrixType()
    {
        $this->eZDataType( self::DATA_TYPE_STRING, ezpI18n::tr( 'kernel/classes/datatypes', 'Matrix', 'Datatype name' ),
                           array( 'serialize_supported' => true ) );
    }

    /*!
     Validates the input and returns true if the input was
     valid for this datatype.
    */
    function validateObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        $data = false;
        if ( $http->hasPostVariable( $base . '_ezmatrix_cell_' . $contentObjectAttribute->attribute( 'id' ) ) )
            $data = $http->PostVariable( $base . '_ezmatrix_cell_' . $contentObjectAttribute->attribute( 'id' ) );
        $count = 0;
        for ( $i = 0; $i < count( $data ); ++$i )
             if ( trim( $data[$i] ) <> '' )
             {
                 ++$count;
                 break;
             }
        if ( $contentObjectAttribute->validateIsRequired() and ( $count == 0 or $data === false ) )
        {
            $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes',
                                                                 'Missing matrix input.' ) );
            return eZInputValidator::STATE_INVALID;
        }
        return eZInputValidator::STATE_ACCEPTED;
    }

    /*!
     Store content
    */
    function storeObjectAttribute( $contentObjectAttribute )
    {
        $matrix = $contentObjectAttribute->content();
        $contentObjectAttribute->setAttribute( 'data_text', $matrix->xmlString() );
        $matrix->decodeXML( $contentObjectAttribute->attribute( 'data_text' ) );
        $contentObjectAttribute->setContent( $matrix );
    }

    function storeClassAttribute( $contentClassAttribute, $version )
    {
        $matrixDefinition = $contentClassAttribute->content();
        $contentClassAttribute->setAttribute( 'data_text5', $matrixDefinition->xmlString() );
        $matrixDefinition->decodeClassAttribute( $contentClassAttribute->attribute( 'data_text5' ) );
        $contentClassAttribute->setContent(  $matrixDefinition );
    }

    /*!
     Returns the content.
    */
    function objectAttributeContent( $contentObjectAttribute )
    {
        $matrix = new eZMatrix( '' );

        $matrix->decodeXML( $contentObjectAttribute->attribute( 'data_text' ) );

        return $matrix;
    }

    function hasObjectAttributeContent( $contentObjectAttribute )
    {
        $matrix = $contentObjectAttribute->content();
        $columnsArray = $matrix->attribute( 'columns' );
        $columns = $columnsArray['sequential'];
        $count = 0;
        foreach ( $columns as $column )
        {
            $count += count( $column['rows'] );
        }
        return $count > 0;
    }

    /*!
     Returns the meta data used for storing search indeces.
    */
    function metaData( $contentObjectAttribute )
    {
        $matrix = $contentObjectAttribute->content();
        $columnsArray = $matrix->attribute( 'columns' );
        $columns = $columnsArray['sequential'];
        $metaDataArray = array();
        foreach ( $columns as $column )
        {
            $rows = $column['rows'];
            foreach ( $rows as $row )
            {
                $metaDataArray[] = array( 'id' => $column['identifier'],
                                          'text' => $row );
            }
        }
        return $metaDataArray;
    }

    /*!
     Fetches the http post var matrix cells input and stores it in the data instance.
    */
    function fetchObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        $cellsVarName = $base . self::CELL_VARIABLE . $contentObjectAttribute->attribute( 'id' );
        if ( $http->hasPostVariable( $cellsVarName ) )
        {
            $cells = array();
            foreach ( $http->postVariable( $cellsVarName ) as $cell )
            {
                $cells[] = $cell;
            }
            $matrix = $contentObjectAttribute->attribute( 'content' );
            $matrix->Cells = $cells;

            $contentObjectAttribute->setAttribute( 'data_text', $matrix->xmlString() );
            $matrix->decodeXML( $contentObjectAttribute->attribute( 'data_text' ) );
            $contentObjectAttribute->setContent( $matrix );
        }
        return true;
    }

    function customObjectAttributeHTTPAction( $http, $action, $contentObjectAttribute, $parameters )
    {
        switch ( $action )
        {
            case 'new_row' :
            {
                $matrix = $contentObjectAttribute->content( );

                $postvarname = 'ContentObjectAttribute' . '_data_matrix_remove_' . $contentObjectAttribute->attribute( 'id' );
                $addCountName = 'ContentObjectAttribute' . '_data_matrix_add_count_' . $contentObjectAttribute->attribute( 'id' );

                $addCount = 1;
                if ( $http->hasPostVariable( $addCountName ) )
                {
                    $addCount = $http->postVariable( $addCountName );
                }

                if ( $http->hasPostVariable( $postvarname ) )
                {
                    $selected = $http->postVariable( $postvarname );
                    $matrix->addRow( $selected[0], $addCount );
                }
                else
                {
                    $matrix->addRow( false, $addCount );
                }

                $contentObjectAttribute->setAttribute( 'data_text', $matrix->xmlString() );
                $matrix->decodeXML( $contentObjectAttribute->attribute( 'data_text' ) );
                $contentObjectAttribute->setContent( $matrix );
                $contentObjectAttribute->store();
            }break;
            case 'remove_selected' :
            {
                $matrix = $contentObjectAttribute->content( );
                $postvarname = 'ContentObjectAttribute' . '_data_matrix_remove_' . $contentObjectAttribute->attribute( 'id' );
                $arrayRemove = $http->postVariable( $postvarname );

                rsort( $arrayRemove );
                foreach ( $arrayRemove as $rowNum)
                {
                    $matrix->removeRow( $rowNum );
                }

                $contentObjectAttribute->setAttribute( 'data_text', $matrix->xmlString() );
                $matrix->decodeXML( $contentObjectAttribute->attribute( 'data_text' ) );
                $contentObjectAttribute->setContent( $matrix );
                $contentObjectAttribute->store();
            }break;
            default :
            {
                eZDebug::writeError( 'Unknown custom HTTP action: ' . $action, 'eZMatrixType' );
            }break;
        }
    }

    /*!
     Returns the integer value.
    */
    function title( $contentObjectAttribute, $name = 'name' )
    {
        $matrix = $contentObjectAttribute->content( );

        $value = $matrix->attribute( $name );

        return $value;
    }

    /*!
     Sets the default value.
    */
    function initializeObjectAttribute( $contentObjectAttribute, $currentVersion, $originalContentObjectAttribute )
    {

        if ( $currentVersion != false )
        {
            $matrix = $originalContentObjectAttribute->content();
            $contentClassAttribute = $contentObjectAttribute->contentClassAttribute();
            // make sure that $matrix contains right columns
            $matrix->adjustColumnsToDefinition( $contentClassAttribute->attribute( 'content' ) );

            $contentObjectAttribute->setAttribute( 'data_text', $matrix->xmlString() );
            $contentObjectAttribute->setContent( $matrix );
        }
        else
        {
            $contentClassAttribute = $contentObjectAttribute->contentClassAttribute();
            $numRows = $contentClassAttribute->attribute( 'data_int1' );
            $matrix = new eZMatrix( '', $numRows, $contentClassAttribute->attribute( 'content' ) );
            // 'default name' is never used => just a stub
            // $matrix->setName( $contentClassAttribute->attribute( 'data_text1' ) );
            $contentObjectAttribute->setAttribute( 'data_text', $matrix->xmlString() );
            $contentObjectAttribute->setContent( $matrix );
        }

    }

    function fetchClassAttributeHTTPInput( $http, $base, $classAttribute )
    {
        // 'default name' is never used => just a stub
        // $defaultValueName = $base . self::DEFAULT_NAME_VARIABLE . $classAttribute->attribute( 'id' );
        $defaultValueName = '';
        $defaultNumColumnsName = $base . self::NUM_COLUMNS_VARIABLE . $classAttribute->attribute( 'id' );
        $defaultNumRowsName = $base . self::NUM_ROWS_VARIABLE . $classAttribute->attribute( 'id' );
        $dataFetched = false;
        // 'default name' is never used => just a stub
        /*
        if ( $http->hasPostVariable( $defaultValueName ) )
        {
            $defaultValueValue = $http->postVariable( $defaultValueName );

            if ( $defaultValueValue == '' )
            {
                $defaultValueValue = '';
            }
            $classAttribute->setAttribute( 'data_text1', $defaultValueValue );
            $dataFetched = true;
        }
        */

        if ( $http->hasPostVariable( $defaultNumRowsName ) )
        {
            $defaultNumRowsValue = $http->postVariable( $defaultNumRowsName );

            if ( $defaultNumRowsValue == '' )
            {
                $defaultNumRowsValue = '1';
            }
            $classAttribute->setAttribute( 'data_int1', $defaultNumRowsValue );
            $dataFetched = true;
        }

        $columnNameVariable = $base . '_data_ezmatrix_column_name_' . $classAttribute->attribute( 'id' );
        $columnIDVariable = $base . '_data_ezmatrix_column_id_' . $classAttribute->attribute( 'id' );


        if ( $http->hasPostVariable( $columnNameVariable ) && $http->hasPostVariable( $columnIDVariable ) )
        {
            $columns = array();
            $i = 0;
            $columnNameList = $http->postVariable( $columnNameVariable );
            $columnIDList = $http->postVariable( $columnIDVariable );

            $matrixDefinition = $classAttribute->attribute( 'content' );
            $columnNames = $matrixDefinition->attribute( 'columns' );
            foreach ( $columnNames as $columnName )
            {
                $columnID = '';
                $name = '';
                $index = $columnName['index'];

                // after adding a new column $columnIDList and $columnNameList doesn't contain values for new column.
                // if so just add column with empty 'name' and 'columnID'.
                if ( isset( $columnIDList[$index] ) && isset( $columnNameList[$index] ) )
                {
                    $columnID = $columnIDList[$index];
                    $name = $columnNameList[$index];
                    if ( strlen( $columnID ) == 0 )
                    {
                        $columnID = $name;
                        // Initialize transformation system
                        $trans = eZCharTransform::instance();
                        $columnID = $trans->transformByGroup( $columnID, 'identifier' );
                    }
                }

                $columns[] = array( 'name' => $name,
                                    'identifier' => $columnID,
                                    'index' => $i );

                $i++;
            }

            $matrixDefinition->ColumnNames = $columns;
            $classAttribute->setContent( $matrixDefinition );
            $classAttribute->setAttribute( 'data_text5', $matrixDefinition->xmlString() );

            $dataFetched = true;
        }
        if ( $dataFetched )
        {
            return true;
        }
        return false;

    }

    function preStoreClassAttribute( $classAttribute, $version )
    {
        $matrixDefinition = $classAttribute->attribute( 'content' );
        $classAttribute->setAttribute( 'data_text5', $matrixDefinition->xmlString() );
    }

    /*!
     Returns the content.
    */
    function classAttributeContent( $contentClassAttribute )
    {
        $matrixDefinition = new eZMatrixDefinition();
        $matrixDefinition->decodeClassAttribute( $contentClassAttribute->attribute( 'data_text5' ) );
        return $matrixDefinition;
    }

    function customClassAttributeHTTPAction( $http, $action, $contentClassAttribute )
    {
        $id = $contentClassAttribute->attribute( 'id' );
        switch ( $action )
        {
            case 'new_ezmatrix_column' :
            {
                $matrixDefinition = $contentClassAttribute->content( );
                $matrixDefinition->addColumn( '' );
                $contentClassAttribute->setContent( $matrixDefinition );
                $contentClassAttribute->store();
            }break;
            case 'remove_selected' :
            {
                $matrixDefinition = $contentClassAttribute->content( );

                $postvarname = 'ContentClass' . '_data_ezmatrix_column_remove_' . $contentClassAttribute->attribute( 'id' );
                $array_remove = $http->postVariable( $postvarname );
                foreach( $array_remove as $columnIndex )
                {
                    $matrixDefinition->removeColumn( $columnIndex );
                }
                $contentClassAttribute->setContent( $matrixDefinition );
            }break;
            default :
            {
                eZDebug::writeError( 'Unknown custom HTTP action: ' . $action, 'eZEnumType' );
            }break;
        }
    }

    function isIndexable()
    {
        return true;
    }

    /*!
     \return string representation of an contentobjectattribute data for simplified export

    */
    function toString( $contentObjectAttribute )
    {
        $matrix = $contentObjectAttribute->attribute( 'content' );
        $matrixArray = array();
        $rows = $matrix->attribute( 'rows' );

        foreach( $rows['sequential'] as $row )
        {
            $matrixArray[] = eZStringUtils::implodeStr( $row['columns'], '|' );
        }

        return eZStringUtils::implodeStr( $matrixArray, '&' );

    }

    function fromString( $contentObjectAttribute, $string )
    {
        $matrix = $contentObjectAttribute->attribute( 'content' );
        $matrix->Cells = array();
        $matrix->Matrix['rows']['sequential'] = array();
        $matrix->NumRows = 0;

        if ( $string != '' )
        {
            $matrixRowsList = eZStringUtils::explodeStr( $string, "&" );
            
            foreach( $matrixRowsList as $key => $value )
            {
                $newCells = eZStringUtils::explodeStr( $value, '|' );
                $matrixArray[] = $newCells;
                $matrix->Cells = array_merge( $matrix->Cells, $newCells );

                $newRow['columns'] = $newCells;
                $newRow['identifier'] =  'row_' . ( $matrix->NumRows + 1 );
                $newRow['name'] = 'Row_' . ( $matrix->NumRows + 1 );
                $matrix->NumRows++;

                $matrix->Matrix['rows']['sequential'][] = $newRow;
            }
        }

        return true;
    }

    function serializeContentClassAttribute( $classAttribute, $attributeNode, $attributeParametersNode )
    {
        $content = $classAttribute->content();
        if ( $content )
        {
            $defaultName = $classAttribute->attribute( 'data_text1' );
            $defaultRowCount = $classAttribute->attribute( 'data_int1' );
            $columns = $content->attribute( 'columns' );

            $dom = $attributeParametersNode->ownerDocument;
            $defaultNameNode = $dom->createElement( 'default-name' );
            $defaultNameNode->appendChild( $dom->createTextNode( $defaultName ) );
            $attributeParametersNode->appendChild( $defaultNameNode );
            $defaultRowCountNode = $dom->createElement( 'default-row-count' );
            $defaultRowCountNode->appendChild( $dom->createTextNode( $defaultRowCount ) );
            $attributeParametersNode->appendChild( $defaultRowCountNode );
            $columnsNode = $dom->createElement( 'columns' );
            $attributeParametersNode->appendChild( $columnsNode );
            foreach ( $columns as $column )
            {
                unset( $columnNode );
                $columnNode = $dom->createElement( 'column' );
                $columnNode->setAttribute( 'name', $column['name'] );
                $columnNode->setAttribute( 'identifier', $column['identifier'] );
                $columnNode->setAttribute( 'index', $column['index'] );
                $columnsNode->appendChild( $columnNode );
            }
        }
    }

    function unserializeContentClassAttribute( $classAttribute, $attributeNode, $attributeParametersNode )
    {
        $defaultName = $attributeParametersNode->getElementsByTagName( 'default-name' )->item( 0 )->textContent;
        $defaultRowCount = $attributeParametersNode->getElementsByTagName( 'default-row-count' )->item( 0 )->textContent;
        $classAttribute->setAttribute( 'data_text1', $defaultName );
        $classAttribute->setAttribute( 'data_int1', $defaultRowCount );

        $matrixDefinition = new eZMatrixDefinition();
        $columnsNode = $attributeParametersNode->getElementsByTagName( 'columns' )->item( 0 );
        $columnsList = $columnsNode->getElementsByTagName( 'column' );
        foreach ( $columnsList  as $columnNode )
        {
            $columnName = $columnNode->getAttribute( 'name' );
            $columnIdentifier = $columnNode->getAttribute( 'identifier' );
            $matrixDefinition->addColumn( $columnName, $columnIdentifier );
        }
        $classAttribute->setContent( $matrixDefinition );
    }

    function serializeContentObjectAttribute( $package, $objectAttribute )
    {
        $node = $this->createContentObjectAttributeDOMNode( $objectAttribute );

        $dom = new DOMDocument( '1.0', 'utf-8' );
        $success = $dom->loadXML( $objectAttribute->attribute( 'data_text' ) );

        $importedRoot = $node->ownerDocument->importNode( $dom->documentElement, true );
        $node->appendChild( $importedRoot );

        return $node;
    }

    function unserializeContentObjectAttribute( $package, $objectAttribute, $attributeNode )
    {
        $rootNode = $attributeNode->getElementsByTagName( 'ezmatrix' )->item( 0 );
        $xmlString = $rootNode ? $rootNode->ownerDocument->saveXML( $rootNode ) : '';
        $objectAttribute->setAttribute( 'data_text', $xmlString );
    }

    function supportsBatchInitializeObjectAttribute()
    {
        return true;
    }

    function batchInitializeObjectAttributeData( $classAttribute )
    {
        $numRows = $classAttribute->attribute( 'data_int1' );
        $matrix = new eZMatrix( '', $numRows, $classAttribute->attribute( 'content' ) );
        $db = eZDB::instance();
        return array( 'data_text' => "'" . $db->escapeString( $matrix->xmlString() ) . "'" );
    }
}

eZDataType::register( eZMatrixType::DATA_TYPE_STRING, 'ezmatrixtype' );

?>
