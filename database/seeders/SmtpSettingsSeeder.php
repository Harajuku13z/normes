<?php

namespace Database\Seeders;

use App\Models\HomeSection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

/**
 * Seeds the simulateur_settings record with the Hostinger SMTP credentials.
 * Used by ContactMailer, SimulateurMailer, and FranchiseMailer at runtime.
 *
 * Run with:  php artisan db:seed --class=SmtpSettingsSeeder
 * Re-running is safe (updateOrCreate).
 */
class SmtpSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $host    = (string) env('MAIL_HOST',     'smtp.hostinger.com');
        $port    = (int)    env('MAIL_PORT',     465);
        $enc     = (string) env('MAIL_SCHEME',   'ssl');
        $user    = (string) env('MAIL_USERNAME', 'contact@normesrenovationbretagne.fr');
        $pass    = (string) env('MAIL_PASSWORD', '');
        $from    = (string) env('MAIL_FROM_ADDRESS', $user);
        $name    = (string) env('MAIL_FROM_NAME', 'Normes Rénovation');
        $adminTo = $from; // notifications go to the same mailbox by default

        // Normalise encryption string
        if ($enc === 'null' || $enc === 'none' || $enc === '') {
            $enc = 'none';
        }

        $payload = [
            'smtp' => [
                'host'         => $host,
                'port'         => $port,
                'encryption'   => $enc,
                'username'     => $user,
                'password'     => $pass !== '' ? Crypt::encryptString($pass) : '',
                'from_address' => $from,
                'from_name'    => $name,
            ],
            'notifications' => [
                'admin_email'                   => $adminTo,
                'send_to_client'                => true,
                'send_to_admin_on_step1'        => true,
                'send_to_admin_on_completed'    => true,
            ],
        ];

        HomeSection::query()->updateOrCreate(
            ['key' => 'simulateur_settings'],
            ['payload' => $payload]
        );

        $this->command->info('SMTP settings seeded → ' . $user . ' via ' . $host . ':' . $port . ' (' . $enc . ')');
    }
}
