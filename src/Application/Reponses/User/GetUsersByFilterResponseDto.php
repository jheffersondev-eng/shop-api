<?php

namespace Src\Application\Reponses\User;

use DateTime;
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
        public DateTime $createdAt,
        public DateTime|null $updatedAt,
        public DateTime|null $emailVerifiedAt,
        public string|null $verificationCode,
        public DateTime|null $verificationExpiresAt
    ) {}
}