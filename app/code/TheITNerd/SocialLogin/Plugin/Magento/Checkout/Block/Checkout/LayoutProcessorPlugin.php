<?php

namespace TheITNerd\SocialLogin\Plugin\Magento\Checkout\Block\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessor;
use TheITNerd\SocialLogin\Helper\Config;

/**
 * Class LayoutProcessorPlugin
 * @package TheITNerd\SocialLogin\Plugin\Magento\Checkout\Block\Checkout
 */
class LayoutProcessorPlugin
{
    /**
     * @param Config $helper
     */
    public function __construct(
        private readonly Config $helper
    )
    {
    }

    /**
     * @param LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        LayoutProcessor $subject,
        array           $jsLayout
    )
    {
        $jsLayout['components']['checkout']['children']['authentication']['children']['social_login'] = [
            'component' => 'TheITNerd_SocialLogin/js/view/socialLogin',
            'displayArea' => 'additional-login-form-fields',
            'configSource' => 'checkoutConfig',
            'is_google_enabled' => $this->helper->isGoogleEnabled(),
            'is_facebook_enabled' => $this->helper->isFacebookEnabled(),
            'config' => [
                'template' => 'TheITNerd_SocialLogin/authentication-popup-buttons'
            ]

        ];

        return $jsLayout;
    }
}
