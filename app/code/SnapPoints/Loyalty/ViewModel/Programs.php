<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\ViewModel;

use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Programs extends DataObject implements ArgumentInterface
{

    /**
     * Programs constructor.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getPrograms()
    {
        //Your viewModel code
        // you can use me in your template like:
        // $viewModel = $block->getData('viewModel');
        // echo $viewModel->getPrograms();

        return __('Hello Developer!');
    }
}

