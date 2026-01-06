<?php

namespace Src\Infrastructure\Persistence\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Src\Application\Dto\Category\GetCategoryFilterDto;
use Src\Application\Exceptions\CategoryNotFoundException;
use Src\Application\Interfaces\Repositories\ICategoryRepository;
use Illuminate\Support\Facades\Log;
use Src\Application\Dto\Category\CreateCategoryDto;
use Src\Application\Mappers\GenericMapper;
use Src\Application\Mappers\CategoriesMapper;
use Src\Infrastructure\Persistence\Models\Category;
use Src\Domain\Entities\CategorySummaryEntity;

class CategoryRepository implements ICategoryRepository
{
    private CategoriesMapper $mapper;

    public function __construct()
    {
        $this->mapper = new CategoriesMapper();
    }

    public function getCategoriesByFilter(GetCategoryFilterDto $getCategoryFilterDto): array
    {
        try {
            $query = DB::table('categories as c')
            ->leftJoin('user_details as cdo', 'c.owner_id', '=', 'cdo.id')
            ->leftJoin('user_details as cdc', 'c.user_id_created', '=', 'cdc.id')
            ->leftJoin('user_details as cdu', 'c.user_id_updated', '=', 'cdu.id')
            ->select(
                'c.id',
                'c.name',
                'c.description',
                'cdo.id as owner_id',
                'cdo.name as owner_name',
                'cdc.id as user_created_id',
                'cdc.name as user_created_name',
                'cdu.id as user_updated_id',
                'cdu.name as user_updated_name',
                'c.created_at',
                'c.updated_at'
            );

            $query = $this->applyFilter($query, $getCategoryFilterDto);
            $offset = ($getCategoryFilterDto->page - 1) * $getCategoryFilterDto->pageSize;
            $categories = $query->offset($offset)->limit($getCategoryFilterDto->pageSize)->get();

            return $this->mapper->map($categories);
        } catch (Exception $e) {
            Log::error('Erro ao filtrar categorias: ' . $e->getMessage());
            throw $e;
        }
    }

    private function applyFilter($query, GetCategoryFilterDto $getCategoryFilterDto)
    {
        $query->where('c.owner_id', $getCategoryFilterDto->ownerId);

        if ($getCategoryFilterDto->id) {
            $query->where('c.id', $getCategoryFilterDto->id);
        }

        if ($getCategoryFilterDto->name) {
            $query->where('c.name', 'like', '%' . $getCategoryFilterDto->name . '%');
        }

        if ($getCategoryFilterDto->description) {
            $query->where('c.description', 'like', '%' . $getCategoryFilterDto->description . '%');
        }

        return $query;
    }

    public function createCategory(CreateCategoryDto $createCategoryDto): CategorySummaryEntity
    {
        try {
            $category = Category::create([
                'name' => $createCategoryDto->name,
                'description' => $createCategoryDto->description,
                'owner_id' => $createCategoryDto->ownerId,
                'user_id_created' => $createCategoryDto->userIdCreated,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $categorySummaryEntity = GenericMapper::map($category, CategorySummaryEntity::class);

            return $categorySummaryEntity;
        } catch (Exception $e) {
            Log::error('Erro ao criar categoria: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteCategory(int $categoryId, int $userIdDeleted): bool
    {
        $category = Category::where('id', $categoryId)->first();

        if (!$category) {
            throw new CategoryNotFoundException('Categoria já foi deletada.');
        }

        $category->user_id_updated = $userIdDeleted;
        $category->deleted_at = now();

        $category->save();

        return true;
    }

    public function updateCategory(int $categoryId, CreateCategoryDto $createCategoryDto):  CategorySummaryEntity
    {
        $category = Category::where('id', $categoryId)
                    ->where('owner_id', $createCategoryDto->ownerId)
                    ->first();

        if (!$category) {
            throw new CategoryNotFoundException();
        }

        $category->update([
            'name' => $createCategoryDto->name,
            'description' => $createCategoryDto->description,
            'user_id_updated' => $createCategoryDto->userIdUpdated,
            'updated_at' => now(),
        ]);

        $categoryEntity = GenericMapper::map($category, CategorySummaryEntity::class);
        
        return $categoryEntity;
    }
}
