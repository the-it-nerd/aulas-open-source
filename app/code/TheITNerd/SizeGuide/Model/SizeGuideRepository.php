<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Model;

use Exception;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use TheITNerd\SizeGuide\Api\Data\SizeGuideInterface;
use TheITNerd\SizeGuide\Api\Data\SizeGuideInterfaceFactory;
use TheITNerd\SizeGuide\Api\Data\SizeGuideSearchResultsInterface;
use TheITNerd\SizeGuide\Api\Data\SizeGuideSearchResultsInterfaceFactory;
use TheITNerd\SizeGuide\Api\SizeGuideRepositoryInterface;
use TheITNerd\SizeGuide\Model\ResourceModel\SizeGuide as ResourceSizeGuide;
use TheITNerd\SizeGuide\Model\ResourceModel\SizeGuide\CollectionFactory as SizeGuideCollectionFactory;

/**
 * Class SizeGuideRepository
 * @package TheITNerd\SizeGuide\Model
 */
class SizeGuideRepository implements SizeGuideRepositoryInterface
{


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
        protected readonly ResourceSizeGuide                      $resource,
        protected readonly SizeGuideFactory                       $sizeGuideFactory,
        protected readonly SizeGuideInterfaceFactory              $dataSizeGuideFactory,
        protected readonly SizeGuideCollectionFactory             $sizeGuideCollectionFactory,
        protected readonly SizeGuideSearchResultsInterfaceFactory $searchResultsFactory,
        protected readonly DataObjectHelper                       $dataObjectHelper,
        protected readonly DataObjectProcessor                    $dataObjectProcessor,
        protected readonly StoreManagerInterface                  $storeManager,
        protected readonly CollectionProcessorInterface           $collectionProcessor,
        protected readonly JoinProcessorInterface                 $extensionAttributesJoinProcessor,
        protected readonly ExtensibleDataObjectConverter          $extensibleDataObjectConverter
    )
    {
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        SizeGuide $sizeGuide
    ): SizeGuide
    {
        $sizeGuideData = $this->extensibleDataObjectConverter->toNestedArray(
            $sizeGuide,
            [],
            SizeGuideInterface::class
        );

        $sizeGuideModel = $this->sizeGuideFactory->create()->setData($sizeGuideData);

        try {
            $this->resource->save($sizeGuideModel);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the sizeGuide: %1',
                $exception->getMessage()
            ));
        }
        return $sizeGuideModel;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        SearchCriteriaInterface $criteria
    ): SizeGuideSearchResultsInterface
    {
        $collection = $this->sizeGuideCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            SizeGuideInterface::class
        );

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
     * {@inheritdoc}
     */
    public function deleteById($sizeGuideId): bool
    {
        return $this->delete($this->get($sizeGuideId));
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        SizeGuide $sizeGuide
    ): bool
    {
        try {
            $sizeGuideModel = $this->sizeGuideFactory->create();
            $this->resource->load($sizeGuideModel, $sizeGuide->getId());
            $this->resource->delete($sizeGuideModel);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the SizeGuide: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @return SizeGuide
     */
    public function create(): SizeGuide
    {
        return $this->sizeGuideFactory->create();
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $sizeGuideId, int|null $storeId = null): SizeGuide
    {
        $sizeGuide = $this->sizeGuideFactory->create();
        if(!is_null($storeId)) {
            $sizeGuide->setStoreId($storeId);
        }

        $this->resource->load($sizeGuide, $sizeGuideId);

        if (!$sizeGuide->getId()) {
            throw new NoSuchEntityException(__('SizeGuide with id "%1" does not exist.', $sizeGuideId));
        }
        return $sizeGuide;
    }
}

