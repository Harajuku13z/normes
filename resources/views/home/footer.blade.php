@php
    $h = $home ?? [];
    $f = data_get($h, 'footer', []);
    $logo = \App\Support\HomeView::url(data_get($f, 'logo'));
@endphp
<footer
    class="footer-hero-bg relative border-t-4 border-brand-blue text-white"
    style="--footer-hero-bg: url('{{ \App\Support\HomeView::url('/slide/toiture.png') }}');"
>
    <div class="relative z-10 mx-auto w-[95%] px-4 py-12 sm:px-6 lg:px-8 lg:py-14">
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-12 lg:gap-x-10 lg:gap-y-8">
            <div class="lg:col-span-4">
                <a href="#top" class="inline-block">
                    <img src="{{ $logo }}" alt="{{ data_get($f, 'logo_alt') }}" class="h-11 w-auto sm:h-12">
                </a>
                <h3 class="mt-8 text-xs font-bold uppercase tracking-wider text-brand-yellow">{{ data_get($f, 'siege_title') }}</h3>
                <p class="mt-2 text-sm font-semibold">{{ data_get($f, 'company') }}</p>
                <p class="mt-1 text-sm leading-relaxed text-white">
                    @foreach (data_get($f, 'address_lines', []) as $line)
                        {{ $line }}@if (! $loop->last)<br>@endif
                    @endforeach
                </p>
                <p class="mt-5 border-t border-white/15 pt-5 text-xs leading-relaxed text-white/90">
                    {{ data_get($f, 'legal') }}
                </p>
            </div>
            <div class="lg:col-span-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-brand-yellow">Contact</h3>
                <p class="mt-4 text-sm text-white">Téléphone</p>
                <a href="tel:{{ data_get($f, 'phone_href') }}" class="text-base font-bold text-brand-blue transition hover:text-white">{{ data_get($f, 'phone') }}</a>
                <p class="mt-4 text-sm text-white">E-mail</p>
                <a href="mailto:{{ data_get($f, 'email') }}" class="break-all text-sm text-white underline-offset-2 transition hover:text-brand-yellow hover:underline">{{ data_get($f, 'email') }}</a>
            </div>
            <div class="lg:col-span-2">
                <h3 class="text-xs font-bold uppercase tracking-wider text-brand-yellow">Liens rapides</h3>
                <ul class="mt-4 space-y-2 text-sm text-white">
                    <li><a href="#services" class="transition hover:text-white">Nos services</a></li>
                    <li><a href="#realisations" class="transition hover:text-white">Réalisations</a></li>
                    <li><a href="#agences" class="transition hover:text-white">Agences &amp; carte</a></li>
                    <li><a href="#conseils" class="transition hover:text-white">Conseils</a></li>
                    <li><a href="#devis" class="font-semibold text-brand-blue transition hover:text-white">Contact / devis</a></li>
                </ul>
            </div>
            <div class="lg:col-span-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-brand-yellow">Horaires d'ouverture</h3>
                <p class="mt-4 text-sm leading-relaxed text-white">{{ data_get($f, 'networks_note') }}</p>
                <p class="mt-5 text-xs font-bold uppercase tracking-wider text-brand-yellow">Réseaux sociaux</p>
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach (data_get($f, 'social', []) as $item)
                        @if (($item['network'] ?? '') === 'facebook')
                            <a href="{{ $item['url'] ?? '#' }}" aria-label="{{ $item['label'] ?? 'Facebook' }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#1877F2] text-white transition hover:opacity-90">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        @elseif (($item['network'] ?? '') === 'linkedin')
                            <a href="{{ $item['url'] ?? '#' }}" aria-label="{{ $item['label'] ?? 'LinkedIn' }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#0A66C2] text-white transition hover:opacity-90">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                        @elseif (($item['network'] ?? '') === 'instagram')
                            <a href="{{ $item['url'] ?? '#' }}" aria-label="{{ $item['label'] ?? 'Instagram' }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white transition hover:opacity-90">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
                                    <defs>
                                        <linearGradient id="instaGradFooter" x1="0%" y1="100%" x2="100%" y2="0%">
                                            <stop offset="0%" stop-color="#FFDC80"/>
                                            <stop offset="25%" stop-color="#F77737"/>
                                            <stop offset="50%" stop-color="#FD1D1D"/>
                                            <stop offset="75%" stop-color="#E1306C"/>
                                            <stop offset="100%" stop-color="#C13584"/>
                                        </linearGradient>
                                    </defs>
                                    <path fill="url(#instaGradFooter)" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.27.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.354 2.618 6.78 6.979 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="mt-12 flex flex-col gap-3 border-t border-white/15 pt-8 text-xs text-white/90 sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; <span id="footerYear"></span> {{ data_get($f, 'copyright_name') }}. Tous droits réservés.</p>
            <p class="sm:text-right">{{ data_get($f, 'bottom_line') }} <a href="{{ data_get($f, 'bottom_href') }}" class="text-white underline-offset-2 transition hover:text-brand-yellow hover:underline">{{ data_get($f, 'bottom_link') }}</a></p>
        </div>
    </div>
</footer>
