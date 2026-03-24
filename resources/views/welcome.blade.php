<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Normes & Renovation - Rénovation énergétique en Bourgogne</title>
    <meta name="description" content="Normes & Renovation accompagne vos projets de rénovation énergétique, thermique et électrique en Bourgogne. Devis gratuit et accompagnement complet.">
    <link rel="icon" type="image/png" href="/iconne.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#60B4F9',
                            yellow: '#FADF70',
                            dark: '#2F4251',
                        },
                    },
                    fontFamily: {
                        sans: ['Google Sans', 'Product Sans', 'Inter', 'Segoe UI', 'Arial', 'sans-serif'],
                    },
                    boxShadow: {
                        soft: '0 10px 24px rgba(47, 66, 81, 0.12)',
                    },
                },
            },
        };
    </script>
</head>
<body class="bg-white text-brand-dark font-sans antialiased">
    <header class="sticky top-0 z-50 border-b border-slate-100 bg-white/95 backdrop-blur">
        <div class="mx-auto flex min-h-[86px] w-[min(1180px,calc(100%-2rem))] items-center justify-between gap-4">
            <a href="#top" class="shrink-0">
                <img src="/logo.png" alt="Normes & Renovation" class="h-12 w-auto">
            </a>
            <nav class="flex flex-wrap items-center gap-4 text-base font-semibold lg:gap-6">
                <a href="#top" class="transition hover:text-brand-blue">Acceuil</a>
                <a href="#services" class="transition hover:text-brand-blue">nos services</a>
                <a href="#franchise" class="transition hover:text-brand-blue">agences</a>
                <a href="#realisations" class="transition hover:text-brand-blue">nos realisation</a>
                <a href="#devis" class="rounded-lg bg-brand-blue px-5 py-2.5 text-white shadow-soft transition hover:-translate-y-0.5 hover:bg-sky-500">Nous contacter</a>
                <div class="ml-1 flex items-center gap-2">
                    <a href="#" aria-label="Facebook" class="grid h-8 w-8 place-items-center rounded-full bg-brand-blue text-sm font-bold text-white transition hover:bg-brand-yellow hover:text-brand-dark">F</a>
                    <a href="#" aria-label="LinkedIn" class="grid h-8 w-8 place-items-center rounded-full bg-brand-dark text-sm font-bold text-white transition hover:bg-brand-yellow hover:text-brand-dark">in</a>
                </div>
            </nav>
        </div>
    </header>

    <section id="top" class="relative min-h-[68vh] overflow-hidden">
        <div id="heroBg" class="absolute inset-0 bg-cover bg-center transition-all duration-500" style="background-image:linear-gradient(110deg, rgba(47,66,81,.72), rgba(47,66,81,.28)), url('https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=1600&q=80')"></div>
        <div class="relative z-10 mx-auto flex min-h-[68vh] w-[min(1180px,calc(100%-2rem))] flex-col justify-end gap-5 py-8 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-3xl text-white">
                <h1 class="mb-3 text-4xl font-extrabold leading-[1.05] tracking-tight sm:text-5xl lg:text-6xl">Renovez, Economisez, Valorisez votre maison</h1>
                <p class="mb-5 text-lg text-slate-100 sm:text-xl">Expert en renovation energetique en Bourgogne. Nous vous accompagnons de l'etude a la realisation.</p>
                <div class="flex flex-wrap gap-3">
                    <a href="#devis" class="rounded-lg bg-brand-blue px-5 py-3 font-bold text-white shadow-soft transition hover:-translate-y-0.5 hover:bg-sky-500">Devis gratuit</a>
                    <a href="#devis" class="rounded-lg bg-brand-yellow px-5 py-3 font-bold text-brand-dark shadow-soft transition hover:-translate-y-0.5 hover:bg-yellow-300">Etre rappele</a>
                </div>
            </div>
            <div id="heroThumbs" class="flex w-full gap-2 lg:w-auto">
                <button class="hero-thumb active h-20 min-w-0 flex-1 rounded-xl border-2 border-brand-blue bg-cover bg-center shadow-soft lg:h-24 lg:w-32 lg:flex-none" data-bg="1" style="background-image:url('https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=600&q=80')" aria-label="Image hero 1"></button>
                <button class="hero-thumb h-20 min-w-0 flex-1 rounded-xl border-2 border-transparent bg-cover bg-center shadow-soft lg:h-24 lg:w-32 lg:flex-none" data-bg="2" style="background-image:url('https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=600&q=80')" aria-label="Image hero 2"></button>
                <button class="hero-thumb h-20 min-w-0 flex-1 rounded-xl border-2 border-transparent bg-cover bg-center shadow-soft lg:h-24 lg:w-32 lg:flex-none" data-bg="3" style="background-image:url('https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=600&q=80')" aria-label="Image hero 3"></button>
            </div>
        </div>
    </section>

    <section id="services" class="bg-sky-50/40 py-20">
        <div class="mx-auto w-[min(1180px,calc(100%-2rem))]">
            <h2 class="mb-3 text-4xl font-extrabold leading-tight text-brand-dark">Nos services de renovation</h2>
            <p class="mb-8 text-lg text-slate-600">Des prestations completes pour améliorer le confort thermique, les performances et la valeur de votre bien.</p>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <article class="rounded-2xl border border-slate-100 bg-white p-5 shadow-soft transition hover:-translate-y-1"><div class="mb-3 grid h-11 w-11 place-items-center rounded-xl bg-sky-100 text-xl text-brand-blue">🏠</div><h3 class="mb-1 text-lg font-bold">Toiture & couverture</h3><p class="text-sm text-slate-600">Protection durable et etancheite optimisee de votre habitat.</p></article>
                <article class="rounded-2xl border border-slate-100 bg-white p-5 shadow-soft transition hover:-translate-y-1"><div class="mb-3 grid h-11 w-11 place-items-center rounded-xl bg-sky-100 text-xl text-brand-blue">🧱</div><h3 class="mb-1 text-lg font-bold">Isolation thermique</h3><p class="text-sm text-slate-600">Confort hiver/ete et reduction de vos depenses energetiques.</p></article>
                <article class="rounded-2xl border border-slate-100 bg-white p-5 shadow-soft transition hover:-translate-y-1"><div class="mb-3 grid h-11 w-11 place-items-center rounded-xl bg-sky-100 text-xl text-brand-blue">🧰</div><h3 class="mb-1 text-lg font-bold">Façade & ravalement</h3><p class="text-sm text-slate-600">Valorisation esthetique et protection longue duree.</p></article>
                <article class="rounded-2xl border border-slate-100 bg-white p-5 shadow-soft transition hover:-translate-y-1"><div class="mb-3 grid h-11 w-11 place-items-center rounded-xl bg-sky-100 text-xl text-brand-blue">💧</div><h3 class="mb-1 text-lg font-bold">Traitement humidite</h3><p class="text-sm text-slate-600">Solutions durables contre infiltrations et moisissures.</p></article>
                <article class="rounded-2xl border border-slate-100 bg-white p-5 shadow-soft transition hover:-translate-y-1"><div class="mb-3 grid h-11 w-11 place-items-center rounded-xl bg-sky-100 text-xl text-brand-blue">🌬️</div><h3 class="mb-1 text-lg font-bold">Ventilation</h3><p class="text-sm text-slate-600">Air sain et qualite de vie amelioree au quotidien.</p></article>
                <article class="rounded-2xl border border-slate-100 bg-white p-5 shadow-soft transition hover:-translate-y-1"><div class="mb-3 grid h-11 w-11 place-items-center rounded-xl bg-sky-100 text-xl text-brand-blue">⚡</div><h3 class="mb-1 text-lg font-bold">Electricite</h3><p class="text-sm text-slate-600">Mise en securite et modernisation des installations.</p></article>
                <article class="rounded-2xl border border-slate-100 bg-white p-5 shadow-soft transition hover:-translate-y-1"><div class="mb-3 grid h-11 w-11 place-items-center rounded-xl bg-sky-100 text-xl text-brand-blue">☀️</div><h3 class="mb-1 text-lg font-bold">Photovoltaique</h3><p class="text-sm text-slate-600">Production locale d'electricite et autonomie energetique.</p></article>
                <article class="rounded-2xl border border-slate-100 bg-white p-5 shadow-soft transition hover:-translate-y-1"><div class="mb-3 grid h-11 w-11 place-items-center rounded-xl bg-sky-100 text-xl text-brand-blue">❄️</div><h3 class="mb-1 text-lg font-bold">Climatisation</h3><p class="text-sm text-slate-600">Confort thermique performant toute l'annee.</p></article>
            </div>
        </div>
    </section>

    <section id="realisations" class="py-20">
        <div class="mx-auto w-[min(1180px,calc(100%-2rem))]">
            <h2 class="mb-3 text-4xl font-extrabold text-brand-dark">Avant / Apres</h2>
            <p class="mb-8 text-lg text-slate-600">Des resultats visibles immediatement avec un comparateur interactif.</p>
            <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft">
                <div class="relative h-[420px] bg-slate-200">
                    <div class="absolute inset-0 bg-cover bg-center" style="background-image:url('https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=1400&q=80')"></div>
                    <div id="afterLayer" class="absolute inset-0 bg-cover bg-center" style="clip-path: inset(0 0 0 50%); background-image:url('https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&w=1400&q=80')"></div>
                </div>
                <input id="baRange" type="range" min="0" max="100" value="50" class="w-full accent-[#60B4F9]">
                <div class="flex items-center justify-between bg-slate-50 px-4 py-3 text-sm font-bold text-slate-600"><span>Avant</span><span>Apres</span></div>
            </div>
        </div>
    </section>

    <section class="bg-sky-50/40 py-20">
        <div class="mx-auto w-[min(1180px,calc(100%-2rem))]">
            <h2 class="mb-8 text-4xl font-extrabold text-brand-dark">Pourquoi nous ?</h2>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <article class="rounded-xl border border-slate-100 bg-white p-5"><h3 class="mb-2 font-bold">Expertise technique</h3><p class="text-sm text-slate-600">Des equipes qualifiees et des conseils adaptes a votre maison.</p></article>
                <article class="rounded-xl border border-slate-100 bg-white p-5"><h3 class="mb-2 font-bold">Entreprise certifiee RGE</h3><p class="text-sm text-slate-600">Un accompagnement conforme aux normes et aides en vigueur.</p></article>
                <article class="rounded-xl border border-slate-100 bg-white p-5"><h3 class="mb-2 font-bold">Solutions durables</h3><p class="text-sm text-slate-600">Des choix techniques performants pour un impact long terme.</p></article>
                <article class="rounded-xl border border-slate-100 bg-white p-5"><h3 class="mb-2 font-bold">Accompagnement complet</h3><p class="text-sm text-slate-600">Un interlocuteur unique du devis jusqu'a la fin de chantier.</p></article>
            </div>
        </div>
    </section>

    <section class="bg-brand-dark py-20 text-white">
        <div class="mx-auto grid w-[min(1180px,calc(100%-2rem))] gap-4 text-center sm:grid-cols-2 lg:grid-cols-4">
            <article><strong class="block text-4xl font-extrabold text-brand-yellow">+1000</strong><span>chantiers realises</span></article>
            <article><strong class="block text-4xl font-extrabold text-brand-yellow">98%</strong><span>satisfaction client</span></article>
            <article><strong class="block text-4xl font-extrabold text-brand-yellow">48h</strong><span>prise en charge rapide</span></article>
            <article><strong class="block text-4xl font-extrabold text-brand-yellow">100%</strong><span>devis gratuit</span></article>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto w-[min(1180px,calc(100%-2rem))]">
            <h2 class="mb-3 text-4xl font-extrabold text-brand-dark">Avis clients</h2>
            <p class="mb-8 text-lg text-slate-600">Ils nous font confiance pour leurs travaux de renovation.</p>
            <div class="grid gap-4 lg:grid-cols-3">
                <article class="rounded-xl border border-slate-100 bg-white p-5 shadow-soft"><div class="mb-2 text-yellow-500">★★★★★</div><p class="mb-3 text-slate-600">Equipe serieuse, chantier propre et tres bon resultat.</p><b class="text-sm">Claire M.</b></article>
                <article class="rounded-xl border border-slate-100 bg-white p-5 shadow-soft"><div class="mb-2 text-yellow-500">★★★★★</div><p class="mb-3 text-slate-600">Accompagnement pro du debut a la fin et tres bons conseils.</p><b class="text-sm">Julien R.</b></article>
                <article class="rounded-xl border border-slate-100 bg-white p-5 shadow-soft"><div class="mb-2 text-yellow-500">★★★★★</div><p class="mb-3 text-slate-600">Travail de qualite, delais tenus et equipe tres a l'ecoute.</p><b class="text-sm">Sophie L.</b></article>
            </div>
        </div>
    </section>

    <section id="devis" class="bg-brand-dark py-20 text-white">
        <div class="mx-auto grid w-[min(1180px,calc(100%-2rem))] gap-5 lg:grid-cols-[1.15fr_.85fr] lg:items-center">
            <div>
                <h2 class="mb-3 text-4xl font-extrabold leading-tight">Vous avez un projet de renovation ?</h2>
                <p class="text-slate-200">Simulez votre besoin et recevez rapidement un accompagnement personnalise.</p>
            </div>
            <form class="rounded-2xl bg-white p-5 text-brand-dark">
                <label for="name" class="mb-1 block text-sm font-semibold">Nom</label>
                <input id="name" type="text" class="mb-3 w-full rounded-lg border border-slate-200 px-3 py-2">
                <label for="phone" class="mb-1 block text-sm font-semibold">Telephone</label>
                <input id="phone" type="tel" class="mb-3 w-full rounded-lg border border-slate-200 px-3 py-2">
                <label for="project" class="mb-1 block text-sm font-semibold">Projet</label>
                <select id="project" class="mb-3 w-full rounded-lg border border-slate-200 px-3 py-2">
                    <option>Isolation</option>
                    <option>Toiture</option>
                    <option>Electricite</option>
                    <option>Photovoltaique</option>
                    <option>Climatisation</option>
                </select>
                <button type="button" class="w-full rounded-lg bg-brand-yellow px-4 py-3 text-sm font-extrabold text-brand-dark transition hover:bg-yellow-300">Recevoir mon devis gratuit</button>
            </form>
        </div>
    </section>

    <section id="franchise" class="bg-sky-50/40 py-20">
        <div class="mx-auto w-[min(1180px,calc(100%-2rem))]">
            <h2 class="mb-8 text-4xl font-extrabold text-brand-dark">Bonus</h2>
            <div class="grid gap-4 lg:grid-cols-3">
                <article class="rounded-xl border border-slate-100 bg-white p-5"><h3 class="mb-2 text-xl font-bold">Simulateur de devis</h3><p class="text-slate-600">Un parcours simple pour qualifier rapidement votre projet.</p></article>
                <article class="rounded-xl border border-slate-100 bg-white p-5"><h3 class="mb-2 text-xl font-bold">Page realisations</h3><p class="text-slate-600">Mise en avant des chantiers avant/apres pour rassurer.</p></article>
                <article class="rounded-xl border border-slate-100 bg-white p-5"><h3 class="mb-2 text-xl font-bold">Blog SEO 2026</h3><p class="text-slate-600">Contenus sur les aides, l'isolation et les economies d'energie.</p></article>
            </div>
        </div>
    </section>

    <footer class="bg-brand-dark py-10 text-white">
        <div class="mx-auto w-[min(1180px,calc(100%-2rem))]">
            <h3 class="mb-2 text-2xl font-bold">Normes & Renovation</h3>
            <p class="text-slate-300">6 rue Pierre de Coubertin, 71100 Chalon-sur-Saone</p>
            <p class="text-slate-300">03 85 41 98 86</p>
            <p class="text-slate-300">bourgogne-agence@normesrenovation.fr</p>
        </div>
    </footer>

    <a href="tel:+33385419886" class="fixed bottom-4 right-4 z-50 inline-flex rounded-full bg-brand-blue px-4 py-3 text-sm font-bold text-white shadow-soft transition hover:bg-sky-500 lg:hidden">Appeler maintenant</a>

    <script>
        (function () {
            const hero = document.getElementById('heroBg');
            const thumbs = Array.from(document.querySelectorAll('.hero-thumb'));
            const backgrounds = {
                1: "linear-gradient(110deg, rgba(47,66,81,.72), rgba(47,66,81,.28)), url('https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=1600&q=80')",
                2: "linear-gradient(110deg, rgba(47,66,81,.72), rgba(47,66,81,.28)), url('https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=1600&q=80')",
                3: "linear-gradient(110deg, rgba(47,66,81,.72), rgba(47,66,81,.28)), url('https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1600&q=80')"
            };
            thumbs.forEach((thumb) => {
                thumb.addEventListener('click', () => {
                    hero.style.backgroundImage = backgrounds[thumb.dataset.bg];
                    thumbs.forEach((t) => t.classList.remove('active', 'border-brand-blue', '-translate-y-0.5'));
                    thumb.classList.add('active', 'border-brand-blue', '-translate-y-0.5');
                });
            });

            const range = document.getElementById('baRange');
            const afterLayer = document.getElementById('afterLayer');
            if (range && afterLayer) {
                range.addEventListener('input', () => {
                    afterLayer.style.clipPath = `inset(0 0 0 ${Number(range.value)}%)`;
                });
            }
        })();
    </script>
</body>
</html>
