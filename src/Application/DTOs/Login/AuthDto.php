<?php

namespace Src\Application\DTOs\Login;

class AuthDto
{
    public function __construct(
        public string $email,
        public string $password
    ) {}
}
