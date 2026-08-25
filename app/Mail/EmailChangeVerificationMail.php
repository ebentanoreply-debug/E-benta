<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailChangeVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $newEmail,
        public string $verificationLink
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirm Your E-Benta Email Change',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.email-change-verification',
            with: [
                'user' => $this->user,
                'newEmail' => $this->newEmail,
                'verificationLink' => $this->verificationLink,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
