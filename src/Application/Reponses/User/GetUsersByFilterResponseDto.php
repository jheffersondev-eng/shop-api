<?php

namespace Src\Application\Reponses\User;

use Carbon\Carbon;
use Src\Application\Reponses\Profile\ProfileSummaryResponseDto;

class GetUsersByFilterResponseDto
{
    public function __construct(
        public int $id,
        public string $email,
        public UserDetailSummaryResponseDto|null $owner,
        public ProfileSummaryResponseDto|null $profile,
        public bool $isActive,
        public UserDetailSummaryResponseDto|null $userCreated,
        public UserDetailSummaryResponseDto|null $userUpdated,
        public UserDetailSummaryResponseDto|null $userDeleted,
        public Carbon $createdAt,
        public Carbon|null $updatedAt,
        public Carbon|null $deletedAt,
        public Carbon|null $emailVerifiedAt,
        public string|null $verificationCode,
        public Carbon|null $verificationExpiresAt
    ) {}
}