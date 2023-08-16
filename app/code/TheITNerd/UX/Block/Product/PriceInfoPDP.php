<?php

namespace TheITNerd\UX\Block\Product;


use Exception;
use Magento\Catalog\Block\Product\View;

/**
 * Class PriceInfo
 * @package TheITNerd\UX\Block\Product
 */
class PriceInfoPDP extends View
{
    /**
     * @return string
     */
    public function getCustomHtml(): string
    {
        try {
            return $this->getLayout()
                ->createBlock(PriceInfo::class)
                ->setTemplate("TheITNerd_UX::Magento_Catalog/product/view/priceInfo/pdp.phtml")
                ->setProduct($this->getProduct())
                ->toHtml();
        } catch (Exception $e) {
            $this->_logger->error($e->getMessage());
            return '';
        }
    }
}
