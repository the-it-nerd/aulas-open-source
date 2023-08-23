<?php

namespace TheITNerd\UX\Rewrite\Magento\Wishlist\CustomerData;


/**
 * Class Wishlist
 * @package TheITNerd\UX\Rewrite\Magento\Wishlist\CustomerData
 */
class Wishlist extends \Magento\Wishlist\CustomerData\Wishlist
{
    /**
     * Get wishlist items
     *
     * @return array
     */
    protected function getItems(bool $usePaging = true )
    {
        $collection = $this->wishlistHelper->getWishlistItemCollection();
        $collection->clear()->setOrder('added_at');

        if($usePaging) {
            $collection->setPageSize(self::SIDEBAR_ITEMS_NUMBER)
                ->setInStockFilter(true);
        }

        $items = [];
        foreach ($collection as $wishlistItem) {
            $items[] = $this->getItemData($wishlistItem);
        }
        return $items;
    }

    /**
     * @inheritdoc
     */
    public function getSectionData()
    {
        $counter = $this->getCounter();
        return [
            'counter' => $counter,
            'full_list' => $counter ? $this->getItems(false) : [],
            'items' => $counter ? $this->getItems() : []
        ];
    }

}
