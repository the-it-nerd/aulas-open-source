<?php

namespace TheITNerd\UX\Model\Config\Source;


/**
 * Class LinkType
 * @package TheITNerd\UX\Model\Config\Source
 */
class LinkType  implements \Magento\Framework\Option\ArrayInterface
{
    public const POPUP_LINK_TYPE = '_popup';

    public const CONFIG = [
        '_blank' => 'New Tab',
        '_popup' => 'Popup'
    ];

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $data = [];

        foreach (self::CONFIG as $key => $value) {
            $data[] = [
                'value' => $key,
                'label' => __($value)
            ];
        }

        return $data;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return self::CONFIG;
    }
}
