<?php

namespace TheITNerd\Brasil\Model\Config;

use Magento\Framework\App\ObjectManager;

class PostcodeAdapters implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var array
     */
    private array $adapters;

    /**
     * @param array $adapters
     */
    public function __construct(
        array $adapters = []
    ) {
        $this->adapters = $adapters;
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        $data = [];

        foreach($this->adapters as $adapter) {
            /**
             * @var $tmpClass \TheITNerd\Brasil\Api\Adapters\PostcodeClientInterface
             */
            $tmpClass = ObjectManager::getInstance()->get($adapter);

            $data[] = [
                'label' => __($tmpClass->getLabel()),
                'value' => $adapter
            ];
        }

        return $data;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [];

        foreach($this->toOptionArray() as $adapter) {
            $data[$adapter['value']] = $adapter['label'];
        }

        return $data;
    }
}
