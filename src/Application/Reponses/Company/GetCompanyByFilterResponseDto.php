<?php

namespace Src\Application\Reponses\Company;

use Carbon\Carbon;
use Src\Application\Reponses\User\UserDetailSummaryResponseDto;

class GetCompanyByFilterResponseDto
{
    public function __construct(
        public string $id,
        public UserDetailSummaryResponseDto $owner,
        public string $fantasyName,
        public string $description,
        public string $slogan,
        public string $legalName,
        public string $document,
        public string $email,
        public string $phone,
        public string $image,
        public string $imageBanner,
        public string $primaryColor,
        public string $secondaryColor,
        public string $domain,
        public string $zipCode,
        public string $state,
        public string $city,
        public string $neighborhood,
        public string $street,
        public string $number,
        public string $complement,
        public bool $isActive,
        public UserDetailSummaryResponseDto $userCreated,
        public UserDetailSummaryResponseDto|null $userUpdated,
        public UserDetailSummaryResponseDto|null $userDeleted,
        public Carbon $createdAt,
        public Carbon|null $updatedAt,
        public Carbon|null $deletedAt,
    ) {}
}