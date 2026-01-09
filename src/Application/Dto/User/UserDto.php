<?php

namespace Src\Application\Dto\User;

class UserDto
{
	public function __construct(
		public string $email,
		public string|null $password,
		public bool $isActive,
		public int|null $profileId,
		public UserDetailsDto $userDetailsDto,
		public int|null $ownerId,
        public int|null $userIdCreated,
        public int|null $userIdUpdated,) {}
}