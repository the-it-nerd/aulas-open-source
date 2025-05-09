<?php

namespace SnapPoints\Loyalty\Rewrite\Magento\CatalogWidget\Block\Product;

use Exception;
use Magento\Catalog\Model\Product;
use Magento\CatalogWidget\Block\Product\ProductsList as BaseProductsList;
use SnapPoints\Loyalty\Block\Config\LibraryConfig;

class ProductsList extends BaseProductsList
{
    /**
     * @inheridoc
     */
    public function getProductDetailsHtml(Product $product)
    {
        $html = parent::getProductDetailsHtml($product);

        try {

            // Check if we're on product page
            $currentProduct = $this->_coreRegistry->registry('current_product');
            if ($currentProduct && $currentProduct->getId() === $product->getId()) {
                return $html;
            }

            // Add your custom points HTML
            $pointsHtml = $this->getLayout()
                ->createBlock(LibraryConfig::class)
                ->setData('product', $product)
                ->setTemplate('SnapPoints_Loyalty::widgets/product/list/points.phtml')
                ->toHtml();

            $html .= $pointsHtml;
        } catch (Exception $e) {
            $this->_logger->error($e->getMessage());
        }

        return $html;
    }

    /**
     * Set the correct template for the block
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('Magento_CatalogWidget::product/widget/content/grid.phtml');
    }
}
