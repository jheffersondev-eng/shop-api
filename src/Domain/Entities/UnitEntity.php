<?php

namespace Src\Domain\Entities;

use DateTime;

class UnitEntity
{
    public function __construct(
        public int $id,
        public UserSummaryEntity $owner,
        public string $name,
        public string $abbreviation,
        public int $format,
        public UserSummaryEntity $userCreated,
        public UserSummaryEntity $userUpdated,
        public DateTime $createdAt,
        public DateTime $updatedAt
    ) {}
}