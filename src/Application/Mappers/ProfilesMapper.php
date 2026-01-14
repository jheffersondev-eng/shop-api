<?php

namespace Src\Application\Mappers;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Src\Application\Reponses\Profile\GetProfileByFilterResponseDto;
use Src\Application\Reponses\User\UserDetailSummaryResponseDto;

class ProfilesMapper
{
    public function map(Collection $profilesEntity): array
    {
        return $profilesEntity->map(function ($profile) {
            $userUpdated = $profile->user_updated_id ? new UserDetailSummaryResponseDto(
                id: $profile->user_updated_id,
                name: $profile->user_updated_name
            ) : null;

            $userCreated = $profile->user_created_id ? new UserDetailSummaryResponseDto(
                id: $profile->user_created_id,
                name: $profile->user_created_name
            ) : null;

            $userDeleted = $profile->user_deleted_id ? new UserDetailSummaryResponseDto(
                id: $profile->user_deleted_id,
                name: $profile->user_deleted_name
            ) : null;

            return new GetProfileByFilterResponseDto(
                id: $profile->id,
                owner: new UserDetailSummaryResponseDto(
                    id: $profile->owner_id,
                    name: $profile->owner_name
                ),
                name: $profile->name,
                description: $profile->description,
                permission: $profile->permission,
                userCreated: $userCreated,
                userUpdated: $userUpdated,
                userDeleted: $userDeleted,
                createdAt: Carbon::parse($profile->created_at)->subHours(3),
                updatedAt: $profile->updated_at ? Carbon::parse($profile->updated_at)->subHours(3) : null,
                deletedAt: $profile->deleted_at ? Carbon::parse($profile->deleted_at)->subHours(3) : null,
            );
        })->toArray();
    }
}
