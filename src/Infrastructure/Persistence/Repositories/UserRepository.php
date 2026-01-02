<?php

namespace Src\Infrastructure\Persistence\Repositories;

use Src\Application\DTOs\Login\AuthDto;
use Src\Infrastructure\Persistence\Models\User;
use Src\Application\Interfaces\Repositories\IUserRepository;
use Illuminate\Support\Facades\Hash;

class UserRepository implements IUserRepository
{
    public function findByEmail(string $email): User|null
    {
        return User::where('email', $email)->first();
    }

    public function checkPassword(User $user, string $password): bool
    {
        return Hash::check($password, $user->password);
    }

    public function authenticate(AuthDto $authDto): string
    {
        $user = $this->findByEmail($authDto->email);
        return $user->createToken('api-token')->plainTextToken;
    }
}
