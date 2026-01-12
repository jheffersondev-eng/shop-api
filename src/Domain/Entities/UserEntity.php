<?php

namespace Src\Domain\Entities;

use DateTime;

class UserEntity
{
    public function __construct(
        public int $id,
        public string $email,
        public int|null $ownerId,
        public int|null $profileId,
        public bool $isActive,
        public int|null $userIdCreated,
        public int|null $userIdUpdated,
        public DateTime $createdAt,
        public DateTime|null $updatedAt,
        public string|null $emailVerifiedAt,
        public string|null $verificationCode,
        public DateTime|null $verificationExpiresAt
    ) {}
}