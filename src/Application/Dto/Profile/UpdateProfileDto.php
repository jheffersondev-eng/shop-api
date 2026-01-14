<?php

namespace Src\Application\Dto\Profile;

class UpdateProfileDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly array|null $permissions,
        public readonly int $userIdUpdated,
        public readonly int $ownerId,
    ) {}
}
