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
use SnapPoints\Loyalty\Api\Data\QueueLogInterface;
use SnapPoints\Loyalty\Api\Data\QueueLogInterfaceFactory;
use SnapPoints\Loyalty\Api\Data\QueueLogSearchResultsInterface;
use SnapPoints\Loyalty\Api\Data\QueueLogSearchResultsInterfaceFactory;
use SnapPoints\Loyalty\Api\QueueLogRepositoryInterface;
use SnapPoints\Loyalty\Model\ResourceModel\QueueLog as ResourceQueueLog;
use SnapPoints\Loyalty\Model\ResourceModel\QueueLog\CollectionFactory as QueueLogCollectionFactory;

class QueueLogRepository implements QueueLogRepositoryInterface
{


    /**
     * @param ResourceQueueLog $resource
     * @param QueueLogInterfaceFactory $queueLogFactory
     * @param QueueLogCollectionFactory $queueLogCollectionFactory
     * @param QueueLogSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        protected readonly ResourceQueueLog                      $resource,
        protected readonly QueueLogInterfaceFactory              $queueLogFactory,
        protected readonly QueueLogCollectionFactory             $queueLogCollectionFactory,
        protected readonly QueueLogSearchResultsInterfaceFactory $searchResultsFactory,
        protected readonly CollectionProcessorInterface          $collectionProcessor
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function save(QueueLogInterface $queueLog): QueueLogInterface
    {
        try {
            $this->resource->save($queueLog);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the queueLog: %1',
                $exception->getMessage()
            ));
        }
        return $queueLog;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        SearchCriteriaInterface $criteria
    ): QueueLogSearchResultsInterface
    {
        $collection = $this->queueLogCollectionFactory->create();

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
    public function deleteById($queueLogId): bool
    {
        return $this->delete($this->get($queueLogId));
    }

    /**
     * @inheritDoc
     */
    public function delete(QueueLogInterface $queueLog): bool
    {
        try {
            $queueLogModel = $this->queueLogFactory->create();
            $this->resource->load($queueLogModel, $queueLog->getQueueLogId());
            $this->resource->delete($queueLogModel);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the queue_log: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function get($queueLogId): QueueLogInterface
    {
        $queueLog = $this->queueLogFactory->create();
        $this->resource->load($queueLog, $queueLogId);
        if (!$queueLog->getId()) {
            throw new NoSuchEntityException(__('queue_log with id "%1" does not exist.', $queueLogId));
        }
        return $queueLog;
    }
}

