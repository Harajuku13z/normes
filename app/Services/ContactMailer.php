<?php

namespace App\Services;

use App\Models\ContactInquiry;
use App\Models\HomeSection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class ContactMailer
{
    /**
     * @return array<string, mixed>
     */
    public function settings(): array
    {
        $saved = HomeSection::query()->where('key', 'simulateur_settings')->first();
        $payload = is_array($saved?->payload) ? $saved->payload : [];

        $smtp = (array) data_get($payload, 'smtp', []);
        $notifications = (array) data_get($payload, 'notifications', []);

        $password = '';
        $encrypted = (string) data_get($smtp, 'password', '');
        if ($encrypted !== '') {
            try {
                $password = Crypt::decryptString($encrypted);
            } catch (\Throwable) {
                $password = '';
            }
        }

        return [
            'smtp' => [
                'host'         => trim((string) data_get($smtp, 'host', '')),
                'port'         => (int) data_get($smtp, 'port', 587),
                'encryption'   => trim((string) data_get($smtp, 'encryption', 'tls')),
                'username'     => trim((string) data_get($smtp, 'username', '')),
                'password'     => $password,
                'from_address' => trim((string) data_get($smtp, 'from_address', '')),
                'from_name'    => trim((string) data_get($smtp, 'from_name', 'Normes & Renovation')),
            ],
            'admin_email' => trim((string) data_get($notifications, 'admin_email', '')),
        ];
    }

    public function sendAdminNotification(ContactInquiry $inquiry): void
    {
        $settings = $this->settings();
        $adminEmail = (string) data_get($settings, 'admin_email', '');
        if ($adminEmail === '') {
            return;
        }

        $html = View::make('emails.contact-admin', ['inquiry' => $inquiry])->render();
        $this->sendHtml($settings, $adminEmail, 'Nouveau message de contact – ' . ($inquiry->nom_complet ?: 'inconnu'), $html);
    }

    public function sendClientConfirmation(ContactInquiry $inquiry): void
    {
        $clientEmail = trim((string) ($inquiry->email ?? ''));
        if ($clientEmail === '') {
            return;
        }

        $settings = $this->settings();
        $html = View::make('emails.contact-client', ['inquiry' => $inquiry])->render();
        $this->sendHtml($settings, $clientEmail, 'Votre demande a bien été reçue – Normes & Renovation', $html);
    }

    /**
     * @param  array<string, mixed>  $settings
     */
    private function sendHtml(array $settings, string $to, string $subject, string $html): void
    {
        $smtp = (array) data_get($settings, 'smtp', []);
        $host         = (string) data_get($smtp, 'host', '');
        $fromAddress  = (string) data_get($smtp, 'from_address', '');
        $username     = (string) data_get($smtp, 'username', '');
        $password     = (string) data_get($smtp, 'password', '');

        if ($host === '' || $fromAddress === '' || $username === '' || $password === '') {
            throw new \RuntimeException('SMTP settings are incomplete. Configure them in Admin → Paramètres simulateur.');
        }

        // Laravel 11 uses 'scheme' (smtp/smtps) instead of 'encryption' (ssl/tls).
        // If port is 465, always use smtps (implicit TLS) regardless of encryption value.
        $rawEnc = (string) data_get($smtp, 'encryption', 'smtps');
        $port   = (int) data_get($smtp, 'port', 465);
        $scheme = match (strtolower($rawEnc)) {
            'ssl', 'smtps' => 'smtps',
            'tls'          => 'smtp',
            default        => $port === 465 ? 'smtps' : 'smtp',
        };

        config([
            'mail.default'                    => 'smtp',
            'mail.mailers.smtp.transport'     => 'smtp',
            'mail.mailers.smtp.scheme'        => $scheme,
            'mail.mailers.smtp.host'          => $host,
            'mail.mailers.smtp.port'          => (int) data_get($smtp, 'port', 465),
            'mail.mailers.smtp.username'      => $username,
            'mail.mailers.smtp.password'      => $password,
            'mail.from.address'               => $fromAddress,
            'mail.from.name'                  => (string) data_get($smtp, 'from_name', 'Normes & Renovation'),
        ]);

        Mail::html($html, function ($message) use ($to, $subject): void {
            $message->to($to)->subject($subject);
        });
    }
}
