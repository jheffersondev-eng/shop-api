<?php

namespace Src\Application\Interfaces\Repositories;

use Src\Application\Dto\Company\GetCompanyFilterDto;
use Src\Application\Dto\Company\CreateCompanyDto;
use Src\Domain\Entities\CompanyEntity;

interface ICompanyRepository
{
    public function getCompaniesByFilter(GetCompanyFilterDto $getCompanyFilterDto): array;
    public function create(CreateCompanyDto $createCompanyDto): CompanyEntity;
    public function update(string $companyId, CreateCompanyDto $createCompanyDto): CompanyEntity;
    public function delete(string $companyId, int $userIdDeleted): bool;
}
