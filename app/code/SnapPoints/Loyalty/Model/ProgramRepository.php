<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Model;

use DateTimeZone;
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
use Snappoints\Sdk\DataObjects\Interfaces\Objects\LoyaltyProgramInterface;

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

    /**
     * @inheritDoc
     */
    public function upsertProgram(LoyaltyProgramInterface $program): ProgramInterface
    {
        try {
            $DBProgram = $this->getByExternalId($program->getId());
        } catch (NoSuchEntityException $e) {
            $DBProgram = $this->programFactory->create();
        }

        // Map all available fields from SDK to database entity
        $DBProgram->setExternalId($program->getId())
            ->setName($program->getName())
            ->setLogo($program->getLogoUrl())
            ->setUnit($program->getUnit())
            ->setPointsPerSpend($program->getPointsPerSpend());

        if ($program->getVersion()) {
            $DBProgram->setVersion((string)$program->getVersion());
        }

        if ($program->getPointsPerSpendVersion()) {
            $DBProgram->setPointsPerSpendVersion((int)$program->getPointsPerSpendVersion());
        }

        if (method_exists($program, 'getPointsPerSpendCreatedAt') && $program->getPointsPerSpendCreatedAt()) {
            $timezone = new DateTimeZone(date_default_timezone_get());
            $DBProgram->setPointsPerSpendCreatedAt($timezone);
        }

        if (method_exists($program, 'getPointsPerSpendUpdatedAt') && $program->getPointsPerSpendUpdatedAt()) {
            $timezone = new DateTimeZone(date_default_timezone_get());
            $DBProgram->setPointsPerSpendUpdatedAt($timezone);
        }

        if (method_exists($program, 'getPointsPerSpendDeletedAt') && $program->getPointsPerSpendDeletedAt()) {
            $timezone = new DateTimeZone(date_default_timezone_get());
            $DBProgram->setPointsPerSpendDeletedAt($timezone);
        }

        // Save the mapped entity
        try {
            $this->save($DBProgram);
        } catch (CouldNotSaveException $e) {
            throw new CouldNotSaveException(__(
                'Could not save program data from SDK: %1',
                $e->getMessage()
            ));
        }

        return $DBProgram;
    }

    /**
     * @param string $id
     * @return ProgramInterface
     * @throws NoSuchEntityException
     */
    public function getByExternalId(string $id): ProgramInterface
    {

        $program = $this->programFactory->create();
        $this->resource->load($program, $id, 'external_id');

        if (!$program->getId()) {
            throw new NoSuchEntityException(__('Program with external ID "%1" does not exist.', $id));
        }

        return $program;
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
}

