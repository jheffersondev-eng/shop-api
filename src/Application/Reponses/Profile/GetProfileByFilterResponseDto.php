<?php

namespace Src\Application\Reponses\Profile;

use Carbon\Carbon;
use Src\Application\Reponses\User\UserDetailSummaryResponseDto;

class GetProfileByFilterResponseDto
{
    public function __construct(
        public int $id,
        public UserDetailSummaryResponseDto $owner,
        public string $name,
        public string $description,
        public string $permission,
        public UserDetailSummaryResponseDto $userCreated,
        public UserDetailSummaryResponseDto|null $userUpdated,
        public UserDetailSummaryResponseDto|null $userDeleted,
        public Carbon $createdAt,
        public Carbon|null $updatedAt,
        public Carbon|null $deletedAt,
    ) {}
}