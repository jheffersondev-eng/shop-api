<?php

namespace Src\Application\Dto\User;

class VerifyEmailDto
{
	public function __construct(
		public int $userId,
		public string $email,
		public string $verificationCode
	) {}
}