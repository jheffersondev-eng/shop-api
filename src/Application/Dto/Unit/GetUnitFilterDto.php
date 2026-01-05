<?php

namespace Src\Application\Dto\Unit;

class GetUnitFilterDto
{
    public function __construct(
        public int|null $id,
        public int|null $ownerId,
        public string|null $name,
        public string|null $abbreviation,
        public string|null $format,
        public int $page = 1,
        public int $pageSize = 10
    ) {}
}
