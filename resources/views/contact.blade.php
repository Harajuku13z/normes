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
    $heroBg = HomeView::url('slide/toiture.png');
    $agenciesContact = data_get($d, 'agencies_contact', []);
    if (! is_array($agenciesContact)) {
        $agenciesContact = [];
    }
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

<section id="top" class="relative min-h-[280px] overflow-hidden sm:min-h-[340px]">
    <div
        class="absolute inset-0 bg-cover bg-center"
        style="background-image: url('{{ $heroBg }}');"
        aria-hidden="true"
    ></div>
    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/92 via-brand-dark/65 to-brand-dark/35" aria-hidden="true"></div>
    <div class="relative z-10 mx-auto flex min-h-[280px] w-[95%] max-w-3xl flex-col justify-end px-4 py-10 sm:min-h-[340px] sm:px-6 lg:px-8">
        <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-brand-yellow">Contact</p>
        <h1 class="mt-3 text-4xl font-black leading-tight tracking-tight text-white sm:text-5xl">
            Parlons de votre <span class="text-brand-blue">projet</span>
        </h1>
        <p class="mt-4 max-w-2xl text-base leading-relaxed text-white/90 sm:text-lg">
            {{ data_get($d, 'subtitle', 'Estimation personnalisée & rappel d’un conseiller') }} — {{ data_get($d, 'intro', '') }}
        </p>
        <div class="mt-6 flex flex-wrap gap-3">
            <a
                href="#formulaire-contact"
                class="inline-flex items-center justify-center rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500"
            >
                Formulaire de contact
            </a>
            <a
                href="tel:{{ data_get($f, 'phone_href') }}"
                class="inline-flex items-center justify-center rounded-xl border-2 border-white/40 bg-white/10 px-5 py-3 text-sm font-extrabold text-white backdrop-blur-sm transition hover:bg-white/20"
            >
                {{ data_get($f, 'phone') }}
            </a>
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
    <section id="reseaux" class="scroll-mt-24 border-t border-slate-200 bg-slate-50/70 py-12 sm:py-16">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-soft sm:flex-row sm:items-center sm:justify-between sm:p-8">
                <div class="min-w-0">
                    <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-blue">Réseaux sociaux</p>
                    <h2 class="mt-2 text-2xl font-extrabold text-brand-dark sm:text-3xl">Suivez nos actualités</h2>
                    <p class="mt-2 max-w-xl text-sm text-slate-600 sm:text-base">Retrouvez-nous sur les réseaux pour nos chantiers, conseils et nouveautés.</p>
                </div>
                @include('home._social_icons', ['home' => $h, 'socialGradientId' => 'instaGradContactPage', 'socialWrapperClass' => 'flex flex-shrink-0 flex-wrap justify-start gap-3 sm:justify-end'])
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
        <div
            id="agencyMap"
            class="relative z-[1] h-[min(22rem,55vh)] min-h-[16rem] overflow-hidden rounded-2xl border border-slate-200 shadow-soft sm:h-[28rem]"
            role="region"
            aria-label="Carte des agences"
        ></div>
    </div>
</section>

@include('home.footer', ['home' => $h])

@include('home.cookie_consent', ['home' => $h])
@include('home.scripts', ['home' => $h])
</body>
</html>
