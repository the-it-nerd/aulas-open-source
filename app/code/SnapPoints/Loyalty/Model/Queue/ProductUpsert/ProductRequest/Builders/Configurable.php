<?php

namespace SnapPoints\Loyalty\Model\Queue\ProductUpsert\ProductRequest\Builders;

use Magento\Catalog\Api\Data\ProductInterface;
use Snappoints\Sdk\DataObjects\Collection\ProductCollection;

class Configurable extends Simple
{


    /**
     * @inheritDoc
     */
    public function process(ProductInterface $magentoProduct, \Snappoints\Sdk\DataObjects\Interfaces\Objects\ProductInterface $snapPointsProduct): \Snappoints\Sdk\DataObjects\Interfaces\Objects\ProductInterface
    {
        $snapPointsProduct = parent::process($magentoProduct, $snapPointsProduct);
        $variantsCollection = new ProductCollection();

        $typeInstance = $magentoProduct->getTypeInstance();
        $childProducts = $typeInstance->getUsedProducts($magentoProduct);

        foreach($childProducts as $childProduct) {
            $variantsCollection->add(new \Snappoints\Sdk\DataObjects\Entities\Product()
                ->setId($childProduct->getId())
                ->setName($childProduct->getName())
            );
        }

        return $snapPointsProduct->setVariants($variantsCollection);
    }
}
