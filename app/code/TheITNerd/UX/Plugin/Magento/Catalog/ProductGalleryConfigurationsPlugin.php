<?php

namespace TheITNerd\UX\Plugin\Magento\Catalog;


use Magento\Catalog\Block\Product\View\Gallery;
use  Magento\Framework\Serialize\Serializer\Json;

/**
 * Class ProductGalleryConfigurationsPlugin
 * @package TheITNerd\UX\Plugin\Magento\Catalog
 */
readonly class ProductGalleryConfigurationsPlugin
{

    public function __construct(
        private \TheITNerd\UX\Helper\Gallery $galleryHelper,
        private Json                         $jsonEncoder,
    )
    {
    }

    /**
     * @param Gallery $subject
     * @param string $result
     * @return string
     */
    public function afterGetMagnifier(Gallery $subject, string $result): string
    {
        if($this->galleryHelper->isEnabled() || $this->galleryHelper->isMagnifierEnabled()) {
            $var = $this->jsonEncoder->unserialize($result);

            if($var){
                $var['enabled'] = $this->galleryHelper->isMagnifierEnabled();
                $var['fullscreenzoom'] = $this->galleryHelper->getMagnifierFullscreenzoom();
                $var['top'] = $this->galleryHelper->getMagnifierTop();
                $var['left'] = $this->galleryHelper->getMagnifierLeft();
                $var['width'] = $this->galleryHelper->getMagnifierWidth();
                $var['height'] = $this->galleryHelper->getMagnifierHeight();
                $var['eventType'] = $this->galleryHelper->getMagnifierEventType();
                $var['mode'] = $this->galleryHelper->getMagnifierMode();

                $result = $this->jsonEncoder->serialize($var);
            }
        }

        return $result;
    }
}
