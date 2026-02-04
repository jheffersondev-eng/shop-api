<?php

namespace Src\Infrastructure\Persistence\Repositories;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Src\Application\Dto\Product\GetProductFilterDto;
use Src\Application\Exceptions\ProductNotFoundException;
use Src\Application\Exceptions\ProductImageNotFoundException;
use Src\Application\Interfaces\Repositories\IProductRepository;
use Src\Application\Mappers\ProductsMapper;
use Illuminate\Support\Facades\Log;
use Src\Application\Dto\Product\CreateProductDto;
use Src\Application\Mappers\GenericMapper;
use Src\Domain\Entities\ProductEntity;
use Src\Infrastructure\Persistence\Models\Product;
use Src\Infrastructure\Persistence\Models\ProductImage;

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
            ->leftJoin('user_details as udd', 'p.user_id_deleted', '=', 'udd.id')
            ->select(
                'p.id as id',
                'p.name',
                'p.description',
                'p.barcode',
                'p.is_active',
                'p.price',
                'p.cost_price',
                'p.stock_quantity',
                'p.min_quantity',
                'p.user_id_created as user_id_created',
                'p.user_id_updated as user_id_updated',
                'p.user_id_deleted as user_id_deleted',
                'p.created_at',
                'p.updated_at',
                'p.deleted_at',
                'c.id as category_id',
                'c.name as category_name',
                'u.id as unit_id',
                'u.name as unit_name',
                'u.abbreviation as unit_abbreviation',
                'u.format as unit_format',
                'udo.id as owner_id',
                'udo.name as owner_name',
                'udc.id as user_created_id',
                'udc.name as user_created_name',
                'udu.id as user_updated_id',
                'udu.name as user_updated_name',
                'udd.id as user_deleted_id',
                'udd.name as user_deleted_name'
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

    public function getAllProductsByFilter(GetProductFilterDto $getProductFilterDto): array
    {
        try {
            $query = DB::table('products as p')
            ->join('categories as c', 'p.category_id', '=', 'c.id')
            ->join('units as u', 'p.unit_id', '=', 'u.id')
            ->leftJoin('user_details as udo', 'p.owner_id', '=', 'udo.id')
            ->leftJoin('user_details as udc', 'p.user_id_created', '=', 'udc.id')
            ->leftJoin('user_details as udu', 'p.user_id_updated', '=', 'udu.id')
            ->leftJoin('user_details as udd', 'p.user_id_deleted', '=', 'udd.id')
            ->select(
                'p.id as id',
                'p.name',
                'p.description',
                'p.barcode',
                'p.is_active',
                'p.price',
                'p.cost_price',
                'p.stock_quantity',
                'p.min_quantity',
                'p.user_id_created as user_id_created',
                'p.user_id_updated as user_id_updated',
                'p.user_id_deleted as user_id_deleted',
                'p.created_at',
                'p.updated_at',
                'p.deleted_at',
                'c.id as category_id',
                'c.name as category_name',
                'u.id as unit_id',
                'u.name as unit_name',
                'u.abbreviation as unit_abbreviation',
                'u.format as unit_format',
                'udo.id as owner_id',
                'udo.name as owner_name',
                'udc.id as user_created_id',
                'udc.name as user_created_name',
                'udu.id as user_updated_id',
                'udu.name as user_updated_name',
                'udd.id as user_deleted_id',
                'udd.name as user_deleted_name'
            );

            $query = $this->applyOptionalFilter($query, $getProductFilterDto);

            $offset = ($getProductFilterDto->page - 1) * $getProductFilterDto->pageSize;
            $products = $query->offset($offset)->limit($getProductFilterDto->pageSize)->get();
            $productsWithImages = $this->addProductImages($products);

            return $this->mapper->map($productsWithImages);
        } catch (Exception $e) {
            Log::error('Erro ao filtrar produtos: ' . $e->getMessage());
            throw $e;
        }
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
            ->whereNull('deleted_at')
            ->get()
            ->toArray();
    }

    public function create(CreateProductDto $createProductDto): ProductEntity
    {
        try {
            $product = Product::create([
                'name' => $createProductDto->name,
                'description' => $createProductDto->description,
                'owner_id' => $createProductDto->ownerId,
                'category_id' => $createProductDto->categoryId,
                'unit_id' => $createProductDto->unitId,
                'barcode' => $createProductDto->barcode,
                'is_active' => $createProductDto->isActive,
                'price' => $createProductDto->price,
                'cost_price' => $createProductDto->costPrice,
                'stock_quantity' => $createProductDto->stockQuantity,
                'min_quantity' => $createProductDto->minQuantity,
                'user_id_created' => $createProductDto->userIdCreated,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $productEntity = GenericMapper::map($product, ProductEntity::class);

            return $productEntity; 
        } catch (Exception $e) {
            Log::error('Erro ao criar produto: ' . $e->getMessage());
            throw $e;
        }
    }

    public function createProductImages(int $productId, array $images): array
    {
        $createdImages = [];

        foreach ($images as $image) {
            if ($image instanceof UploadedFile) {
                $imagePath = $image->store('products', 'shop_storage');
                $createdImage = ProductImage::create([
                    'product_id' => $productId,
                    'image' => $imagePath,
                ]);
                $createdImages[] = $createdImage->toArray();
            }
        }

        return $createdImages;
    }

    public function delete(int $productId, int $userIdDeleted): bool
    {
        $product = Product::where('id', $productId)->first();
        if (!$product) {
            throw new ProductNotFoundException('Produto já foi deletado.');
        }

        $product->deleted_at = now();
        $product->user_id_deleted = $userIdDeleted;

        $product->save();

        return true;
    }

    public function deleteProductImage(int $imageId): bool
    {
        $image = ProductImage::where('id', $imageId)->first();

        if (!$image) {
            throw new ProductImageNotFoundException();
        }

        if ($image->image && Storage::disk('shop_storage')->exists($image->image)) {
            Storage::disk('shop_storage')->delete($image->image);
        }

        $image->delete();

        return true;
    }

    public function update(int $productId, CreateProductDto $createProductDto):  ProductEntity
    {
        $product = Product::where('id', $productId)
                    ->where('owner_id', $createProductDto->ownerId)
                    ->first();

        if (!$product) {
            throw new ProductNotFoundException();
        }

        $product->update([
            'name' => $createProductDto->name,
            'description' => $createProductDto->description,
            'category_id' => $createProductDto->categoryId,
            'unit_id' => $createProductDto->unitId,
            'barcode' => $createProductDto->barcode,
            'is_active' => $createProductDto->isActive,
            'price' => $createProductDto->price,
            'cost_price' => $createProductDto->costPrice,
            'stock_quantity' => $createProductDto->stockQuantity,
            'min_quantity' => $createProductDto->minQuantity,
            'user_id_updated' => $createProductDto->userIdUpdated,
            'updated_at' => now(),
        ]);

        $productEntity = GenericMapper::map($product, ProductEntity::class);
        
        return $productEntity;
    }

    public function updateProductImages(int $productId, int $ownerId, array $images): array
    {
        $product = Product::where('id', $productId)
                    ->where('owner_id', $ownerId)
                    ->first();

        if (!$product) {
            throw new ProductNotFoundException();
        }

        foreach ($product->images as $image) {
            $this->deleteProductImage($image->id);
        }

        $createdImages = $this->createProductImages($productId, $images);

        return $createdImages;
    }

    private function addProductImages($products)
    {
        return $products->map(function($product) {
            $images = $this->getProductImages($product->id);
            $product->images = $images;
            return $product;
        });
    }

    private function applyFilter($query, GetProductFilterDto $getProductFilterDto)
    {
        $query->where('p.owner_id', $getProductFilterDto->ownerId);

        if ($getProductFilterDto->id) {
            $query->where('p.id', $getProductFilterDto->id);
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

    private function applyOptionalFilter($query, GetProductFilterDto $getProductFilterDto)
    {
        if($getProductFilterDto->ownerId) {
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

        return $query;
    }
}
