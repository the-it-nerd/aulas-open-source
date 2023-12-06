<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use TheITNerd\SizeGuide\Api\Data\SizeGuideSearchResultsInterface;
use TheITNerd\SizeGuide\Model\SizeGuide;

/**
 * Interface SizeGuideRepositoryInterface
 *
 * This interface provides methods to interact with the size guide repository.
 *
 * @package TheITNerd\SizeGuide\Api
 */
interface SizeGuideRepositoryInterface
{

    public const PRODUCT_ATTRIBUTE = "size_guide";

    /**
     * Save SizeGuide
     * @param SizeGuide $sizeGuide
     * @return SizeGuide
     * @throws LocalizedException
     */
    public function save(
        SizeGuide $sizeGuide
    ): SizeGuide;

    /**
     * Retrieve SizeGuide
     * @param string $entityId
     * @return SizeGuide
     * @throws LocalizedException
     */
    public function get(string $entityId, int|null $storeId = null): SizeGuide;

    /**
     * Retrieve SizeGuide matching the specified criteria.
     * @param SearchCriteriaInterface $searchCriteria
     * @return SizeGuideSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    ): SizeGuideSearchResultsInterface;

    /**
     * Delete SizeGuide
     * @param SizeGuide $sizeGuide
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(
        SizeGuide $sizeGuide
    ): bool;

    /**
     * Delete SizeGuide by ID
     * @param string $entityId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(string $entityId): bool;
}

