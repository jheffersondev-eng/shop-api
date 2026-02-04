<?php

namespace Src\Application\Dto\Company;

use Illuminate\Http\UploadedFile;

class CreateCompanyDto
{
    public function __construct(
        public int $ownerId,
		public string $fantasyName,
		public string $legalName,
		public string|null $document,
		public string $email,
		public string $phone,
		public UploadedFile|null $image,
		public UploadedFile|null $imageBanner,
		public string $primaryColor,
		public string $secondaryColor,
		public string $neighborhood,
		public string $domain,
		public string $zipCode,
		public string $state,
		public string $city,
		public string $street,
		public string $number,
		public string|null $complement,
		public string|null $description,
		public string $slogan,
		public bool $isActive,
        public int $userIdCreated,
        public int|null $userIdUpdated,
	) {}
}
