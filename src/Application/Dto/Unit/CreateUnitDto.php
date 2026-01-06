<?php

namespace Src\Application\Dto\Unit;

class CreateUnitDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $abbreviation,
        public readonly int $format,
        public readonly int|null $ownerId,
        public readonly int|null $userIdCreated,
        public readonly int|null $userIdUpdated
    ) {}
}
