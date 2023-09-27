<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface SizeGuideRepositoryInterface
{

    /**
     * Save SizeGuide
     * @param \TheITNerd\SizeGuide\Api\Data\SizeGuideInterface $sizeGuide
     * @return \TheITNerd\SizeGuide\Api\Data\SizeGuideInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \TheITNerd\SizeGuide\Api\Data\SizeGuideInterface $sizeGuide
    );

    /**
     * Retrieve SizeGuide
     * @param string $entityId
     * @return \TheITNerd\SizeGuide\Api\Data\SizeGuideInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($entityId);

    /**
     * Retrieve SizeGuide matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \TheITNerd\SizeGuide\Api\Data\SizeGuideSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete SizeGuide
     * @param \TheITNerd\SizeGuide\Api\Data\SizeGuideInterface $sizeGuide
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \TheITNerd\SizeGuide\Api\Data\SizeGuideInterface $sizeGuide
    );

    /**
     * Delete SizeGuide by ID
     * @param string $entityId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($entityId);
}

