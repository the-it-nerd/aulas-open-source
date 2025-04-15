<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface LogSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get log list.
     * @return LogInterface[]
     */
    public function getItems(): array;

    /**
     * Set log_stack list.
     * @param LogInterface[] $items
     * @return self
     */
    public function setItems(array $items): self;
}

