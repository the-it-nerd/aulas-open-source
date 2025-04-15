<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface QueueLogSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get queue_log list.
     * @return QueueLogInterface[]
     */
    public function getItems(): array;

    /**
     * Set queue list.
     * @param QueueLogInterface[] $items
     * @return self
     */
    public function setItems(array $items): self;
}

