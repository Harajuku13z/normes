<?php

namespace App\Services;

use App\Models\HomeSection;
use App\Models\SimulateurLead;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class SimulateurMailer
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
                'host' => trim((string) data_get($smtp, 'host', '')),
                'port' => (int) data_get($smtp, 'port', 587),
                'encryption' => trim((string) data_get($smtp, 'encryption', 'tls')),
                'username' => trim((string) data_get($smtp, 'username', '')),
                'password' => $password,
                'from_address' => trim((string) data_get($smtp, 'from_address', '')),
                'from_name' => trim((string) data_get($smtp, 'from_name', 'Normes & Renovation')),
            ],
            'notifications' => [
                'admin_email' => trim((string) data_get($notifications, 'admin_email', '')),
                'send_to_client' => (bool) data_get($notifications, 'send_to_client', true),
                'send_to_admin_on_step1' => (bool) data_get($notifications, 'send_to_admin_on_step1', true),
                'send_to_admin_on_completed' => (bool) data_get($notifications, 'send_to_admin_on_completed', true),
            ],
        ];
    }

    public function sendAdminStep1(SimulateurLead $lead): void
    {
        $settings = $this->settings();
        if (! data_get($settings, 'notifications.send_to_admin_on_step1', false)) {
            return;
        }
        $adminEmail = (string) data_get($settings, 'notifications.admin_email', '');
        if ($adminEmail === '') {
            return;
        }

        $html = View::make('emails.simulateur_admin_step1', ['lead' => $lead])->render();
        $this->sendHtml($settings, $adminEmail, 'Nouveau lead simulateur démarré', $html);
    }

    public function sendCompleted(SimulateurLead $lead): void
    {
        $settings = $this->settings();
        $adminEmail = (string) data_get($settings, 'notifications.admin_email', '');
        $sendAdmin = (bool) data_get($settings, 'notifications.send_to_admin_on_completed', false);
        $sendClient = (bool) data_get($settings, 'notifications.send_to_client', false);

        if ($sendAdmin && $adminEmail !== '') {
            $htmlAdmin = View::make('emails.simulateur_admin_completed', ['lead' => $lead])->render();
            $this->sendHtml($settings, $adminEmail, 'Simulateur complété par '.$lead->nom_prenom, $htmlAdmin);
        }

        $clientEmail = trim((string) ($lead->email ?? ''));
        if ($sendClient && $clientEmail !== '') {
            $htmlClient = View::make('emails.simulateur_client_confirmation', ['lead' => $lead])->render();
            $this->sendHtml($settings, $clientEmail, 'Confirmation de votre demande de simulation', $htmlClient);
        }
    }

    public function sendAdminManual(SimulateurLead $lead, string $recipientEmail): void
    {
        $to = trim($recipientEmail);
        if ($to === '') {
            throw new \RuntimeException('Admin recipient email is required.');
        }

        $settings = $this->settings();
        if ($lead->completed_at) {
            $html = View::make('emails.simulateur_admin_completed', ['lead' => $lead])->render();
            $subject = 'Simulateur complété par '.($lead->nom_prenom ?: 'un prospect');
        } else {
            $html = View::make('emails.simulateur_admin_step1', ['lead' => $lead])->render();
            $subject = 'Nouveau lead simulateur démarré';
        }

        $this->sendHtml($settings, $to, $subject, $html);
    }

    public function sendClientManual(SimulateurLead $lead, string $recipientEmail): void
    {
        $to = trim($recipientEmail);
        if ($to === '') {
            throw new \RuntimeException('Client recipient email is required.');
        }

        $settings = $this->settings();
        $html = View::make('emails.simulateur_client_confirmation', ['lead' => $lead])->render();
        $this->sendHtml($settings, $to, 'Confirmation de votre demande de simulation', $html);
    }

    /**
     * Public entry point for external callers (e.g. FranchiseController).
     *
     * @param  array<string, mixed>  $settings
     */
    public function sendRaw(array $settings, string $to, string $subject, string $html): void
    {
        $this->sendHtml($settings, $to, $subject, $html);
    }

    /**
     * @param  array<string, mixed>  $settings
     */
    private function sendHtml(array $settings, string $to, string $subject, string $html): void
    {
        $smtp = (array) data_get($settings, 'smtp', []);
        $host = (string) data_get($smtp, 'host', '');
        $fromAddress = (string) data_get($smtp, 'from_address', '');
        $username = (string) data_get($smtp, 'username', '');
        $password = (string) data_get($smtp, 'password', '');
        if ($host === '' || $fromAddress === '' || $username === '' || $password === '') {
            throw new \RuntimeException('SMTP settings are incomplete.');
        }

        // Laravel 11 uses 'scheme' (smtp/smtps) instead of 'encryption' (ssl/tls).
        // Map legacy values stored in DB to the new format.
        // If port is 465, always use smtps (implicit TLS) regardless of encryption value.
        $rawEnc = (string) data_get($smtp, 'encryption', 'smtps');
        $port   = (int) data_get($smtp, 'port', 465);
        $scheme = match (strtolower($rawEnc)) {
            'ssl', 'smtps' => 'smtps',
            'tls'          => 'smtp',    // STARTTLS on port 587
            default        => $port === 465 ? 'smtps' : 'smtp',  // auto-detect by port
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
