<?php

namespace SnapPoints\Loyalty\Model\Queue\ProductUpsert\ProductRequest;

use Magento\Catalog\Api\Data\ProductInterface;
use SnapPoints\Loyalty\Model\Queue\ProductUpsert\ProductRequest\Builders\Configurable;
use SnapPoints\Loyalty\Model\Queue\ProductUpsert\ProductRequest\Builders\Simple;
use Snappoints\Sdk\DataObjects\Entities\Product;

class Builder
{

    /**
     * @param Configurable $configurableProcessor
     * @param Simple $simpleProcessor
     */
    public function __construct(
        protected readonly Configurable $configurableProcessor,
        protected readonly Simple $simpleProcessor,
    )
    {
    }

    /**
     * Processes a given Magento product and returns a Snappoints SDK product object.
     *
     * @param ProductInterface $magentoProduct The Magento product to be processed.
     * @return \Snappoints\Sdk\DataObjects\Interfaces\Objects\ProductInterface The processed Snappoints SDK product object.
     */
    public function process(ProductInterface $magentoProduct): \Snappoints\Sdk\DataObjects\Interfaces\Objects\ProductInterface
    {
        $snapPointsProduct = new Product();
        if ($magentoProduct->getTypeId() === \Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE) {
            return $this->configurableProcessor->process($magentoProduct, $snapPointsProduct);
        }

        return $this->simpleProcessor->process($magentoProduct, $snapPointsProduct);
    }
}
