<?php

namespace Src\Application\Dto\Category;

class CreateCategoryDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly int|null $ownerId,
        public readonly int|null $userIdCreated,
        public readonly int|null $userIdUpdated
    ) {}
}
