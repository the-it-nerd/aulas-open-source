<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Model;

use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use SnapPoints\Loyalty\Api\Data\QuoteInterface;
use SnapPoints\Loyalty\Api\Data\QuoteInterfaceFactory;
use SnapPoints\Loyalty\Api\Data\QuoteSearchResultsInterface;
use SnapPoints\Loyalty\Api\Data\QuoteSearchResultsInterfaceFactory;
use SnapPoints\Loyalty\Api\QuoteRepositoryInterface;
use SnapPoints\Loyalty\Model\ResourceModel\Quote as ResourceQuote;
use SnapPoints\Loyalty\Model\ResourceModel\Quote\CollectionFactory as QuoteCollectionFactory;

class QuoteRepository implements QuoteRepositoryInterface
{


    /**
     * @param ResourceQuote $resource
     * @param QuoteInterfaceFactory $quoteFactory
     * @param QuoteCollectionFactory $QuoteCollectionFactory
     * @param QuoteSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        protected readonly ResourceQuote                      $resource,
        protected readonly QuoteInterfaceFactory              $quoteFactory,
        protected readonly QuoteCollectionFactory             $QuoteCollectionFactory,
        protected readonly QuoteSearchResultsInterfaceFactory $searchResultsFactory,
        protected readonly CollectionProcessorInterface       $collectionProcessor
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function save(QuoteInterface $quote): QuoteInterface
    {
        try {
            $this->resource->save($quote);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the Quote: %1',
                $exception->getMessage()
            ));
        }
        return $quote;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        SearchCriteriaInterface $criteria
    ): QuoteSearchResultsInterface
    {
        $collection = $this->QuoteCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($quoteId): bool
    {
        return $this->delete($this->get($quoteId));
    }

    /**
     * @inheritDoc
     */
    public function delete(QuoteInterface $quote): bool
    {
        try {
            $quoteModel = $this->quoteFactory->create();
            $this->resource->load($quoteModel, $quote->getEntityId());
            $this->resource->delete($quoteModel);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Quote: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function get($quoteId): QuoteInterface
    {
        $quote = $this->quoteFactory->create();
        $this->resource->load($quote, $quoteId);
        if (!$quote->getId()) {
            throw new NoSuchEntityException(__('Quote with id "%1" does not exist.', $quoteId));
        }
        return $quote;
    }

    /**
     * @inheritDoc
     */
    public function getByMagentoQuoteId(int $quoteId): QuoteInterface
    {
        $quote = $this->quoteFactory->create();
        $this->resource->load($quote, $quoteId, 'quote_id');
        if (!$quote->getId()) {
            throw new NoSuchEntityException(__('Quote with quote id "%1" does not exist.', $quoteId));
        }
        return $quote;
    }
}

