<?php

namespace Src\Application\Services\Category;

use Src\Application\Services\ServiceResult;
use Exception;
use Illuminate\Support\Facades\Log;
use Src\Application\Dto\Category\CreateCategoryDto;
use Src\Application\Dto\Category\GetCategoryFilterDto;
use Src\Application\Exceptions\CategoryNotFoundException;
use Src\Application\Interfaces\Repositories\ICategoryRepository;
use Src\Application\Interfaces\Services\ICategoryService;

class CategoryService implements ICategoryService
{
    public function __construct(
        private ICategoryRepository $categoryRepository
    ) {}

    public function getCategoriesByFilter(GetCategoryFilterDto $getCategoryFilterDto): ServiceResult
    {
        try {
            $data = $this->categoryRepository->getCategoriesByFilter($getCategoryFilterDto);
            
            return ServiceResult::ok(
                data: $data,
                message: 'Categorias filtradas com sucesso.'
            );
        } catch (Exception $e) {
            Log::error('Erro ao filtrar categorias: ' . $e->getMessage());
            throw $e;
        }
    }

    public function create(CreateCategoryDto $createCategoryDto): ServiceResult
    {
        try {
            $category = $this->categoryRepository->create($createCategoryDto);

            return ServiceResult::ok(
                data: $category,
                message: 'Categoria criada com sucesso.'
            );
        } catch (Exception $e) {
            Log::error('Erro ao criar categoria: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update(int $categoryId, CreateCategoryDto $createCategoryDto): ServiceResult
    {
        try {
            $category = $this->categoryRepository->update($categoryId, $createCategoryDto);
            
            return ServiceResult::ok(
                data: $category,
                message: 'Categoria atualizada com sucesso.'
            );
        } catch (CategoryNotFoundException $e) {
            Log::error('Categoria não encontrada: ' . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            Log::error('Erro ao atualizar categoria: ' . $e->getMessage());
            throw $e;
        }
    }
    
    public function delete(int $categoryId, int $userIdDeleted): ServiceResult
    {
        try {
            $this->categoryRepository->delete($categoryId, $userIdDeleted);
            
            return ServiceResult::ok(
                data: null,
                message: 'Categoria excluída com sucesso.'
            );
        } catch (CategoryNotFoundException $e) {
            Log::error('Categoria não encontrada: ' . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            Log::error('Erro ao excluir categoria: ' . $e->getMessage());
            throw $e;
        }
    }
}
