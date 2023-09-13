<?php /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */

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
class Gallery extends AbstractHelper
{
    public const UX_PDP_GALLERY_ENABLED_CONFIG_PATH = "ux/pdp_gallery/enabled";
    public const UX_PDP_GALLERY_MAGNIFIER_ENABLED_CONFIG_PATH = "ux/pdp_gallery/magnifier_enabled";
    public const UX_PDP_GALLERY_MAGNIFIER_FULLSCREENZOOM_CONFIG_PATH = "ux/pdp_gallery/magnifier_fullscreenzoom";
    public const UX_PDP_GALLERY_MAGNIFIER_TOP_CONFIG_PATH = "ux/pdp_gallery/magnifier_top";
    public const UX_PDP_GALLERY_MAGNIFIER_LEFT_CONFIG_PATH = "ux/pdp_gallery/magnifier_left";
    public const UX_PDP_GALLERY_MAGNIFIER_WIDTH_CONFIG_PATH = "ux/pdp_gallery/magnifier_width";
    public const UX_PDP_GALLERY_MAGNIFIER_HEIGHT_CONFIG_PATH = "ux/pdp_gallery/magnifier_height";
    public const UX_PDP_GALLERY_MAGNIFIER_EVENTTYPE_CONFIG_PATH = "ux/pdp_gallery/magnifier_eventType";
    public const UX_PDP_GALLERY_MAGNIFIER_MODE_CONFIG_PATH = "ux/pdp_gallery/magnifier_mode";


    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::UX_PDP_GALLERY_ENABLED_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return bool
     */
    public function isMagnifierEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::UX_PDP_GALLERY_MAGNIFIER_ENABLED_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return int
     */
    public function getMagnifierTop(): int
    {
        return (int)$this->scopeConfig->getValue(self::UX_PDP_GALLERY_MAGNIFIER_TOP_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return int
     */
    public function getMagnifierFullscreenzoom(): int
    {
        return (int)$this->scopeConfig->getValue(self::UX_PDP_GALLERY_MAGNIFIER_FULLSCREENZOOM_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return int
     */
    public function getMagnifierLeft(): int
    {
        return (int)$this->scopeConfig->getValue(self::UX_PDP_GALLERY_MAGNIFIER_LEFT_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return int
     */
    public function getMagnifierWidth(): int
    {
        return (int)$this->scopeConfig->getValue(self::UX_PDP_GALLERY_MAGNIFIER_WIDTH_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return int
     */
    public function getMagnifierHeight(): int
    {
        return (int)$this->scopeConfig->getValue(self::UX_PDP_GALLERY_MAGNIFIER_HEIGHT_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getMagnifierEventType():string
    {
        return $this->scopeConfig->getValue(self::UX_PDP_GALLERY_MAGNIFIER_EVENTTYPE_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getMagnifierMode():string
    {
        return $this->scopeConfig->getValue(self::UX_PDP_GALLERY_MAGNIFIER_MODE_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
    }


}
