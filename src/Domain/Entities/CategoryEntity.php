<?php

namespace Src\Domain\Entities;

use DateTime;

class CategoryEntity
{
    public function __construct(
        public int $id,
        public UserSummaryEntity $owner,
        public string $name,
        public string $description,
        public UserSummaryEntity $userCreated,
        public UserSummaryEntity $userUpdated,
        public DateTime $createdAt,
        public DateTime $updatedAt
    ) {}
}