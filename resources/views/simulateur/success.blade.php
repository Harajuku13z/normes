@php
    use App\Support\HomeView;

    $h = $home ?? [];
    $sum = is_array($summary ?? null) ? $summary : [];
    $logo = HomeView::url((string) data_get($h, 'header.logo', '/logo.png'));
    $siteName = (string) data_get($h, 'meta.site_name', 'Normes & Rénovation');
    $agencyPhone = (string) data_get($h, 'footer.phone', '03 85 41 98 86');
@endphp
<!DOCTYPE html>
<html lang="fr">
@include('home.head', [
    'home' => $h,
    'title' => 'Simulation envoyée | '.$siteName,
    'description' => 'Votre demande de simulation a bien été validée.',
    'canonicalUrl' => route('simulateur.success'),
])
<body class="bg-slate-50 font-sans text-slate-900 antialiased">
    <main class="mx-auto flex min-h-screen w-[95%] max-w-3xl items-center px-4 py-10 sm:px-6 lg:px-8">
        <section class="w-full rounded-3xl border border-slate-200 bg-white p-6 text-center shadow-soft sm:p-10">
            <img src="{{ $logo }}" alt="Logo {{ $siteName }}" class="mx-auto h-12 w-auto">
            <p class="mt-6 inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-extrabold uppercase tracking-[0.18em] text-emerald-700">
                Tout est ok
            </p>
            <h1 class="mt-3 text-3xl font-black text-slate-900 sm:text-4xl">Votre demande est validée</h1>
            <p class="mt-3 text-sm leading-relaxed text-slate-600 sm:text-base">
                Merci {{ data_get($sum, 'nom_prenom', '') }}. Un conseiller vous rappelle rapidement au
                <span class="font-extrabold text-brand-blue">{{ data_get($sum, 'telephone', '-') }}</span>.
            </p>
            <p class="mt-2 text-sm text-slate-500">
                Besoin d’un contact immédiat ? Appelez-nous au <span class="font-extrabold">{{ $agencyPhone }}</span>.
            </p>

            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('home') }}" class="rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white hover:bg-sky-500">
                    Retour à l'accueil
                </a>
                <a href="{{ route('contact.page') }}" class="rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
                    Voir la page contact
                </a>
            </div>
        </section>
    </main>
</body>
</html>
