@php
    $h = $home ?? [];
    $logo = \App\Support\HomeView::url(data_get($h, 'header.logo', '/logo.png'));
    $logoAlt = data_get($h, 'header.logo_alt', 'Normes & Renovation');
@endphp
@php
    $routeName = request()->route() ? request()->route()->getName() : null;
    $isServicePage = $routeName === 'service.page';
    $homeHref = route('home');
    $servicesHref = $isServicePage ? $homeHref.'#services' : '#services';
    $realisationsHref = $isServicePage ? $homeHref.'#realisations' : '#realisations';
    $conseilsHref = $isServicePage ? $homeHref.'#conseils' : '#conseils';
@endphp
<header class="sticky top-0 z-[1000] border-b-4 border-brand-blue bg-white/95 shadow-[0_1px_0_rgba(15,23,42,0.06)] backdrop-blur-md">
    <div class="mx-auto flex min-h-[84px] w-[95%] items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="#top" class="shrink-0">
            <img src="{{ $logo }}" alt="{{ $logoAlt }}" class="h-12 w-auto sm:h-14">
        </a>

        <nav class="hidden items-center gap-1 lg:flex xl:gap-2" aria-label="Navigation principale">
            <a href="{{ $homeHref }}" class="rounded-lg px-3 py-2 text-[15px] font-semibold text-brand-dark transition hover:bg-slate-50 hover:text-brand-blue xl:text-[16px]">Accueil</a>

            <a href="{{ $servicesHref }}" data-service-filter-group="toiture facade" class="service-submenu-link rounded-lg px-3 py-2 text-[15px] font-semibold text-brand-dark transition hover:bg-slate-50 hover:text-brand-blue xl:text-[16px]">
                Toiture
            </a>
            <a href="{{ $servicesHref }}" data-service-filter-group="toiture facade" class="service-submenu-link rounded-lg px-3 py-2 text-[15px] font-semibold text-brand-dark transition hover:bg-slate-50 hover:text-brand-blue xl:text-[16px]">
                Façade
            </a>
            <a href="{{ $servicesHref }}" data-service-filter-group="isolation" class="service-submenu-link rounded-lg px-3 py-2 text-[15px] font-semibold text-brand-dark transition hover:bg-slate-50 hover:text-brand-blue xl:text-[16px]">
                Isolation
            </a>
            <a href="{{ $servicesHref }}" data-service-filter-group="energie" class="service-submenu-link rounded-lg px-3 py-2 text-[15px] font-semibold text-brand-dark transition hover:bg-slate-50 hover:text-brand-blue xl:text-[16px]">
                Énergie
            </a>

            <div class="nav-dropdown relative">
                <button type="button" class="inline-flex items-center gap-0.5 rounded-lg px-3 py-2 text-[15px] font-semibold text-brand-dark transition hover:bg-slate-50 hover:text-brand-blue xl:text-[16px]" aria-expanded="false" aria-haspopup="true" aria-controls="nav-mega-reseau">
                    Le réseau
                    <svg class="h-4 w-4 opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="nav-mega-reseau" class="nav-dropdown-panel invisible absolute left-0 top-full z-[1100] min-w-[220px] translate-y-1 pt-1 opacity-0 transition-all duration-150 pointer-events-none">
                    <div class="rounded-xl border border-slate-200 bg-white py-2 shadow-lg ring-1 ring-black/5">
                        <a href="{{ $homeHref.'#a-propos' }}" class="block px-4 py-2.5 text-sm font-semibold text-brand-dark hover:bg-slate-50 hover:text-brand-blue">À propos</a>
                        <a href="{{ $homeHref.'#agences' }}" class="block px-4 py-2.5 text-sm font-semibold text-brand-dark hover:bg-slate-50 hover:text-brand-blue">Nos agences</a>
                        <a href="{{ $homeHref.'#franchise' }}" class="block px-4 py-2.5 text-sm font-semibold text-brand-dark hover:bg-slate-50 hover:text-brand-blue">Franchise</a>
                    </div>
                </div>
            </div>

            <a href="{{ $realisationsHref }}" class="rounded-lg px-3 py-2 text-[15px] font-semibold text-brand-dark transition hover:bg-slate-50 hover:text-brand-blue xl:text-[16px]">Réalisations</a>
            <a href="{{ $conseilsHref }}" class="rounded-lg px-3 py-2 text-[15px] font-semibold text-brand-dark transition hover:bg-slate-50 hover:text-brand-blue xl:text-[16px]">Conseils</a>

            <a href="{{ route('contact.page').'#devis' }}" class="nav-cta-contact ml-2 inline-flex items-center rounded-xl bg-brand-blue px-5 py-2.5 text-sm font-extrabold text-white ring-2 ring-white/20 transition hover:-translate-y-0.5 hover:bg-sky-500 hover:ring-brand-yellow/40">Devis</a>

            <ul class="ml-3 flex list-none items-center gap-2 border-l border-slate-200 pl-3 xl:ml-4 xl:gap-3 xl:pl-4" aria-label="Réseaux sociaux">
                @foreach (data_get($h, 'header.social', []) as $item)
                    @if (($item['network'] ?? '') === 'facebook')
                        <li>
                            <a href="{{ $item['url'] ?? '#' }}" aria-label="{{ $item['label'] ?? 'Facebook' }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#1877F2] text-white shadow-soft transition hover:opacity-90 hover:ring-2 hover:ring-[#1877F2]/35 hover:ring-offset-2">
                                <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        </li>
                    @elseif (($item['network'] ?? '') === 'linkedin')
                        <li>
                            <a href="{{ $item['url'] ?? '#' }}" aria-label="{{ $item['label'] ?? 'LinkedIn' }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#0A66C2] text-white shadow-soft transition hover:opacity-90 hover:ring-2 hover:ring-[#0A66C2]/35 hover:ring-offset-2">
                                <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                        </li>
                    @elseif (($item['network'] ?? '') === 'instagram')
                        <li>
                            <a href="{{ $item['url'] ?? '#' }}" aria-label="{{ $item['label'] ?? 'Instagram' }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white shadow-soft ring-2 ring-slate-200 transition hover:opacity-90 hover:ring-brand-blue/40">
                                <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" aria-hidden="true">
                                    <defs>
                                        <linearGradient id="instaGradNav" x1="0%" y1="100%" x2="100%" y2="0%">
                                            <stop offset="0%" stop-color="#FFDC80"/>
                                            <stop offset="25%" stop-color="#F77737"/>
                                            <stop offset="50%" stop-color="#FD1D1D"/>
                                            <stop offset="75%" stop-color="#E1306C"/>
                                            <stop offset="100%" stop-color="#C13584"/>
                                        </linearGradient>
                                    </defs>
                                    <path fill="url(#instaGradNav)" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.27.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.354 2.618 6.78 6.979 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>

            @php
                $avisUrl = data_get($h, 'sidebar_avis.google_url');
            @endphp
            <a
                href="{{ $avisUrl }}"
                target="_blank"
                rel="noopener noreferrer"
                class="ml-3 inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 shadow-soft transition hover:border-brand-blue/40 hover:bg-slate-50 xl:ml-4"
                aria-label="Avis Google"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span class="flex flex-col leading-none">
                    <span class="text-[12px] font-extrabold text-brand-dark">{{ data_get($h, 'sidebar_avis.score', '5.0/5') }}</span>
                    <span class="text-[11px] font-bold text-yellow-500">{{ data_get($h, 'sidebar_avis.stars', '★★★★★') }} <span class="ml-1 text-brand-blue">{{ data_get($h, 'sidebar_avis.text', '+100 avis') }}</span></span>
                </span>
            </a>
        </nav>

        <button id="menuBtn" type="button" class="inline-flex items-center rounded-lg border border-slate-200 p-2 text-brand-dark lg:hidden" aria-label="Ouvrir le menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <div id="mobileMenu" class="hidden border-t border-slate-100 bg-white lg:hidden">
        <div class="mx-auto flex w-[95%] flex-col gap-0.5 px-4 py-3 sm:px-6">
            <a href="{{ $homeHref }}" class="rounded-lg px-3 py-2.5 text-[15px] font-semibold text-brand-dark hover:bg-slate-50">Accueil</a>

            <a href="{{ $servicesHref }}" data-service-filter-group="toiture facade" class="service-submenu-link rounded-lg px-3 py-2.5 text-[15px] font-semibold text-brand-dark hover:bg-slate-50 hover:text-brand-blue">Toiture</a>
            <a href="{{ $servicesHref }}" data-service-filter-group="toiture facade" class="service-submenu-link rounded-lg px-3 py-2.5 text-[15px] font-semibold text-brand-dark hover:bg-slate-50 hover:text-brand-blue">Façade</a>
            <a href="{{ $servicesHref }}" data-service-filter-group="isolation" class="service-submenu-link rounded-lg px-3 py-2.5 text-[15px] font-semibold text-brand-dark hover:bg-slate-50 hover:text-brand-blue">Isolation</a>
            <a href="{{ $servicesHref }}" data-service-filter-group="energie" class="service-submenu-link rounded-lg px-3 py-2.5 text-[15px] font-semibold text-brand-dark hover:bg-slate-50 hover:text-brand-blue">Énergie</a>

            <details class="group rounded-lg">
                <summary class="cursor-pointer list-none px-3 py-2.5 text-[15px] font-semibold text-brand-dark marker:content-none [&::-webkit-details-marker]:hidden hover:bg-slate-50">
                    <span class="inline-flex w-full items-center justify-between">Le réseau <span class="text-slate-400" aria-hidden="true">▼</span></span>
                </summary>
                <div class="border-l-2 border-brand-blue/30 py-1 pl-4">
                    <a href="{{ $homeHref.'#a-propos' }}" class="block rounded-lg py-2 text-sm font-medium text-slate-700 hover:text-brand-blue">À propos</a>
                    <a href="{{ $homeHref.'#agences' }}" class="block rounded-lg py-2 text-sm font-medium text-slate-700 hover:text-brand-blue">Nos agences</a>
                    <a href="{{ $homeHref.'#franchise' }}" class="block rounded-lg py-2 text-sm font-medium text-slate-700 hover:text-brand-blue">Franchise</a>
                </div>
            </details>

            <a href="{{ $realisationsHref }}" class="rounded-lg px-3 py-2.5 text-[15px] font-semibold text-brand-dark hover:bg-slate-50">Réalisations</a>
            <a href="{{ $conseilsHref }}" class="rounded-lg px-3 py-2.5 text-[15px] font-semibold text-brand-dark hover:bg-slate-50">Conseils</a>

            <a href="{{ route('contact.page').'#devis' }}" class="nav-cta-contact mt-2 inline-flex w-full items-center justify-center rounded-xl bg-brand-blue px-4 py-3.5 text-sm font-extrabold text-white ring-2 ring-brand-blue/30 transition hover:bg-sky-500">Devis</a>
            <div class="mt-4 flex flex-col items-center gap-2 border-t border-slate-100 pt-4 sm:items-start">
                <p class="text-center text-xs font-bold uppercase tracking-wide text-slate-500 sm:text-left">Suivez-nous</p>
                <ul class="flex list-none items-center justify-center gap-4 sm:justify-start" aria-label="Réseaux sociaux">
                    @foreach (data_get($h, 'header.social', []) as $item)
                        @if (($item['network'] ?? '') === 'facebook')
                            <li>
                                <a href="{{ $item['url'] ?? '#' }}" aria-label="{{ $item['label'] ?? 'Facebook' }}" class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-[#1877F2] text-white shadow-soft transition hover:opacity-90 active:scale-95">
                                    <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                            </li>
                        @elseif (($item['network'] ?? '') === 'linkedin')
                            <li>
                                <a href="{{ $item['url'] ?? '#' }}" aria-label="{{ $item['label'] ?? 'LinkedIn' }}" class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-[#0A66C2] text-white shadow-soft transition hover:opacity-90 active:scale-95">
                                    <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                </a>
                            </li>
                        @elseif (($item['network'] ?? '') === 'instagram')
                            <li>
                                <a href="{{ $item['url'] ?? '#' }}" aria-label="{{ $item['label'] ?? 'Instagram' }}" class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white shadow-soft ring-2 ring-slate-200 transition hover:opacity-90 active:scale-95">
                                    <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" aria-hidden="true">
                                        <defs>
                                            <linearGradient id="instaGradMobile" x1="0%" y1="100%" x2="100%" y2="0%">
                                                <stop offset="0%" stop-color="#FFDC80"/>
                                                <stop offset="25%" stop-color="#F77737"/>
                                                <stop offset="50%" stop-color="#FD1D1D"/>
                                                <stop offset="75%" stop-color="#E1306C"/>
                                                <stop offset="100%" stop-color="#C13584"/>
                                            </linearGradient>
                                        </defs>
                                        <path fill="url(#instaGradMobile)" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.27.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.354 2.618 6.78 6.979 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</header>
