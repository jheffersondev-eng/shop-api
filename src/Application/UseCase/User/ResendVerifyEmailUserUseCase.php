<?php

namespace Src\Application\UseCase\User;

use Carbon\Carbon;
use Src\Application\Dto\User\ResendVerifyEmailDto;
use Src\Application\Interfaces\Repositories\IUserRepository;
use Src\Application\Services\ServiceResult;
use Src\Application\Support\TimeHelper;
use Src\Infrastructure\Mail\SendMail;

class ResendVerifyEmailUserUseCase
{
    public function __construct(
        private IUserRepository $userRepository
    ) {}

    public function resendVerifyEmail(ResendVerifyEmailDto $resendEmailDto): ServiceResult
    {
        $user = $this->userRepository->findById($resendEmailDto->userId);

        if (!$user) {
            return ServiceResult::fail('Usuário não encontrado');
        }

        if ($user->email !== $resendEmailDto->email) {
            return ServiceResult::fail('E-mail não corresponde ao usuário');
        }

        // Verifica se já se passaram 5 minutos desde o último envio
        $lastSend = Carbon::parse($user->verificationExpiresAt)->subMinutes(30);
        $currentTime = $lastSend->diffInMinutes(now());
        $minutesRemaining = 5 - $currentTime;

        if ($currentTime < 5) {
            $timeFormatted = TimeHelper::formatMinutesAndSeconds($minutesRemaining);
            return ServiceResult::fail("Aguarde {$timeFormatted} antes de reenviar o código de verificação");
        }

        $verificationCode = rand(100000, 999999);
        $user->verificationCode = $verificationCode;
        $user->verificationExpiresAt = now()->addMinutes(30);

        $this->userRepository->save($user);

        SendMail::send($user->email, $user->id, $verificationCode);

        return ServiceResult::ok(
            data: null,
            message: 'Email de verificação reenviado com sucesso',
        );
    }
}
