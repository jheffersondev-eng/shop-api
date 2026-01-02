<?php

namespace Src\Application\DTOs\Login;

class AuthResponseDto
{
    public function __construct(
        public int $userId,
        public string $email,
        public string $token
    ) {}
}
