<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Controller\Adminhtml\SizeGuide;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use TheITNerd\SizeGuide\Api\SizeGuideRepositoryInterface;

/**
 * Class Edit
 * @package TheITNerd\SizeGuide\Controller\Adminhtml\SizeGuide
 */
class Edit extends \TheITNerd\SizeGuide\Controller\Adminhtml\SizeGuide
{


    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param SizeGuideRepositoryInterface $sizeGuideRepository
     */
    public function __construct(
        Context                                         $context,
        Registry                                        $coreRegistry,
        protected readonly PageFactory                  $resultPageFactory,
        protected readonly SizeGuideRepositoryInterface $sizeGuideRepository
    )
    {
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('entity_id');
        $isEdit = false;
        // 2. Initial checking
        if ($id) {
            $isEdit = true;
            $storeId = (int)$this->getRequest()->getParam('store', 0);
            $model = $this->sizeGuideRepository->get($id);
            $model->setStoreId($storeId);

            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Sizeguide no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }

            $this->_coreRegistry->register('theitnerd_sizeguide_sizeguide', $model);
        }

        // 3. Build edit form
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Size Guide') : __('New Size Guide'),
            $id ? __('Edit Size Guide') : __('New Size Guide')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Size Guides'));
        $resultPage->getConfig()->getTitle()->prepend($isEdit ? __('Edit Size Guide %1', $id) : __('New Size Guide'));
        return $resultPage;
    }
}

