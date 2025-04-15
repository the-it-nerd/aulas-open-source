<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Model;

use Magento\Framework\Model\AbstractModel;
use SnapPoints\Loyalty\Api\Data\ProgramInterface;

class Program extends AbstractModel implements ProgramInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\SnapPoints\Loyalty\Model\ResourceModel\Program::class);
    }

    /**
     * @inheritDoc
     */
    public function getProgramId()
    {
        return $this->getData(self::PROGRAM_ID);
    }

    /**
     * @inheritDoc
     */
    public function setProgramId($programId)
    {
        return $this->setData(self::PROGRAM_ID, $programId);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getLogo()
    {
        return $this->getData(self::LOGO);
    }

    /**
     * @inheritDoc
     */
    public function setLogo($logo)
    {
        return $this->setData(self::LOGO, $logo);
    }

    /**
     * @inheritDoc
     */
    public function getBanner()
    {
        return $this->getData(self::BANNER);
    }

    /**
     * @inheritDoc
     */
    public function setBanner($banner)
    {
        return $this->setData(self::BANNER, $banner);
    }

    /**
     * @inheritDoc
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }
}

