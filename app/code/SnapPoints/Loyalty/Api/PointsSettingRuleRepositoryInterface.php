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
use SnapPoints\Loyalty\Api\Data\PointsSettingRuleInterface;
use SnapPoints\Loyalty\Api\Data\PointsSettingRuleSearchResultsInterface;

interface PointsSettingRuleRepositoryInterface
{

    /**
     * Save queue_log
     * @param PointsSettingRuleInterface $queueLog
     * @return PointsSettingRuleInterface
     * @throws LocalizedException
     */
    public function save(
        PointsSettingRuleInterface $queueLog
    ): PointsSettingRuleInterface;

    /**
     * Retrieve queue_log
     * @param int $queueLogId
     * @return PointsSettingRuleInterface
     * @throws LocalizedException
     */
    public function get(int $queueLogId): PointsSettingRuleInterface;

    /**
     * Retrieve queue_log matching the specified criteria.
     * @param SearchCriteriaInterface $searchCriteria
     * @return PointsSettingRuleSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    ): PointsSettingRuleSearchResultsInterface;

    /**
     * Delete queue_log
     * @param PointsSettingRuleInterface $queueLog
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(
        PointsSettingRuleInterface $queueLog
    ): bool;

    /**
     * Delete queue_log by ID
     * @param int $queueLogId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $queueLogId): bool;

    /**
     * @param \Snappoints\Sdk\DataObjects\Interfaces\Objects\PointsSettingRuleInterface $pointsSettingRule
     * @param \Magento\Store\Api\Data\WebsiteInterface $website
     * @return PointsSettingRuleInterface
     */
    public function upsertRule(\Snappoints\Sdk\DataObjects\Interfaces\Objects\PointsSettingRuleInterface $pointsSettingRule, \Magento\Store\Api\Data\WebsiteInterface $website): PointsSettingRuleInterface;
}

