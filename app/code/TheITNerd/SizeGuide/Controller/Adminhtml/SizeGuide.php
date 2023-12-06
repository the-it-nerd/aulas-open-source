<?php
/**
 * Copyright © MIT All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace TheITNerd\SizeGuide\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Registry;

/**
 * Class SizeGuide
 * @package TheITNerd\SizeGuide\Controller\Adminhtml
 */
abstract class SizeGuide extends Action
{

    public const ADMIN_RESOURCE = 'TheITNerd_SizeGuide::top_level';

    /**
     * @param Context $context
     * @param Registry $_coreRegistry
     */
    public function __construct(
        Context                     $context,
        protected readonly Registry $_coreRegistry
    )
    {
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param Page $resultPage
     * @return Page
     */
    public function initPage(Page $resultPage): Page
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('The IT Nerd'), __('The IT Nerd'))
            ->addBreadcrumb(__('Size Guide'), __('Size Guide'));
        return $resultPage;
    }
}

