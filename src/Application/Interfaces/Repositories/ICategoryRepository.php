<?php

namespace Src\Application\Interfaces\Repositories;

use Src\Application\Dto\Category\GetCategoryFilterDto;
use Src\Application\Dto\Category\CreateCategoryDto;
use Src\Domain\Entities\CategoryEntity;

interface ICategoryRepository
{
    public function getCategoriesByFilter(GetCategoryFilterDto $getCategoryFilterDto): array;
    public function createCategory(CreateCategoryDto $createCategoryDto): CategoryEntity;
    public function updateCategory(int $categoryId, CreateCategoryDto $createCategoryDto): CategoryEntity;
    public function deleteCategory(int $categoryId, int $userIdDeleted): bool;
}
