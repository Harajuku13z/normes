@extends('admin.layout')

@section('title', 'Simulator SMTP Settings')

@section('content')
    <div class="space-y-6">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h1 class="text-2xl font-extrabold text-slate-900">Simulator mail settings</h1>
            <p class="mt-1 text-sm text-slate-600">
                Configure SMTP directly from admin (no .env). This config sends HTML emails to admin and clients.
            </p>

            <form method="post" action="{{ route('admin.simulateur_settings.update') }}" class="mt-6 grid gap-4">
                @csrf

                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="grid gap-1 text-sm font-semibold text-slate-700">
                        <span>SMTP Server *</span>
                        <input type="text" name="smtp[host]" value="{{ old('smtp.host', data_get($settings, 'smtp.host', '')) }}" required class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm">
                    </label>
                    <label class="grid gap-1 text-sm font-semibold text-slate-700">
                        <span>SMTP Port *</span>
                        <input type="number" name="smtp[port]" min="1" max="65535" value="{{ old('smtp.port', data_get($settings, 'smtp.port', '587')) }}" required class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm">
                    </label>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="grid gap-1 text-sm font-semibold text-slate-700">
                        <span>Encryption *</span>
                        @php($enc = old('smtp.encryption', data_get($settings, 'smtp.encryption', 'tls')))
                        <select name="smtp[encryption]" required class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm">
                            <option value="none" @selected($enc === 'none')>none</option>
                            <option value="tls" @selected($enc === 'tls')>tls</option>
                            <option value="ssl" @selected($enc === 'ssl')>ssl</option>
                        </select>
                    </label>
                    <label class="grid gap-1 text-sm font-semibold text-slate-700">
                        <span>Username (email) *</span>
                        <input type="email" name="smtp[username]" value="{{ old('smtp.username', data_get($settings, 'smtp.username', '')) }}" required class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm">
                    </label>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="grid gap-1 text-sm font-semibold text-slate-700">
                        <span>SMTP Password *</span>
                        <input type="text" name="smtp[password]" value="{{ old('smtp.password', $smtpPassword) }}" required class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm">
                    </label>
                    <label class="grid gap-1 text-sm font-semibold text-slate-700">
                        <span>Admin notification email *</span>
                        <input type="email" name="notifications[admin_email]" value="{{ old('notifications.admin_email', data_get($settings, 'notifications.admin_email', '')) }}" required class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm">
                        <small class="text-xs font-medium text-slate-500">All admin alerts are sent to this email.</small>
                    </label>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="grid gap-1 text-sm font-semibold text-slate-700">
                        <span>From address *</span>
                        <input type="email" name="smtp[from_address]" value="{{ old('smtp.from_address', data_get($settings, 'smtp.from_address', '')) }}" required class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm">
                    </label>
                    <label class="grid gap-1 text-sm font-semibold text-slate-700">
                        <span>From name</span>
                        <input type="text" name="smtp[from_name]" value="{{ old('smtp.from_name', data_get($settings, 'smtp.from_name', 'Normes & Renovation')) }}" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm">
                    </label>
                </div>

                <div class="grid gap-2 rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                        <input type="hidden" name="notifications[send_to_admin_on_step1]" value="0">
                        <input type="checkbox" name="notifications[send_to_admin_on_step1]" value="1" @checked(old('notifications.send_to_admin_on_step1', data_get($settings, 'notifications.send_to_admin_on_step1', true)))>
                        Notify admin when step 1 is submitted (lead started)
                    </label>
                    <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                        <input type="hidden" name="notifications[send_to_admin_on_completed]" value="0">
                        <input type="checkbox" name="notifications[send_to_admin_on_completed]" value="1" @checked(old('notifications.send_to_admin_on_completed', data_get($settings, 'notifications.send_to_admin_on_completed', true)))>
                        Notify admin when simulator is completed
                    </label>
                    <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                        <input type="hidden" name="notifications[send_to_client]" value="0">
                        <input type="checkbox" name="notifications[send_to_client]" value="1" @checked(old('notifications.send_to_client', data_get($settings, 'notifications.send_to_client', true)))>
                        Send confirmation email to client on completion
                    </label>
                </div>

                <div>
                    <button class="inline-flex items-center rounded-xl bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
                        Save SMTP settings
                    </button>
                </div>
            </form>
        </section>
    </div>
@endsection
