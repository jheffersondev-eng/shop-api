<?php

namespace Src\Application\Interfaces\Repositories;

use Src\Application\Dto\Category\GetCategoryFilterDto;
use Src\Application\Dto\Category\CreateCategoryDto;
use Src\Domain\Entities\CategorySummaryEntity;

interface ICategoryRepository
{
    public function getCategoriesByFilter(GetCategoryFilterDto $getCategoryFilterDto): array;
    public function createCategory(CreateCategoryDto $createCategoryDto): CategorySummaryEntity;
    public function updateCategory(int $categoryId, CreateCategoryDto $createCategoryDto): CategorySummaryEntity;
    public function deleteCategory(int $categoryId, int $userIdDeleted): bool;
}
