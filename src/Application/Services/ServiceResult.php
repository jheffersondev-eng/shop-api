<?php

namespace Src\Application\Services;

class ServiceResult
{
    public function __construct(
        public bool $success,
        public mixed $data = null,
        public string|null $message = null
    ) {}
    
    public static function ok(mixed $data = null, string|null $message = null): self
    {
        return new self(true, $data, $message);
    }

    public static function fail(string $message): self
    {
        return new self(false, null, $message);
    }
}
