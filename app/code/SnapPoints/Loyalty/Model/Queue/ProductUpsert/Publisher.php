<?php

namespace SnapPoints\Loyalty\Model\Queue\ProductUpsert;

use Magento\Framework\MessageQueue\PublisherInterface;

class Publisher
{

    /**
     * @param PublisherInterface $publisher
     */
    public function __construct(
        protected readonly PublisherInterface $publisher
    )
    {

    }

    /**
     * Publishes a product by its ID.
     *
     * @param int $entityId The unique identifier of the product to be published.
     */
    public function publishProductById(int $entityId)
    {
        $this->publisher->publish('snappoints.product.upsert', $entityId);
    }
}
