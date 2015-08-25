<?php
/**
 * File containing the Legacy Storage Handler
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\Persistence\Legacy;

use eZ\Publish\SPI\Persistence\Handler as HandlerInterface;
use eZ\Publish\SPI\Persistence\Content\Handler as ContentHandler;
use eZ\Publish\SPI\Persistence\Content\Language\Handler as LanguageHandler;
use eZ\Publish\SPI\Persistence\Content\Location\Handler as LocationHandler;
use eZ\Publish\SPI\Search\Location\Handler as LocationSearchHandler;
use eZ\Publish\SPI\Persistence\Content\Location\Trash\Handler as TrashHandler;
use eZ\Publish\SPI\Persistence\Content\ObjectState\Handler as ObjectStateHandler;
use eZ\Publish\SPI\Search\Handler as ContentSearchHandler;
use eZ\Publish\SPI\Persistence\Content\Section\Handler as SectionHandler;
use eZ\Publish\SPI\Persistence\Content\Type\Handler as ContentTypeHandler;
use eZ\Publish\SPI\Persistence\Content\UrlAlias\Handler as UrlAliasHandler;
use eZ\Publish\SPI\Persistence\Content\UrlWildcard\Handler as UrlWildcardHandler;
use eZ\Publish\SPI\Persistence\User\Handler as UserHandler;
use eZ\Publish\SPI\Persistence\TransactionHandler as SPITransactionHandler;

/**
 * The main handler for Legacy Storage Engine
 */
class Handler implements HandlerInterface
{
    /**
     * @var \eZ\Publish\SPI\Persistence\Content\Handler
     */
    protected $contentHandler;

    /**
     * @var \eZ\Publish\SPI\Search\Handler
     */
    protected $contentSearchHandler;

    /**
     * @var \eZ\Publish\SPI\Persistence\Content\Type\Handler
     */
    protected $contentTypeHandler;

    /**
     * @var \eZ\Publish\SPI\Persistence\Content\Language\Handler
     */
    protected $languageHandler;

    /**
     * @var \eZ\Publish\SPI\Persistence\Content\Location\Handler
     */
    protected $locationHandler;

    /**
     * @var \eZ\Publish\SPI\Search\Location\Handler
     */
    protected $locationSearchHandler;

    /**
     * @var \eZ\Publish\SPI\Persistence\Content\ObjectState\Handler
     */
    protected $objectStateHandler;

    /**
     * @var \eZ\Publish\SPI\Persistence\Content\Section\Handler
     */
    protected $sectionHandler;

    /**
     * @var \eZ\Publish\SPI\Persistence\TransactionHandler
     */
    protected $transactionHandler;

    /**
     * @var \eZ\Publish\SPI\Persistence\Content\Location\Trash\Handler
     */
    protected $trashHandler;

    /**
     * @var \eZ\Publish\SPI\Persistence\Content\UrlAlias\Handler
     */
    protected $urlAliasHandler;

    /**
     * @var \eZ\Publish\SPI\Persistence\Content\UrlWildcard\Handler
     */
    protected $urlWildcardHandler;

    /**
     * @var \eZ\Publish\SPI\Persistence\User\Handler
     */
    protected $userHandler;

    public function __construct(
        ContentHandler $contentHandler,
        ContentSearchHandler $contentSearchHandler,
        ContentTypeHandler $contentTypeHandler,
        LanguageHandler $languageHandler,
        LocationHandler $locationHandler,
        LocationSearchHandler $locationSearchHandler,
        ObjectStateHandler $objectStateHandler,
        SectionHandler $sectionHandler,
        SPITransactionHandler $transactionHandler,
        TrashHandler $trashHandler,
        UrlAliasHandler $urlAliasHandler,
        UrlWildcardHandler $urlWildcardHandler,
        UserHandler $userHandler
    )
    {
        $this->contentHandler = $contentHandler;
        $this->contentSearchHandler = $contentSearchHandler;
        $this->contentTypeHandler = $contentTypeHandler;
        $this->languageHandler = $languageHandler;
        $this->locationHandler = $locationHandler;
        $this->locationSearchHandler = $locationSearchHandler;
        $this->objectStateHandler = $objectStateHandler;
        $this->sectionHandler = $sectionHandler;
        $this->transactionHandler = $transactionHandler;
        $this->trashHandler = $trashHandler;
        $this->urlAliasHandler = $urlAliasHandler;
        $this->urlWildcardHandler = $urlWildcardHandler;
        $this->userHandler = $userHandler;

    }

    public function contentHandler()
    {
        return $this->contentHandler;
    }

    public function searchHandler()
    {
        return $this->contentSearchHandler;
    }

    public function contentTypeHandler()
    {
        return $this->contentTypeHandler;
    }

    public function contentLanguageHandler()
    {
        return $this->languageHandler;
    }

    public function locationHandler()
    {
        return $this->locationHandler;
    }

    public function locationSearchHandler()
    {
        return $this->locationSearchHandler;
    }

    public function objectStateHandler()
    {
        return $this->objectStateHandler;
    }

    public function sectionHandler()
    {
        return $this->sectionHandler;
    }

    public function trashHandler()
    {
        return $this->trashHandler;
    }

    public function urlAliasHandler()
    {
        return $this->urlAliasHandler;
    }

    public function urlWildcardHandler()
    {
        return $this->urlWildcardHandler;
    }

    public function userHandler()
    {
        return $this->userHandler;
    }

    /**
     * @return \eZ\Publish\SPI\Persistence\TransactionHandler
     */
    public function transactionHandler()
    {
        return $this->transactionHandler;
    }

    /**
     * Begin transaction
     *
     * @deprecated Since 5.3 {@use transactionHandler()->beginTransaction()}
     */
    public function beginTransaction()
    {
        $this->transactionHandler->beginTransaction();
    }

    /**
     * Commit transaction
     *
     * Commit transaction, or throw exceptions if no transactions has been started.
     *
     * @throws \RuntimeException If no transaction has been started
     *
     * @deprecated Since 5.3 {@use transactionHandler()->beginTransaction()}
     */
    public function commit()
    {
        $this->transactionHandler->commit();
    }

    /**
     * Rollback transaction
     *
     * Rollback transaction, or throw exceptions if no transactions has been started.
     *
     * @throws \RuntimeException If no transaction has been started
     *
     * @deprecated Since 5.3 {@use transactionHandler()->beginTransaction()}
     */
    public function rollback()
    {
        $this->transactionHandler->rollback();
    }
}