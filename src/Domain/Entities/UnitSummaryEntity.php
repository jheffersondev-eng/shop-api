<?php

namespace Src\Domain\Entities;

class UnitSummaryEntity
{
    public function __construct(
        public int $id,
        public string $name,
        public string $abbreviation,
        public int $format
    ) {}
}