<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ProgramSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get program list.
     * @return ProgramInterface[]
     */
    public function getItems(): array;

    /**
     * Set name list.
     * @param ProgramInterface[] $items
     * @return self
     */
    public function setItems(array $items): self;
}

