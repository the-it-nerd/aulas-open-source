<?php

namespace SnapPoints\Loyalty\Rewrite\Magento\Catalog\Block\Product;


use Exception;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\ListProduct as MagentoListProduct;
use Magento\Catalog\Helper\Output as OutputHelper;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Pricing\Price\SpecialPriceBulkResolverInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Framework\Url\Helper\Data;
use SnapPoints\Loyalty\Block\Config\LibraryConfig;

class ListProduct extends MagentoListProduct
{
    protected SpecialPriceBulkResolverInterface $specialPriceBulkResolver;

    /**
     * @param Context $context
     * @param PostHelper $postDataHelper
     * @param Resolver $layerResolver
     * @param CategoryRepositoryInterface $categoryRepository
     * @param Data $urlHelper
     * @param array $data
     * @param OutputHelper|null $outputHelper
     * @param SpecialPriceBulkResolverInterface|null $specialPriceBulkResolver
     */
    public function __construct(
        Context                            $context,
        PostHelper                         $postDataHelper,
        Resolver                           $layerResolver,
        CategoryRepositoryInterface        $categoryRepository,
        Data                               $urlHelper,
        array                              $data = [],
        ?OutputHelper                      $outputHelper = null,
        ?SpecialPriceBulkResolverInterface $specialPriceBulkResolver = null
    )
    {
        $this->specialPriceBulkResolver = $specialPriceBulkResolver ??
            ObjectManager::getInstance()->get(SpecialPriceBulkResolverInterface::class);
        parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper, $data, $outputHelper, $specialPriceBulkResolver);
    }

    /**
     * Get product details html
     *
     * @param Product $product
     * @return string
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

}
