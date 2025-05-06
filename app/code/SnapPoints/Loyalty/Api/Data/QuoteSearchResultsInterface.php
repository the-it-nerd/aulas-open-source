<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface QuoteSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get quote list.
     * @return QuoteInterface[]
     */
    public function getItems(): array;

    /**
     * Set quote_stack list.
     * @param QuoteInterface[] $items
     * @return self
     */
    public function setItems(array $items): self;
}

