<?php

namespace Src\Application\Dto\Profile;

class CreateProfileDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly array $permissions,
        public readonly int|null $ownerId,
        public readonly int|null $userIdCreated,
        public readonly int|null $userIdUpdated
    ) {}
}
