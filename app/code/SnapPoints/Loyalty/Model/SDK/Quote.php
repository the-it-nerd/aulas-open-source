<?php

namespace SnapPoints\Loyalty\Model\SDK;

use DateInvalidTimeZoneException;
use DateMalformedStringException;
use DateTime;
use DateTimeZone;
use GuzzleHttp\Exception\GuzzleException;
use Magento\Directory\Model\Currency;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Stdlib\DateTime\Timezone;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\Quote\Address;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use SnapPoints\Loyalty\Api\ProgramRepositoryInterface;
use SnapPoints\Loyalty\Helper\Config;
use Snappoints\Sdk\DataObjects\Collection\TransactionItemCollection;
use Snappoints\Sdk\DataObjects\Entities\Customer;
use Snappoints\Sdk\DataObjects\Entities\TransactionItem;
use Snappoints\Sdk\DataObjects\Entities\TransactionQuotation;
use Snappoints\Sdk\DataObjects\Interfaces\Objects\CustomerInterface;
use Snappoints\Sdk\DataObjects\Interfaces\Objects\TransactionQuotationInterface;

class Quote extends BaseSDK
{

    public function __construct(
        Config                                        $config,
        Currency                                      $currency,
        StoreManagerInterface                         $storeManager,
        protected readonly Timezone                   $timezone,
        protected readonly ProgramRepositoryInterface $programRepository
    )
    {
        parent::__construct($config, $currency, $storeManager);
    }

    /**
     * @param CartInterface $cart
     * @param string $programID
     * @return TransactionQuotationInterface
     * @throws DateMalformedStringException
     * @throws GuzzleException
     * @throws DateInvalidTimeZoneException
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function syncQuote(CartInterface $cart, string $programID): TransactionQuotationInterface
    {
        //TODO check quote hash from database if cached
        $program = $this->programRepository->get($programID);

        $items = new TransactionItemCollection();

        foreach ($cart->getItems() as $item) {
            $items->add(
                new TransactionItem()
                    ->setType('purchase')
                    ->setCurrency($this->storeManager->getStore()->getBaseCurrencyCode())
                    ->setProductId($item->getProduct()->getData('sku'))
                    ->setVariantId($item->getSku())
                    ->setSpend((float)$item->getRowTotal() / $item->getQty())
                    ->setQuantity($item->getQty())
                    ->setExternalId($item->getId())
            );
        }

        $timezone = $this->timezone->getConfigTimezone(ScopeInterface::SCOPE_STORES, $this->storeManager->getStore()->getId());

        $quote = new TransactionQuotation()
            ->setItems($items)
            //TODO this needs to come from a config?
            ->setProcessingDays(45)
            ->setOrderedAt(new DateTime('now', new DateTimeZone($timezone)))
            //TODO get from the api request, replace the email?
            ->setLoyaltyProgramId($program->getExternalId());

        //TODO save quote on the database
        return $this->getQuoteSDK()->createTransaction($quote);

    }

    /**
     * @param CartInterface $cart
     * @param string $customerEmail
     * @return CustomerInterface
     * @throws DateMalformedStringException
     * @throws GuzzleException
     */
    protected function getSnapCustomer(CartInterface $cart, string $customerEmail): CustomerInterface
    {
        $email = $this->getCustomerEmail($cart, $customerEmail);
        $customer = new Customer()
            ->setExternalId($email)
            ->setEmail($email)
            ->setFirstName($this->getCustomerFirstName($cart))
            ->setLastName($this->getCustomerLastName($cart));
        return $this->getCustomerSDK()->upsertCustomer($customer);
    }

    /**
     * @param CartInterface $cart
     * @param string $customerEmail
     * @return string
     */
    protected function getCustomerEmail(CartInterface $cart, string $customerEmail): string
    {
        return $cart->getCustomerEmail() ?? $customerEmail;
    }

    /**
     * @param CartInterface $cart
     * @return string
     */
    protected function getCustomerFirstName(CartInterface $cart): string
    {
        if ($cart->getCustomerFirstname()) {
            return $cart->getCustomerFirstname();
        }

        return $this->getOrderAddress($cart)->getFirstname();

    }

    /**
     * @param CartInterface $cart
     * @return Address|AddressInterface|null
     */
    protected function getOrderAddress(CartInterface $cart): Address|AddressInterface|null
    {
        if ($cart->getBillingAddress()->getFirstname()) {
            return $cart->getBillingAddress();
        }

        return $cart->getShippingAddress();
    }

    /**
     * @param CartInterface $cart
     * @return string
     */
    protected function getCustomerLastName(CartInterface $cart): string
    {
        if ($cart->getCustomerLastname()) {
            return $cart->getCustomerLastname();
        }

        return $this->getOrderAddress($cart)->getLastname();

    }
}
