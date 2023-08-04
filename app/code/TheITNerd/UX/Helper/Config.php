<?php

namespace TheITNerd\UX\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\ObjectManager;
use Magento\Store\Model\ScopeInterface;
use TheITNerd\Core\Api\Adapters\PostcodeClientInterface;

/**
 * Class Config
 * @package TheITNerd\UX\Helper
 */
class Config extends AbstractHelper
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

    /**
     * @return bool
     */
    public function canShowPDPQtyButtons(): bool
    {
        return $this->scopeConfig->isSetFlag(self::UX_PDP_ENABLED_QTY_BTN_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
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
     * @return bool
     */
    public function canShowInstallments(): bool
    {
        return $this->scopeConfig->isSetFlag(self::UX_INSTALLMENT_ENABLED, ScopeInterface::SCOPE_STORE);
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
    public function getMaxInstallments(): int
    {
        return (int)$this->scopeConfig->getValue(self::UX_INSTALLMENT_MAX_INSTALLMENT, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return int
     */
    public function getInstallmentsWithoutTax(): int
    {
        return (int)$this->scopeConfig->getValue(self::UX_INSTALLMENT_NO_TAX_INSTALLMENT, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return float
     */
    function getInstallmentTax(): float
    {
        return (float)$this->scopeConfig->getValue(self::UX_INSTALLMENT_INSTALLMENT_TX, ScopeInterface::SCOPE_STORE);
    }







}
