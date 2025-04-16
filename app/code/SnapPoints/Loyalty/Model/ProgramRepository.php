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
use SnapPoints\Loyalty\Api\Data\ProgramInterface;
use SnapPoints\Loyalty\Api\Data\ProgramInterfaceFactory;
use SnapPoints\Loyalty\Api\Data\ProgramSearchResultsInterface;
use SnapPoints\Loyalty\Api\Data\ProgramSearchResultsInterfaceFactory;
use SnapPoints\Loyalty\Api\ProgramRepositoryInterface;
use SnapPoints\Loyalty\Model\ResourceModel\Program as ResourceProgram;
use SnapPoints\Loyalty\Model\ResourceModel\Program\CollectionFactory as ProgramCollectionFactory;

class ProgramRepository implements ProgramRepositoryInterface
{
    /**
     * @param ResourceProgram $resource
     * @param ProgramInterfaceFactory $programFactory
     * @param ProgramCollectionFactory $programCollectionFactory
     * @param ProgramSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        protected readonly ResourceProgram                      $resource,
        protected readonly ProgramInterfaceFactory              $programFactory,
        protected readonly ProgramCollectionFactory             $programCollectionFactory,
        protected readonly ProgramSearchResultsInterfaceFactory $searchResultsFactory,
        protected readonly CollectionProcessorInterface         $collectionProcessor
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function save(ProgramInterface $program): ProgramInterface
    {
        try {
            $this->resource->save($program);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the program: %1',
                $exception->getMessage()
            ));
        }
        return $program;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        SearchCriteriaInterface $criteria
    ): ProgramSearchResultsInterface
    {
        $collection = $this->programCollectionFactory->create();

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
    public function deleteById($programId): bool
    {
        return $this->delete($this->get($programId));
    }

    /**
     * @inheritDoc
     */
    public function delete(ProgramInterface $program): bool
    {
        try {
            $programModel = $this->programFactory->create();
            $this->resource->load($programModel, $program->getProgramId());
            $this->resource->delete($programModel);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the program: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function get($programId): ProgramInterface
    {
        $program = $this->programFactory->create();
        $this->resource->load($program, $programId);
        if (!$program->getId()) {
            throw new NoSuchEntityException(__('program with id "%1" does not exist.', $programId));
        }
        return $program;
    }
}

