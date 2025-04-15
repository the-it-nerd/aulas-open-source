<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface RatesSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get rates list.
     * @return RatesInterface[]
     */
    public function getItems(): array;

    /**
     * Set program_id list.
     * @param RatesInterface[] $items
     * @return self
     */
    public function setItems(array $items): self;
}

