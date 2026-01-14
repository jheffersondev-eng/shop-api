<?php

namespace Src\Application\Interfaces\Repositories;

use Src\Application\Dto\Login\AuthDto;
use Src\Application\Dto\User\GetUserFilterDto;
use Src\Application\Dto\User\UserDto;
use Src\Domain\Entities\UserEntity;

interface IUserRepository
{
    public function getUsersByFilter(GetUserFilterDto $getUserFilterDto): array;
    public function create(UserDto $userDto): UserEntity;
    public function update(int $userId, UserDto $userDto): UserEntity;
    public function save(UserEntity $userEntity): UserEntity;
    public function delete(int $userId, int $userIdDeleted): bool;
    public function findByEmail(string $email): UserEntity|null;
    public function findById(int $id): UserEntity|null;
    public function checkPassword(UserEntity $user, string $password): bool;
    public function authenticate(AuthDto $authDto): string;
}
