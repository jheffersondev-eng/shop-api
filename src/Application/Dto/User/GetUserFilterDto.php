<?php

namespace Src\Application\Dto\User;

class GetUserFilterDto
{
    public function __construct(
        public readonly int|null $id,
        public readonly int|null $ownerId,
        public readonly string|null $name,
        public readonly string|null $email,
        public readonly string|null $document,
        public readonly int|null $profileId,
        public readonly bool|null $isActive,
        public readonly int $page = 1,
        public readonly int $pageSize = 10,
    ) {}
}
