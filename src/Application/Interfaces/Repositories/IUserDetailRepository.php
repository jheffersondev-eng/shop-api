<?php

namespace Src\Application\Interfaces\Repositories;

use Src\Application\Dto\User\UserDetailsDto;
use Src\Domain\Entities\UserDetailsEntity;

interface IUserDetailRepository
{
    public function findByDocument(string $document): UserDetailsEntity|null;
    public function getUserDetailByUserId(int $userId): UserDetailsEntity|null;
    public function create(UserDetailsDto $userDetailsDto, int $userId): UserDetailsEntity;
    public function update(UserDetailsDto $userDetailsDto): UserDetailsEntity;
    public function delete(int $id): UserDetailsEntity;
}
