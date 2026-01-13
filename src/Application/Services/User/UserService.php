<?php

namespace Src\Application\Services\User;

use Src\Application\Services\ServiceResult;
use Exception;
use Illuminate\Support\Facades\Log;
use Src\Application\Dto\User\UserDto;
use Src\Application\Dto\User\GetUserFilterDto;
use Src\Application\Dto\User\ResendVerifyEmailDto;
use Src\Application\Dto\User\VerifyEmailDto;
use Src\Application\Exceptions\UserNotFoundException;
use Src\Application\UseCase\User\VerifyEmailUserUseCase;
use Src\Application\Interfaces\Repositories\IUserRepository;
use Src\Application\Interfaces\Services\IUserService;
use Src\Application\UseCase\User\CreateUserUseCase;
use Src\Application\UseCase\User\ResendVerifyEmailUserUseCase;
use Throwable;

class UserService implements IUserService
{
    public function __construct(
        private IUserRepository $userRepository,
        private VerifyEmailUserUseCase $verifyEmailUserUseCase,
        private ResendVerifyEmailUserUseCase $resendVerifyEmailUserUseCase,
        private CreateUserUseCase $createUserUseCase
    ) {}

    public function getUsersByFilter(GetUserFilterDto $getUserFilterDto): ServiceResult
    {
        try {
            $data = $this->userRepository->getUsersByFilter($getUserFilterDto);
            
            return ServiceResult::ok(
                data: $data,
                message: 'Usuários filtrados com sucesso.'
            );
        } catch (Exception $e) {
            Log::error('Erro ao filtrar usuários: ' . $e->getMessage());
            throw $e;
        }
    }

    public function create(UserDto $userDto): ServiceResult
    {
        try {
            return $this->createUserUseCase->createUser($userDto);
        } catch (Throwable $e) {
            Log::error('Erro ao criar usuário: '.$e->getMessage());
            Log::error('Stack trace: '.$e->getTraceAsString());
            return ServiceResult::fail('Ocorreu um erro ao criar usuário');
        }
    }

    public function update(int $userId, UserDto $userDto): ServiceResult
    {
        try {
            $user = $this->userRepository->update($userId, $userDto);

            return ServiceResult::ok(
                data: $user,
                message: 'Usuário atualizado com sucesso.'
            );
        } catch (UserNotFoundException $e) {
            Log::error('Usuário não encontrado: ' . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            Log::error('Erro ao atualizar usuário: ' . $e->getMessage());
            throw $e;
        }
    }

    public function delete(int $userId, int $userIdDeleted): ServiceResult
    {
        try {
            $this->userRepository->delete($userId, $userIdDeleted);
            
            return ServiceResult::ok(
                data: null,
                message: 'Usuário excluído com sucesso.'
            );
        } catch (UserNotFoundException $e) {
            Log::error('Usuário não encontrado: ' . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            Log::error('Erro ao excluir usuário: ' . $e->getMessage());
            throw $e;
        }
    }

    public function verifyEmail(VerifyEmailDto $verifyEmailDto): ServiceResult
    {
        try {
            return $this->verifyEmailUserUseCase->verifyEmail($verifyEmailDto);
        } catch (Exception $e) {
            Log::error('Erro ao verificar e-mail: ' . $e->getMessage());
            throw $e;
        }
    }

    public function resendVerifyEmail(ResendVerifyEmailDto $resendEmailDto): ServiceResult
    {
        try {
            return $this->resendVerifyEmailUserUseCase->resendVerifyEmail($resendEmailDto);
        } catch (Exception $e) {
            Log::error('Erro ao reenviar e-mail de verificação: ' . $e->getMessage());
            throw $e;
        }
    }
}
