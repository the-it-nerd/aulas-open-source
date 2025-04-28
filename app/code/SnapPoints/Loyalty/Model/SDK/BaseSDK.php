<?php

namespace SnapPoints\Loyalty\Model\SDK;

use SnapPoints\Loyalty\Helper\Config;
use Snappoints\Sdk\Client\ClientFacade;
use Snappoints\Sdk\Client\Product\Product;
use Snappoints\Sdk\Client\Program\LoyaltyProgram;
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
     */
    public function __construct(
        protected readonly Config $config,
        protected readonly \Magento\Directory\Model\Currency $currency,
        protected readonly \Magento\Store\Model\StoreManagerInterface $storeManager,
    )
    {
        $this->buildFacade();
    }

    /**
     * Builds and configures the facade for the Client.
     *
     * @return ClientFacade Configured instance of the ClientFacade.
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
                'merchants:loyalty-programs:read'
            ]);

        //todo: add config to enable debug
        $this->facade = new ClientFacade($authRequest, $this->config->getMerchantId(), $this->storeManager->getStore()->getBaseCurrencyCode(), !$this->config->isProductionMode(), false);

        return $this->facade;
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
}
