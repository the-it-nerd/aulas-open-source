<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Controller\Adminhtml\SizeGuide;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use TheITNerd\EAV\Model\EntityUseDefault;
use TheITNerd\SizeGuide\Api\SizeGuideRepositoryInterface;

/**
 * Class Save
 * @package TheITNerd\SizeGuide\Controller\Adminhtml\SizeGuide
 */
class Save extends Action
{

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param EntityUseDefault $entityUseDefault
     * @param SizeGuideRepositoryInterface $sizeGuideRepository
     */
    public function __construct(
        Context                                         $context,
        protected readonly DataPersistorInterface       $dataPersistor,
        protected readonly EntityUseDefault             $entityUseDefault,
        protected readonly SizeGuideRepositoryInterface $sizeGuideRepository
    )
    {
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $storeId = (int)$this->getRequest()->getParam('store_id');
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('entity_id');

            $model = (!is_null($id)) ? $this->sizeGuideRepository->get($id) : $this->sizeGuideRepository->create();
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Size Guide no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            if(isset($data['image'][0]['name'])) {
                $data['image'] = "/media/size_guides/{$data['image'][0]['name']}";
            }

            $model->setStoreId($storeId)
                ->setData($data);

            $this->entityUseDefault->apply($model, $data);

            try {
                $model = $this->sizeGuideRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the Sizeguide.'));
                $this->dataPersistor->clear('theitnerd_sizeguide_sizeguide');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['entity_id' => $model->getId(), 'store' => $storeId]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Sizeguide.'));
            }

            $this->dataPersistor->set('theitnerd_sizeguide_sizeguide', $data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}

