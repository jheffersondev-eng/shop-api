<?php

namespace Src\Application\Dto\Company;

class GetCompanyFilterDto
{
    public function __construct(
        public readonly string|null $id,
        public readonly string|null $name,
        public readonly int $page = 1,
        public readonly int $pageSize = 10
    ) {}
}
