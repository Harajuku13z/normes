<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Models\SimulateurLead;
use App\Services\SimulateurMailer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

class AdminSimulateurSettingsController extends Controller
{
    public function edit(): View
    {
        [$settings, $smtpPassword] = $this->settingsData();

        return view('admin.simulateur_settings.edit', [
            'settings' => $settings,
            'smtpPassword' => $smtpPassword,
        ]);
    }

    public function leads(): View
    {
        [$settings] = $this->settingsData();
        $leads = SimulateurLead::query()
            ->orderByDesc('id')
            ->limit(100)
            ->get();

        return view('admin.simulateur_settings.leads', [
            'leads' => $leads,
            'defaultAdminEmail' => (string) data_get($settings, 'notifications.admin_email', ''),
        ]);
    }

    public function resendAdminMail(Request $request, SimulateurLead $simulateurLead, SimulateurMailer $mailer): RedirectResponse
    {
        $lead = $simulateurLead;
        $data = $request->validate([
            'recipient_email' => ['required', 'email', 'max:190'],
        ]);

        $recipient = trim((string) $data['recipient_email']);

        try {
            $mailer->sendAdminManual($lead, $recipient);

            $lead->forceFill([
                'mail_error' => null,
                'admin_notified_started_at' => $lead->completed_at ? $lead->admin_notified_started_at : now(),
                'admin_notified_completed_at' => $lead->completed_at ? now() : $lead->admin_notified_completed_at,
            ])->save();

            return redirect()
                ->route('admin.simulateur_leads.index')
                ->with('status', 'Admin email resent to '.$recipient.' for lead #'.$lead->id.'.');
        } catch (\Throwable $e) {
            $lead->forceFill(['mail_error' => $e->getMessage()])->save();

            return redirect()
                ->route('admin.simulateur_leads.index')
                ->withErrors(['recipient_email' => 'Unable to send email: '.$e->getMessage()]);
        }
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'smtp.host' => ['required', 'string', 'max:255'],
            'smtp.port' => ['required', 'integer', 'min:1', 'max:65535'],
            'smtp.encryption' => ['required', 'in:none,tls,ssl'],
            'smtp.username' => ['required', 'email', 'max:190'],
            'smtp.password' => ['required', 'string', 'max:255'],
            'smtp.from_address' => ['required', 'email', 'max:190'],
            'smtp.from_name' => ['nullable', 'string', 'max:190'],
            'notifications.admin_email' => ['required', 'email', 'max:190'],
            'notifications.send_to_client' => ['nullable', 'boolean'],
            'notifications.send_to_admin_on_step1' => ['nullable', 'boolean'],
            'notifications.send_to_admin_on_completed' => ['nullable', 'boolean'],
        ]);

        $payload = [
            'smtp' => [
                'host' => (string) data_get($data, 'smtp.host'),
                'port' => (int) data_get($data, 'smtp.port'),
                'encryption' => (string) data_get($data, 'smtp.encryption'),
                'username' => (string) data_get($data, 'smtp.username'),
                'password' => Crypt::encryptString((string) data_get($data, 'smtp.password')),
                'from_address' => (string) data_get($data, 'smtp.from_address'),
                'from_name' => trim((string) data_get($data, 'smtp.from_name', '')) ?: 'Normes & Renovation',
            ],
            'notifications' => [
                'admin_email' => (string) data_get($data, 'notifications.admin_email'),
                'send_to_client' => (bool) data_get($data, 'notifications.send_to_client', false),
                'send_to_admin_on_step1' => (bool) data_get($data, 'notifications.send_to_admin_on_step1', false),
                'send_to_admin_on_completed' => (bool) data_get($data, 'notifications.send_to_admin_on_completed', false),
            ],
        ];

        HomeSection::query()->updateOrCreate(
            ['key' => 'simulateur_settings'],
            ['payload' => $payload]
        );

        return redirect()
            ->route('admin.simulateur_settings.edit')
            ->with('status', 'Simulator SMTP settings saved.');
    }

    /**
     * @return array{0: array<string, mixed>, 1: string}
     */
    private function settingsData(): array
    {
        $saved = HomeSection::query()->where('key', 'simulateur_settings')->first();
        $payload = is_array($saved?->payload) ? $saved->payload : [];

        $smtpUsername = (string) data_get($payload, 'smtp.username', '');
        $adminEmail = (string) data_get($payload, 'notifications.admin_email', '');

        $settings = [
            'smtp' => [
                'host' => (string) data_get($payload, 'smtp.host', ''),
                'port' => (string) data_get($payload, 'smtp.port', '587'),
                'encryption' => (string) data_get($payload, 'smtp.encryption', 'tls'),
                'username' => $smtpUsername,
                'password_encrypted' => (string) data_get($payload, 'smtp.password', ''),
                'from_address' => (string) data_get($payload, 'smtp.from_address', ''),
                'from_name' => (string) data_get($payload, 'smtp.from_name', 'Normes & Renovation'),
            ],
            'notifications' => [
                // If admin email is empty, fallback to SMTP username to avoid missing recipient.
                'admin_email' => $adminEmail !== '' ? $adminEmail : $smtpUsername,
                'send_to_client' => (bool) data_get($payload, 'notifications.send_to_client', true),
                'send_to_admin_on_step1' => (bool) data_get($payload, 'notifications.send_to_admin_on_step1', true),
                'send_to_admin_on_completed' => (bool) data_get($payload, 'notifications.send_to_admin_on_completed', true),
            ],
        ];

        $smtpPassword = '';
        if ($settings['smtp']['password_encrypted'] !== '') {
            try {
                $smtpPassword = Crypt::decryptString($settings['smtp']['password_encrypted']);
            } catch (\Throwable) {
                $smtpPassword = '';
            }
        }

        return [$settings, $smtpPassword];
    }
}
