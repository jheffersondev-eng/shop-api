<?php

namespace Src\Application\Mappers;

use DateTime;
use Illuminate\Support\Collection;
use Src\Domain\Entities\CategoryEntity;
use Src\Domain\Entities\UserSummaryEntity;

class CategoriesMapper
{
    public function map(Collection $categoriesEntity): array
    {
        return $categoriesEntity->map(function($category) {
            $userUpdated = $category->user_updated_id ? new UserSummaryEntity(
                    id: $category->user_updated_id,
                    name: $category->user_updated_name
                ) : null;
                
            return new CategoryEntity(
                id: $category->id,
                name: $category->name,
                owner: new UserSummaryEntity(
                    id: $category->owner_id,
                    name: $category->owner_name
                ),
                description: $category->description,
                userCreated: $category->user_created_id ? new UserSummaryEntity(
                    id: $category->user_created_id,
                    name: $category->user_created_name
                ) : null,
                userUpdated: $userUpdated,
                createdAt: DateTime::createFromFormat('Y-m-d H:i:s', $category->created_at),
                updatedAt: DateTime::createFromFormat('Y-m-d H:i:s', $category->updated_at)
            );
        })->toArray();
    }
}
