<?php

namespace Src\Application\Interfaces\Services;

use Src\Application\Dto\Unit\CreateUnitDto;
use Src\Application\Dto\Unit\GetUnitFilterDto;
use Src\Application\Services\ServiceResult;

interface IUnitService
{
    public function getUnitsByFilter(GetUnitFilterDto $getUnitFilterDto): ServiceResult;
    public function createUnit(CreateUnitDto $createUnitDto): ServiceResult;
    public function deleteUnit(int $unitId, int $userIdDeleted): ServiceResult;
    public function updateUnit(int $unitId, CreateUnitDto $createUnitDto): ServiceResult;
}
