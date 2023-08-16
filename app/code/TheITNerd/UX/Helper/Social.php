<?php

namespace TheITNerd\UX\Helper;

use Magento\Catalog\Model\Product as ProductModel;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Pricing\Helper\Data;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Config
 * @package TheITNerd\UX\Helper
 */
class Social extends AbstractHelper
{

    public const UX_FACEBOOK_SHARE_ENABLED_CONFIG_PATH = 'ux/facebook_share/enabled';
    public const UX_FACEBOOK_SHARE_LINK_TEXT_CONFIG_PATH = 'ux/facebook_share/link_text';
    public const UX_FACEBOOK_SHARE_LINK_TYPE_CONFIG_PATH = 'ux/facebook_share/link_type';
    public const UX_FACEBOOK_SHARE_POPUP_WIDTH_CONFIG_PATH = 'ux/facebook_share/popup_width';
    public const UX_FACEBOOK_SHARE_POPUP_HEIGHT_CONFIG_PATH = 'ux/facebook_share/popup_height';
    public const UX_FACEBOOK_SHARE_POPUP_SCROLLBARS_CONFIG_PATH = 'ux/facebook_share/popup_scrollbars';
    public const UX_FACEBOOK_SHARE_POPUP_RESIZABLE_CONFIG_PATH = 'ux/facebook_share/popup_resizable';
    public const UX_TWITTER_SHARE_ENABLED_CONFIG_PATH = 'ux/twitter_share/enabled';
    public const UX_TWITTER_SHARE_LINK_TEXT_CONFIG_PATH = 'ux/twitter_share/link_text';
    public const UX_TWITTER_SHARE_SHARE_TEXT_CONFIG_PATH = 'ux/twitter_share/share_text';
    public const UX_TWITTER_SHARE_LINK_TYPE_CONFIG_PATH = 'ux/twitter_share/link_type';
    public const UX_TWITTER_SHARE_POPUP_WIDTH_CONFIG_PATH = 'ux/twitter_share/popup_width';
    public const UX_TWITTER_SHARE_POPUP_HEIGHT_CONFIG_PATH = 'ux/twitter_share/popup_height';
    public const UX_TWITTER_SHARE_POPUP_SCROLLBARS_CONFIG_PATH = 'ux/twitter_share/popup_scrollbars';
    public const UX_TWITTER_SHARE_POPUP_RESIZABLE_CONFIG_PATH = 'ux/twitter_share/popup_resizable';
    public const UX_WHATSAPP_SHARE_ENABLED_CONFIG_PATH = 'ux/whatsapp_share/enabled';
    public const UX_WHATSAPP_SHARE_LINK_TEXT_CONFIG_PATH = 'ux/whatsapp_share/link_text';
    public const UX_WHATSAPP_SHARE_SHARE_TEXT_CONFIG_PATH = 'ux/whatsapp_share/share_text';



    /**
     * @return bool
     */
    public function canShowFacebook(): bool
    {
        return $this->scopeConfig->isSetFlag(self::UX_FACEBOOK_SHARE_ENABLED_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    public function getFacebookLinkText(): string
    {
        return $this->scopeConfig->getValue(self::UX_FACEBOOK_SHARE_LINK_TEXT_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
    public function getFacebookLinkType(): string
    {
        return $this->scopeConfig->getValue(self::UX_FACEBOOK_SHARE_LINK_TYPE_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
    public function getFacebookPopupWidth(): int
    {
        return (int)$this->scopeConfig->getValue(self::UX_FACEBOOK_SHARE_POPUP_WIDTH_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
    public function getFacebookPopupHeight(): int
    {
        return (int)$this->scopeConfig->getValue(self::UX_FACEBOOK_SHARE_POPUP_HEIGHT_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
    public function getFacebookPopupScrollbars(): bool
    {
        return $this->scopeConfig->isSetFlag(self::UX_FACEBOOK_SHARE_POPUP_SCROLLBARS_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
    public function getFacebookPopupResizable(): bool
    {
        return $this->scopeConfig->isSetFlag(self::UX_FACEBOOK_SHARE_POPUP_RESIZABLE_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    public function canShowTwitter(): bool
    {
        return $this->scopeConfig->isSetFlag(self::UX_TWITTER_SHARE_ENABLED_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
    public function getTwitterLinkText(): string
    {
        return $this->scopeConfig->getValue(self::UX_TWITTER_SHARE_LINK_TEXT_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
    public function getTwitterShareText(): string
    {
        return $this->scopeConfig->getValue(self::UX_TWITTER_SHARE_SHARE_TEXT_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
    public function getTwitterLinkType(): string
    {
        return $this->scopeConfig->getValue(self::UX_TWITTER_SHARE_LINK_TYPE_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
    public function getTwitterPopupWidth(): int
    {
        return (int)$this->scopeConfig->getValue(self::UX_TWITTER_SHARE_POPUP_WIDTH_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
    public function getTwitterPopupHeight(): int
    {
        return (int)$this->scopeConfig->getValue(self::UX_TWITTER_SHARE_POPUP_HEIGHT_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
    public function getTwitterPopupScrollbars(): bool
    {
        return $this->scopeConfig->isSetFlag(self::UX_TWITTER_SHARE_POPUP_SCROLLBARS_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
    public function getTwitterPopupResizable(): bool
    {
        return $this->scopeConfig->isSetFlag(self::UX_TWITTER_SHARE_POPUP_RESIZABLE_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    public function canShowWhatsapp(): bool
    {
        return $this->scopeConfig->isSetFlag(self::UX_WHATSAPP_SHARE_ENABLED_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
    public function getWhatsappLinkText(): string
    {
        return $this->scopeConfig->getValue(self::UX_WHATSAPP_SHARE_LINK_TEXT_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }
    public function getWhatsappShareText(): string
    {
        return $this->scopeConfig->getValue(self::UX_WHATSAPP_SHARE_SHARE_TEXT_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }


}
