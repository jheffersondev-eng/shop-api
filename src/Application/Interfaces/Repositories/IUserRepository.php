<?php

namespace Src\Application\Interfaces\Repositories;

use Src\Application\Dto\Login\AuthDto;
use Src\Application\Dto\User\GetUserFilterDto;
use Src\Application\Dto\User\UserDto;
use Src\Domain\Entities\CreateUserEntity;
use Src\Domain\Entities\UserEntity;
use Src\Domain\Entities\UserSummaryEntity;

interface IUserRepository
{
    public function getUsersByFilter(GetUserFilterDto $getUserFilterDto): array;
    public function create(UserDto $userDto): CreateUserEntity;
    public function update(int $userId, UserDto $userDto): UserSummaryEntity;
    public function save(CreateUserEntity $userEntity): void;
    public function delete(int $userId, int $userIdDeleted): bool;
    public function findByEmail(string $email): UserEntity|null;
    public function checkPassword(UserEntity $user, string $password): bool;
    public function authenticate(AuthDto $authDto): string;
}
