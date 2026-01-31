<?php

namespace Src\Api\Controllers\Company;

use Illuminate\Support\Facades\Auth;
use Src\Api\Controllers\BaseController;
use Src\Api\Requests\Company\CompanyByFilterRequest;
use Src\Api\Requests\Company\UpdateCompanyRequest;
use Src\Api\Requests\Company\CreateCompanyRequest;
use Src\Application\Interfaces\Services\ICompanyService;

class CompanyController extends BaseController
{
    public function __construct(
        private ICompanyService $companyService
    ) {}

    public function getCompaniesByFilter(CompanyByFilterRequest $request)
    {        
        $dto = $request->getDto();

        return $this->execute(
            callback: fn() => $this->companyService->getCompaniesByFilter($dto),
            statusCodeSuccess: 200
        );
    }

    public function create(CreateCompanyRequest $request)
    {
        $dto = $request->getDto();

        return $this->execute(
            callback: fn() => $this->companyService->create($dto),
            statusCodeSuccess: 201
        );
    }

    public function update(string $id, UpdateCompanyRequest $request)
    {
        $dto = $request->getDto();

        return $this->execute(
            callback: fn() => $this->companyService->update($id, $dto),
            statusCodeSuccess: 200
        );
    }

    public function delete(string $id)
    {
        return $this->execute(
            callback: fn() => $this->companyService->delete($id, Auth::id()),
            statusCodeSuccess: 200
        );
    }
}