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
        $desc = $this->getData(self::DESCRIPTION);

        if(is_null($desc)) {
            $desc = '<p>The Offer (As described below) is valid on qualifying items purchased on <strong>{store_name}</strong> online store. This offer is applicable only to <strong>Aeroplan</strong> members who are in good standing in the <strong>Aeroplan Program</strong>. If you are not an Aeroplan member, you can visit the Aeroplan web site (aircanada.com/Aeroplan) and enroll today. Membership is free.</p>
                    <p>Offer Details: Earn up to <strong>{} Aeroplan points per 1 {} spent</strong> on qualifying items purchased with <strong>{}</strong> online store. After checkout, you will receive an email inviting you to link your Aeroplan account to initiate the deposit of points. Your points will be deposited 30 days after your purchase date. <br/> Bonus Aeroplan points may take up to 8-10 weeks to be credited to Aeroplan members’ account after the completion of a transaction. <br/> Offer is non-transferable and is not redeemable for cash.</p>
                    <p>Other Terms: Participation in these offers constitutes acceptance of <a target="_blank" href="https://www.aircanada.com/ca/en/aco/home/aeroplan/legal/terms-and-conditions.html#/">Aeroplan Terms and Conditions</a>, <a target="_blank" href="https://www.aircanada.com/ca/en/aco/home/aeroplan/legal/terms-and-conditions.html#/">Air Canada Terms and Conditions</a>, and <a target="_blank" href="https://www.snappoints.com/consumer-terms">SnapPoints Terms and Conditions</a>. Offers featuring Points may be added, removed or changed at any time. SnapPoints and Aeroplan reserve the right to terminate your participation in this Offer if you violate these Terms and Conditions, or if your use is unauthorized, fraudulent, or otherwise unlawful. <br/><br/> ®️ Aeroplan is a registered trademark of Aeroplan Inc. <br/><br/>®️ The Air Canada maple leaf logo is a registered trademark of Air Canada, used under licence by Aeroplan Inc.</p>';
        }

        return $desc;
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
    public function setPointsPerSpend(string $value): ProgramInterface
    {
        return $this->setData(self::POINTS_PER_SPEND, $value);
    }

    /**
     * @inheritDoc
     */
    public function getPointsPerSpend(): ?string
    {
        return $this->getData(self::POINTS_PER_SPEND);
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
        $dateTime = new \DateTime("now", $value);
        // Format the date to a MySQL compatible datetime string
        $formattedDate = $dateTime->format("Y-m-d H:i:s");
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
        $dateTime = new \DateTime("now", $value);
        // Format the date to a MySQL compatible datetime string
        $formattedDate = $dateTime->format("Y-m-d H:i:s");
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
        $dateTime = new \DateTime("now", $value);
        // Format the date to a MySQL compatible datetime string
        $formattedDate = $dateTime->format("Y-m-d H:i:s");
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

