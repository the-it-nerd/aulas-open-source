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
use SnapPoints\Loyalty\Api\Data\LogInterface;
use SnapPoints\Loyalty\Api\Data\LogInterfaceFactory;
use SnapPoints\Loyalty\Api\Data\LogSearchResultsInterfaceFactory;
use SnapPoints\Loyalty\Api\LogRepositoryInterface;
use SnapPoints\Loyalty\Model\ResourceModel\Log as ResourceLog;
use SnapPoints\Loyalty\Model\ResourceModel\Log\CollectionFactory as LogCollectionFactory;

class LogRepository implements LogRepositoryInterface
{

    /**
     * @var ResourceLog
     */
    protected $resource;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var Log
     */
    protected $searchResultsFactory;

    /**
     * @var LogCollectionFactory
     */
    protected $logCollectionFactory;

    /**
     * @var LogInterfaceFactory
     */
    protected $logFactory;


    /**
     * @param ResourceLog $resource
     * @param LogInterfaceFactory $logFactory
     * @param LogCollectionFactory $logCollectionFactory
     * @param LogSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceLog $resource,
        LogInterfaceFactory $logFactory,
        LogCollectionFactory $logCollectionFactory,
        LogSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->logFactory = $logFactory;
        $this->logCollectionFactory = $logCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(LogInterface $log)
    {
        try {
            $this->resource->save($log);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the log: %1',
                $exception->getMessage()
            ));
        }
        return $log;
    }

    /**
     * @inheritDoc
     */
    public function get($logId)
    {
        $log = $this->logFactory->create();
        $this->resource->load($log, $logId);
        if (!$log->getId()) {
            throw new NoSuchEntityException(__('log with id "%1" does not exist.', $logId));
        }
        return $log;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->logCollectionFactory->create();
        
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
    public function delete(LogInterface $log)
    {
        try {
            $logModel = $this->logFactory->create();
            $this->resource->load($logModel, $log->getLogId());
            $this->resource->delete($logModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the log: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($logId)
    {
        return $this->delete($this->get($logId));
    }
}

