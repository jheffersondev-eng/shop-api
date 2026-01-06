<?php

namespace Src\Application\Dto\Category;

class GetCategoryFilterDto
{
    public function __construct(
        public readonly int|null $id,
        public readonly int|null $ownerId,
        public readonly string|null $name,
        public readonly string|null $description,
        public readonly int $page = 1,
        public readonly int $pageSize = 10
    ) {}
}
