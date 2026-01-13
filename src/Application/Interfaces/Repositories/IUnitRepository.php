<?php

namespace Src\Application\Interfaces\Repositories;

use Src\Application\Dto\Unit\GetUnitFilterDto;
use Src\Application\Dto\Unit\CreateUnitDto;
use Src\Domain\Entities\UnitEntity;

interface IUnitRepository
{
    public function getUnitsByFilter(GetUnitFilterDto $getProductFilterDto): array;
    public function createUnit(CreateUnitDto $createUnitDto): UnitEntity;
    public function updateUnit(int $unitId, CreateUnitDto $createUnitDto): UnitEntity;
    public function deleteUnit(int $unitId, int $userIdDeleted): bool;
}
