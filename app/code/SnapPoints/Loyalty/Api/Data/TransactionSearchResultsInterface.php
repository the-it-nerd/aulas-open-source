<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface TransactionSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get transactions list.
     * @return TransactionInterface[]
     */
    public function getItems(): array;

    /**
     * Set transactions list.
     * @param TransactionInterface[] $items
     * @return self
     */
    public function setItems(array $items): self;
}

