<?php

namespace Src\Infrastructure\Persistence\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Src\Application\Dto\Unit\GetUnitFilterDto;
use Src\Application\Exceptions\UnitNotFoundException;
use Src\Application\Interfaces\Repositories\IUnitRepository;
use Illuminate\Support\Facades\Log;
use Src\Application\Dto\Unit\CreateUnitDto;
use Src\Application\Mappers\GenericMapper;
use Src\Application\Mappers\UnitsMapper;
use Src\Infrastructure\Persistence\Models\Unit;
use Src\Domain\Entities\UnitSummaryEntity;

class UnitRepository implements IUnitRepository
{
    private UnitsMapper $mapper;

    public function __construct()
    {
        $this->mapper = new UnitsMapper();
    }

    public function getUnitsByFilter(GetUnitFilterDto $getUnitFilterDto): array
    {
        try {
            $query = DB::table('units as u')
            ->leftJoin('user_details as udo', 'u.owner_id', '=', 'udo.id')
            ->leftJoin('user_details as udc', 'u.user_id_created', '=', 'udc.id')
            ->leftJoin('user_details as udu', 'u.user_id_updated', '=', 'udu.id')
            ->select(
                'u.id as id',
                'u.name',
                'u.abbreviation',
                'u.format',
                'udo.id as owner_id',
                'udo.name as owner_name',
                'udc.id as user_created_id',
                'udc.name as user_created_name',
                'udu.id as user_updated_id',
                'udu.name as user_updated_name',
                'u.created_at',
                'u.updated_at'
            );

            $query = $this->applyFilter($query, $getUnitFilterDto);
            $offset = ($getUnitFilterDto->page - 1) * $getUnitFilterDto->pageSize;
            $units = $query->offset($offset)->limit($getUnitFilterDto->pageSize)->get();

            return $this->mapper->map($units);
        } catch (Exception $e) {
            Log::error('Erro ao filtrar produtos: ' . $e->getMessage());
            throw $e;
        }
    }

    private function applyFilter($query, GetUnitFilterDto $getUnitFilterDto)
    {
        $query->where('u.owner_id', $getUnitFilterDto->ownerId);

        if ($getUnitFilterDto->id) {
            $query->where('u.id', $getUnitFilterDto->id);
        }

        if ($getUnitFilterDto->name) {
            $query->where('u.name', 'like', '%' . $getUnitFilterDto->name . '%');
        }

        if ($getUnitFilterDto->abbreviation) {
            $query->where('u.abbreviation', 'like', '%' . $getUnitFilterDto->abbreviation . '%');
        }

        if ($getUnitFilterDto->format) {
            $query->where('u.format', 'like', '%' . $getUnitFilterDto->format . '%');
        }

        return $query;
    }

    public function createUnit(CreateUnitDto $createUnitDto): UnitSummaryEntity
    {
        try {
            $unit = Unit::create([
                'owner_id' => $createUnitDto->ownerId,
                'name' => $createUnitDto->name,
                'abbreviation' => $createUnitDto->abbreviation,
                'format' => $createUnitDto->format,
                'user_id_created' => $createUnitDto->userIdCreated,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $unitSummaryEntity = GenericMapper::map($unit, UnitSummaryEntity::class);

            return $unitSummaryEntity;
        } catch (Exception $e) {
            Log::error('Erro ao criar produto: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteUnit(int $unitId, int $userIdDeleted): bool
    {
        $unit = Unit::where('id', $unitId)->first();

        if (!$unit) {
            throw new UnitNotFoundException('Unidade já foi deletada.');
        }

        $unit->user_id_updated = $userIdDeleted;
        $unit->deleted_at = now();

        $unit->save();

        return true;
    }

    public function updateUnit(int $unitId, CreateUnitDto $createUnitDto):  UnitSummaryEntity
    {
        $unit = Unit::where('id', $unitId)
                    ->where('owner_id', $createUnitDto->ownerId)
                    ->first();

        if (!$unit) {
            throw new UnitNotFoundException();
        }

        $unit->update([
            'name' => $createUnitDto->name,
            'abbreviation' => $createUnitDto->abbreviation,
            'format' => $createUnitDto->format,
            'user_id_updated' => $createUnitDto->userIdUpdated,
            'updated_at' => now(),
        ]);

        $unitEntity = GenericMapper::map($unit, UnitSummaryEntity::class);
        
        return $unitEntity;
    }
}
