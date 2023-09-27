<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use TheITNerd\SizeGuide\Api\Data\SizeGuideInterfaceFactory;
use TheITNerd\SizeGuide\Api\Data\SizeGuideSearchResultsInterfaceFactory;
use TheITNerd\SizeGuide\Api\SizeGuideRepositoryInterface;
use TheITNerd\SizeGuide\Model\ResourceModel\SizeGuide as ResourceSizeGuide;
use TheITNerd\SizeGuide\Model\ResourceModel\SizeGuide\CollectionFactory as SizeGuideCollectionFactory;

class SizeGuideRepository implements SizeGuideRepositoryInterface
{

    protected $resource;

    protected $sizeGuideFactory;

    protected $sizeGuideCollectionFactory;

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataSizeGuideFactory;

    protected $extensionAttributesJoinProcessor;

    private $storeManager;

    private $collectionProcessor;

    protected $extensibleDataObjectConverter;

    /**
     * @param ResourceSizeGuide $resource
     * @param SizeGuideFactory $sizeGuideFactory
     * @param SizeGuideInterfaceFactory $dataSizeGuideFactory
     * @param SizeGuideCollectionFactory $sizeGuideCollectionFactory
     * @param SizeGuideSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceSizeGuide $resource,
        SizeGuideFactory $sizeGuideFactory,
        SizeGuideInterfaceFactory $dataSizeGuideFactory,
        SizeGuideCollectionFactory $sizeGuideCollectionFactory,
        SizeGuideSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->sizeGuideFactory = $sizeGuideFactory;
        $this->sizeGuideCollectionFactory = $sizeGuideCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataSizeGuideFactory = $dataSizeGuideFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \TheITNerd\SizeGuide\Api\Data\SizeGuideInterface $sizeGuide
    ) {
        /* if (empty($sizeGuide->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $sizeGuide->setStoreId($storeId);
        } */
        
        $sizeGuideData = $this->extensibleDataObjectConverter->toNestedArray(
            $sizeGuide,
            [],
            \TheITNerd\SizeGuide\Api\Data\SizeGuideInterface::class
        );
        
        $sizeGuideModel = $this->sizeGuideFactory->create()->setData($sizeGuideData);
        
        try {
            $this->resource->save($sizeGuideModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the sizeGuide: %1',
                $exception->getMessage()
            ));
        }
        return $sizeGuideModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($sizeGuideId)
    {
        $sizeGuide = $this->sizeGuideFactory->create();
        $this->resource->load($sizeGuide, $sizeGuideId);
        if (!$sizeGuide->getId()) {
            throw new NoSuchEntityException(__('SizeGuide with id "%1" does not exist.', $sizeGuideId));
        }
        return $sizeGuide->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->sizeGuideCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \TheITNerd\SizeGuide\Api\Data\SizeGuideInterface::class
        );
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \TheITNerd\SizeGuide\Api\Data\SizeGuideInterface $sizeGuide
    ) {
        try {
            $sizeGuideModel = $this->sizeGuideFactory->create();
            $this->resource->load($sizeGuideModel, $sizeGuide->getEntityId());
            $this->resource->delete($sizeGuideModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the SizeGuide: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($sizeGuideId)
    {
        return $this->delete($this->get($sizeGuideId));
    }
}

