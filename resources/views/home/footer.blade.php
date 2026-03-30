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
                <div class="mt-3">
                    @include('home._social_icons', ['home' => $h, 'socialGradientId' => 'instaGradFooter', 'socialWrapperClass' => 'flex flex-wrap gap-2'])
                </div>
            </div>
        </div>
        <div class="mt-12 flex flex-col gap-3 border-t border-white/15 pt-8 text-xs text-white/90 sm:flex-row sm:flex-wrap sm:items-center sm:justify-between">
            <p>&copy; <span id="footerYear"></span> {{ data_get($f, 'copyright_name') }}. Tous droits réservés.</p>
            <p class="sm:text-right">{{ data_get($f, 'bottom_line') }} <a href="{{ data_get($f, 'bottom_href') }}" class="text-white underline-offset-2 transition hover:text-brand-yellow hover:underline">{{ data_get($f, 'bottom_link') }}</a></p>
            <button
                id="cookieManageBtn"
                type="button"
                class="inline-flex w-fit items-center rounded-md border border-white/25 bg-white/10 px-3 py-1.5 text-xs font-extrabold text-white transition hover:bg-white/20"
            >
                Gerer les cookies
            </button>
        </div>
    </div>
</footer>
