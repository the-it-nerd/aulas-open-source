<?php

namespace TheITNerd\SizeGuide\Block\Catalog\Product\View;


use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Block\Product\View;
use Magento\Catalog\Helper\Product;
use Magento\Catalog\Model\ProductTypes\ConfigInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Locale\FormatInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Stdlib\StringUtils;
use TheITNerd\SizeGuide\Api\Data\SizeGuideInterface;
use TheITNerd\SizeGuide\Api\SizeGuideRepositoryInterface;
use TheITNerd\SizeGuide\Model\SizeGuideRepository;

/**
 * Class SizeGuide
 * @package TheITNerd\SizeGuide\Block\Catalog\Product\View
 */
class SizeGuide extends View
{
    public function __construct(
        \Magento\Catalog\Block\Product\Context                                 $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        EncoderInterface                        $jsonEncoder,
        StringUtils                             $string,
        Product                                 $productHelper,
        ConfigInterface                         $productTypeConfig,
        FormatInterface                         $localeFormat,
        Session                                 $customerSession,
        ProductRepositoryInterface              $productRepository,
        PriceCurrencyInterface                  $priceCurrency,
        protected SizeGuideRepository           $sizeGuideRepository,
        array                                   $data = []
    )
    {
        parent::__construct($context, $urlEncoder, $jsonEncoder, $string, $productHelper, $productTypeConfig, $localeFormat, $customerSession, $productRepository, $priceCurrency, $data);
    }

    /**
     * @return SizeGuideInterface|null
     * @throws LocalizedException
     */
    public function getSizeGuide(): SizeGuideInterface|null
    {

        if ($sizeGuideId = $this->getProduct()->getData(SizeGuideRepositoryInterface::PRODUCT_ATTRIBUTE)) {
            try {
                return $this->sizeGuideRepository->get($sizeGuideId);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                return null;
            }
        }

        return null;
    }

}
