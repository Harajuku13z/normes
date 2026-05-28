<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class FormSpamGuard
{
    private const HONEYPOT_FIELD = '_nr_company';
    private const TIMESTAMP_FIELD = '_nr_ts';
    private const SIGNATURE_FIELD = '_nr_sig';
    private const MIN_FILL_SECONDS = 4;
    private const MAX_FORM_AGE_SECONDS = 86400;
    private const BLOCK_WINDOW_SECONDS = 21600;
    private const MAX_BLOCKED_ATTEMPTS = 8;

    /**
     * @return array{honeypot_field: string, timestamp_field: string, signature_field: string, timestamp: int, signature: string}
     */
    public static function payload(string $form): array
    {
        $timestamp = now()->timestamp;

        return [
            'honeypot_field' => self::HONEYPOT_FIELD,
            'timestamp_field' => self::TIMESTAMP_FIELD,
            'signature_field' => self::SIGNATURE_FIELD,
            'timestamp' => $timestamp,
            'signature' => self::sign($form, $timestamp),
        ];
    }

    /**
     * @param  array<int, string>  $fieldsToInspect
     */
    public function ensureValid(Request $request, string $form, array $fieldsToInspect = []): void
    {
        $ip = (string) $request->ip();
        $blockedKey = $this->blockedKey($form, $ip);

        if (RateLimiter::tooManyAttempts($blockedKey, self::MAX_BLOCKED_ATTEMPTS)) {
            $this->reject($request, $form, 'too_many_blocked_attempts');
        }

        if (trim((string) $request->input(self::HONEYPOT_FIELD, '')) !== '') {
            RateLimiter::hit($blockedKey, self::BLOCK_WINDOW_SECONDS);
            $this->reject($request, $form, 'honeypot_filled');
        }

        $timestamp = (string) $request->input(self::TIMESTAMP_FIELD, '');
        $signature = (string) $request->input(self::SIGNATURE_FIELD, '');

        if (! ctype_digit($timestamp) || ! hash_equals(self::sign($form, (int) $timestamp), $signature)) {
            RateLimiter::hit($blockedKey, self::BLOCK_WINDOW_SECONDS);
            $this->reject($request, $form, 'invalid_signature');
        }

        $age = now()->timestamp - (int) $timestamp;
        if ($age < self::MIN_FILL_SECONDS) {
            RateLimiter::hit($blockedKey, self::BLOCK_WINDOW_SECONDS);
            $this->reject($request, $form, 'submitted_too_fast');
        }

        if ($age > self::MAX_FORM_AGE_SECONDS) {
            $this->reject($request, $form, 'expired_form');
        }

        $combined = collect($fieldsToInspect)
            ->map(fn (string $field) => trim((string) $request->input($field, '')))
            ->filter(fn (string $value) => $value !== '')
            ->implode("\n");

        if ($this->looksSpammy($combined)) {
            RateLimiter::hit($blockedKey, self::BLOCK_WINDOW_SECONDS);
            $this->reject($request, $form, 'suspicious_content');
        }
    }

    private static function sign(string $form, int $timestamp): string
    {
        return hash_hmac('sha256', $form.'|'.$timestamp, (string) config('app.key'));
    }

    private function looksSpammy(string $value): bool
    {
        if ($value === '') {
            return false;
        }

        $normalized = Str::lower($value);

        $denyList = [
            'agrigosip',
            'backlink',
            'backlinks',
            'seo service',
            'buy crypto',
            'online casino',
            'telegram:',
        ];

        foreach ($denyList as $needle) {
            if (str_contains($normalized, $needle)) {
                return true;
            }
        }

        if (preg_match('/https?:\/\/|www\./i', $value) === 1) {
            return true;
        }

        if (preg_match('/<a\s|<script|<\/?[a-z][^>]*>/i', $value) === 1) {
            return true;
        }

        return false;
    }

    private function blockedKey(string $form, string $ip): string
    {
        return 'spam-blocked:'.$form.':'.$ip;
    }

    private function reject(Request $request, string $form, string $reason): never
    {
        Log::warning('Spam blocked on public form', [
            'form' => $form,
            'reason' => $reason,
            'ip' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        throw ValidationException::withMessages([
            'spam' => 'Votre demande n’a pas pu être envoyée. Merci de vérifier les informations saisies puis de réessayer.',
        ]);
    }
}
