<?php

namespace Src\Application\DTOs;

class ServiceResult
{
    public function __construct(
        public bool $success,
        public mixed $data = null,
        public ?string $message = null
    ) {}
    
    public static function ok(mixed $data = null, ?string $message = null): self
    {
        return new self(true, $data, $message);
    }

    public static function fail(string $message): self
    {
        return new self(false, null, $message);
    }
}
