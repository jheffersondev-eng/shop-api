<?php

namespace Src\Application\Mappers;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Src\Application\Reponses\Profile\ProfileSummaryResponseDto;
use Src\Application\Reponses\User\GetUsersByFilterResponseDto;
use Src\Application\Reponses\User\UserDetailSummaryResponseDto;

class UsersMapper
{
    public function map(Collection $usersEntity): array
    {
        return $usersEntity->map(function($user) {
            $profile = null;

            $profile = $user->profile_id ? new ProfileSummaryResponseDto(
                id: $user->profile_id,
                name: $user->profile_name,
                description: $user->profile_description ?? null
            ) : null;

            $owner = $user->owner_id ? new UserDetailSummaryResponseDto(
                id: $user->owner_id,
                name: $user->owner_name
            ) : null;

            $userCreated = $user->user_id_created ? new UserDetailSummaryResponseDto(
                id: $user->user_id_created,
                name: $user->user_created_name
            ) : null;

                $userUpdated = $user->user_id_updated ? new UserDetailSummaryResponseDto(
                    id: $user->user_id_updated,
                    name: $user->user_updated_name
                ) : null;

                $userDeleted = $user->user_id_deleted ? new UserDetailSummaryResponseDto(
                    id: $user->user_id_deleted,
                    name: $user->user_deleted_name
                ) : null;

            return new GetUsersByFilterResponseDto(
                id: $user->id,
                email: $user->email,
                owner: $owner,
                profile: $profile,
                isActive: $user->is_active,
                userCreated: $userCreated,
                userUpdated: $userUpdated,
                userDeleted: $userDeleted,
                createdAt: Carbon::parse($user->created_at)->subHours(3),
                updatedAt: $user->updated_at ? Carbon::parse($user->updated_at)->subHours(3) : null,
                deletedAt: $user->deleted_at ? Carbon::parse($user->deleted_at)->subHours(3) : null,
                emailVerifiedAt: $user->email_verified_at ? Carbon::parse($user->email_verified_at)->subHours(3) : null,
                verificationCode: $user->verification_code ?? null,
                verificationExpiresAt: $user->verification_expires_at ? Carbon::parse($user->verification_expires_at)->subHours(3) : null
            );
        })->toArray();
    }
}
