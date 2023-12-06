<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Controller\Adminhtml\SizeGuide;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use TheITNerd\SizeGuide\Controller\Adminhtml\SizeGuide;

/**
 * Class NewAction
 * @package TheITNerd\SizeGuide\Controller\Adminhtml\SizeGuide
 */
class NewAction extends SizeGuide
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
        return $this->resultForwardFactory->create()->forward('edit');
    }
}

