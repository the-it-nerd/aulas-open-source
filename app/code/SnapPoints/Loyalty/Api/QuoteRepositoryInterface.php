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
use SnapPoints\Loyalty\Api\Data\QuoteSearchResultsInterface;

interface QuoteRepositoryInterface
{

    /**
     * Save quote
     * @param QuoteInterface $quote
     * @return QuoteInterface
     * @throws LocalizedException
     */
    public function save(
        QuoteInterface $quote
    ): QuoteInterface;

    /**
     * Retrieve quote
     * @param int $quoteId
     * @return QuoteInterface
     * @throws LocalizedException
     */
    public function get(int $quoteId): QuoteInterface;

    /**
     * Retrieve quote matching the specified criteria.
     * @param SearchCriteriaInterface $searchCriteria
     * @return QuoteSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    ): QuoteSearchResultsInterface;

    /**
     * Delete quote
     * @param QuoteInterface $quote
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(
        QuoteInterface $quote
    ): bool;

    /**
     * Delete quote by ID
     * @param int $quoteId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $quoteId): bool;

    /**
     * @param int $quoteId
     * @return QuoteInterface
     */
    public function getByMagentoQuoteId(int $quoteId): QuoteInterface;
}

