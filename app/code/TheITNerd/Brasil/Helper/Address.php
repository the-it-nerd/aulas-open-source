<?php

namespace TheITNerd\Brasil\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Customer\Helper\Address as CustomerAddressHelper;
use Magento\Framework\App\Helper\Context;

/**
 * Class Address
 * @package TheITNerd\Brasil\Helper
 */
class Address extends AbstractHelper
{

    /**
     * @param Context $context
     * @param CustomerAddressHelper $customerAddressHelper
     */
    public function __construct(
        Context $context,
        protected readonly CustomerAddressHelper $customerAddressHelper
    )
    {
        parent::__construct($context);
    }

    public const STREET_ADDRESS_CONFIG = [
        0 => [
            'label' => 'Street',
            'required' => true
        ],
        1 => [
            'label' => 'Number',
            'required' => true
        ],
        2 => [
            'label' => 'Complement',
            'required' => false
        ],
        3 => [
            'label' => 'Neighborhood',
            'required' => true
        ],
    ];

    /**
     * @param int $id
     * @return string|null
     */
    public function getFieldLabel(int $id): string|null
    {
        return self::STREET_ADDRESS_CONFIG[$id]['label'] ?? null;
    }

    /**
     * @param int $id
     * @return string
     */
    public function getWrapperValidationClass(int $id): string
    {
        if ($this->getFieldIsRequired($id)) {
            return 'required';
        }

        return '';
    }

    /**
     * @param int $id
     * @return bool
     */
    public function getFieldIsRequired(int $id): bool
    {
        return isset(self::STREET_ADDRESS_CONFIG[$id]['required']) && self::STREET_ADDRESS_CONFIG[$id]['required'];
    }

    /**
     * @param int $id
     * @return string
     */
    public function getFieldValidationClass(int $id): string
    {
        if (isset(self::STREET_ADDRESS_CONFIG[$id]['required']) && self::STREET_ADDRESS_CONFIG[$id]['required']) {
            return 'required-entry';
        }

        return '';
    }

    /**
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function companyAddressGetStreetLines(): int
    {
        return $this->customerAddressHelper->getStreetLines();
    }
}
