<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Controller\Adminhtml\Program;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use SnapPoints\Loyalty\Model\Program;

class Edit extends \SnapPoints\Loyalty\Controller\Adminhtml\Program
{

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context                        $context,
        Registry                       $coreRegistry,
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
        $id = $this->getRequest()->getParam('program_id');
        $model = $this->_objectManager->create(Program::class);

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Program no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('snappoints_loyalty_program', $model);

        // 3. Build edit form
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Program') : __('New Program'),
            $id ? __('Edit Program') : __('New Program')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Programs'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Program %1', $model->getId()) : __('New Program'));
        return $resultPage;
    }
}

