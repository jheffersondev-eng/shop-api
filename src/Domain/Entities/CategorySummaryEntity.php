<?php

namespace Src\Domain\Entities;

use DateTime;

class CategorySummaryEntity
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}
}