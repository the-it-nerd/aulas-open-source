<?php

namespace SnapPoints\Loyalty\Model\Queue\ProductUpsert\ProductRequest\Builders;

use Magento\Catalog\Api\Data\ProductInterface;

abstract class AbstractBuilder
{
    /**
     * Processes a Magento product by applying specific rules defined in the Snappoints SDK.
     *
     * This method takes a Magento product and a Snappoints product object, applies any necessary processing,
     * and returns the modified Snappoints product object.
     *
     * @param ProductInterface $magentoProduct The Magento product interface representing the current state of the product.
     * @param \Snappoints\Sdk\DataObjects\Interfaces\Objects\ProductInterface $snapPointsProduct The Snappoints product object with rules applied.
     * @return \Snappoints\Sdk\DataObjects\Interfaces\Objects\ProductInterface The modified Snappoints product object after processing.
     */
    abstract public function process(ProductInterface $magentoProduct, \Snappoints\Sdk\DataObjects\Interfaces\Objects\ProductInterface $snapPointsProduct): \Snappoints\Sdk\DataObjects\Interfaces\Objects\ProductInterface;
}
