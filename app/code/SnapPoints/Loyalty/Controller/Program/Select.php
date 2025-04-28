<?php

namespace SnapPoints\Loyalty\Controller\Program;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Customer\Model\SessionFactory as CustomerSessionFactory;
use Magento\Framework\Exception\LocalizedException;


class Select implements HttpPostActionInterface // Or HttpGetActionInterface if using GET
{
    public const SELECTED_PROGRAM_SESSION_KEY = 'selected_snappoints_program_id';

    /**
     * @param RequestInterface $request
     * @param JsonFactory $resultJsonFactory
     * @param CustomerSessionFactory $customerSessionFactory
     */
    public function __construct(
        private readonly RequestInterface $request, // Injected via Context in older Magento versions
        private readonly JsonFactory $resultJsonFactory,
        private readonly CustomerSessionFactory $customerSessionFactory
    ) {
    }

    /**
     * Execute action based on request and return result
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $programId = $this->request->getParam('program_id');

        if ($programId) {
            try {
                $validatedProgramId = filter_var($programId, FILTER_SANITIZE_NUMBER_INT);
                if (!$validatedProgramId) {
                    //todo valdiate this with the database to se if its a valid program
                    throw new LocalizedException(__('Invalid Program ID provided.'));
                }

                $customerSession = $this->customerSessionFactory->create();
                $customerSession->setData(self::SELECTED_PROGRAM_SESSION_KEY, $validatedProgramId);

                return $result->setData(['success' => true, 'message' => __('Program selection saved.')]);
            } catch (LocalizedException $e) {
                return $result->setData(['success' => false, 'message' => $e->getMessage()]);
            } catch (\Exception $e) {
                //TODO add error log here
                return $result->setData(['success' => false, 'message' => __('An error occurred while saving the program selection.')]);
            }
        }

        return $result->setData(['success' => false, 'message' => __('No Program ID provided.')]);
    }
}
