<?php

namespace Src\Application\Services\Unit;

use Src\Application\Services\ServiceResult;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Src\Application\Dto\Unit\CreateUnitDto;
use Src\Application\Dto\Unit\GetUnitFilterDto;
use Src\Application\Interfaces\Repositories\IUnitRepository;
use Src\Application\Interfaces\Services\IUnitService;

class UnitService implements IUnitService
{
    protected IUnitRepository $unitRepository;
    protected int|null $ownerId;
    protected int $userId;

    public function __construct(
        IUnitRepository $unitRepository,
        Auth $auth
    ) 
    {
        $this->unitRepository = $unitRepository;
        $user = $auth::user();
        $this->ownerId = $user->owner_id ?? $user->id;
        $this->userId = $user->id;
    }

    public function getUnitsByFilter(GetUnitFilterDto $getUnitFilterDto): ServiceResult
    {
        try {
            $getUnitFilterDto->ownerId = $this->ownerId;
            $data = $this->unitRepository->getUnitsByFilter($getUnitFilterDto);
            
            return ServiceResult::ok(
                data: $data,
                message: 'Produto Filtrado com sucesso.'
            );
        } catch (Exception $e) {
            Log::error('Erro na autenticação: ' . $e->getMessage());
            throw $e;
        }
    }

    public function createUnit(CreateUnitDto $createUnitDto): ServiceResult
    {
        try {
            DB::beginTransaction();

            $createUnitDto->userIdCreated = $this->userId;
            $createUnitDto->ownerId = $this->ownerId;

            $unit = $this->unitRepository->createUnit($createUnitDto);

            DB::commit();

            return ServiceResult::ok(
                data: $unit,
                message: 'Unidade criada com sucesso.'
            );
        } catch (Exception $e) {
            Log::error('Erro ao criar unidade: ' . $e->getMessage());
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteUnit(int $unitId): ServiceResult
    {
        try {
            DB::beginTransaction();
            $this->unitRepository->deleteUnit($unitId, $this->userId);
            
            DB::commit();
            return ServiceResult::ok(
                data: null,
                message: 'Unidade excluída com sucesso.'
            );
        } catch (Exception $e) {
            Log::error('Erro ao excluir unidade: ' . $e->getMessage());
            DB::rollBack();
            throw $e;
        }
    }

    public function updateUnit(int $unitId, CreateUnitDto $createUnitDto): ServiceResult
    {
        try {
            DB::beginTransaction();

            $createUnitDto->userIdUpdated = $this->userId;
            $createUnitDto->ownerId = $this->ownerId;
            $unit = $this->unitRepository->updateUnit($unitId, $createUnitDto);
            
            DB::commit();

            return ServiceResult::ok(
                data: $unit,
                message: 'Unidade atualizada com sucesso.'
            );
        } catch (Exception $e) {
            Log::error('Erro ao atualizar unidade: ' . $e->getMessage());
            DB::rollBack();
            throw $e;
        }
    }
}
