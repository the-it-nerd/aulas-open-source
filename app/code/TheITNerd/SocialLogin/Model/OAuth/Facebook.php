<?php

namespace TheITNerd\SocialLogin\Model\OAuth;


use League\OAuth2\Client\Token\AccessToken;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Framework\App\Request\Http;
use TheITNerd\SocialLogin\Api\OauthInterface;
use TheITNerd\SocialLogin\Helper\Config;
use League\OAuth2\Client\Provider\Facebook as FacebookClient;
/**
 * Class Facebook
 * @package TheITNerd\SocialLogin\Model\OAuth
 */
class Facebook implements OauthInterface
{
    /**
     * @param CustomerInterfaceFactory $customerInterfaceFactory
     * @param Config $config
     */
    public function __construct(
        private readonly CustomerInterfaceFactory $customerInterfaceFactory,
        private readonly Config                   $config
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function getCustomerData(Http $request): null|CustomerInterface
    {
        $provider = new FacebookClient([
            'clientId' => $this->config->getFacebookAppId(),
            'clientSecret' => $this->config->getFacebookAppSecret(),
            'redirectUri' => $this->config->getFacebookLoginCallback(),
            'graphApiVersion' => 'v2.10',
        ]);

        $accessToken = new AccessToken(['access_token' => $request->getParam('accessToken')]);

        $response = $provider->getResourceOwner($accessToken);


        if ($response) {
            $customer = $this->customerInterfaceFactory->create();
            return $customer->setEmail($response->getEmail())
                ->setFirstname($response->getFirstName())
                ->setLastname($response->getLastName());
        }

        return null;
    }
}
