<?php

namespace Src\Application\Dto\Profile;

class GetProfileFilterDto
{
    public function __construct(
        public readonly int|null $id,
        public readonly int|null $ownerId,
        public readonly string|null $name,
        public readonly array|null $permissions,
        public readonly int $page = 1,
        public readonly int $pageSize = 10
    ) {}
}
