<?php

namespace Src\Application\Reponses\Category;

class CategorySummaryResponseDto
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}
}