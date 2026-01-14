<?php

namespace Src\Domain\Entities;

use DateTime;

class ProfileEntity
{
    public function __construct(
        public int $id,
        public int $ownerId,
        public string $name,
        public string $description,
        public string $permission,
        public int $userIdCreated,
        public int|null $userIdUpdated,
        public int|null $userIdDeleted,
        public DateTime $createdAt,
        public DateTime|null $updatedAt,
        public DateTime|null $deletedAt,
    ) {}
}