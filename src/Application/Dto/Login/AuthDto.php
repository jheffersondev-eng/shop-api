<?php

namespace Src\Application\Dto\Login;

class AuthDto
{
    public function __construct(
        public string $email,
        public string $password
    ) {}
}
