<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Api\Data;

interface SizeGuideSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get SizeGuide list.
     * @return \TheITNerd\SizeGuide\Api\Data\SizeGuideInterface[]
     */
    public function getItems();

    /**
     * Set title list.
     * @param \TheITNerd\SizeGuide\Api\Data\SizeGuideInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

