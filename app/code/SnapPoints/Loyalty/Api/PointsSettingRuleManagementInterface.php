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

interface PointsSettingRuleManagementInterface
{

    /**
     * @return array
     */
    public function getRules():array;
}

