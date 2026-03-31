@extends('admin.layout')

@section('title', 'Simulator Leads')

@section('content')
    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <h1 class="text-2xl font-extrabold text-slate-900">Simulator leads (latest 100)</h1>
        <p class="mt-1 text-sm text-slate-600">In progress and completed forms with source page, date, and email delivery status.</p>

        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead>
                <tr class="border-b border-slate-200 text-xs uppercase tracking-wide text-slate-500">
                    <th class="px-3 py-2">Date</th>
                    <th class="px-3 py-2">Source page</th>
                    <th class="px-3 py-2">Name</th>
                    <th class="px-3 py-2">Email / Phone</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Mail</th>
                    <th class="px-3 py-2">Resend to admin</th>
                    <th class="px-3 py-2">Error</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @forelse($leads as $lead)
                    <tr class="align-top">
                        <td class="px-3 py-2 text-slate-700">{{ optional($lead->created_at)->format('d/m/Y H:i') }}</td>
                        <td class="px-3 py-2 text-slate-600">{{ $lead->source_page ?: '-' }}</td>
                        <td class="px-3 py-2 font-semibold text-slate-800">{{ $lead->nom_prenom ?: '-' }}</td>
                        <td class="px-3 py-2 text-slate-600">
                            <div>{{ $lead->email ?: '-' }}</div>
                            <div>{{ $lead->telephone ?: '-' }}</div>
                        </td>
                        <td class="px-3 py-2">
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-bold {{ $lead->completed_at ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $lead->completed_at ? 'completed' : 'in_progress' }}
                            </span>
                        </td>
                        <td class="px-3 py-2 text-xs text-slate-600">
                            <div>Admin step1: {{ $lead->admin_notified_started_at ? 'yes' : 'no' }}</div>
                            <div>Admin done: {{ $lead->admin_notified_completed_at ? 'yes' : 'no' }}</div>
                            <div>Client: {{ $lead->client_notified_at ? 'yes' : 'no' }}</div>
                        </td>
                        <td class="px-3 py-2">
                            <form method="post" action="{{ route('admin.simulateur_leads.resend_admin_mail', $lead) }}" class="grid gap-2">
                                @csrf
                                <input
                                    type="email"
                                    name="recipient_email"
                                    required
                                    value="{{ old('recipient_email', $defaultAdminEmail) }}"
                                    class="w-56 rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs"
                                    placeholder="admin@email.com"
                                >
                                <button class="inline-flex w-fit items-center rounded-lg bg-sky-600 px-2.5 py-1.5 text-xs font-extrabold text-white hover:bg-sky-700">
                                    Resend
                                </button>
                            </form>
                        </td>
                        <td class="px-3 py-2 text-xs text-rose-700">{{ $lead->mail_error ?: '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-3 py-6 text-center text-slate-500">No leads yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
