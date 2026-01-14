<?php

namespace Src\Domain\Entities;

use DateTime;

class UnitEntity
{
    public function __construct(
        public int $id,
        public int $ownerId,
        public string $name,
        public string $abbreviation,
        public int $format,
        public int $userIdCreated,
        public int|null $userIdUpdated,
        public DateTime $createdAt,
        public DateTime $updatedAt
    ) {}
}