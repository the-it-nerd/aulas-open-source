<?php

namespace TheITNerd\UX\Rewrite\Magento\Catalog\Block\Product;


use Exception;
use Magento\Catalog\Model\Product;
use TheITNerd\UX\Block\Product\PriceInfo;

/**
 * Class ListProduct
 * @package TheITNerd\UX\Rewrite\Magento\Catalog\Block\Product
 */
class ListProduct extends \Magento\Catalog\Block\Product\ListProduct
{

    /**
     * {@inheritDoc}
     */
    public function getProductPrice(Product $product)
    {
        $price = parent::getProductPrice($product);

        try {
            $price .= $this->getLayout()
                ->createBlock(PriceInfo::class)
                ->setTemplate("TheITNerd_UX::Magento_Catalog/product/view/priceInfo/plp.phtml")
                ->setProduct($product)
                ->toHtml();
        } catch (Exception $e) {
            $this->_logger->error($e->getMessage());
        }

        return $price;
    }


}
