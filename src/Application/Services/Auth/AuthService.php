<?php

namespace Src\Application\Services\Auth;

use Src\Application\Dto\Login\AuthDto;
use Src\Application\Services\ServiceResult;
use Exception;
use Illuminate\Support\Facades\Log;
use Src\Application\Interfaces\Repositories\IUserRepository;
use Src\Application\Interfaces\Services\IAuthService;

class AuthService implements IAuthService
{
    public function __construct(
        private IUserRepository $userRepository
    ) {}

    public function authenticate(AuthDto $authDto): ServiceResult
    {
        try {
            $user = $this->userRepository->findByEmail($authDto->email);

            if (!$user) {
                return ServiceResult::fail('Usuário não encontrado');
            }

            if (! $this->userRepository->checkPassword($user, $authDto->password)) {
                return ServiceResult::fail('Senha incorreta');
            }

            $token = $this->userRepository->authenticate($authDto);

            return ServiceResult::ok(
                data: $token,
                message: 'Autenticação bem-sucedida'
            );
        } catch (Exception $e) {
            Log::error('Erro na autenticação: ' . $e->getMessage());
            throw $e;
        }
    }
}
