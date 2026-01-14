<?php

namespace Src\Application\Reponses\Unit;

use DateTime;
use Src\Application\Reponses\User\UserDetailSummaryResponseDto;

class GetUnitByFilterResponseDto
{
    public function __construct(
        public int $id,
        public UserDetailSummaryResponseDto $owner,
        public string $name,
        public string $abbreviation,
        public int $format,
        public UserDetailSummaryResponseDto $userCreated,
        public UserDetailSummaryResponseDto|null $userUpdated,
        public DateTime $createdAt,
        public DateTime $updatedAt
    ) {}
}