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
use SnapPoints\Loyalty\Api\Data\RatesInterface;
use SnapPoints\Loyalty\Api\Data\RatesInterfaceFactory;
use SnapPoints\Loyalty\Api\Data\RatesSearchResultsInterfaceFactory;
use SnapPoints\Loyalty\Api\RatesRepositoryInterface;
use SnapPoints\Loyalty\Model\ResourceModel\Rates as ResourceRates;
use SnapPoints\Loyalty\Model\ResourceModel\Rates\CollectionFactory as RatesCollectionFactory;

class RatesRepository implements RatesRepositoryInterface
{

    /**
     * @var RatesInterfaceFactory
     */
    protected $ratesFactory;

    /**
     * @var RatesCollectionFactory
     */
    protected $ratesCollectionFactory;

    /**
     * @var Rates
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var ResourceRates
     */
    protected $resource;


    /**
     * @param ResourceRates $resource
     * @param RatesInterfaceFactory $ratesFactory
     * @param RatesCollectionFactory $ratesCollectionFactory
     * @param RatesSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceRates $resource,
        RatesInterfaceFactory $ratesFactory,
        RatesCollectionFactory $ratesCollectionFactory,
        RatesSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->ratesFactory = $ratesFactory;
        $this->ratesCollectionFactory = $ratesCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(RatesInterface $rates)
    {
        try {
            $this->resource->save($rates);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the rates: %1',
                $exception->getMessage()
            ));
        }
        return $rates;
    }

    /**
     * @inheritDoc
     */
    public function get($ratesId)
    {
        $rates = $this->ratesFactory->create();
        $this->resource->load($rates, $ratesId);
        if (!$rates->getId()) {
            throw new NoSuchEntityException(__('rates with id "%1" does not exist.', $ratesId));
        }
        return $rates;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->ratesCollectionFactory->create();
        
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
    public function delete(RatesInterface $rates)
    {
        try {
            $ratesModel = $this->ratesFactory->create();
            $this->resource->load($ratesModel, $rates->getRatesId());
            $this->resource->delete($ratesModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the rates: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($ratesId)
    {
        return $this->delete($this->get($ratesId));
    }
}

