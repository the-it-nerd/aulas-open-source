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
use SnapPoints\Loyalty\Api\Data\TransactionInterface;
use SnapPoints\Loyalty\Api\Data\TransactionInterfaceFactory;
use SnapPoints\Loyalty\Api\Data\TransactionSearchResultsInterface;
use SnapPoints\Loyalty\Api\Data\TransactionSearchResultsInterfaceFactory;
use SnapPoints\Loyalty\Api\TransactionRepositoryInterface;
use SnapPoints\Loyalty\Model\ResourceModel\Transaction as ResourceTransaction;
use SnapPoints\Loyalty\Model\ResourceModel\Transaction\CollectionFactory as TransactionCollectionFactory;

class TransactionRepository implements TransactionRepositoryInterface
{


    /**
     * @param ResourceTransaction $resource
     * @param TransactionIsaventerfaceFactory $transactionFactory
     * @param TransactionCollectionFactory $transactionCollectionFactory
     * @param TransactionSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        protected readonly ResourceTransaction                      $resource,
        protected readonly TransactionInterfaceFactory              $transactionFactory,
        protected readonly TransactionCollectionFactory             $transactionCollectionFactory,
        protected readonly TransactionSearchResultsInterfaceFactory $searchResultsFactory,
        protected readonly CollectionProcessorInterface             $collectionProcessor
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function save(TransactionInterface $transaction): TransactionInterface
    {
        try {
            $this->resource->save($transaction);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the Transaction: %1',
                $exception->getMessage()
            ));
        }
        return $transaction;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        SearchCriteriaInterface $criteria
    ): TransactionSearchResultsInterface
    {
        $collection = $this->transactionCollectionFactory->create();

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
    public function deleteById($transactionId): bool
    {
        return $this->delete($this->get($transactionId));
    }

    /**
     * @inheritDoc
     */
    public function delete(TransactionInterface $transaction): bool
    {
        try {
            $transactionModel = $this->transactionFactory->create();
            $this->resource->load($transactionModel, $transaction->getEntityId());
            $this->resource->delete($transactionModel);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Transaction: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function get($transactionId): TransactionInterface
    {
        $quote = $this->transactionFactory->create();
        $this->resource->load($quote, $transactionId);
        if (!$quote->getId()) {
            throw new NoSuchEntityException(__('Transaction with id "%1" does not exist.', $transactionId));
        }
        return $quote;
    }

    /**
     * @inheritDoc
     */
    public function getByMagentoOrderId(int $orderId): TransactionInterface
    {
        $quote = $this->transactionFactory->create();
        $this->resource->load($quote, $orderId, 'order_id');
        if (!$quote->getEntityId()) {
            throw new NoSuchEntityException(__('Transaction with order id "%1" does not exist.', $orderId));
        }
        return $quote;
    }

}

