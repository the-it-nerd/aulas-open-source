<?php

namespace SnapPoints\Loyalty\Api\Data;

interface PointsSettingRuleSearchResultsInterface
{
    /**
     * Get program list.
     * @return PointsSettingRuleInterface[]
     */
    public function getItems(): array;

    /**
     * Set name list.
     * @param PointsSettingRuleInterface[] $items
     * @return self
     */
    public function setItems(array $items): self;
}
