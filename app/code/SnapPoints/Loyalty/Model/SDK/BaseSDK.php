<?php

namespace SnapPoints\Loyalty\Model\SDK;

use Magento\Directory\Model\Currency;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use SnapPoints\Loyalty\Helper\Config;
use Snappoints\Sdk\Client\ClientFacade;
use Snappoints\Sdk\Client\Merchant\Customer;
use Snappoints\Sdk\Client\Merchant\MaxGiveBackRatio;
use Snappoints\Sdk\Client\Merchant\Product\Product;
use Snappoints\Sdk\Client\Merchant\Program\LoyaltyProgram;
use Snappoints\Sdk\Client\Merchant\Sales\Quotations;
use Snappoints\Sdk\DataObjects\Entities\AuthenticationRequest;


class BaseSDK
{

    /**
     * @var ClientFacade
     */
    protected ClientFacade $facade;

    /**
     * Constructor method.
     *
     * @param Config $config Configuration helper instance.
     * @return void
     * @throws NoSuchEntityException
     */
    public function __construct(
        protected readonly Config                $config,
        protected readonly Currency              $currency,
        protected readonly StoreManagerInterface $storeManager,
    )
    {
        $this->buildFacade();
    }

    /**
     * Builds and configures the facade for the Client.
     *
     * @return ClientFacade Configured instance of the ClientFacade.
     * @throws NoSuchEntityException
     */
    protected function buildFacade(): ClientFacade
    {
        $authRequest = (new AuthenticationRequest)
            ->setGrantType('client_credentials')
            ->setUsername($this->config->getClientId())
            ->setPassword($this->config->getClientSecret())
            ->setScope([
                'me',
                'merchants:products-attributes:read',
                'merchants:products-attributes:write',
                'merchants:products:read',
                'merchants:products:write',
                'merchants:loyalty-programs:read',
                'merchants:points-settings:read',
                'merchants:transactions:write',
                'merchants:transactions:read',
                'merchants:customers:write',
                'merchants:customers:read'
            ]);

        //todo: add config to enable debug
        $this->facade = new ClientFacade($authRequest, $this->config->getMerchantId(), $this->storeManager->getStore()->getBaseCurrencyCode(), !$this->config->isProductionMode(), false);

        return $this->facade;
    }

    /**
     * @return \Snappoints\Sdk\Client\Merchant\Product\PointsSettingsRules
     */
    public function getPointsRulesSDK(): \Snappoints\Sdk\Client\Merchant\Product\PointsSettingsRules
    {
        return $this->facade->getPointsSettingsRulesClient();
    }

    /**
     * Retrieves the Product SDK client instance.
     *
     * @return Product The Product SDK client.
     */
    public function getProductSDK(): Product
    {
        return $this->facade->getProductClient();
    }

    /**
     * Retrieves the Loyalty Program SDK client instance.
     *
     * @return LoyaltyProgram The Loyalty Program SDK client.
     */
    public function getLoyaltyProgramSDK(): LoyaltyProgram
    {
        return $this->facade->getLoyaltyProgramClient();
    }

    /**
     * @return Quotations
     */
    public function getQuoteSDK(): Quotations
    {
        return $this->facade->getQuotationClient();
    }

    /**
     * @return Customer
     */
    public function getCustomerSDK(): Customer
    {
        return $this->facade->getCustomerClient();
    }

    /**
     * @return MaxGiveBackRatio
     */
    public function getMaxGiveBackRatio(): MaxGiveBackRatio
    {
        return $this->facade->getMaxGiveBackRatioClient();
    }
}
