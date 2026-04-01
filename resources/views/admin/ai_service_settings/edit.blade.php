@extends('admin.layout')

@section('title', 'IA Services')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-slate-900">Configuration IA — Génération des services</h1>
        <p class="mt-1 text-sm text-slate-600">Configure la clé API OpenAI et le prompt utilisé pour générer automatiquement les pages service.</p>
    </div>

    <form method="post" action="{{ route('admin.ai_service_settings.update') }}" class="space-y-5">
        @csrf

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <h2 class="text-sm font-extrabold text-slate-900">OpenAI</h2>
            <div class="mt-3 grid gap-4 lg:grid-cols-3">
                <div>
                    <label class="text-sm font-semibold text-slate-800">Model</label>
                    <input
                        name="openai[model]"
                        value="{{ old('openai.model', data_get($settings, 'openai.model', 'gpt-4o-mini')) }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                    />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">Temperature (0 à 2)</label>
                    <input
                        name="openai[temperature]"
                        value="{{ old('openai.temperature', data_get($settings, 'openai.temperature', '0.4')) }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                    />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-800">API Key *</label>
                    <input
                        name="openai[api_key]"
                        value="{{ old('openai.api_key', data_get($settings, 'openai.api_key', '')) }}"
                        class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                    />
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <h2 class="text-sm font-extrabold text-slate-900">Prompt template</h2>
            <p class="mt-1 text-xs text-slate-500">Utilise les placeholders <code>[TITRE]</code> et <code>[DESCRIPTION]</code>.</p>
            <textarea
                name="prompt_template"
                rows="24"
                class="mt-3 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm leading-relaxed focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
            >{{ old('prompt_template', data_get($settings, 'prompt_template', '')) }}</textarea>
        </div>

        <div class="pt-2">
            <button class="rounded-xl bg-sky-600 px-6 py-2.5 text-sm font-extrabold text-white hover:bg-sky-700" type="submit">
                Enregistrer la configuration IA
            </button>
        </div>
    </form>
@endsection

