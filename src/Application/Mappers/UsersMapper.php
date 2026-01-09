<?php

namespace Src\Application\Mappers;

use DateTime;
use Illuminate\Support\Collection;
use Src\Domain\Entities\UserEntity;
use Src\Domain\Entities\ProfileSummaryEntity;
use Src\Domain\Entities\UserSummaryEntity;

class UsersMapper
{
    public function map(Collection $usersEntity): array
    {
        return $usersEntity->map(function($user) {
            $profile = null;

            $profile = $user->profile_id ? new ProfileSummaryEntity(
                id: $user->profile_id,
                name: $user->profile_name,
                description: $user->profile_description ?? null
            ) : null;

            $owner = $user->owner_id ? new UserSummaryEntity(
                id: $user->owner_id,
                name: $user->owner_name
            ) : null;

            $userCreated = $user->user_id_created ? new UserSummaryEntity(
                id: $user->user_id_created,
                name: $user->user_created_name
            ) : null;

            $userUpdated = $user->user_id_updated ? new UserSummaryEntity(
                id: $user->user_id_updated,
                name: $user->user_updated_name
            ) : null;

            return new UserEntity(
                id: $user->id,
                email: $user->email,
                owner: $owner,
                profile: $profile,
                isActive: $user->is_active,
                userCreated: $userCreated,
                userUpdated: $userUpdated,
                createdAt: DateTime::createFromFormat('Y-m-d H:i:s', $user->created_at),
                updatedAt: DateTime::createFromFormat('Y-m-d H:i:s', $user->updated_at),
                verificationCode: $user->verification_code ?? null,
                verificationExpiresAt: $user->verification_expires_at ? DateTime::createFromFormat('Y-m-d H:i:s', $user->verification_expires_at) : null
            );
        })->toArray();
    }
}
