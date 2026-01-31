<?php

namespace Src\Domain\Entities;

use DateTime;

class CompanyEntity
{
    public function __construct(
        public string $id,
        public int $ownerId,
        public string $fantasyName,
        public string $description,
        public string $legalName,
        public string $document,
        public string $email,
        public string $image,
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
        public int $userIdCreated,
        public int|null $userIdUpdated,
        public int|null $userIdDeleted,
    ) {}
}