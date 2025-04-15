<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use SnapPoints\Loyalty\Api\Data\QueueLogInterface;
use SnapPoints\Loyalty\Api\Data\QueueLogInterfaceFactory;
use SnapPoints\Loyalty\Api\Data\QueueLogSearchResultsInterfaceFactory;
use SnapPoints\Loyalty\Api\QueueLogRepositoryInterface;
use SnapPoints\Loyalty\Model\ResourceModel\QueueLog as ResourceQueueLog;
use SnapPoints\Loyalty\Model\ResourceModel\QueueLog\CollectionFactory as QueueLogCollectionFactory;

class QueueLogRepository implements QueueLogRepositoryInterface
{

    /**
     * @var QueueLogInterfaceFactory
     */
    protected $queueLogFactory;

    /**
     * @var ResourceQueueLog
     */
    protected $resource;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var QueueLogCollectionFactory
     */
    protected $queueLogCollectionFactory;

    /**
     * @var QueueLog
     */
    protected $searchResultsFactory;


    /**
     * @param ResourceQueueLog $resource
     * @param QueueLogInterfaceFactory $queueLogFactory
     * @param QueueLogCollectionFactory $queueLogCollectionFactory
     * @param QueueLogSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceQueueLog $resource,
        QueueLogInterfaceFactory $queueLogFactory,
        QueueLogCollectionFactory $queueLogCollectionFactory,
        QueueLogSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->queueLogFactory = $queueLogFactory;
        $this->queueLogCollectionFactory = $queueLogCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(QueueLogInterface $queueLog)
    {
        try {
            $this->resource->save($queueLog);
        } catch (\Exception $exception) {
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
    public function get($queueLogId)
    {
        $queueLog = $this->queueLogFactory->create();
        $this->resource->load($queueLog, $queueLogId);
        if (!$queueLog->getId()) {
            throw new NoSuchEntityException(__('queue_log with id "%1" does not exist.', $queueLogId));
        }
        return $queueLog;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
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
    public function delete(QueueLogInterface $queueLog)
    {
        try {
            $queueLogModel = $this->queueLogFactory->create();
            $this->resource->load($queueLogModel, $queueLog->getQueueLogId());
            $this->resource->delete($queueLogModel);
        } catch (\Exception $exception) {
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
    public function deleteById($queueLogId)
    {
        return $this->delete($this->get($queueLogId));
    }
}

