<?php

namespace Src\Application\Dto\User;

class ResendVerifyEmailDto
{
	public function __construct(
		public int $userId,
		public string $email,
	) {}
}