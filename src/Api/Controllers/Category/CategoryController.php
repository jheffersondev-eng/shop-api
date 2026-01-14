<?php

namespace Src\Api\Controllers\Category;

use Illuminate\Support\Facades\Auth;
use Src\Api\Controllers\BaseController;
use Src\Api\Requests\Category\CreateCategoryRequest;
use Src\Api\Requests\Category\CategoryByFilterRequest;
use Src\Api\Requests\Category\UpdateCategoryRequest;
use Src\Application\Interfaces\Services\ICategoryService;

class CategoryController extends BaseController
{
    public function __construct(
        private ICategoryService $categoryService
    ) {}

    public function getCategoriesByFilter(CategoryByFilterRequest $request)
    {        
        $dto = $request->getDto();

        return $this->execute(
            callback: fn() => $this->categoryService->getCategoriesByFilter($dto),
            statusCodeSuccess: 200
        );
    }

    public function create(CreateCategoryRequest $request)
    {
        $dto = $request->getDto();

        return $this->execute(
            callback: fn() => $this->categoryService->create($dto),
            statusCodeSuccess: 201
        );
    }

    public function update(int $id, UpdateCategoryRequest $request)
    {
        $dto = $request->getDto();

        return $this->execute(
            callback: fn() => $this->categoryService->update($id, $dto),
            statusCodeSuccess: 200
        );
    }

    public function delete(int $id)
    {
        return $this->execute(
            callback: fn() => $this->categoryService->delete($id, Auth::id()),
            statusCodeSuccess: 200
        );
    }
}