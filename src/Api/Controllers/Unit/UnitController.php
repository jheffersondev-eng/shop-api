<?php

namespace Src\Api\Controllers\Unit;

use Illuminate\Support\Facades\Auth;
use Src\Api\Controllers\BaseController;
use Src\Api\Requests\Unit\CreateUnitRequest;
use Src\Api\Requests\Unit\UnitByFilterRequest;
use Src\Api\Requests\Unit\UpdateUnitRequest;
use Src\Application\Interfaces\Services\IUnitService;

class UnitController extends BaseController
{
    public function __construct(
        private IUnitService $unitService
    ) {}

    public function getUnitsByFilter(UnitByFilterRequest $request)
    {        
        $dto = $request->getDto();

        return $this->execute(
            callback: fn() => $this->unitService->getUnitsByFilter($dto),
            statusCodeSuccess: 200
        );
    }

    public function createUnit(CreateUnitRequest $request)
    {
        $dto = $request->getDto();

        return $this->execute(
            callback: fn() => $this->unitService->createUnit($dto),
            statusCodeSuccess: 201
        );
    }

    public function updateUnit(int $id, UpdateUnitRequest $request)
    {
        $dto = $request->getDto();

        return $this->execute(
            callback: fn() => $this->unitService->updateUnit($id, $dto),
            statusCodeSuccess: 200
        );
    }

    public function deleteUnit(int $id)
    {
        return $this->execute(
            callback: fn() => $this->unitService->deleteUnit($id, Auth::id()),
            statusCodeSuccess: 200
        );
    }
}
