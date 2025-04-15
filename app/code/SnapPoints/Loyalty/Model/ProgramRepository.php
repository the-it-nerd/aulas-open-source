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
use SnapPoints\Loyalty\Api\Data\ProgramInterface;
use SnapPoints\Loyalty\Api\Data\ProgramInterfaceFactory;
use SnapPoints\Loyalty\Api\Data\ProgramSearchResultsInterfaceFactory;
use SnapPoints\Loyalty\Api\ProgramRepositoryInterface;
use SnapPoints\Loyalty\Model\ResourceModel\Program as ResourceProgram;
use SnapPoints\Loyalty\Model\ResourceModel\Program\CollectionFactory as ProgramCollectionFactory;

class ProgramRepository implements ProgramRepositoryInterface
{

    /**
     * @var ProgramInterfaceFactory
     */
    protected $programFactory;

    /**
     * @var Program
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var ResourceProgram
     */
    protected $resource;

    /**
     * @var ProgramCollectionFactory
     */
    protected $programCollectionFactory;


    /**
     * @param ResourceProgram $resource
     * @param ProgramInterfaceFactory $programFactory
     * @param ProgramCollectionFactory $programCollectionFactory
     * @param ProgramSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceProgram $resource,
        ProgramInterfaceFactory $programFactory,
        ProgramCollectionFactory $programCollectionFactory,
        ProgramSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->programFactory = $programFactory;
        $this->programCollectionFactory = $programCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(ProgramInterface $program)
    {
        try {
            $this->resource->save($program);
        } catch (\Exception $exception) {
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
    public function get($programId)
    {
        $program = $this->programFactory->create();
        $this->resource->load($program, $programId);
        if (!$program->getId()) {
            throw new NoSuchEntityException(__('program with id "%1" does not exist.', $programId));
        }
        return $program;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
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
    public function delete(ProgramInterface $program)
    {
        try {
            $programModel = $this->programFactory->create();
            $this->resource->load($programModel, $program->getProgramId());
            $this->resource->delete($programModel);
        } catch (\Exception $exception) {
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
    public function deleteById($programId)
    {
        return $this->delete($this->get($programId));
    }
}

