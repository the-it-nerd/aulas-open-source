<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface SizeGuideSearchResultsInterface
 *
 * This interface extends the SearchResultsInterface and provides methods to
 * get and set a list of SizeGuide objects.
 */
interface SizeGuideSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get SizeGuide list.
     * @return SizeGuideInterface[]
     */
    public function getItems(): array;

    /**
     * Set title list.
     * @param SizeGuideInterface[] $items
     * @return $this
     */
    public function setItems(array $items): self;
}

