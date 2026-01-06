<?php

namespace Src\Application\Dto\Unit;

class GetUnitFilterDto
{
    public function __construct(
        public readonly int|null $id,
        public readonly int|null $ownerId,
        public readonly string|null $name,
        public readonly string|null $abbreviation,
        public readonly string|null $format,
        public readonly int $page = 1,
        public readonly int $pageSize = 10
    ) {}
}
