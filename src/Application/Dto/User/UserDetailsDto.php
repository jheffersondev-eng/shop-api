<?php

namespace Src\Application\Dto\User;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

class UserDetailsDto
{
	public function __construct(
		public string $name,
        public string $document,
        public Carbon $birthDate,
        public string $phone,
        public string $address,
        public float $creditLimit,
        public string|UploadedFile|null $image,
        public int|null $userId,
    ) {}
}