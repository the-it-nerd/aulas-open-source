<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Controller\Adminhtml\Rates;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use SnapPoints\Loyalty\Controller\Adminhtml\Rates;

class NewAction extends Rates
{

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context                           $context,
        Registry                          $coreRegistry,
        protected readonly ForwardFactory $resultForwardFactory
    )
    {
        parent::__construct($context, $coreRegistry);
    }

    /**
     * New action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        return $this->resultForwardFactory->create()
            ->forward('edit');
    }
}

