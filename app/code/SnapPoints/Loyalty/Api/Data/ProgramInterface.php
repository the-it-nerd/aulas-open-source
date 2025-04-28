<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Api\Data;

use DateTimeZone;

interface ProgramInterface
{

    public const NAME = 'name';
    public const BANNER = 'banner';
    public const PROGRAM_ID = 'program_id';
    public const EXTERNAL_ID = 'external_id';
    public const LOGO = 'logo';
    public const DESCRIPTION = 'description';

    public const UNIT = "unit";
    public const VERSION = "version";
    public const POINTS_PER_SPEND = "points_per_spend";
    public const POINTS_PER_SPEND_VERSION = "points_per_spend_version";
    public const POINTS_PER_SPEND_CREATED_AT = "points_per_spend_created_at";
    public const POINTS_PER_SPEND_UPDATED_AT = "points_per_spend_updated_at";
    public const POINTS_PER_SPEND_DELETED_AT = "points_per_spend_deleted_at";


    /**
     * @return string|null
     */
    public function getExternalId(): ?string;

    /**
     * @param string $value
     * @return self
     */
    public function setExternalId(string $value): self;

    /**
     * Get program_id
     * @return int|null
     */
    public function getProgramId(): ?int;

    /**
     * Set program_id
     * @param int $programId
     * @return self
     */
    public function setProgramId(int $programId): self;

    /**
     * Get name
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Set name
     * @param string $name
     * @return self
     */
    public function setName(string $name): self;

    /**
     * Get logo
     * @return string|null
     */
    public function getLogo(): ?string;

    /**
     * Set logo
     * @param string $logo
     * @return self
     */
    public function setLogo(string $logo): self;

    /**
     * Get banner
     * @return string|null
     */
    public function getBanner(): ?string;

    /**
     * Set banner
     * @param string $banner
     * @return self
     */
    public function setBanner(string $banner): self;

    /**
     * Get description
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * Set description
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): self;


    /**
     * Set the unit
     * @param string $value
     * @return self
     */
    public function setUnit(string $value): self;

    /**
     * Get the unit value
     * @return string|null
     */
    public function getUnit(): ?string;

    /**
     * Set version
     * @param string $value
     * @return self
     */
    public function setVersion(string $value): self;

    /**
     * Get version
     * @return string|null
     */
    public function getVersion(): ?string;

    /**
     * Set points per spend value
     * @param float $value
     * @return self
     */
    public function setPointsPerSpend(float $value): self;

    /**
     * Get points per spend.
     *
     * @return float|null
     */
    public function getPointsPerSpend(): ?float;

    /**
     * Set points per spend version
     * @param int $value
     * @return self
     */
    public function setPointsPerSpendVersion(int $value): self;

    /**
     * Get points per spend version
     * @return int|null
     */
    public function getPointsPerSpendVersion(): ?int;

    /**
     * Set points_per_spend_created_at
     * @param DateTimeZone $value
     * @return self
     */
    public function setPointsPerSpendCreatedAt(DateTimeZone $value): self;

    /**
     * Get the creation date and time of points per spend.
     *
     * @return DateTimeZone|null
     */
    public function getPointsPerSpendCreatedAt(): ?DateTimeZone;

    /**
     * Set points_per_spend_updated_at
     * @param DateTimeZone $value
     * @return self
     */
    public function setPointsPerSpendUpdatedAt(DateTimeZone $value): self;

    /**
     * Get the date and time when points per spend were last updated.
     * @return DateTimeZone|null
     */
    public function getPointsPerSpendUpdatedAt(): ?DateTimeZone;

    /**
     * Set points_per_spend_deleted_at
     * @param DateTimeZone $value
     * @return self
     */
    public function setPointsPerSpendDeletedAt(DateTimeZone $value): self;

    /**
     * Get the deleted_at timestamp for points per spend
     * @return DateTimeZone|null
     */
    public function getPointsPerSpendDeletedAt(): ?DateTimeZone;
}

