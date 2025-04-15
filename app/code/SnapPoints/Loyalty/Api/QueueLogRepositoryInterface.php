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
use SnapPoints\Loyalty\Api\Data\QueueLogInterface;
use SnapPoints\Loyalty\Api\Data\QueueLogSearchResultsInterface;

interface QueueLogRepositoryInterface
{

    /**
     * Save queue_log
     * @param QueueLogInterface $queueLog
     * @return QueueLogInterface
     * @throws LocalizedException
     */
    public function save(
        QueueLogInterface $queueLog
    ): QueueLogInterface;

    /**
     * Retrieve queue_log
     * @param int $queueLogId
     * @return QueueLogInterface
     * @throws LocalizedException
     */
    public function get(int $queueLogId): QueueLogInterface;

    /**
     * Retrieve queue_log matching the specified criteria.
     * @param SearchCriteriaInterface $searchCriteria
     * @return QueueLogSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    ): QueueLogSearchResultsInterface;

    /**
     * Delete queue_log
     * @param QueueLogInterface $queueLog
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(
        QueueLogInterface $queueLog
    ): bool;

    /**
     * Delete queue_log by ID
     * @param int $queueLogId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $queueLogId): bool;
}

