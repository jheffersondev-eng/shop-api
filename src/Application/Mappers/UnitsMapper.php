<?php

namespace Src\Application\Mappers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Collection;
use Src\Application\Reponses\Unit\GetUnitByFilterResponseDto;
use Src\Application\Reponses\User\UserDetailSummaryResponseDto;

class UnitsMapper
{
    public function map(Collection $unitsEntity): array
    {
        return $unitsEntity->map(function ($unit) {
            $userUpdated = $unit->user_updated_id ? new UserDetailSummaryResponseDto(
                id: $unit->user_updated_id,
                name: $unit->user_updated_name
            ) : null;

            $owner = new UserDetailSummaryResponseDto(
                id: $unit->owner_id,
                name: $unit->owner_name
            );

            $userCreated = new UserDetailSummaryResponseDto(
                id: $unit->user_created_id,
                name: $unit->user_created_name
            );

            $userDeleted = $unit->user_deleted_id ? new UserDetailSummaryResponseDto(
                id: $unit->user_deleted_id,
                name: $unit->user_deleted_name
            ) : null;

            return new GetUnitByFilterResponseDto(
                id: $unit->id,
                name: $unit->name,
                owner: $owner,
                abbreviation: $unit->abbreviation,
                format: $unit->format,
                userCreated: $userCreated,
                userUpdated: $userUpdated,
                userDeleted: $userDeleted,
                createdAt: Carbon::parse($unit->created_at)->subHours(3),
                updatedAt: $unit->updated_at ? Carbon::parse($unit->updated_at)->subHours(3) : null,
                deletedAt: $unit->deleted_at ? Carbon::parse($unit->deleted_at)->subHours(3) : null
            );
        })->toArray();
    }
}
