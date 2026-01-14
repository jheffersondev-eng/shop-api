<?php

namespace Src\Domain\Entities;

use DateTime;

class UserDetailsEntity
{
    public function __construct(
        public int $id,
        public int $userId,
        public string $name,
        public string|null $image,
        public string $document,
        public DateTime $birthDate,
        public string $phone,
        public string $address,
        public float $creditLimit,
        public DateTime $createdAt,
        public DateTime|null $updatedAt,
        public DateTime|null $deletedAt,
    ) {}
}