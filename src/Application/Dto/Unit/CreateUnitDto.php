<?php

namespace Src\Application\Dto\Unit;

class CreateUnitDto
{
    public function __construct(
        public string $name,
        public string $abbreviation,
        public int $format,
        public int|null $ownerId,
        public int|null $userIdCreated,
        public int|null $userIdUpdated
    ) {}
}
