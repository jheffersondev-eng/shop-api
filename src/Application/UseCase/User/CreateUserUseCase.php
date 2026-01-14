<?php

namespace Src\Application\UseCase\User;

use Src\Application\Dto\User\UserDto;
use Src\Application\Interfaces\Repositories\IUserDetailRepository;
use Src\Application\Interfaces\Repositories\IUserRepository;
use Src\Application\Services\ServiceResult;
use Src\Infrastructure\Mail\SendMail;

class CreateUserUseCase
{
    public function __construct(
        private IUserRepository $userRepository,
        private IUserDetailRepository $userDetailRepository
    ) {}

    public function createUser(UserDto $userDto): ServiceResult
    {
        $email = $this->userRepository->findByEmail($userDto->email);
        if ($email) {
            return ServiceResult::fail('E-mail já cadastrado');
        }

        $document = $this->userDetailRepository->findByDocument($userDto->userDetailsDto->document);
        if ($document) {
            return ServiceResult::fail('Documento já cadastrado');
        }

        if ($userDto->userDetailsDto->birthDate > now()->subYears(17)->toDateString()) {
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
    }
}
