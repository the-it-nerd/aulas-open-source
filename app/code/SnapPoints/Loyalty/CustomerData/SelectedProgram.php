<?php

namespace SnapPoints\Loyalty\CustomerData;


use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Model\SessionFactory as CustomerSessionFactory;
use SnapPoints\Loyalty\Controller\Program\Select as ProgramController; // Use the controller constant

class SelectedProgram implements SectionSourceInterface
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    private \Magento\Customer\Model\Session $session;

    /**
     * @param CustomerSessionFactory $customerSessionFactory
     * @param \SnapPoints\Loyalty\Model\ResourceModel\Program\CollectionFactory $collectionFactory
     */
    public function __construct(
        protected readonly CustomerSessionFactory $customerSessionFactory,
        protected readonly \SnapPoints\Loyalty\Model\ResourceModel\Program\CollectionFactory $collectionFactory
    ) {
        $this->session = $this->customerSessionFactory->create();
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getSectionData()
    {
        $programId = $this->session->getData(ProgramController::SELECTED_PROGRAM_SESSION_KEY);

        if (!$programId) {
            $programId = $this->selectDefaultProgram();
        } else {
            $programId = (int)$programId;
        }

        return ['programId' => $programId];
    }

    /**
     * @return int
     */
    protected function selectDefaultProgram(): int
    {
        $itemID = $this->collectionFactory->create()->addFieldToFilter('points_per_spend_deleted_at', ['null' => true])->getFirstItem()
            ->getProgramId();

        $this->session->setData(ProgramController::SELECTED_PROGRAM_SESSION_KEY, $itemID);

        return $itemID;
    }
}
