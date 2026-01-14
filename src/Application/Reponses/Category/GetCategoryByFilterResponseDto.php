<?php

namespace Src\Application\Reponses\Category;

use Carbon\Carbon;
use Src\Application\Reponses\User\UserDetailSummaryResponseDto;

class GetCategoryByFilterResponseDto
{
    public function __construct(
        public int $id,
        public UserDetailSummaryResponseDto $owner,
        public string $name,
        public string $description,
        public UserDetailSummaryResponseDto $userCreated,
        public UserDetailSummaryResponseDto|null $userUpdated,
        public UserDetailSummaryResponseDto|null $userDeleted,
        public Carbon $createdAt,
        public Carbon|null $updatedAt,
        public Carbon|null $deletedAt,
    ) {}
}