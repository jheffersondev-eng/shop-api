<?php

namespace Src\Application\Interfaces\Repositories;

use Src\Application\Dto\Login\AuthDto;
use Src\Infrastructure\Persistence\Models\User;

interface IUserRepository
{
    public function findByEmail(string $email): User|null;
    public function checkPassword(User $user, string $password): bool;
    public function authenticate(AuthDto $authDto): string;
}
