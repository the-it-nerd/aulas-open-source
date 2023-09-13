<?php

namespace TheITNerd\UX\Model\Config\Source\Magnifier;


/**
 * Class LinkType
 * @package TheITNerd\UX\Model\Config\Source
 */
class Mode  implements \Magento\Framework\Option\ArrayInterface
{
    public const POPUP_LINK_TYPE = '_popup';

    public const CONFIG = [
        'outside' => 'Outside the image',
        'inside' => 'Inside the image'
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
