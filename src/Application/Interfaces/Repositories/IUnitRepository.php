<?php

namespace Src\Application\Interfaces\Repositories;

use Src\Application\Dto\Unit\GetUnitFilterDto;
use Src\Application\Dto\Unit\CreateUnitDto;
use Src\Domain\Entities\UnitEntity;

interface IUnitRepository
{
    public function getUnitsByFilter(GetUnitFilterDto $getProductFilterDto): array;
    public function create(CreateUnitDto $createUnitDto): UnitEntity;
    public function update(int $unitId, CreateUnitDto $createUnitDto): UnitEntity;
    public function delete(int $unitId, int $userIdDeleted): bool;
}
