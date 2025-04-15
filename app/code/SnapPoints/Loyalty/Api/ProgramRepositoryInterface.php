<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use SnapPoints\Loyalty\Api\Data\ProgramInterface;
use SnapPoints\Loyalty\Api\Data\ProgramSearchResultsInterface;

interface ProgramRepositoryInterface
{

    /**
     * Save program
     * @param ProgramInterface $program
     * @return ProgramInterface
     * @throws LocalizedException
     */
    public function save(
        ProgramInterface $program
    ): ProgramInterface;

    /**
     * Retrieve program
     * @param int $programId
     * @return ProgramInterface
     * @throws LocalizedException
     */
    public function get(int $programId): ProgramInterface;

    /**
     * Retrieve program matching the specified criteria.
     * @param SearchCriteriaInterface $searchCriteria
     * @return ProgramSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    ): ProgramSearchResultsInterface;

    /**
     * Delete program
     * @param ProgramInterface $program
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(
        ProgramInterface $program
    ): bool;

    /**
     * Delete program by ID
     * @param int $programId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $programId): bool;
}

