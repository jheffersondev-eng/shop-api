<?php

namespace Src\Domain\Entities;

use DateTime;

class UserEntity
{
    public function __construct(
        public int $id,
        public string $email,
        public string $password,
        public int $ownerId,
        public bool $isActive,
        public int $userIdCreated,
        public DateTime $createdAt,
        public DateTime $updatedAt
    ) {}
}