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
use SnapPoints\Loyalty\Api\Data\QuoteInterface;
use SnapPoints\Loyalty\Api\Data\TransactionInterface;
use SnapPoints\Loyalty\Api\Data\TransactionSearchResultsInterface;

interface TransactionRepositoryInterface
{

    /**
     * Save transaction
     * @param TransactionInterface $transaction
     * @return TransactionInterface
     * @throws LocalizedException
     */
    public function save(
        TransactionInterface $transaction
    ): TransactionInterface;

    /**
     * Retrieve transaction
     * @param int $transactionId
     * @return TransactionInterface
     * @throws LocalizedException
     */
    public function get(int $transactionId): TransactionInterface;

    /**
     * Retrieve transaction matching the specified criteria.
     * @param SearchCriteriaInterface $searchCriteria
     * @return TransactionSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    ): TransactionSearchResultsInterface;

    /**
     * Delete transaction
     * @param TransactionInterface $transaction
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(
        TransactionInterface $transaction
    ): bool;

    /**
     * Delete transaction by ID
     * @param int $transactionId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $transactionId): bool;

    /**
     * @param int $orderId
     * @return TransactionInterface
     */
    public function getByMagentoOrderId(int $orderId): TransactionInterface;
}

