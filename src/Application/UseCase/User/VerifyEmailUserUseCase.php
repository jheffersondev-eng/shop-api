<?php

namespace Src\Application\UseCase\User;

use Src\Application\Interfaces\Repositories\IUserRepository;
use Src\Application\Services\ServiceResult;

class VerifyEmailUserUseCase
{
    public function __construct(
        private IUserRepository $userRepository
    ) {}

    public function verifyEmail($verifyEmailDto): ServiceResult
    {
        $user = $this->userRepository->findById($verifyEmailDto->userId);

        if (!$user) {
            return ServiceResult::fail('Usuário não encontrado');
        }

        if ($user->email !== $verifyEmailDto->email) {
            return ServiceResult::fail('E-mail não corresponde ao usuário');
        }

        if ($user->verificationCode !== $verifyEmailDto->verificationCode) {
            return ServiceResult::fail('Código de verificação inválido');
        }

        if ($user->verificationExpiresAt < now()) {
            return ServiceResult::fail('Código de verificação expirado');
        }

        $user->emailVerifiedAt = now();
        $user->verificationCode = null;
        $user->verificationExpiresAt = null;

        $this->userRepository->save($user);

        return ServiceResult::ok(
            data: $user,
            message: 'E-mail verificado com sucesso'
        );
    }
}
