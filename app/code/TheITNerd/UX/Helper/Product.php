<?php /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */

namespace TheITNerd\UX\Helper;

use Magento\Catalog\Model\Product as ProductModel;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Pricing\Helper\Data;

/**
 * Class Config
 * @package TheITNerd\UX\Helper
 */
class Product extends AbstractHelper
{

    public const UX_PDP_ENABLED_QTY_BTN_CONFIG_PATH = 'ux/pdp/enabled_qty_btn';
    public const UX_CASH_DISCOUNT_ENABLED_CONFIG_PATH = 'ux/cash_discount/enabled';
    public const UX_CASH_DISCOUNT_AMOUNT_CONFIG_PATH = 'ux/cash_discount/amount';
    public const UX_CASH_DISCOUNT_PAYMENT_TYPE_CONFIG_PATH = 'ux/cash_discount/payment_type';
    public const UX_INSTALLMENT_ENABLED = "ux/installment/enabled";
    public const UX_INSTALLMENT_MIN_INSTALLMENT = "ux/installment/min_installment";
    public const UX_INSTALLMENT_MAX_INSTALLMENT = "ux/installment/max_installment";
    public const UX_INSTALLMENT_NO_TAX_INSTALLMENT = "ux/installment/no_tax_installment";
    public const UX_INSTALLMENT_INSTALLMENT_TX = "ux/installment/installment_tx";


    public function __construct(
        Context                                                 $context,
        private readonly Data $priceHelper
    )
    {
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    public function canShowPDPQtyButtons(): bool
    {
        return $this->scopeConfig->isSetFlag(self::UX_PDP_ENABLED_QTY_BTN_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @param ProductModel $product
     * @return bool
     */
    public function hasInterest(ProductModel $product): bool
    {
        return ($product->getFinalPrice() / $this->getMinInstallmentAmount()) > $this->getInstallmentsWithoutTax();
    }

    /**
     * @return float
     */
    public function getMinInstallmentAmount(): float
    {
        return (float)$this->scopeConfig->getValue(self::UX_INSTALLMENT_MIN_INSTALLMENT, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return int
     */
    public function getInstallmentsWithoutTax(): int
    {
        return (int)$this->scopeConfig->getValue(self::UX_INSTALLMENT_NO_TAX_INSTALLMENT, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @param ProductModel $product
     * @return string
     */
    public function getCashDiscountedPrice(ProductModel $product): string
    {
        $discountedPrice = $this->getProductCashDiscountedPrice($product);

        if (!is_null($discountedPrice)) {
            return "<div class='cash-discount'>
                <span class='cash-discount--price'>{$this->priceHelper->currency($discountedPrice)}</span>
                <span class='cash-discount--text'>"
                . __("Paying with <strong>%1</strong> you have up to <strong>%2% OFF</strong>", $this->getCashDiscountPaymentType(), $this->getCashDiscountAmount())
                . "</span>
            </div>";

        }

        return "";
    }

    /**
     * @param ProductModel $product
     * @return float|null
     */
    public function getProductCashDiscountedPrice(ProductModel $product): float|null
    {
        if (
            $this->canShowCashDiscount()
            && $this->getCashDiscountAmount() > 0
            && $price = $product->getFinalPrice()
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
        return $this->scopeConfig->isSetFlag(self::UX_CASH_DISCOUNT_ENABLED_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return float
     */
    public function getCashDiscountAmount(): float
    {
        return (float)$this->scopeConfig->getValue(self::UX_CASH_DISCOUNT_AMOUNT_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string|null
     */
    public function getCashDiscountPaymentType(): string|null
    {
        return $this->scopeConfig->getValue(self::UX_CASH_DISCOUNT_PAYMENT_TYPE_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @param ProductModel $product
     * @return string
     */
    public function getProductInstallments(ProductModel $product): string
    {
        $html = '';

        if ($this->canShowInstallments()) {
            $uid = str_replace('.', '', uniqid('installments-modal-', true));

            $html .= "<div class='installments'>
                    <div class='installments--no-interest'>"
                . __("Or in <strong>%1</strong> easy installments of <strong>%2</strong> without interest", $this->getInstallmentsWithoutTax(), $this->priceHelper->currency($this->getInstallmentsWithoutTaxAmount($product)))
                . "</div>
                    <a href='javascript:void(0)' id='{$uid}-trigger'  class='installments--trigger'>"
                . __('More installment options')
                . "</a>
                    <div class='installments--table' id='{$uid}' style='display: none'>";

            foreach ($this->getInstallmentsTableArray($product) as $item) {
                $html .= "<div class='installments--table--item'>"
                    . __('%1 easy installments of %2%3', $item['qty'], $this->priceHelper->currency($item['price']), ($item['hasTax']) ? '*' : '')
                    . "</div>";
            }


            $html .= "<small>"
                . __('* With interest of %1%/month', $this->getInstallmentInterest())
                . "</small>
            </div>
            <script type='text/x-magento-init'>
                {
                    \"#{$uid}\": {
                        \"Magento_Ui/js/modal/modal\": {
                            \"buttons\": false,
                            \"modalClass\": \"modal-installments\",
                            \"trigger\": \"#{$uid}-trigger\",
                            \"title\": \" " . __('Installments') . "\"
                        }
                    }
                }
            </script>
            </div>";
        }

        return $html;
    }

    /**
     * @return bool
     */
    public function canShowInstallments(): bool
    {
        return $this->scopeConfig->isSetFlag(self::UX_INSTALLMENT_ENABLED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @param ProductModel $product
     * @return float
     */
    public function getInstallmentsWithoutTaxAmount(ProductModel $product): float
    {
        return $product->getFinalPrice() / $this->getInstallmentsWithoutTax();
    }

    /**
     * @param ProductModel $product
     * @return array
     */
    public function getInstallmentsTableArray(ProductModel $product): array
    {
        $price = $product->getFinalPrice();

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
        return (int)$this->scopeConfig->getValue(self::UX_INSTALLMENT_MAX_INSTALLMENT, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @param float $value
     * @param float $tax
     * @param int $installments
     * @return float
     */
    protected function getCompoundTaxInstallmentValue(float $value, float $tax, int $installments): float
    {
        $finalAmount = $value * pow((1 + $tax / 100), $installments);

        return $finalAmount / $installments;
    }

    /**
     * @return float
     */
    public function getInstallmentInterest(): float
    {
        return (float)$this->scopeConfig->getValue(self::UX_INSTALLMENT_INSTALLMENT_TX, ScopeInterface::SCOPE_STORE);
    }

}
