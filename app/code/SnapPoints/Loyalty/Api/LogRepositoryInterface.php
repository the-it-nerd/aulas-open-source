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
use SnapPoints\Loyalty\Api\Data\LogInterface;
use SnapPoints\Loyalty\Api\Data\LogSearchResultsInterface;

interface LogRepositoryInterface
{

    /**
     * Save log
     * @param LogInterface $log
     * @return LogInterface
     * @throws LocalizedException
     */
    public function save(
        LogInterface $log
    ): LogInterface;

    /**
     * Retrieve log
     * @param int $logId
     * @return LogInterface
     * @throws LocalizedException
     */
    public function get(int $logId): LogInterface;

    /**
     * Retrieve log matching the specified criteria.
     * @param SearchCriteriaInterface $searchCriteria
     * @return LogSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    ): LogSearchResultsInterface;

    /**
     * Delete log
     * @param LogInterface $log
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(
        LogInterface $log
    ): bool;

    /**
     * Delete log by ID
     * @param int $logId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $logId): bool;
}

