<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Controller\Adminhtml\SizeGuide;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        protected readonly \TheITNerd\EAV\Model\EntityUseDefault $entityUseDefault,
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $storeId = (int) $this->getRequest()->getParam('store_id');
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('entity_id');

            $model = $this->_objectManager->create(\TheITNerd\SizeGuide\Model\SizeGuide::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Sizeguide no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setStoreId($storeId);
            $model->setData($data);

            $this->entityUseDefault->apply($model, $data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Sizeguide.'));
                $this->dataPersistor->clear('theitnerd_sizeguide_sizeguide');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['entity_id' => $model->getId(), 'store' => $storeId]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Sizeguide.'));
            }

            $this->dataPersistor->set('theitnerd_sizeguide_sizeguide', $data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}

