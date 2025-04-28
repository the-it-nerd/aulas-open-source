<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\ViewModel;

use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\View\Helper\SecureHtmlRenderer;
use Magento\Store\Model\StoreManagerInterface;
use SnapPoints\Loyalty\Api\Data\ProgramInterface;
use SnapPoints\Loyalty\Model\ResourceModel\Program\Collection;
use SnapPoints\Loyalty\Model\ResourceModel\Program\CollectionFactory;

class Programs extends DataObject implements ArgumentInterface
{

    /**
     * @param CollectionFactory $collectionFactory
     * @param SecureHtmlRenderer $secureRenderer
     * @param FormKey $formKey
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        protected readonly CollectionFactory     $collectionFactory,
        protected readonly SecureHtmlRenderer    $secureRenderer,
        protected readonly FormKey               $formKey,
        protected readonly StoreManagerInterface $storeManager,
    )
    {
        parent::__construct();
    }

    /**
     * @return Phrase
     */

    /**
     * Retrieves the JavaScript script configuration for programs.
     *
     * @return string The JavaScript script containing program configuration data.
     */
    public function getProgramsConfigsScript(): string
    {
        return $this->secureRenderer->renderTag('script', ['type' => 'text/javascript'], "\n window.snapPointsPrograms = " . json_encode($this->getProgramsData()) . "\n", false);
    }

    /**
     * Retrieves an array of program data.
     *
     * @return array An array where each element contains data related to a specific program,
     * including name, program ID, banner, description, logo, unit, and points per spend.
     * @throws LocalizedException
     */
    public function getProgramsData(): array
    {
        $data = [
            'currency' => $this->storeManager->getStore()->getBaseCurrencyCode(),
            'programs' => []
        ];

        foreach ($this->getPrograms() as $program) {
            /**
             * @var ProgramInterface $program
             */
            $data['programs'][] = [
                'name' => $program->getName(),
                'programId' => $program->getProgramId(),
                'banner' => $program->getBanner(),
                'description' => $program->getDescription(),
                'logo' => $program->getLogo(),
                'unit' => $program->getUnit(),
                'pointsPerSpend' => $program->getPointsPerSpend()
            ];
        }

        return $data;
    }

    /**
     * Get active programs collection
     *
     * @return Collection
     */
    public function getPrograms()
    {
        return $this->collectionFactory->create()->addFieldToFilter('points_per_spend_deleted_at', ['null' => true]);
    }
}

