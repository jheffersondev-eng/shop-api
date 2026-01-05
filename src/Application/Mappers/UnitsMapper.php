<?php

namespace Src\Application\Mappers;

use DateTime;
use Illuminate\Support\Collection;
use Src\Domain\Entities\UnitEntity;
use Src\Domain\Entities\UserSummaryEntity;

class UnitsMapper
{
    public function map(Collection $unitsEntity): array
    {
        return $unitsEntity->map(function($unit) {
            $userUpdated = $unit->user_updated_id ? new UserSummaryEntity(
                    id: $unit->user_updated_id,
                    name: $unit->user_updated_name
                ) : null;
            
            return new UnitEntity(
                id: $unit->id,
                name: $unit->name,
                owner: new UserSummaryEntity(
                    id: $unit->owner_id,
                    name: $unit->owner_name
                ),
                abbreviation: $unit->abbreviation,
                format: $unit->format,
                userCreated: $unit->user_created_id ? new UserSummaryEntity(
                    id: $unit->user_created_id,
                    name: $unit->user_created_name
                ) : null,
                userUpdated: $userUpdated,
                createdAt: DateTime::createFromFormat('Y-m-d H:i:s', $unit->created_at),
                updatedAt: DateTime::createFromFormat('Y-m-d H:i:s', $unit->updated_at)
            );
        })->toArray();
    }
}