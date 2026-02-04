<?php

namespace Src\Application\Interfaces\Repositories;

use Src\Application\Dto\Category\GetCategoryFilterDto;
use Src\Application\Dto\Category\CreateCategoryDto;
use Src\Domain\Entities\CategoryEntity;

interface ICategoryRepository
{
    public function getCategoriesByFilter(GetCategoryFilterDto $getCategoryFilterDto): array;
    public function create(CreateCategoryDto $createCategoryDto): CategoryEntity;
    public function update(int $categoryId, CreateCategoryDto $createCategoryDto): CategoryEntity;
    public function delete(int $categoryId, int $userIdDeleted): bool;
}
