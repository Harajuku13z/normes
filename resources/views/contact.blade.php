@php
    use App\Support\HomeView;

    $h = $home ?? [];
    $f = data_get($h, 'footer', []);
    $d = data_get($h, 'devis', []);
    $siteName = (string) data_get($h, 'meta.site_name', 'Normes & Rénovation');
    $metaTitle = 'Contact | '.$siteName;
    $metaDescription = trim((string) data_get($h, 'meta.description', ''));
    if ($metaDescription === '') {
        $metaDescription = 'Contactez-nous pour un devis gratuit, une question sur votre chantier ou nos agences. Réponse sous 48 h en général.';
    }
    $heroBg = HomeView::url((string) data_get($h, 'hero.background_image', 'slide/toiture.png'));
    $heroKicker = (string) data_get($d, 'contact_heading', 'Contact');
    $heroTitleLine1 = (string) data_get($d, 'title_line1', 'Vous avez');
    $heroTitleLine2 = (string) data_get($d, 'title_line2', 'un projet de rénovation ?');
    $heroIntro = trim((string) data_get($d, 'intro', ''));
    $heroSubtitle = trim((string) data_get($d, 'subtitle', ''));
    $agenciesContact = data_get($d, 'agencies_contact', []);
    if (! is_array($agenciesContact)) {
        $agenciesContact = [];
    }
    $hqLines = data_get($f, 'address_lines', []);
    if (! is_array($hqLines)) {
        $hqLines = [];
    }
    $googleMapQuery = trim((string) data_get($f, 'company', 'Normes et Rénovation'));
    if ($hqLines !== []) {
        $googleMapQuery .= ', '.implode(', ', array_filter(array_map('strval', $hqLines)));
    }
    $googleMapEmbedUrl = 'https://www.google.com/maps?q='.rawurlencode($googleMapQuery).'&output=embed';
    $socialBg = HomeView::url((string) data_get($h, 'hero.background_image', 'slide/toiture.png'));
@endphp
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
@include('home.head', [
    'home' => $h,
    'title' => $metaTitle,
    'description' => $metaDescription,
    'keywords' => '',
    'canonicalUrl' => route('contact.page'),
    'ogImage' => trim((string) data_get($h, 'meta.og_image', 'logo.png')),
])
<body class="overflow-x-hidden bg-white font-sans text-brand-dark antialiased">
@include('home.header', ['home' => $h])

<section id="top" class="relative min-h-[520px] overflow-hidden sm:min-h-[620px]">
    <div
        class="absolute inset-0 bg-cover bg-center"
        style="background-image: url('{{ $heroBg }}');"
        aria-hidden="true"
    ></div>
    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/90 via-brand-dark/55 to-transparent" aria-hidden="true"></div>
    <div class="relative z-10 mx-auto flex min-h-[520px] w-[95%] flex-col justify-end gap-6 px-4 py-10 sm:min-h-[620px] sm:px-6 lg:px-8">
        <div class="max-w-3xl text-white">
            <div class="rounded-3xl border border-white/15 bg-brand-dark/35 p-6 shadow-soft backdrop-blur-md sm:p-8">
                <p class="mb-3 text-xs font-extrabold uppercase tracking-[0.22em] text-brand-yellow">
                    {{ $heroKicker }}
                </p>
                <h1 class="mb-4 text-4xl font-black leading-[1.02] tracking-tight drop-shadow sm:text-5xl">
                    <span>{{ $heroTitleLine1 }}</span>
                    <span class="text-brand-blue">{{ ' '.$heroTitleLine2 }}</span>
                </h1>
                @if ($heroSubtitle !== '' || $heroIntro !== '')
                    <p class="max-w-2xl text-base leading-relaxed text-white/90 sm:text-lg">
                        {{ $heroSubtitle }}@if ($heroSubtitle !== '' && $heroIntro !== '') — @endif{{ $heroIntro }}
                    </p>
                @endif
                <div class="mt-6 flex flex-wrap gap-3">
                    <a
                        href="#formulaire-contact"
                        class="rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500"
                    >
                        Formulaire de contact
                    </a>
                    <a
                        href="tel:{{ data_get($f, 'phone_href') }}"
                        class="rounded-xl bg-brand-yellow px-5 py-3 text-sm font-extrabold text-brand-dark shadow-soft transition hover:bg-yellow-300"
                    >
                        {{ data_get($f, 'phone') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="devis" class="scroll-mt-24 bg-slate-50/80 py-12 sm:py-16">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[1fr_1.1fr] lg:items-start lg:gap-10">
            <div class="order-2 min-w-0 space-y-6 lg:order-1">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-soft sm:p-8">
                    <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">{{ data_get($f, 'siege_title') }}</p>
                    <h2 class="mt-2 text-xl font-extrabold text-brand-dark">{{ data_get($f, 'company') }}</h2>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">
                        @foreach (data_get($f, 'address_lines', []) as $line)
                            {{ $line }}@if (! $loop->last)<br>@endif
                        @endforeach
                    </p>
                    <div class="mt-5 space-y-3 border-t border-slate-100 pt-5">
                        <p class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Téléphone</p>
                        <a href="tel:{{ data_get($f, 'phone_href') }}" class="text-lg font-extrabold text-brand-blue transition hover:text-brand-dark">
                            {{ data_get($f, 'phone') }}
                        </a>
                        <p class="text-xs font-extrabold uppercase tracking-wider text-slate-500">E-mail</p>
                        <a href="mailto:{{ data_get($f, 'email') }}" class="break-all text-sm font-semibold text-brand-dark underline-offset-2 hover:text-brand-blue hover:underline">
                            {{ data_get($f, 'email') }}
                        </a>
                    </div>
                    @if ($agenciesContact !== [])
                        <div class="mt-6 border-t border-slate-100 pt-6">
                            <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">{{ data_get($d, 'contact_heading', 'Nos agences') }}</p>
                            <ul class="mt-4 space-y-4">
                                @foreach ($agenciesContact as $ag)
                                    <li class="rounded-xl border border-slate-100 bg-slate-50/80 p-4">
                                        <p class="font-extrabold text-brand-dark">{{ data_get($ag, 'name') }}</p>
                                        @if (is_array(data_get($ag, 'lines')))
                                            <p class="mt-1 text-sm text-slate-600">
                                                @foreach (data_get($ag, 'lines', []) as $ln)
                                                    {{ $ln }}@if (! $loop->last)<br>@endif
                                                @endforeach
                                            </p>
                                        @endif
                                        <a href="tel:{{ data_get($ag, 'phone_href', '') }}" class="mt-2 inline-block text-sm font-bold text-brand-blue hover:underline">
                                            {{ data_get($ag, 'phone') }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-soft sm:p-8">
                    <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">Horaires</p>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ data_get($f, 'networks_note') }}</p>
                </div>
            </div>

            <div class="order-1 min-w-0 lg:order-2 lg:sticky lg:top-28">
                @include('home._devis_form', ['home' => $h])
            </div>
        </div>
    </div>
</section>

@if (is_array(data_get($f, 'social')) && data_get($f, 'social') !== [])
    <section id="reseaux" class="relative scroll-mt-24 overflow-hidden border-t border-slate-200 bg-slate-50/70 py-12 sm:py-16">
        <div class="absolute inset-0 bg-cover bg-center opacity-25" style="background-image: url('{{ $socialBg }}');" aria-hidden="true"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-brand-dark/20 via-transparent to-brand-blue/20" aria-hidden="true"></div>
        <div class="relative z-10 mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-soft sm:p-8">
                <div class="pointer-events-none absolute -right-14 -top-16 h-40 w-40 rounded-full bg-brand-blue/10 blur-2xl" aria-hidden="true"></div>
                <div class="pointer-events-none absolute -bottom-14 -left-10 h-36 w-36 rounded-full bg-brand-yellow/20 blur-2xl" aria-hidden="true"></div>
                <div class="relative z-10 flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                <div class="min-w-0">
                    <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">Réseaux sociaux</p>
                    <h2 class="mt-2 text-2xl font-extrabold text-brand-dark sm:text-3xl">Suivez nos actualités</h2>
                    <p class="mt-2 max-w-xl text-sm text-slate-600 sm:text-base">Retrouvez-nous sur les réseaux pour nos chantiers, conseils et nouveautés.</p>
                </div>
                @include('home._social_icons', [
                    'home' => $h,
                    'socialGradientId' => 'instaGradContactPage',
                    'socialVariant' => 'card',
                    'socialWrapperClass' => 'flex flex-wrap gap-3 sm:justify-end'
                ])
                </div>
            </div>
        </div>
    </section>
@endif

<section id="carte-agences" class="scroll-mt-24 border-t border-slate-200 bg-white py-12 sm:py-16">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        <div class="mb-6 max-w-2xl">
            <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">Carte</p>
            <h2 class="mt-2 text-3xl font-extrabold text-brand-dark sm:text-4xl">Nos implantations</h2>
            <p class="mt-2 text-sm text-slate-600 sm:text-base">Repérez nos agences en un coup d’œil (Bretagne et Bourgogne).</p>
        </div>
        <div class="overflow-hidden rounded-2xl border border-slate-200 shadow-soft">
            <iframe
                src="{{ $googleMapEmbedUrl }}"
                class="h-[min(22rem,55vh)] min-h-[16rem] w-full sm:h-[28rem]"
                style="border:0;"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                allowfullscreen
                title="Google Maps - Siège social"
            ></iframe>
        </div>
    </div>
</section>

<section id="avis" class="scroll-mt-24 bg-slate-50/70 py-16 sm:py-20">
    <div class="mx-auto w-[95%] scroll-mt-32 px-4 sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-2 lg:items-stretch">
            <div class="min-w-0">
                @include('services.avis_only', ['home' => $h])
            </div>

            <div class="min-w-0">
                @php
                    $ctaCardBg = HomeView::url((string) data_get($h, 'hero.background_image', 'slide/toiture.png'));
                @endphp
                <div class="relative overflow-hidden rounded-2xl border border-white/20 shadow-soft ring-1 ring-black/5 lg:flex lg:h-full lg:min-h-[20rem] lg:flex-col">
                    <div
                        class="absolute inset-0 bg-cover bg-center"
                        style="background-image: url('{{ $ctaCardBg }}');"
                        aria-hidden="true"
                    ></div>
                    <div class="absolute inset-0 bg-gradient-to-br from-brand-dark/90 via-brand-dark/75 to-brand-dark/60" aria-hidden="true"></div>

                    <div class="relative z-10 flex w-full flex-col items-center justify-center px-4 py-8 text-center sm:px-6 sm:py-10 lg:flex-1 lg:px-8 lg:py-10">
                        <div class="w-full max-w-md">
                            <p class="text-[0.7rem] font-extrabold uppercase leading-snug tracking-[0.12em] text-brand-yellow sm:text-xs sm:tracking-[0.2em]">
                                Un projet de rénovation ?
                            </p>
                            <h2 class="mt-2 break-words text-2xl font-extrabold leading-snug text-white sm:text-3xl sm:leading-tight lg:text-4xl">
                                Démarrez dès maintenant
                            </h2>
                            <p class="mt-3 text-sm leading-relaxed text-slate-100/95 sm:text-base">
                                Lancez le simulateur pour une première estimation, ou envoyez votre demande pour être contacté rapidement.
                            </p>
                            <div class="mt-6 grid w-full gap-3">
                                <a
                                    href="{{ route('home').'#simulateur-devis' }}"
                                    class="inline-flex w-full min-w-0 items-center justify-center rounded-xl bg-brand-blue px-4 py-3 text-center text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500 sm:px-5"
                                >
                                    Ouvrir le simulateur de devis
                                </a>
                                <a
                                    href="#formulaire-contact"
                                    class="inline-flex w-full min-w-0 items-center justify-center rounded-xl border-2 border-white/45 bg-white/10 px-4 py-3 text-center text-sm font-extrabold text-white shadow-sm backdrop-blur-sm transition hover:bg-white/20 sm:px-5"
                                >
                                    Accéder au formulaire de contact
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('home.footer', ['home' => $h])

@include('home.cookie_consent', ['home' => $h])
@include('home.scripts', ['home' => $h])
</body>
</html>
