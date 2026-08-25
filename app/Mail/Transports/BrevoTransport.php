<?php

namespace App\Mail\Transports;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\MessageConverter;

class BrevoTransport extends AbstractTransport
{
    protected string $key;

    public function __construct(string $key)
    {
        parent::__construct();
        $this->key = $key;
    }

    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());

        $sender = $email->getFrom()[0] ?? null;
        $senderName = $sender ? $sender->getName() : config('mail.from.name');
        $senderEmail = $sender ? $sender->getAddress() : config('mail.from.address');

        $to = [];
        foreach ($email->getTo() as $recipient) {
            $to[] = [
                'email' => $recipient->getAddress(),
                'name' => $recipient->getName() ?: $recipient->getAddress(),
            ];
        }

        $payload = [
            'sender' => [
                'name' => $senderName ?: 'E-benta',
                'email' => $senderEmail ?: 'ebentanoreply@gmail.com',
            ],
            'to' => $to,
            'subject' => $email->getSubject() ?? 'No Subject',
        ];

        $html = $email->getHtmlBody();
        $text = $email->getTextBody();

        if ($html) {
            $payload['htmlContent'] = is_resource($html) ? stream_get_contents($html) : (string) $html;
        }

        if ($text) {
            $payload['textContent'] = is_resource($text) ? stream_get_contents($text) : (string) $text;
        }

        if (empty($payload['htmlContent']) && empty($payload['textContent'])) {
            $payload['textContent'] = ' ';
        }

        $attachments = [];
        foreach ($email->getAttachments() as $attachment) {
            $attachments[] = [
                'name' => $attachment->getPreparedHeaders()->getHeaderParameter('Content-Disposition', 'filename') ?: 'attachment',
                'content' => base64_encode($attachment->getBody()),
            ];
        }

        if (!empty($attachments)) {
            $payload['attachment'] = $attachments;
        }

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'api-key' => $this->key,
            'content-type' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', $payload);

        if (!$response->successful()) {
            Log::error('Brevo API Mail Error: ' . $response->body());
            throw new \RuntimeException('Brevo API Error: ' . $response->body());
        }
    }

    public function __toString(): string
    {
        return 'brevo';
    }
}
