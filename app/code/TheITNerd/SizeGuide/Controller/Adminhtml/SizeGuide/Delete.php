<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Controller\Adminhtml\SizeGuide;

use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use TheITNerd\SizeGuide\Model\SizeGuide;
use TheITNerd\SizeGuide\Api\SizeGuideRepositoryInterface;

/**
 * Class Delete
 * @package TheITNerd\SizeGuide\Controller\Adminhtml\SizeGuide
 */
class Delete extends \TheITNerd\SizeGuide\Controller\Adminhtml\SizeGuide
{

    /**
     * @param Context $context
     * @param Registry $_coreRegistry
     * @param SizeGuideRepositoryInterface $sizeGuideRepository
     */
    public function __construct(
        Context $context,
        Registry $_coreRegistry,
        protected readonly SizeGuideRepositoryInterface $sizeGuideRepository
    )
    {
        parent::__construct($context, $_coreRegistry);
    }

    /**
     * Delete action
     *
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            try {
                $this->sizeGuideRepository->deleteById($id);
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Sizeguide.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Sizeguide to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}

