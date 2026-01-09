<?php

namespace Src\Domain\Entities;

use DateTime;

class CreateUserEntity
{
    public function __construct(
        public int $id,
        public string $email,
        public int|null $ownerId,
        public string $password,
        public int|null $profileId,
        public bool $isActive,
        public int|null $userIdCreated,
        public int|null $userIdUpdated,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public string|null $verificationCode,
        public DateTime|null $verificationExpiresAt
    ) {}
}