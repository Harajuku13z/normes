<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Normes Rénovation</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    colors: {
                        brand: {
                            50:  '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', system-ui, sans-serif; }
        /* Custom scrollbar for sidebar */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
    </style>

    @stack('styles')
</head>

<body class="h-full bg-slate-100" x-data="{ sidebarOpen: false }">

    {{-- ── MOBILE OVERLAY ──────────────────────────────────────────── --}}
    <div x-cloak x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-slate-900/60 lg:hidden">
    </div>

    {{-- ── SIDEBAR ──────────────────────────────────────────────────── --}}
    <aside x-cloak
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col bg-slate-900 transition-transform duration-200 ease-in-out lg:translate-x-0"
           style="display: flex !important;">

        {{-- Logo --}}
        <div class="flex h-16 shrink-0 items-center gap-3 border-b border-slate-700/60 px-5">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-600 shadow-lg">
                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-white leading-tight">Normes Rénovation</p>
                <p class="text-xs text-slate-400">Administration</p>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="sidebar-scroll flex-1 overflow-y-auto px-3 py-4">

            @php
                $r = request()->route()?->getName() ?? '';
                function nav_active(string $r, array $routes): bool {
                    foreach ($routes as $route) {
                        if (str_starts_with($r, $route)) return true;
                    }
                    return false;
                }
            @endphp

            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}"
               class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold transition-colors
                      {{ nav_active($r, ['admin.dashboard']) ? 'bg-brand-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Tableau de bord
            </a>

            {{-- LEADS (juste après tableau de bord) --}}
            <p class="mt-4 mb-2 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-500">Leads</p>

            <a href="{{ route('admin.contact_inquiries.index') }}"
               class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold transition-colors
                      {{ nav_active($r, ['admin.contact_inquiries']) ? 'bg-brand-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/>
                </svg>
                Demandes contact
                @php
                    try { $contactCount = \App\Models\ContactInquiry::query()->where('admin_mail_sent', false)->count(); } catch (\Throwable) { $contactCount = 0; }
                @endphp
                @if($contactCount > 0)
                    <span class="ml-auto rounded-full bg-red-500 px-2 py-0.5 text-[10px] font-bold text-white">{{ $contactCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.simulateur_leads.index') }}"
               class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold transition-colors
                      {{ nav_active($r, ['admin.simulateur_leads']) ? 'bg-brand-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                </svg>
                Leads simulateur
                @php
                    try { $leadsCount = \App\Models\SimulateurLead::query()->whereNotNull('completed_at')->where('completed_at', '>=', now()->subDays(30))->count(); } catch (\Throwable) { $leadsCount = 0; }
                @endphp
                @if($leadsCount > 0)
                    <span class="ml-auto rounded-full bg-blue-500 px-2 py-0.5 text-[10px] font-bold text-white">{{ $leadsCount }}</span>
                @endif
            </a>

            {{-- CONTENU --}}
            <p class="mt-5 mb-2 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-500">Contenu</p>

            <a href="{{ route('admin.homepage.edit') }}"
               class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold transition-colors
                      {{ nav_active($r, ['admin.homepage']) ? 'bg-brand-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z"/>
                </svg>
                Homepage
            </a>

            <a href="{{ route('admin.services_pages.index') }}"
               class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold transition-colors
                      {{ nav_active($r, ['admin.services_pages']) ? 'bg-brand-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z"/>
                </svg>
                Pages services
            </a>

            <a href="{{ route('admin.realisations.index') }}"
               class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold transition-colors
                      {{ nav_active($r, ['admin.realisations', 'admin.portfolio_projects']) ? 'bg-brand-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                </svg>
                Réalisations
            </a>

            <a href="{{ route('admin.blog_posts.index') }}"
               class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold transition-colors
                      {{ nav_active($r, ['admin.blog_posts']) ? 'bg-brand-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z"/>
                </svg>
                Blog
            </a>

            {{-- PAGES --}}
            <p class="mt-5 mb-2 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-500">Pages</p>

            <a href="{{ route('admin.contact_settings.edit') }}"
               class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold transition-colors
                      {{ nav_active($r, ['admin.contact_settings']) ? 'bg-brand-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
                </svg>
                Contact
            </a>

            <a href="{{ route('admin.about_settings.edit') }}"
               class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold transition-colors
                      {{ nav_active($r, ['admin.about_settings']) ? 'bg-brand-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>
                </svg>
                À propos
            </a>

            <a href="{{ route('admin.franchise_settings.edit') }}"
               class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold transition-colors
                      {{ nav_active($r, ['admin.franchise_settings']) ? 'bg-brand-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016 2.993 2.993 0 0 0 2.25-1.016 3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z"/>
                </svg>
                Franchise
            </a>

            <a href="{{ route('admin.legacy_pages.index') }}"
               class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold transition-colors
                      {{ nav_active($r, ['admin.legacy_pages']) ? 'bg-brand-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244"/>
                </svg>
                Legacy URLs SEO
            </a>

            {{-- PARAMÈTRES --}}
            <p class="mt-5 mb-2 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-500">Paramètres</p>

            <a href="{{ route('admin.layout_settings.edit') }}"
               class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold transition-colors
                      {{ nav_active($r, ['admin.layout_settings']) ? 'bg-brand-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5"/>
                </svg>
                Header & Footer
            </a>

            <a href="{{ route('admin.header_settings.edit') }}"
               class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold transition-colors
                      {{ nav_active($r, ['admin.header_settings']) ? 'bg-brand-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"/>
                </svg>
                Menu navigation
            </a>

            <a href="{{ route('admin.avis_settings.edit') }}"
               class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold transition-colors
                      {{ nav_active($r, ['admin.avis_settings']) ? 'bg-brand-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/>
                </svg>
                Avis clients
            </a>

            <a href="{{ route('admin.ai_service_settings.edit') }}"
               class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold transition-colors
                      {{ nav_active($r, ['admin.ai_service_settings']) ? 'bg-brand-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456Z"/>
                </svg>
                IA Services
            </a>

            {{-- SIMULATEUR --}}
            <p class="mt-5 mb-2 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-500">Simulateur</p>

            <a href="{{ route('admin.simulateur_settings.edit') }}"
               class="group mb-1 flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold transition-colors
                      {{ nav_active($r, ['admin.simulateur_settings']) ? 'bg-brand-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
                Config SMTP
            </a>


        </nav>

        {{-- Voir le site + Déconnexion --}}
        <div class="border-t border-slate-700/60 p-3 space-y-1">
            <a href="{{ route('home') }}" target="_blank" rel="noopener"
               class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold text-slate-400 transition-colors hover:bg-slate-800 hover:text-white">
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                </svg>
                Voir le site
            </a>
            <form method="post" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold text-slate-400 transition-colors hover:bg-red-500/20 hover:text-red-400">
                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25"/>
                    </svg>
                    Déconnexion
                </button>
            </form>
        </div>
    </aside>

    {{-- ── MAIN CONTENT ─────────────────────────────────────────────── --}}
    <div class="lg:pl-64">

        {{-- Topbar --}}
        <header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b border-slate-200 bg-white px-4 shadow-sm sm:px-6">

            {{-- Mobile burger --}}
            <button @click="sidebarOpen = true"
                    class="rounded-lg p-1.5 text-slate-500 hover:bg-slate-100 lg:hidden">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>

            {{-- Page title --}}
            <div class="min-w-0 flex-1">
                <h1 class="truncate text-base font-bold text-slate-900">@yield('title', 'Tableau de bord')</h1>
            </div>

            {{-- Right actions --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" rel="noopener"
                   class="hidden items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 sm:flex">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                    </svg>
                    Voir le site
                </a>

                {{-- User badge --}}
                <div class="flex items-center gap-2 rounded-lg bg-slate-100 px-3 py-1.5">
                    <div class="flex h-7 w-7 items-center justify-center rounded-full bg-brand-600 text-xs font-bold text-white">
                        {{ strtoupper(substr(auth()->user()?->name ?? 'A', 0, 1)) }}
                    </div>
                    <span class="hidden text-xs font-semibold text-slate-700 sm:block">
                        {{ auth()->user()?->name ?? 'Admin' }}
                    </span>
                </div>
            </div>
        </header>

        {{-- Page content --}}
        <main class="p-4 sm:p-6">

            {{-- Flash messages --}}
            @if (session('status'))
                <div class="mb-5 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3">
                    <svg class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-medium text-emerald-800">{{ session('status') }}</p>
                </div>
            @endif
            @if (session('import_status'))
                <div class="mb-5 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3">
                    <svg class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-medium text-emerald-800">{{ session('import_status') }}</p>
                </div>
            @endif
            @if (session('import_error') || session('error'))
                <div class="mb-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                    <svg class="mt-0.5 h-4 w-4 shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-medium text-red-700">{{ session('import_error') ?? session('error') }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                    <svg class="mt-0.5 h-4 w-4 shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/>
                    </svg>
                    <ul class="text-sm font-medium text-red-700 list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="border-t border-slate-200 px-6 py-4">
            <p class="text-xs text-slate-400">© {{ date('Y') }} Normes &amp; Rénovation — Administration</p>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
