<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Controller\Adminhtml\Rates;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use SnapPoints\Loyalty\Model\Rates;

class Edit extends \SnapPoints\Loyalty\Controller\Adminhtml\Rates
{


    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context                        $context,
        protected readonly Registry    $coreRegistry,
        protected readonly PageFactory $resultPageFactory
    )
    {
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('rates_id');
        $model = $this->_objectManager->create(Rates::class);

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Rates no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('snappoints_loyalty_rates', $model);

        // 3. Build edit form
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Rate') : __('New Rate'),
            $id ? __('Edit Rate') : __('New Rate')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Rates'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Rate %1', $model->getId()) : __('New Rate'));
        return $resultPage;
    }
}

