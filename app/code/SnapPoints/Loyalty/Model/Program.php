<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Model;

use DateTimeZone;
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
    public function getProgramId(): ?int
    {
        $value = $this->getData(self::PROGRAM_ID);
        return $value !== null ? (int)$value : null;
    }

    /**
     * @inheritDoc
     */
    public function setProgramId($programId): ProgramInterface
    {
        return $this->setData(self::PROGRAM_ID, $programId);
    }

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName($name): ProgramInterface
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getLogo(): ?string
    {
        return $this->getData(self::LOGO);
    }

    /**
     * @inheritDoc
     */
    public function setLogo($logo): ProgramInterface
    {
        return $this->setData(self::LOGO, $logo);
    }

    /**
     * @inheritDoc
     */
    public function getBanner(): ?string
    {
        return $this->getData(self::BANNER);
    }

    /**
     * @inheritDoc
     */
    public function setBanner($banner): ProgramInterface
    {
        return $this->setData(self::BANNER, $banner);
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): ?string
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setDescription($description): ProgramInterface
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * @inheritDoc
     */
    public function getExternalId(): ?string
    {
        return $this->getData(self::EXTERNAL_ID);
    }

    /**
     * @inheritDoc
     */
    public function setExternalId(string $value): ProgramInterface
    {
        return $this->setData(self::EXTERNAL_ID, $value);
    }

    /**
     * @inheritDoc
     */
    public function setUnit(string $value): ProgramInterface
    {
        return $this->setData(self::UNIT, $value);
    }

    /**
     * @inheritDoc
     */
    public function getUnit(): ?string
    {
        return $this->getData(self::UNIT);
    }

    /**
     * @inheritDoc
     */
    public function setVersion(string $value): ProgramInterface
    {
        return $this->setData(self::VERSION, $value);
    }

    /**
     * @inheritDoc
     */
    public function getVersion(): ?string
    {
        return $this->getData(self::VERSION);
    }

    /**
     * @inheritDoc
     */
    public function setPointsPerSpend(float $value): ProgramInterface
    {
        return $this->setData(self::POINTS_PER_SPEND, $value);
    }

    /**
     * @inheritDoc
     */
    public function getPointsPerSpend(): ?float
    {
        $value = $this->getData(self::POINTS_PER_SPEND);
        return $value !== null ? (float)$value : null;
    }

    /**
     * @inheritDoc
     */
    public function setPointsPerSpendVersion(int $value): ProgramInterface
    {
        return $this->setData(self::POINTS_PER_SPEND_VERSION, $value);
    }

    /**
     * @inheritDoc
     */
    public function getPointsPerSpendVersion(): ?int
    {
        $value = $this->getData(self::POINTS_PER_SPEND_VERSION);
        return $value !== null ? (int)$value : null;
    }

    /**
     * @inheritDoc
     */
    public function setPointsPerSpendCreatedAt(DateTimeZone $value): ProgramInterface
    {
        // Create a DateTime object with the given timezone
        $dateTime = new \DateTime('now', $value);
        // Format the date to a MySQL compatible datetime string
        $formattedDate = $dateTime->format('Y-m-d H:i:s');
        return $this->setData(self::POINTS_PER_SPEND_CREATED_AT, $formattedDate);
    }

    /**
     * @inheritDoc
     */
    public function getPointsPerSpendCreatedAt(): ?DateTimeZone
    {
        $value = $this->getData(self::POINTS_PER_SPEND_CREATED_AT);
        if ($value !== null && !($value instanceof DateTimeZone)) {
            // Convert string to DateTimeZone if needed
            try {
                $dateTime = new \DateTime($value);
                return $dateTime->getTimezone();
            } catch (\Exception $e) {
                return null;
            }
        }
        return $value;
    }

    /**
     * @inheritDoc
     */
    public function setPointsPerSpendUpdatedAt(DateTimeZone $value): ProgramInterface
    {
        // Create a DateTime object with the given timezone
        $dateTime = new \DateTime('now', $value);
        // Format the date to a MySQL compatible datetime string
        $formattedDate = $dateTime->format('Y-m-d H:i:s');
        return $this->setData(self::POINTS_PER_SPEND_UPDATED_AT, $formattedDate);
    }

    /**
     * @inheritDoc
     */
    public function getPointsPerSpendUpdatedAt(): ?DateTimeZone
    {
        $value = $this->getData(self::POINTS_PER_SPEND_UPDATED_AT);
        if ($value !== null && !($value instanceof DateTimeZone)) {
            // Convert string to DateTimeZone if needed
            try {
                $dateTime = new \DateTime($value);
                return $dateTime->getTimezone();
            } catch (\Exception $e) {
                return null;
            }
        }
        return $value;
    }

    /**
     * @inheritDoc
     */
    public function setPointsPerSpendDeletedAt(DateTimeZone $value): ProgramInterface
    {
        // Create a DateTime object with the given timezone
        $dateTime = new \DateTime('now', $value);
        // Format the date to a MySQL compatible datetime string
        $formattedDate = $dateTime->format('Y-m-d H:i:s');
        return $this->setData(self::POINTS_PER_SPEND_DELETED_AT, $formattedDate);
    }

    /**
     * @inheritDoc
     */
    public function getPointsPerSpendDeletedAt(): ?DateTimeZone
    {
        $value = $this->getData(self::POINTS_PER_SPEND_DELETED_AT);
        if ($value !== null && !($value instanceof DateTimeZone)) {
            // Convert string to DateTimeZone if needed
            try {
                $dateTime = new \DateTime($value);
                return $dateTime->getTimezone();
            } catch (\Exception $e) {
                return null;
            }
        }
        return $value;
    }
}

