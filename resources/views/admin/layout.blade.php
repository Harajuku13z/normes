<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin — Normes')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">
    <header class="border-b border-slate-200 bg-white">
        @php
            $currentRoute = request()->route() ? request()->route()->getName() : null;
            $isHomepage = $currentRoute === 'admin.homepage.edit' || $currentRoute === 'admin.homepage.update';
            $isServicesPages = str_starts_with((string) $currentRoute, 'admin.services_pages.');
            $isContactSettings = $currentRoute === 'admin.contact_settings.edit' || $currentRoute === 'admin.contact_settings.update';
            $isAboutSettings = $currentRoute === 'admin.about_settings.edit' || $currentRoute === 'admin.about_settings.update';
            $isLayoutSettings = $currentRoute === 'admin.layout_settings.edit' || $currentRoute === 'admin.layout_settings.update';
            $isHeaderSettings = $currentRoute === 'admin.header_settings.edit' || $currentRoute === 'admin.header_settings.update';
            $isAvisSettings = $currentRoute === 'admin.avis_settings.edit' || $currentRoute === 'admin.avis_settings.update' || $currentRoute === 'admin.avis_settings.fetch_google';
            $isAiServiceSettings = $currentRoute === 'admin.ai_service_settings.edit' || $currentRoute === 'admin.ai_service_settings.update';
            $isSimulateurSettings = $currentRoute === 'admin.simulateur_settings.edit' || $currentRoute === 'admin.simulateur_settings.update';
            $isSimulateurLeads = $currentRoute === 'admin.simulateur_leads.index';
            $isRealisationsAdmin = str_starts_with((string) $currentRoute, 'admin.realisations.')
                || str_starts_with((string) $currentRoute, 'admin.portfolio_projects.');
            $isBlogAdmin = str_starts_with((string) $currentRoute, 'admin.blog_posts.');
            $isLegacyPagesAdmin = str_starts_with((string) $currentRoute, 'admin.legacy_pages.');
        @endphp
        <div class="w-full flex flex-wrap items-center justify-between gap-3 px-4 py-4 sm:px-6 relative z-20">
            <a href="{{ route('admin.dashboard') }}" class="text-lg font-extrabold text-slate-800">Admin — Page d'accueil</a>
            <div class="flex items-center gap-3 text-sm">
                <a href="{{ route('home') }}" class="font-semibold text-sky-700 hover:underline" target="_blank" rel="noopener">Voir le site</a>
                <form action="{{ route('admin.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 font-semibold text-slate-700 hover:bg-slate-50">Déconnexion</button>
                </form>
            </div>
        </div>
    </header>
    @php
        $isDashboard = $currentRoute === 'admin.dashboard';
    @endphp
    <div class="w-full px-4 py-8 sm:px-6">
        <div class="flex gap-6">
            <aside class="hidden w-64 shrink-0 lg:block">
                <nav class="rounded-2xl border border-slate-200 bg-white p-3">
                    <p class="px-2 text-xs font-extrabold uppercase tracking-wide text-slate-500">Menu admin</p>
                    <div class="mt-3 space-y-2">
                        <a href="{{ route('admin.dashboard') }}"
                           class="block rounded-xl px-3 py-2 text-sm font-extrabold {{ $isDashboard ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-slate-50' }}">
                            Accueil
                        </a>
                        <a href="{{ route('admin.homepage.edit') }}"
                           class="block rounded-xl px-3 py-2 text-sm font-extrabold {{ $isHomepage ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-slate-50' }}">
                            Homepage
                        </a>
                        <a href="{{ route('admin.contact_settings.edit') }}"
                           class="block rounded-xl px-3 py-2 text-sm font-extrabold {{ $isContactSettings ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-slate-50' }}">
                            Page contact
                        </a>
                        <a href="{{ route('admin.about_settings.edit') }}"
                           class="block rounded-xl px-3 py-2 text-sm font-extrabold {{ $isAboutSettings ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-slate-50' }}">
                            Page À propos
                        </a>
                        <a href="{{ route('admin.layout_settings.edit') }}"
                           class="block rounded-xl px-3 py-2 text-sm font-extrabold {{ $isLayoutSettings ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-slate-50' }}">
                            Header & Footer
                        </a>
                        <a href="{{ route('admin.header_settings.edit') }}"
                           class="block rounded-xl px-3 py-2 text-sm font-extrabold {{ $isHeaderSettings ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-slate-50' }}">
                            Header (menu)
                        </a>
                        <a href="{{ route('admin.avis_settings.edit') }}"
                           class="block rounded-xl px-3 py-2 text-sm font-extrabold {{ $isAvisSettings ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-slate-50' }}">
                            Avis
                        </a>
                        <a href="{{ route('admin.ai_service_settings.edit') }}"
                           class="block rounded-xl px-3 py-2 text-sm font-extrabold {{ $isAiServiceSettings ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-slate-50' }}">
                            IA Services
                        </a>
                        <a href="{{ route('admin.simulateur_settings.edit') }}"
                           class="block rounded-xl px-3 py-2 text-sm font-extrabold {{ $isSimulateurSettings ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-slate-50' }}">
                            Simulator SMTP
                        </a>
                        <a href="{{ route('admin.simulateur_leads.index') }}"
                           class="block rounded-xl px-3 py-2 text-sm font-extrabold {{ $isSimulateurLeads ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-slate-50' }}">
                            Simulator Leads
                        </a>
                        <a href="{{ route('admin.services_pages.index') }}"
                           class="block rounded-xl px-3 py-2 text-sm font-extrabold {{ $isServicesPages ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-slate-50' }}">
                            Services pages
                        </a>
                        <a href="{{ route('admin.realisations.index') }}"
                           class="block rounded-xl px-3 py-2 text-sm font-extrabold {{ $isRealisationsAdmin ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-slate-50' }}">
                            Réalisations
                        </a>
                        <a href="{{ route('admin.blog_posts.index') }}"
                           class="block rounded-xl px-3 py-2 text-sm font-extrabold {{ $isBlogAdmin ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-slate-50' }}">
                            Blog
                        </a>
                        <a href="{{ route('admin.legacy_pages.index') }}"
                           class="block rounded-xl px-3 py-2 text-sm font-extrabold {{ $isLegacyPagesAdmin ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-slate-50' }}">
                            Legacy URLs SEO
                        </a>
                    </div>
                </nav>
            </aside>

            <main class="min-w-0 flex-1">
                @if (session('status'))
                    <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-900">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900">
                        <ul class="list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <footer class="border-t border-slate-200 bg-white/70">
        <div class="w-full px-4 py-8 sm:px-6">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm font-semibold text-slate-700">
                    Admin Normes &amp; Rénovation
                </p>
                <p class="text-xs text-slate-500">
                    © <span id="adminFooterYear"></span> — Tous droits réservés.
                </p>
            </div>
        </div>
    </footer>

    @stack('scripts')

    <script>
        (function () {
            const y = document.getElementById('adminFooterYear');
            if (y) y.textContent = String(new Date().getFullYear());
        })();
    </script>
</body>
</html>
