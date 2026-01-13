<?php

namespace Src\Application\Interfaces\Services;

use Src\Application\Dto\Profile\CreateProfileDto;
use Src\Application\Dto\Profile\GetProfileFilterDto;
use Src\Application\Dto\Profile\UpdateProfileDto;
use Src\Application\Services\ServiceResult;

interface IProfileService
{
    public function getProfilesByFilter(GetProfileFilterDto $getProfileFilterDto): ServiceResult;
    public function create(CreateProfileDto $createProfileDto): ServiceResult;
    public function delete(int $profileId, int $userIdDeleted): ServiceResult;
    public function update(int $profileId, UpdateProfileDto $updateProfileDto): ServiceResult;
}
