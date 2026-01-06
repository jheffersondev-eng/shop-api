<?php

namespace Src\Domain\Entities;

class CategorySummaryEntity
{
    public function __construct(
        public int $id,
        public string $name,
        public string|null $description
    ) {}
}