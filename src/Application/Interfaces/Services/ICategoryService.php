<?php

namespace Src\Application\Interfaces\Services;

use Src\Application\Dto\Category\CreateCategoryDto;
use Src\Application\Dto\Category\GetCategoryFilterDto;
use Src\Application\Services\ServiceResult;

interface ICategoryService
{
    public function getCategoriesByFilter(GetCategoryFilterDto $getCategoryFilterDto): ServiceResult;
    public function createCategory(CreateCategoryDto $createCategoryDto): ServiceResult;
    public function deleteCategory(int $categoryId, int $userIdDeleted): ServiceResult;
    public function updateCategory(int $categoryId, CreateCategoryDto $createCategoryDto): ServiceResult;
}
