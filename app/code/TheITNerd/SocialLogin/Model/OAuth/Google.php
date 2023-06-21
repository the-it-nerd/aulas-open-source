<?php

namespace TheITNerd\SocialLogin\Model\OAuth;


use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\App\Request\Http;
use Google_Client;

/**
 * Class Google
 * @package TheITNerd\SocialLogin\Model\OAuth
 */
class Google implements \TheITNerd\SocialLogin\Api\OauthInterface
{
    public function __construct(
        private readonly \Magento\Customer\Api\Data\CustomerInterfaceFactory $customerInterfaceFactory,
        private readonly \TheITNerd\SocialLogin\Helper\Config $config
    ){}

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
