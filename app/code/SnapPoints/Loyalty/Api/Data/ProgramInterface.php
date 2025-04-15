<?php
/**
 * Copyright © SnapPoints Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SnapPoints\Loyalty\Api\Data;

interface ProgramInterface
{

    public const NAME = 'name';
    public const BANNER = 'banner';
    public const PROGRAM_ID = 'program_id';
    public const LOGO = 'logo';
    public const DESCRIPTION = 'description';

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
    public function getLogo(): ? string;

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
}

