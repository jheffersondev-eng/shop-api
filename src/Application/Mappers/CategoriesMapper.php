<?php

namespace Src\Application\Mappers;

use DateTime;
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

            return new GetCategoryByFilterResponseDto(
                id: $category->id,
                name: $category->name,
                owner: new UserDetailSummaryResponseDto(
                    id: $category->owner_id,
                    name: $category->owner_name
                ),
                description: $category->description,
                userCreated: $userCreated,
                userUpdated: $userUpdated,
                createdAt: DateTime::createFromFormat('Y-m-d H:i:s', $category->created_at),
                updatedAt: DateTime::createFromFormat('Y-m-d H:i:s', $category->updated_at)
            );
        })->toArray();
    }
}
