<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Controller\Adminhtml\SizeGuide;

class Edit extends \TheITNerd\SizeGuide\Controller\Adminhtml\SizeGuide
{

    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('entity_id');
        $model = $this->_objectManager->create(\TheITNerd\SizeGuide\Model\SizeGuide::class);

        // 2. Initial checking
        if ($id) {
            $storeId = (int) $this->getRequest()->getParam('store', 0);
            $model->load($id)
            ->setStoreId($storeId);

            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Sizeguide no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('theitnerd_sizeguide_sizeguide', $model);

        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Sizeguide') : __('New Sizeguide'),
            $id ? __('Edit Sizeguide') : __('New Sizeguide')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Sizeguides'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Sizeguide %1', $model->getId()) : __('New Sizeguide'));
        return $resultPage;
    }
}

