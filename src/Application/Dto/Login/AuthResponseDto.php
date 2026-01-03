<?php

namespace Src\Application\Dto\Login;

class AuthResponseDto
{
    public function __construct(
        public int $userId,
        public string $email,
        public string $token
    ) {}
}
