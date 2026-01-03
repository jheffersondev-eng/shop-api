<?php

namespace Src\Infrastructure\Persistence\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Src\Application\Dto\Product\GetProductFilterDto;
use Src\Application\Interfaces\Repositories\IProductRepository;
use Src\Application\Mappers\ProductsMapper;
use Illuminate\Support\Facades\Log;

class ProductRepository implements IProductRepository
{
    private ProductsMapper $mapper;

    public function __construct()
    {
        $this->mapper = new ProductsMapper();
    }

    public function getProductsByFilter(GetProductFilterDto $getProductFilterDto): array
    {
        try {
            $query = DB::table('products as p')
            ->join('categories as c', 'p.category_id', '=', 'c.id')
            ->join('units as u', 'p.unit_id', '=', 'u.id')
            ->leftJoin('user_details as udo', 'p.owner_id', '=', 'udo.id')
            ->leftJoin('user_details as udc', 'p.user_id_created', '=', 'udc.id')
            ->leftJoin('user_details as udu', 'p.user_id_updated', '=', 'udu.id')
            ->select(
                'p.id',
                'p.name',
                'p.barcode',
                'p.is_active',
                'p.price',
                'p.cost_price',
                'p.stock_quantity',
                'p.min_quantity',
                'p.user_id_created',
                'p.user_id_updated',
                'p.user_id_deleted',
                'p.created_at',
                'p.updated_at',
                'p.deleted_at',
                'c.id as category_id',
                'c.name as category_name',
                'u.id as unit_id',
                'u.name as unit_name',
                'udo.id as owner_id',
                'udo.name as owner_name',
                'udc.id as user_created_id',
                'udc.name as user_created_name',
                'udu.id as user_updated_id',
                'udu.name as user_updated_name',
            );

            $query = $this->applyFilter($query, $getProductFilterDto);
            $offset = ($getProductFilterDto->page - 1) * $getProductFilterDto->pageSize;
            $products = $query->offset($offset)->limit($getProductFilterDto->pageSize)->get();
            $productsWithImages = $this->addProductImages($products);

            return $this->mapper->map($productsWithImages);
        } catch (Exception $e) {
            Log::error('Erro ao filtrar produtos: ' . $e->getMessage());
            throw $e;
        }
    }

    private function addProductImages($products)
    {
        return $products->map(function($product) {
            $images = $this->getProductImages($product->id);
            $product->images = $images;
            return $product;
        });
    }

    public function applyFilter($query, GetProductFilterDto $getProductFilterDto)
    {
        if ($getProductFilterDto->id) {
            $query->where('p.id', $getProductFilterDto->id);
        }

        if ($getProductFilterDto->ownerId) {
            $query->where('p.owner_id', $getProductFilterDto->ownerId);
        }

        if ($getProductFilterDto->name) {
            $query->where('p.name', 'like', '%' . $getProductFilterDto->name . '%');
        }

        if ($getProductFilterDto->categoryId) {
            $query->where('p.category_id', $getProductFilterDto->categoryId);
        }

        if ($getProductFilterDto->unitId) {
            $query->where('p.unit_id', $getProductFilterDto->unitId);
        }

        if ($getProductFilterDto->barcode) {
            $query->where('p.barcode', 'like', '%' . $getProductFilterDto->barcode . '%');
        }

        if ($getProductFilterDto->isActive !== null) {
            $query->where('p.is_active', $getProductFilterDto->isActive);
        }

        if($getProductFilterDto->userIdCreated) {
            $query->where('p.user_id_created', $getProductFilterDto->userIdCreated);
        }

        if($getProductFilterDto->dateDe) {
            $query->where('p.created_at', '>=', $getProductFilterDto->dateDe->format('Y-m-d H:i:s'));
        }

        if($getProductFilterDto->dateAte) {
            $query->where('p.created_at', '<=', $getProductFilterDto->dateAte->format('Y-m-d H:i:s'));
        }

        return $query;
    }

    public function getProductImages(int $productId): array
    {
        return DB::table('product_images')
            ->select(
                'id', 
                'product_id', 
                'image', 
                'created_at', 
                'updated_at'
            )
            ->where('product_id', $productId)
            ->get()
            ->toArray();
    }
}
