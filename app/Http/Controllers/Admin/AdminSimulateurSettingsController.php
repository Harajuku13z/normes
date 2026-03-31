<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Models\SimulateurLead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

class AdminSimulateurSettingsController extends Controller
{
    public function edit(): View
    {
        $saved = HomeSection::query()->where('key', 'simulateur_settings')->first();
        $payload = is_array($saved?->payload) ? $saved->payload : [];

        $settings = [
            'smtp' => [
                'host' => (string) data_get($payload, 'smtp.host', ''),
                'port' => (string) data_get($payload, 'smtp.port', '587'),
                'encryption' => (string) data_get($payload, 'smtp.encryption', 'tls'),
                'username' => (string) data_get($payload, 'smtp.username', ''),
                'password_encrypted' => (string) data_get($payload, 'smtp.password', ''),
                'from_address' => (string) data_get($payload, 'smtp.from_address', ''),
                'from_name' => (string) data_get($payload, 'smtp.from_name', 'Normes & Renovation'),
            ],
            'notifications' => [
                'admin_email' => (string) data_get($payload, 'notifications.admin_email', ''),
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

        $leads = SimulateurLead::query()
            ->orderByDesc('id')
            ->limit(100)
            ->get();

        return view('admin.simulateur_settings.edit', [
            'settings' => $settings,
            'smtpPassword' => $smtpPassword,
            'leads' => $leads,
        ]);
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
}
