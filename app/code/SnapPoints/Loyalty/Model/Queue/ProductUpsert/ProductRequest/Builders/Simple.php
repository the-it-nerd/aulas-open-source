<?php

namespace SnapPoints\Loyalty\Model\Queue\ProductUpsert\ProductRequest\Builders;

use Magento\Catalog\Api\Data\ProductInterface;
use Snappoints\Sdk\DataObjects\Collection\ProductAttributeCollection;
use Snappoints\Sdk\DataObjects\Collection\ProductCollection;
use Snappoints\Sdk\DataObjects\Entities\Product;
use Snappoints\Sdk\DataObjects\Entities\ProductAttribute;

class Simple extends AbstractBuilder
{

    protected \Magento\Catalog\Helper\Image $imageHelper;

    public function __construct(
        \Magento\Catalog\Helper\ImageFactory $imageFactory
    )
    {
        $this->imageHelper = $imageFactory->create();
    }

    /**
     * @inheritDoc
     */
    public function process(ProductInterface $magentoProduct, \Snappoints\Sdk\DataObjects\Interfaces\Objects\ProductInterface $snapPointsProduct): \Snappoints\Sdk\DataObjects\Interfaces\Objects\ProductInterface
    {
        $attributesCollection = new ProductAttributeCollection();
        $variantsCollection = new ProductCollection();
        $variantsCollection->add(new Product()->setId($magentoProduct->getId())->setName($magentoProduct->getName()));


        $attributesCollection->add(new ProductAttribute()
            ->setKey('category')
            ->setValue($magentoProduct->getCategoryId()));

        return $snapPointsProduct->setId($magentoProduct->getId())
            ->setName($magentoProduct->getName())
            ->setLogoUrl($this->imageHelper->init($magentoProduct, 'product_base_image')
                ->setImageFile($magentoProduct->getImage())
                ->resize(250)
                ->getUrl()
            )
            ->setVariants($variantsCollection)
            ->setAttributes($attributesCollection);
    }
}
