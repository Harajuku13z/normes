@php
    $h = $home ?? [];
    $d = data_get($h, 'devis', []);
    $sim = data_get($d, 'sim_block', []);
@endphp
<section id="devis" class="scroll-mt-24 bg-brand-dark py-16 text-white sm:py-20">
        <div class="mx-auto grid w-[95%] gap-10 px-4 sm:px-6 lg:grid-cols-[1.05fr_1fr] lg:items-stretch lg:gap-12 lg:px-8">
        <div class="flex min-h-0 flex-col gap-8 lg:h-full lg:min-h-0 lg:justify-center">
            <div class="shrink-0">
                <h2 class="mb-4 text-4xl font-extrabold leading-tight sm:text-5xl"><span class="text-sky-400">{{ data_get($d, 'title_line1') }}</span> <span class="text-white">{{ data_get($d, 'title_line2') }}</span></h2>
                <p class="text-xl font-bold text-white sm:text-2xl">{{ data_get($d, 'subtitle') }}</p>
                <p class="mt-3 text-sm leading-relaxed text-slate-200 sm:text-base">{{ data_get($d, 'intro') }}</p>
                <p class="mt-2 text-sm text-slate-300">{{ data_get($d, 'response_note') }}</p>
                <a href="#formulaire-contact" class="mt-5 inline-flex rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-lg transition hover:bg-sky-500 lg:hidden">{{ data_get($d, 'mobile_form_cta') }}</a>
            </div>

            <div class="relative overflow-hidden rounded-2xl">
                <img src="{{ \App\Support\HomeView::url('/nous/equipe.jpeg') }}" alt="L'équipe Normes & Rénovation à votre service" class="w-full object-cover" loading="lazy" decoding="async">
                <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/90 via-brand-dark/40 to-transparent"></div>
                <div class="absolute inset-x-0 bottom-0 p-5 sm:p-6">
                    <p class="text-lg font-extrabold text-white sm:text-xl">Nous sommes là pour vous accompagner</p>
                    <p class="mt-1 text-sm leading-relaxed text-slate-200">Une équipe de professionnels certifiés RGE, à votre écoute pour chaque étape de votre projet de rénovation.</p>
                </div>
            </div>

            <div class="rounded-2xl border border-white/20 bg-white/10 p-5 sm:p-6 lg:shrink-0">
                <p class="text-xs font-bold uppercase tracking-wide text-sky-300">{{ data_get($sim, 'kicker') }}</p>
                <p class="mt-2 text-base font-semibold text-white sm:text-lg">{{ data_get($sim, 'title') }}</p>
                <p class="mt-2 text-sm leading-relaxed text-slate-300">{{ data_get($sim, 'text') }}</p>
                <div class="mt-4 flex flex-col gap-2 sm:flex-row sm:flex-wrap">
                    <a href="{{ data_get($sim, 'primary_href') }}" class="inline-flex items-center justify-center rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-md transition hover:bg-sky-500">{{ data_get($sim, 'primary') }}</a>
                    <a href="{{ data_get($sim, 'secondary_href') }}" class="inline-flex items-center justify-center rounded-xl border-2 border-white/40 bg-transparent px-5 py-3 text-sm font-extrabold text-white transition hover:border-white hover:bg-white/10">{{ data_get($sim, 'secondary') }}</a>
                </div>
            </div>
        </div>

        @include('home._devis_form', [
            'home' => $h,
            'serviceOptionsPreferred' => $serviceOptionsPreferred ?? [],
        ])
    </div>
</section>
