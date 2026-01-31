<?php

namespace Src\Application\Interfaces\Services;

use Src\Application\Dto\Company\CreateCompanyDto;
use Src\Application\Dto\Company\GetCompanyFilterDto;
use Src\Application\Services\ServiceResult;

interface ICompanyService
{
    public function getCompaniesByFilter(GetCompanyFilterDto $getCompanyFilterDto): ServiceResult;
    public function create(CreateCompanyDto $createCompanyDto): ServiceResult;
    public function delete(string $companyId, int $userIdDeleted): ServiceResult;
    public function update(string $companyId, CreateCompanyDto $createCompanyDto): ServiceResult;
}
