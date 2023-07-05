<?php

namespace TheITNerd\SocialLogin\Model;


use Magento\Framework\Exception\LocalizedException;
use TheITNerd\SocialLogin\Api\OauthInterface;

/**
 * Class OAuth
 * @package TheITNerd\SocialLogin\Model
 */
class OAuth
{
    /**
     * @param array $adapters
     */
    public function __construct(
        private readonly array $adapters = []
    )
    {
    }

    /**
     * @param string $oauthCode
     * @return OauthInterface|null
     * @throws LocalizedException
     */
    public function getOathAdapter(string $oauthCode): OauthInterface|null
    {
        if (isset($this->adapters[$oauthCode])) {
            if (!$this->adapters[$oauthCode] instanceof OauthInterface) {
                throw new LocalizedException(__('The OAuth adapter %s must implement \TheITNerd\SocialLogin\Api\OauthInterface', $this->adapters[$oauthCode]));
            }
            return $this->adapters[$oauthCode];
        }

        return null;
    }
}
