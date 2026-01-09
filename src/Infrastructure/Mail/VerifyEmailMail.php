<?php

namespace Src\Infrastructure\Mail;

use Src\Infrastructure\Persistence\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyEmailMail extends Mailable
{
    use SerializesModels;

    public function __construct(
        public User $user,
        public string $verificationCode
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verifique seu e-mail - Porto Shop',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verify-email',
            with: [
                'user' => $this->user,
                'verificationCode' => $this->verificationCode,
            ]
        );
    }
}
