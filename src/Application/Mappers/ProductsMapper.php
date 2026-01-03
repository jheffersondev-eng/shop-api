<?php

namespace Src\Application\Mappers;

use DateTime;
use Illuminate\Support\Collection;
use Src\Domain\Entities\CategorySummaryEntity;
use Src\Domain\Entities\ProductEntity;
use Src\Domain\Entities\UnitSummaryEntity;
use Src\Domain\Entities\UserSummaryEntity;

class ProductsMapper
{
    public function __construct()
    {
    }

    public function map(Collection $productsEntity): array
    {
        return $productsEntity->map(function($product) {

            return new ProductEntity(
                id: $product->id,
                name: $product->name,
                owner: new UserSummaryEntity(
                    id: $product->owner_id,
                    name: $product->owner_name
                ),
                images: $product->images,
                category: new CategorySummaryEntity(
                    id: $product->category_id,
                    name: $product->category_name
                ),
                unit: new UnitSummaryEntity(
                    id: $product->unit_id,
                    name: $product->unit_name
                ),
                barcode: $product->barcode,
                price: $product->price,
                costPrice: $product->cost_price,
                stockQuantity: $product->stock_quantity,
                minQuantity: $product->min_quantity,
                isActive: $product->is_active,
                userCreated: new UserSummaryEntity(
                    id: $product->user_created_id,
                    name: $product->user_created_name
                ),
                userUpdated: new UserSummaryEntity(
                    id: $product->user_updated_id,
                    name: $product->user_updated_name
                ),
                createdAt: DateTime::createFromFormat('Y-m-d H:i:s', $product->created_at),
                updatedAt: DateTime::createFromFormat('Y-m-d H:i:s', $product->updated_at)
            );
        })->toArray();
    }
}