<?php

namespace Src\Api\Controllers\Unit;

use Src\Api\Controllers\BaseController;
use Src\Api\Requests\Unit\CreateUnitRequest;
use Src\Api\Requests\Unit\UnitByFilterRequest;
use Src\Application\Interfaces\Services\IUnitService;

class UnitController extends BaseController
{
    public function __construct(
        private IUnitService $unitService
    ) {}

    public function getUnitsByFilter(UnitByFilterRequest $request)
    {        
        $dto = $request->getDto();
        $result = $this->unitService->getUnitsByFilter($dto);

        return response()->json([
            'success' => $result->success,
            'data' => $result->data,
            'message' => $result->message
        ], 200);
    }

    public function createUnit(CreateUnitRequest $request)
    {
        $dto = $request->getDto();
        $result = $this->unitService->createUnit($dto);

        return response()->json([
            'success' => $result->success,
            'data' => $result->data,
            'message' => $result->message
        ], 201);
    }

    public function updateUnit(int $id, CreateUnitRequest $request)
    {
        $dto = $request->getDto();
        $result = $this->unitService->updateUnit($id, $dto);

        return response()->json([
            'success' => $result->success,
            'data' => $result->data,
            'message' => $result->message
        ], 200);
    }

    public function deleteUnit(int $id)
    {
        $result = $this->unitService->deleteUnit($id);

        return response()->json([
            'success' => $result->success,
            'data' => $result->data,
            'message' => $result->message
        ], 200);
    }
}
