<?php

namespace Src\Domain\Entities;

class UserSummaryEntity
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}
}