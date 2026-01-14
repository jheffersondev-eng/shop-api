<?php

namespace Src\Application\Interfaces\Repositories;

use Src\Application\Dto\Profile\GetProfileFilterDto;
use Src\Application\Dto\Profile\CreateProfileDto;
use Src\Application\Dto\Profile\UpdateProfileDto;
use Src\Domain\Entities\ProfileEntity;

interface IProfileRepository
{
    public function getProfilesByFilter(GetProfileFilterDto $getProfileFilterDto): array;
    public function create(CreateProfileDto $createProfileDto): ProfileEntity;
    public function update(int $profileId, UpdateProfileDto $updateProfileDto): ProfileEntity;
    public function delete(int $profileId, int $userIdDeleted): bool;
}
