<?php

namespace TheITNerd\UX\Block\Product;


use Magento\Catalog\Model\Product;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use TheITNerd\UX\Helper\Product as UxProductHelper;

/**
 * Class PriceInfo
 * @package TheITNerd\UX\Block\Product
 */
class PriceInfo extends Template
{

    /**
     * @var string
     */
    private string $uniqueID;

    /**
     * @param Context $context
     * @param UxProductHelper $uxProductHelper
     * @param array $data
     */
    public function __construct(
        Context                          $context,
        private readonly UxProductHelper $uxProductHelper,
        array                            $data = []
    )
    {
        $this->uniqueID = str_replace('.', '', uniqid('installments-modal-', true));
        parent::__construct($context, $data);
    }

    /**
     * @param Product $product
     * @return PriceInfo
     */
    public function setProduct(Product $product): self
    {
        return $this->setData('product', $product);
    }

    /**
     * @return string
     */
    public function getUID(): string
    {
        return $this->uniqueID;
    }

    /**
     * @return string
     */
    public function getTriggerUID(): string
    {
        return $this->uniqueID . '--trigger';
    }

    /**
     * @return string|null
     */
    public function getCashDiscountPaymentType(): string|null
    {
        return $this->uxProductHelper->getCashDiscountPaymentType();
    }

    /**
     * @return float|null
     */
    public function getProductCashDiscountedPrice(): float|null
    {
        if (
            $this->canShowCashDiscount()
            && $this->getCashDiscountAmount() > 0
            && $price = $this->getProduct()->getFinalPrice()
        ) {
            return $price - ($price * ($this->getCashDiscountAmount() / 100));
        }

        return null;
    }

    /**
     * @return bool
     */
    public function canShowCashDiscount(): bool
    {
        return $this->uxProductHelper->canShowCashDiscount();
    }

    /**
     * @return float
     */
    public function getCashDiscountAmount(): float
    {
        return $this->uxProductHelper->getCashDiscountAmount();
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->getData('product');
    }

    /**
     * @return bool
     */
    public function canShowInstallments(): bool
    {
        return $this->uxProductHelper->canShowInstallments();
    }

    /**
     * @return float
     */
    public function getInstallmentsWithoutTaxAmount(): float
    {
        return $this->getProduct()->getFinalPrice() / $this->getInstallmentsWithoutTax();
    }

    /**
     * @return int
     */
    public function getInstallmentsWithoutTax(): int
    {
        return $this->uxProductHelper->getInstallmentsWithoutTax();
    }

    /**
     * @return array
     */
    public function getInstallmentsTableArray(): array
    {
        $price = $this->getProduct()->getFinalPrice();

        $data = [];

        for ($i = 2; $i <= $this->getMaxInstallments(); $i++) {
            $hasTax = $this->getInstallmentsWithoutTax() < $i;
            $value = ($hasTax) ? $this->getCompoundTaxInstallmentValue($price, $this->getInstallmentInterest(), $i) : $price / $i;

            if ($value >= $this->getMinInstallmentAmount()) {
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
     * @return int
     */
    public function getMaxInstallments(): int
    {
        return $this->uxProductHelper->getMaxInstallments();
    }

    /**
     * @param float $value
     * @param float $tax
     * @param int $installments
     * @return float
     */
    protected function getCompoundTaxInstallmentValue(float $value, float $tax, int $installments): float
    {
        $finalAmount = $value * ((1 + $tax / 100) ** $installments);

        return $finalAmount / $installments;
    }

    /**
     * @return float
     */
    public function getInstallmentInterest(): float
    {
        return $this->uxProductHelper->getInstallmentInterest();
    }

    /**
     * @return float
     */
    public function getMinInstallmentAmount(): float
    {
        return $this->uxProductHelper->getMinInstallmentAmount();
    }

    /**
     * @return bool
     */
    public function hasInterest(): bool
    {
        return ($this->getProduct()->getFinalPrice() / $this->getMinInstallmentAmount()) > $this->getInstallmentsWithoutTax();
    }
}
