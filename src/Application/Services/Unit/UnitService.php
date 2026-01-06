<?php

namespace Src\Application\Services\Unit;

use Src\Application\Services\ServiceResult;
use Exception;
use Illuminate\Support\Facades\Log;
use Src\Application\Dto\Unit\CreateUnitDto;
use Src\Application\Dto\Unit\GetUnitFilterDto;
use Src\Application\Exceptions\UnitNotFoundException;
use Src\Application\Interfaces\Repositories\IUnitRepository;
use Src\Application\Interfaces\Services\IUnitService;

class UnitService implements IUnitService
{
    public function __construct(
        private IUnitRepository $unitRepository
    ) {}

    public function getUnitsByFilter(GetUnitFilterDto $getUnitFilterDto): ServiceResult
    {
        try {
            $data = $this->unitRepository->getUnitsByFilter($getUnitFilterDto);
            
            return ServiceResult::ok(
                data: $data,
                message: 'Unidades filtradas com sucesso.'
            );
        } catch (Exception $e) {
            Log::error('Erro ao filtrar unidades: ' . $e->getMessage());
            throw $e;
        }
    }

    public function createUnit(CreateUnitDto $createUnitDto): ServiceResult
    {
        try {
            $unit = $this->unitRepository->createUnit($createUnitDto);

            return ServiceResult::ok(
                data: $unit,
                message: 'Unidade criada com sucesso.'
            );
        } catch (Exception $e) {
            Log::error('Erro ao criar unidade: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteUnit(int $unitId, int $userIdDeleted): ServiceResult
    {
        try {
            $this->unitRepository->deleteUnit($unitId, $userIdDeleted);
            
            return ServiceResult::ok(
                data: null,
                message: 'Unidade excluída com sucesso.'
            );
        } catch (UnitNotFoundException $e) {
            Log::error('Unidade não encontrada: ' . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            Log::error('Erro ao excluir unidade: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateUnit(int $unitId, CreateUnitDto $createUnitDto): ServiceResult
    {
        try {
            $unit = $this->unitRepository->updateUnit($unitId, $createUnitDto);
            
            return ServiceResult::ok(
                data: $unit,
                message: 'Unidade atualizada com sucesso.'
            );
        } catch (UnitNotFoundException $e) {
            Log::error('Unidade não encontrada: ' . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            Log::error('Erro ao atualizar unidade: ' . $e->getMessage());
            throw $e;
        }
    }
}
