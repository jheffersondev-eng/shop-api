<?php

namespace Src\Application\Reponses\Unit;

class UnitSummaryResponseDto
{
    public function __construct(
        public int $id,
        public string $name,
        public string $abbreviation,
        public string $format
    ) {}
}