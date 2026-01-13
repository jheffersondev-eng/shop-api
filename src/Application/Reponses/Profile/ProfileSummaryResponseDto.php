<?php

namespace Src\Application\Reponses\Profile;

class ProfileSummaryResponseDto
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}
}