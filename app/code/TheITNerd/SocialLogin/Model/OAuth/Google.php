<?php

namespace TheITNerd\SocialLogin\Model\OAuth;


use Google_Client;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Framework\App\Request\Http;
use TheITNerd\SocialLogin\Api\OauthInterface;
use TheITNerd\SocialLogin\Helper\Config;

/**
 * Class Google
 * @package TheITNerd\SocialLogin\Model\OAuth
 */
class Google implements OauthInterface
{
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
        $client = new Google_Client(['client_id' => $this->config->getGoogleClientId()]);
        $payload = $client->verifyIdToken($request->getParam('credential'));

        if ($payload) {
            $customer = $this->customerInterfaceFactory->create();

            return $customer->setEmail($payload['email'])
                ->setFirstname($payload['given_name'])
                ->setLastname($payload['family_name']);
        }

        return null;
    }
}
