<?php

namespace Src\Application\Mappers;

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

            return new GetUnitByFilterResponseDto(
                id: $unit->id,
                name: $unit->name,
                owner: $owner,
                abbreviation: $unit->abbreviation,
                format: $unit->format,
                userCreated: $userCreated,
                userUpdated: $userUpdated,
                createdAt: DateTime::createFromFormat('Y-m-d H:i:s', $unit->created_at),
                updatedAt: DateTime::createFromFormat('Y-m-d H:i:s', $unit->updated_at)
            );
        })->toArray();
    }
}
