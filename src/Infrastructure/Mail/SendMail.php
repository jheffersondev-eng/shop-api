<?php
 
namespace Src\Infrastructure\Mail;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Src\Application\Exceptions\UserNotFoundException;
use Src\Infrastructure\Persistence\Models\User;
use Throwable;

class SendMail
{
    public static function send($sendTo, int $userId, $verificationCode)
    {
        try {
            $user = User::find($userId);

            if (!$user) {
                throw new UserNotFoundException();
            }

            Mail::to($sendTo)->send(new VerifyEmailMail($user, $verificationCode));
        } catch (Throwable $mailException) {
            Log::error("Erro ao enviar email de verificação: {$mailException->getMessage()}");
        }
    }
}