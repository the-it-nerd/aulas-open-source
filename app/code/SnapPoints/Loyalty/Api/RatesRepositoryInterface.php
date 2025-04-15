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
use SnapPoints\Loyalty\Api\Data\RatesInterface;
use SnapPoints\Loyalty\Api\Data\RatesSearchResultsInterface;

interface RatesRepositoryInterface
{

    /**
     * Save rates
     * @param RatesInterface $rates
     * @return RatesInterface
     * @throws LocalizedException
     */
    public function save(
        RatesInterface $rates
    ): RatesInterface;

    /**
     * Retrieve rates
     * @param int $ratesId
     * @return RatesInterface
     * @throws LocalizedException
     */
    public function get(int $ratesId): RatesInterface;

    /**
     * Retrieve rates matching the specified criteria.
     * @param SearchCriteriaInterface $searchCriteria
     * @return RatesSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    ): RatesSearchResultsInterface;

    /**
     * Delete rates
     * @param RatesInterface $rates
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(
        RatesInterface $rates
    ): bool;

    /**
     * Delete rates by ID
     * @param int $ratesId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $ratesId): bool;
}

