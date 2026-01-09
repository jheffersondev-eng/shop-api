<?php

namespace Src\Application\Interfaces\Services;

use Src\Application\Dto\User\UserDto;
use Src\Application\Dto\User\GetUserFilterDto;
use Src\Application\Services\ServiceResult;

interface IUserService
{
    public function getUsersByFilter(GetUserFilterDto $getUserFilterDto): ServiceResult;
    public function create(UserDto $userDto): ServiceResult;
    public function delete(int $userId, int $userIdDeleted): ServiceResult;
    public function update(int $userId, UserDto $userDto): ServiceResult;
}
