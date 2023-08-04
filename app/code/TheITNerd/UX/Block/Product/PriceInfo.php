<?php

namespace TheITNerd\UX\Block\Product;


use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\View;
use Magento\Catalog\Helper\Product;
use Magento\Catalog\Model\ProductTypes\ConfigInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Locale\FormatInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Stdlib\StringUtils;
use TheITNerd\UX\Helper\Config;

/**
 * Class PriceInfo
 * @package TheITNerd\UX\Block\Product
 */
class PriceInfo extends View
{

    /**
     * @param Context $context
     * @param \Magento\Framework\Url\EncoderInterface $urlEncoder
     * @param EncoderInterface $jsonEncoder
     * @param StringUtils $string
     * @param Product $productHelper
     * @param ConfigInterface $productTypeConfig
     * @param FormatInterface $localeFormat
     * @param Session $customerSession
     * @param ProductRepositoryInterface $productRepository
     * @param PriceCurrencyInterface $priceCurrency
     * @param Config $configHelper
     * @param array $data
     */
    public function __construct(
        Context                                 $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        EncoderInterface                        $jsonEncoder,
        StringUtils                             $string,
        Product                                 $productHelper,
        ConfigInterface                         $productTypeConfig,
        FormatInterface                         $localeFormat,
        Session                                 $customerSession,
        ProductRepositoryInterface              $productRepository,
        PriceCurrencyInterface                  $priceCurrency,
        private readonly Config                 $configHelper,
        array                                   $data = []
    )
    {
        parent::__construct($context, $urlEncoder, $jsonEncoder, $string, $productHelper, $productTypeConfig, $localeFormat, $customerSession, $productRepository, $priceCurrency, $data);
    }

    /**
     * @return bool
     */
    public function canShowCashDiscount(): bool
    {
        return $this->configHelper->canShowCashDiscount();
    }

    /**
     * @return float
     */
    public function getCashDiscountAmount(): float
    {
        return $this->configHelper->getCashDiscountAmount();
    }

    /**
     * @return string|null
     */
    public function getCashDiscountPaymentType(): string|null
    {
        return $this->configHelper->getCashDiscountPaymentType();
    }

    /**
     * @return float|null
     */
    public function getProductCashDiscountedPrice() : float|null
    {
        if(
            $this->canShowCashDiscount()
            && $this->getCashDiscountAmount() > 0
            && $price = $this->getProduct()->getFinalPrice()
        ) {
            return  $price - ($price * ($this->getCashDiscountAmount()/100));
        }

        return null;
    }


    /**
     * @return bool
     */
    public function canShowInstallments(): bool
    {
        return $this->configHelper->canShowInstallments();
    }

    /**
     * @return float
     */
    public function getMinInstallmentAmount(): float
    {
        return $this->configHelper->getMinInstallmentAmount();
    }

    /**
     * @return int
     */
    public function getMaxInstallments(): int
    {
        return $this->configHelper->getMaxInstallments();
    }

    /**
     * @return int
     */
    public function getInstallmentsWithoutTax(): int
    {
        return $this->configHelper->getInstallmentsWithoutTax();
    }

    /**
     * @return float
     */
    function getInstallmentInterest(): float
    {
        return $this->configHelper->getInstallmentTax();
    }

    /**
     * @return float
     */
    public function getInstallmentsWithoutTaxAmount(): float
    {
        return $this->getProduct()->getFinalPrice() / $this->getInstallmentsWithoutTax();
    }

    /**
     * @return array
     */
    public function getInstallmentsTableArray(): array
    {
        $price = $this->getProduct()->getFinalPrice();

        $data = [];

        for($i = 2; $i <= $this->getMaxInstallments(); $i ++) {
            $hasTax = $this->getInstallmentsWithoutTax() < $i;
            $value = ($hasTax) ?$this->getCompoundTaxInstallmentValue($price, $this->getInstallmentInterest(), $i) : $price/$i;

            if($value >= $this->getMinInstallmentAmount()) {
                $data[] = [
                    'hasTax' => $hasTax,
                    'qty' => $i,
                    'price' => $value
                ];
            } else {
                break;
            }
        }

        return $data;
    }

    /**
     * @param float $value
     * @param float $tax
     * @param int $installments
     * @return float
     */
    protected function getCompoundTaxInstallmentValue(float $value, float $tax, int $installments): float
    {
        $finalAmount = $value * pow((1+$tax/100), $installments);

        return $finalAmount/$installments;
    }

    /**
     * @return bool
     */
    public function hasInterest() :bool
    {
        return ($this->getProduct()->getFinalPrice() / $this->getMinInstallmentAmount()) > $this->getInstallmentsWithoutTax();
    }
}
