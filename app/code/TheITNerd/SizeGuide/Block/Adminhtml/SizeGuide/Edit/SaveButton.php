<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Block\Adminhtml\SizeGuide\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveButton
 *
 * This class represents a save button.
 * It extends the GenericButton class and implements the ButtonProviderInterface.
 */
class SaveButton extends GenericButton implements ButtonProviderInterface
{

    /**
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Save Size Guide'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}

