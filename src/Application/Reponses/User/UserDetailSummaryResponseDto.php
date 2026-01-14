<?php

namespace Src\Application\Reponses\User;

class UserDetailSummaryResponseDto
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}
}