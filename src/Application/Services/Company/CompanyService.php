<?php

namespace Src\Application\Services\Company;

use Src\Application\Services\ServiceResult;
use Exception;
use Illuminate\Support\Facades\Log;
use Src\Application\Dto\Company\CreateCompanyDto;
use Src\Application\Dto\Company\GetCompanyFilterDto;
use Src\Application\Exceptions\CompanyNotFoundException;
use Src\Application\Interfaces\Repositories\ICompanyRepository;
use Src\Application\Interfaces\Services\ICompanyService;

class CompanyService implements ICompanyService
{
    public function __construct(
        private ICompanyRepository $companyRepository
    ) {}

    public function getCompaniesByFilter(GetCompanyFilterDto $getCompanyFilterDto): ServiceResult
    {
        try {
            $data = $this->companyRepository->getCompaniesByFilter($getCompanyFilterDto);
            
            return ServiceResult::ok(
                data: $data,
                message: 'Empresas filtradas com sucesso.'
            );
        } catch (Exception $e) {
            Log::error('Erro ao filtrar empresas: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getCompany(int $ownerId): ServiceResult
    {
        try {
            $data = $this->companyRepository->getCompany($ownerId);

            return ServiceResult::ok(
                data: $data,
                message: 'Empresa obtida com sucesso.'
            );
        } catch (Exception $e) {
            Log::error('Erro ao obter empresa: ' . $e->getMessage());
            throw $e;
        }
    }

    public function create(CreateCompanyDto $createCompanyDto): ServiceResult
    {
        try {
            $company = $this->companyRepository->create($createCompanyDto);

            return ServiceResult::ok(
                data: $company,
                message: 'Empresa criada com sucesso.'
            );
        } catch (Exception $e) {
            Log::error('Erro ao criar empresa: ' . $e->getMessage());
            throw $e;
        }
    }

    public function delete(string $companyId, int $userIdDeleted): ServiceResult
    {
        try {
            $this->companyRepository->delete($companyId, $userIdDeleted);
            
            return ServiceResult::ok(
                data: null,
                message: 'Empresa excluída com sucesso.'
            );
        } catch (CompanyNotFoundException $e) {
            Log::error('Empresa não encontrada: ' . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            Log::error('Erro ao excluir empresa: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update(string $companyId, CreateCompanyDto $createCompanyDto): ServiceResult
    {
        try {
            $company = $this->companyRepository->update($companyId, $createCompanyDto);
            
            return ServiceResult::ok(
                data: $company,
                message: 'Empresa atualizada com sucesso.'
            );
        } catch (CompanyNotFoundException $e) {
            Log::error('Empresa não encontrada: ' . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            Log::error('Erro ao atualizar empresa: ' . $e->getMessage());
            throw $e;
        }
    }
}
