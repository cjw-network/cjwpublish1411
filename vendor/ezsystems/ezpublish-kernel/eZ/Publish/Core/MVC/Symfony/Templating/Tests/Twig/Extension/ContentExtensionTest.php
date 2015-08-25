<?php
/**
 * File containing the ContentExtensionIntegrationTest class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\MVC\Symfony\Templating\Tests\Twig\Extension;

use eZ\Publish\Core\MVC\Symfony\Templating\Twig\Extension\ContentExtension;
use eZ\Publish\Core\Helper\TranslationHelper;
use eZ\Publish\Core\Repository\Values\ContentType\FieldDefinition;
use eZ\Publish\Core\Repository\Values\ContentType\ContentType;
use eZ\Publish\Core\Repository\Values\Content\Content;
use eZ\Publish\Core\Repository\Values\Content\VersionInfo;
use eZ\Publish\API\Repository\Values\Content\ContentInfo;
use eZ\Publish\API\Repository\Values\Content\Field;

/**
 * Integration tests for ContentExtension templates
 *
 * Tests ContentExtension in context of site with "fre-FR, eng-US" configured as languages.
 *
 * @package eZ\Publish\Core\MVC\Symfony\Templating\Tests\Twig\Extension
 */
class ContentExtensionIntegrationTest extends FileSystemTwigIntegrationTestCase
{
    /**
     * @var \eZ\Publish\API\Repository\ContentTypeService|\PHPUnit_Framework_MockObject_MockObject
     */
    private $fieldHelperMock;

    public function getExtensions()
    {
        $configResolver = $this->getConfigResolverMock();
        $this->fieldHelperMock = $this->getMockBuilder( 'eZ\\Publish\\Core\\Helper\\FieldHelper' )
            ->disableOriginalConstructor()->getMock();

        return array(
            new ContentExtension(
                $this->getRepositoryMock(),
                $configResolver,
                $this->getMock( 'eZ\\Publish\\Core\\MVC\\Symfony\\FieldType\\View\\ParameterProviderRegistryInterface' ),
                $this->getMockBuilder( 'eZ\Publish\Core\FieldType\XmlText\Converter\Html5' )->disableOriginalConstructor()->getMock(),
                $this->getMockBuilder( 'eZ\\Publish\\Core\\FieldType\\RichText\\Converter' )->disableOriginalConstructor()->getMock(),
                $this->getMockBuilder( 'eZ\\Publish\\Core\\FieldType\\RichText\\Converter' )->disableOriginalConstructor()->getMock(),
                $this->getMock( 'eZ\Publish\SPI\Variation\VariationHandler' ),
                new TranslationHelper(
                    $configResolver,
                    $this->getMock( 'eZ\\Publish\\API\\Repository\\ContentService' ),
                    array(),
                    $this->getMock( 'Psr\Log\LoggerInterface' )
                ),
                $this->fieldHelperMock
            )
        );
    }

    public function getFixturesDir()
    {
        return dirname( __FILE__ ) . '/_fixtures/content_functions/';
    }

    public function getFieldDefinition( $typeIdentifier, $id = null, $settings = array() )
    {
        return new FieldDefinition(
            array(
                'id' => $id,
                'fieldSettings' => $settings,
                'fieldTypeIdentifier' => $typeIdentifier
            )
        );
    }

    public $fieldDefinitions = array();

    /**
     * Creates content with initial/main language being fre-FR
     *
     * @param string $contentTypeIdentifier
     * @param array $fieldsData
     * @param array $namesData
     *
     * @return Content
     */
    protected function getContent( $contentTypeIdentifier, array $fieldsData, array $namesData = array() )
    {
        $fields = array();
        foreach ( $fieldsData as $fieldTypeIdentifier => $fieldsArray )
        {
            $fieldsArray = isset( $fieldsArray['id'] ) ? array( $fieldsArray ) : $fieldsArray;
            foreach ( $fieldsArray as $fieldInfo )
            {
                // Save field definitions in property for mocking purposes
                $this->fieldDefinitions[$contentTypeIdentifier][$fieldInfo['fieldDefIdentifier']] = new FieldDefinition(
                    array(
                        'identifier' => $fieldInfo['fieldDefIdentifier'],
                        'id' => $fieldInfo['id'],
                        'fieldTypeIdentifier' => $fieldTypeIdentifier,
                        'names' => isset( $fieldInfo['fieldDefNames'] ) ? $fieldInfo['fieldDefNames'] : array(),
                        'descriptions' => isset( $fieldInfo['fieldDefDescriptions'] ) ? $fieldInfo['fieldDefDescriptions'] : array()
                    )
                );
                unset( $fieldInfo['fieldDefNames'], $fieldInfo['fieldDefDescriptions'] );
                $fields[] = new Field( $fieldInfo );
            }
        }
        $content = new Content(
            array(
                'internalFields' => $fields,
                'versionInfo' => new VersionInfo(
                    array(
                        'versionNo' => 64,
                        'names' => $namesData,
                        'initialLanguageCode' => 'fre-FR',
                        'contentInfo' => new ContentInfo(
                            array(
                                'id' => 42,
                                'mainLanguageCode' => 'fre-FR',
                                // Using as id as we don't really care to test the service here
                                'contentTypeId' => $contentTypeIdentifier
                            )
                        )
                    )
                )
            )
        );

        return $content;

    }

    protected function getField( $isEmpty )
    {
        $field = new Field( array( 'fieldDefIdentifier' => 'testfield', 'value' => null ) );

        $this->fieldHelperMock
            ->expects( $this->once() )
            ->method( 'isFieldEmpty' )
            ->will( $this->returnValue( $isEmpty ) );

        return $field;
    }

    private function getTemplatePath( $tpl )
    {
        return 'templates/' . $tpl;
    }

    private function getConfigResolverMock()
    {
        $mock = $this->getMock(
            'eZ\\Publish\\Core\\MVC\\ConfigResolverInterface'
        );
        // Signature: ConfigResolverInterface->getParameter( $paramName, $namespace = null, $scope = null )
        $mock->expects( $this->any() )
            ->method( 'getParameter' )
            ->will(
                $this->returnValueMap(
                    array(
                        array(
                            'languages',
                            null,
                            null,
                            array( 'fre-FR', 'eng-US' )
                        ),
                        array(
                            'field_templates',
                            null,
                            null,
                            array(
                                array(
                                    'template' => $this->getTemplatePath( 'fields_override1.html.twig' ),
                                    'priority' => 10
                                ),
                                array(
                                    'template' => $this->getTemplatePath( 'fields_default.html.twig' ),
                                    'priority' => 0
                                ),
                                array(
                                    'template' => $this->getTemplatePath( 'fields_override2.html.twig' ),
                                    'priority' => 20
                                ),
                            )
                        ),
                        array(
                            'fielddefinition_settings_templates',
                            null,
                            null,
                            array(
                                array(
                                    'template' => $this->getTemplatePath( 'settings_override1.html.twig' ),
                                    'priority' => 10
                                ),
                                array(
                                    'template' => $this->getTemplatePath( 'settings_default.html.twig' ),
                                    'priority' => 0
                                ),
                                array(
                                    'template' => $this->getTemplatePath( 'settings_override2.html.twig' ),
                                    'priority' => 20
                                ),
                            )
                        )
                    )
                )
            );
        return $mock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getRepositoryMock()
    {
        $mock = $this->getMock( "eZ\\Publish\\API\\Repository\\Repository" );

        $mock->expects( $this->any() )
            ->method( "getContentTypeService" )
            ->will( $this->returnValue( $this->getContentTypeServiceMock() ) );

        return $mock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getContentTypeServiceMock()
    {
        $mock = $this->getMock( "eZ\\Publish\\API\\Repository\\ContentTypeService" );

        $context = $this;
        $mock->expects( $this->any() )
            ->method( "loadContentType" )
            ->will(
                $this->returnCallback(
                    function ( $contentTypeId ) use ( $context )
                    {
                        return new ContentType(
                            array(
                                'identifier' => $contentTypeId,
                                'mainLanguageCode' => 'fre-FR',
                                'fieldDefinitions' => $context->fieldDefinitions[$contentTypeId]
                            )
                        );
                    }
                )
            );

        return $mock;
    }
}
