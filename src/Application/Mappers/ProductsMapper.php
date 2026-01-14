<?php

namespace Src\Application\Mappers;

use DateTime;
use Illuminate\Support\Collection;
use Src\Application\Reponses\Category\CategorySummaryResponseDto;
use Src\Application\Reponses\Product\GetProductsByFilterResponseDto;
use Src\Application\Reponses\Unit\UnitSummaryResponseDto;
use Src\Application\Reponses\User\UserDetailSummaryResponseDto;

class ProductsMapper
{
    public function map(Collection $productsEntity): array
    {
        return $productsEntity->map(function($product) {
            $userUpdated = $product->user_updated_id ? new UserDetailSummaryResponseDto(
                    id: $product->user_updated_id,
                    name: $product->user_updated_name
                ) : null;

            $userCreated = $product->user_created_id ? new UserDetailSummaryResponseDto(
                    id: $product->user_created_id,
                    name: $product->user_created_name
                ) : null;
            
            return new GetProductsByFilterResponseDto(
                id: $product->id,
                name: $product->name,
                owner: new UserDetailSummaryResponseDto(
                    id: $product->owner_id,
                    name: $product->owner_name
                ),
                description: $product->description,
                images: $product->images,
                category: new CategorySummaryResponseDto(
                    id: $product->category_id,
                    name: $product->category_name
                ),
                unit: new UnitSummaryResponseDto(
                    id: $product->unit_id,
                    name: $product->unit_name,
                    abbreviation: $product->unit_abbreviation,
                    format: $product->unit_format
                ),
                barcode: $product->barcode,
                price: $product->price,
                costPrice: $product->cost_price,
                stockQuantity: $product->stock_quantity,
                minQuantity: $product->min_quantity,
                isActive: $product->is_active,
                userCreated: $userCreated,
                userUpdated: $userUpdated,
                createdAt: DateTime::createFromFormat('Y-m-d H:i:s', $product->created_at),
                updatedAt: DateTime::createFromFormat('Y-m-d H:i:s', $product->updated_at)
            );
        })->toArray();
    }
}