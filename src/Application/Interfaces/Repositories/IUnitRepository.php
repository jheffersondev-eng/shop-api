<?php

namespace Src\Application\Interfaces\Repositories;

use Src\Application\Dto\Unit\GetUnitFilterDto;
use Src\Application\Dto\Unit\CreateUnitDto;
use Src\Domain\Entities\UnitSummaryEntity;

interface IUnitRepository
{
    public function getUnitsByFilter(GetUnitFilterDto $getProductFilterDto): array;
    public function createUnit(CreateUnitDto $createUnitDto): array;
    public function deleteUnit(int $unitId, int $userId): bool;
    public function updateUnit(int $unitId, CreateUnitDto $createUnitDto): UnitSummaryEntity;
}
