<?php

namespace Src\Application\Services\User;

use Src\Application\Services\ServiceResult;
use Exception;
use Illuminate\Support\Facades\Log;
use Src\Application\Dto\User\UserDto;
use Src\Application\Dto\User\GetUserFilterDto;
use Src\Application\Exceptions\UserNotFoundException;
use Src\Application\Interfaces\Repositories\IUserDetailRepository;
use Src\Application\Interfaces\Repositories\IUserRepository;
use Src\Application\Interfaces\Services\IUserService;
use Src\Infrastructure\Mail\SendMail;
use Throwable;

class UserService implements IUserService
{
    public function __construct(
        private IUserRepository $userRepository,
        private IUserDetailRepository $userDetailRepository
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
            $email = $this->userRepository->findByEmail($userDto->email);
            if ($email) {
                return ServiceResult::fail('E-mail já cadastrado');
            }

            $document = $this->userDetailRepository->findByDocument($userDto->userDetailsDto->document);
            if ($document) {
                return ServiceResult::fail('Documento já cadastrado');
            }

            if($userDto->userDetailsDto->birthDate > now()->subYears(17)->toDateString()) {
                return ServiceResult::fail('Usuário deve ser maior de 18 anos');
            }
            
            $userEntity = $this->userRepository->create($userDto);

            if (!$userEntity->ownerId) {
                $userEntity->ownerId = $userEntity->id;
            }
            
            $verificationCode = rand(100000, 999999);
            $userEntity->verificationCode = $verificationCode;
            $userEntity->verificationExpiresAt = now()->addMinutes(30);
          
            $this->userRepository->save($userEntity);
            $this->userDetailRepository->create($userDto->userDetailsDto, $userEntity->id);

            SendMail::send($userEntity->email, $userEntity->id, $verificationCode);

            return ServiceResult::ok(
                data: $userEntity,
                message: 'Usuário criado com sucesso',
            );

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
}
