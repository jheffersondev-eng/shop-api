<?php

namespace Src\Application\Mappers;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Src\Application\Reponses\Category\GetCategoryByFilterResponseDto;
use Src\Application\Reponses\User\UserDetailSummaryResponseDto;

class CategoriesMapper
{
    public function map(Collection $categoriesEntity): array
    {
        return $categoriesEntity->map(function ($category) {
            $userUpdated = $category->user_updated_id ? new UserDetailSummaryResponseDto(
                id: $category->user_updated_id,
                name: $category->user_updated_name
            ) : null;

            $userCreated = $category->user_created_id ? new UserDetailSummaryResponseDto(
                id: $category->user_created_id,
                name: $category->user_created_name
            ) : null;

            $userDeleted = $category->user_deleted_id ? new UserDetailSummaryResponseDto(
                id: $category->user_deleted_id,
                name: $category->user_deleted_name
            ) : null;

            return new GetCategoryByFilterResponseDto(
                id: $category->id,
                name: ucfirst(strtolower($category->name)),
                owner: new UserDetailSummaryResponseDto(
                    id: $category->owner_id,
                    name: $category->owner_name
                ),
                description: $category->description,
                userCreated: $userCreated,
                userUpdated: $userUpdated,
                userDeleted: $userDeleted,
                createdAt: Carbon::parse($category->created_at)->subHours(3),
                updatedAt: $category->updated_at ? Carbon::parse($category->updated_at)->subHours(3) : null,
                deletedAt: $category->deleted_at ? Carbon::parse($category->deleted_at)->subHours(3) : null
            );
        })->toArray();
    }
}
