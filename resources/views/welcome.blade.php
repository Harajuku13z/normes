<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Normes & Renovation - Rénovation énergétique en Bourgogne</title>
    <meta name="description" content="Normes & Renovation accompagne vos projets de rénovation énergétique, thermique et électrique en Bourgogne. Devis gratuit, entreprise certifiée RGE.">
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
                    boxShadow: {
                        soft: '0 12px 26px rgba(47, 66, 81, 0.12)',
                    },
                    fontFamily: {
                        sans: ['Google Sans', 'Product Sans', 'Inter', 'Segoe UI', 'Arial', 'sans-serif'],
                    },
                },
            },
        };
    </script>
</head>
<body class="bg-white font-sans text-brand-dark antialiased">
    <header class="sticky top-0 z-50 border-b border-slate-100 bg-white/95 backdrop-blur-md">
        <div class="mx-auto flex min-h-[84px] max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="#top" class="shrink-0">
                <img src="/logo.png" alt="Normes & Renovation" class="h-12 w-auto sm:h-14">
            </a>

            <nav class="hidden items-center gap-6 lg:flex">
                <a href="#top" class="text-[17px] font-semibold transition hover:text-brand-blue">Acceuil</a>
                <a href="#services" class="text-[17px] font-semibold transition hover:text-brand-blue">nos services</a>
                <a href="#franchise" class="text-[17px] font-semibold transition hover:text-brand-blue">agences</a>
                <a href="#realisations" class="text-[17px] font-semibold transition hover:text-brand-blue">nos realisation</a>
                <a href="#devis" class="rounded-xl bg-brand-blue px-5 py-2.5 text-sm font-bold text-white shadow-soft transition hover:-translate-y-0.5 hover:bg-sky-500">Nous contacter</a>
                <div class="ml-1 flex items-center gap-2">
                    <a href="#" aria-label="Facebook" class="grid h-9 w-9 place-items-center rounded-full bg-brand-blue font-bold text-white transition hover:bg-brand-yellow hover:text-brand-dark">F</a>
                    <a href="#" aria-label="LinkedIn" class="grid h-9 w-9 place-items-center rounded-full bg-brand-dark text-sm font-bold text-white transition hover:bg-brand-yellow hover:text-brand-dark">in</a>
                </div>
            </nav>

            <button id="menuBtn" type="button" class="inline-flex items-center rounded-lg border border-slate-200 p-2 text-brand-dark lg:hidden" aria-label="Ouvrir le menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <div id="mobileMenu" class="hidden border-t border-slate-100 bg-white lg:hidden">
            <div class="mx-auto flex max-w-7xl flex-col gap-1 px-4 py-3 sm:px-6">
                <a href="#top" class="rounded-lg px-3 py-2 font-semibold hover:bg-slate-50">Acceuil</a>
                <a href="#services" class="rounded-lg px-3 py-2 font-semibold hover:bg-slate-50">nos services</a>
                <a href="#franchise" class="rounded-lg px-3 py-2 font-semibold hover:bg-slate-50">agences</a>
                <a href="#realisations" class="rounded-lg px-3 py-2 font-semibold hover:bg-slate-50">nos realisation</a>
                <a href="#devis" class="mt-2 inline-flex w-full items-center justify-center rounded-xl bg-brand-blue px-4 py-3 text-sm font-extrabold text-white shadow-soft">Nous contacter</a>
                <div class="mt-2 flex items-center gap-2">
                    <a href="#" aria-label="Facebook" class="grid h-9 w-9 place-items-center rounded-full bg-brand-blue font-bold text-white">F</a>
                    <a href="#" aria-label="LinkedIn" class="grid h-9 w-9 place-items-center rounded-full bg-brand-dark text-sm font-bold text-white">in</a>
                </div>
            </div>
        </div>
    </header>

    <section id="top" class="relative min-h-[540px] overflow-hidden sm:min-h-[620px]">
        <div id="heroBg" class="absolute inset-0 bg-cover bg-center transition-all duration-500" style="background-image:linear-gradient(110deg, rgba(47,66,81,.74), rgba(47,66,81,.32)), url('https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=1600&q=80')"></div>
        <div class="relative z-10 mx-auto flex min-h-[540px] max-w-7xl flex-col justify-end gap-5 px-4 py-8 sm:min-h-[620px] sm:px-6 lg:flex-row lg:items-end lg:justify-between lg:px-8">
            <div class="max-w-3xl text-white">
                <h1 class="mb-3 text-4xl font-extrabold leading-[1.03] tracking-tight sm:text-5xl lg:text-6xl">Renovez, Economisez, Valorisez votre maison</h1>
                <p class="mb-5 text-lg text-slate-100 sm:text-xl">Expert en renovation energetique en Bourgogne. Nous vous accompagnons de l'etude a la realisation.</p>
                <div class="flex flex-wrap gap-3">
                    <a href="#devis" class="rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:-translate-y-0.5 hover:bg-sky-500">Devis gratuit</a>
                    <a href="#devis" class="rounded-xl bg-brand-yellow px-5 py-3 text-sm font-extrabold text-brand-dark shadow-soft transition hover:-translate-y-0.5 hover:bg-yellow-300">Etre rappele</a>
                </div>
            </div>

            <div id="heroThumbs" class="flex w-full gap-2 pb-1 lg:w-auto">
                <button class="hero-thumb h-20 min-w-0 flex-1 rounded-xl border-2 border-brand-blue bg-cover bg-center shadow-soft lg:h-24 lg:w-32 lg:flex-none" data-bg="1" style="background-image:url('https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=600&q=80')" aria-label="Image hero 1"></button>
                <button class="hero-thumb h-20 min-w-0 flex-1 rounded-xl border-2 border-transparent bg-cover bg-center shadow-soft lg:h-24 lg:w-32 lg:flex-none" data-bg="2" style="background-image:url('https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=600&q=80')" aria-label="Image hero 2"></button>
                <button class="hero-thumb h-20 min-w-0 flex-1 rounded-xl border-2 border-transparent bg-cover bg-center shadow-soft lg:h-24 lg:w-32 lg:flex-none" data-bg="3" style="background-image:url('https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=600&q=80')" aria-label="Image hero 3"></button>
            </div>
        </div>
    </section>

    <section class="border-b border-slate-100 bg-gradient-to-r from-[#FADF70]/65 via-[#FADF70]/45 to-white py-8 sm:py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <form class="grid gap-3 rounded-2xl border border-[#FADF70] bg-white p-4 shadow-soft ring-2 ring-[#FADF70]/40 sm:grid-cols-[1fr_auto] sm:items-end sm:gap-4 sm:p-5">
                <div>
                    <label for="address" class="mb-2 block text-sm font-extrabold text-brand-dark">Entrez votre adresse (simulateur)</label>
                    <input id="address" type="text" placeholder="Ex: 6 rue Pierre de Coubertin, Chalon-sur-Saone" class="w-full rounded-xl border-2 border-[#FADF70]/70 bg-white px-4 py-3 text-sm text-brand-dark outline-none transition focus:border-brand-blue">
                </div>
                <button type="button" class="rounded-xl bg-[#FADF70] px-6 py-3 text-sm font-extrabold text-brand-dark transition hover:bg-yellow-300">Lancer le simulateur</button>
            </form>
        </div>
    </section>

    <aside class="fixed left-3 top-1/2 z-40 hidden -translate-y-1/2 rounded-2xl border border-slate-200 bg-white p-3 shadow-soft xl:block">
        <p class="text-xs font-bold uppercase tracking-wide text-slate-500">Google</p>
        <div class="mt-1 text-lg font-extrabold text-brand-dark">5.0/5</div>
        <div class="text-xs text-yellow-500">★★★★★</div>
        <p class="mt-1 max-w-[130px] text-xs text-slate-600">Avis sur plus de 100 clients</p>
    </aside>

    <section id="services" class="bg-slate-50/70 py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="mb-3 text-3xl font-extrabold leading-tight sm:text-4xl">Nos services de renovation</h2>
            <p class="mb-6 max-w-3xl text-base text-slate-600 sm:text-lg">Choisissez une categorie et affichez uniquement les services concernes.</p>
            <div id="serviceFilters" class="mb-6 flex flex-wrap gap-2">
                <button type="button" data-filter="all" class="service-filter rounded-full bg-brand-dark px-4 py-2 text-xs font-bold uppercase tracking-wide text-white sm:text-sm">Tous</button>
                <button type="button" data-filter="toiture" class="service-filter rounded-full border border-slate-300 bg-white px-4 py-2 text-xs font-bold uppercase tracking-wide text-slate-700 sm:text-sm">Toiture</button>
                <button type="button" data-filter="isolation" class="service-filter rounded-full border border-slate-300 bg-white px-4 py-2 text-xs font-bold uppercase tracking-wide text-slate-700 sm:text-sm">Isolation</button>
                <button type="button" data-filter="electricite" class="service-filter rounded-full border border-slate-300 bg-white px-4 py-2 text-xs font-bold uppercase tracking-wide text-slate-700 sm:text-sm">Electricite</button>
                <button type="button" data-filter="energie" class="service-filter rounded-full border border-slate-300 bg-white px-4 py-2 text-xs font-bold uppercase tracking-wide text-slate-700 sm:text-sm">Energie</button>
                <button type="button" data-filter="air" class="service-filter rounded-full border border-slate-300 bg-white px-4 py-2 text-xs font-bold uppercase tracking-wide text-slate-700 sm:text-sm">Air & confort</button>
            </div>
            <div id="serviceGrid" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                <article data-category="toiture" class="service-card overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1632759145351-1d592ac9b238?auto=format&fit=crop&w=1000&q=80" alt="Toiture couverture" class="h-44 w-full object-cover"><div class="p-5"><h3 class="mb-2 text-lg font-bold">Toiture & couverture</h3><p class="text-sm text-slate-600">Renovation de toiture, etancheite et protection durable de votre maison.</p></div></article>
                <article data-category="toiture" class="service-card overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1628744448840-55bdb2497bd4?auto=format&fit=crop&w=1000&q=80" alt="Zinguerie" class="h-44 w-full object-cover"><div class="p-5"><h3 class="mb-2 text-lg font-bold">Zinguerie</h3><p class="text-sm text-slate-600">Gestion des eaux pluviales, gouttieres et finitions toiture haute qualite.</p></div></article>
                <article data-category="isolation" class="service-card overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1581094271901-8022df4466f9?auto=format&fit=crop&w=1000&q=80" alt="Isolation thermique" class="h-44 w-full object-cover"><div class="p-5"><h3 class="mb-2 text-lg font-bold">Isolation thermique</h3><p class="text-sm text-slate-600">Isolation des combles, murs et planchers pour limiter les pertes d'energie.</p></div></article>
                <article data-category="isolation" class="service-card overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=1000&q=80" alt="Ravalement facade" class="h-44 w-full object-cover"><div class="p-5"><h3 class="mb-2 text-lg font-bold">Facade & ravalement</h3><p class="text-sm text-slate-600">Traitements et finitions facade pour proteger et valoriser votre bien.</p></div></article>
                <article data-category="isolation air" class="service-card overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1000&q=80" alt="Traitement humidite" class="h-44 w-full object-cover"><div class="p-5"><h3 class="mb-2 text-lg font-bold">Traitement de l'humidite</h3><p class="text-sm text-slate-600">Solutions anti-humidite pour un habitat sain, durable et confortable.</p></div></article>
                <article data-category="air" class="service-card overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?auto=format&fit=crop&w=1000&q=80" alt="Ventilation" class="h-44 w-full object-cover"><div class="p-5"><h3 class="mb-2 text-lg font-bold">Ventilation</h3><p class="text-sm text-slate-600">VMC simple et double flux pour une qualite d'air optimale au quotidien.</p></div></article>
                <article data-category="electricite" class="service-card overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1621905252507-b35492cc74b4?auto=format&fit=crop&w=1000&q=80" alt="Electricite" class="h-44 w-full object-cover"><div class="p-5"><h3 class="mb-2 text-lg font-bold">Mise aux normes electriques</h3><p class="text-sm text-slate-600">Securisation complete du reseau electrique selon les normes en vigueur.</p></div></article>
                <article data-category="electricite energie" class="service-card overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1466611653911-95081537e5b7?auto=format&fit=crop&w=1000&q=80" alt="Photovoltaique" class="h-44 w-full object-cover"><div class="p-5"><h3 class="mb-2 text-lg font-bold">Photovoltaique</h3><p class="text-sm text-slate-600">Panneaux solaires pour produire votre electricite et reduire vos factures.</p></div></article>
                <article data-category="air energie" class="service-card overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1000&q=80" alt="Pompe a chaleur" class="h-44 w-full object-cover"><div class="p-5"><h3 class="mb-2 text-lg font-bold">Pompe a chaleur</h3><p class="text-sm text-slate-600">Performance energetique elevee pour chauffer et rafraichir votre maison.</p></div></article>
                <article data-category="air" class="service-card overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1556911220-bff31c812dba?auto=format&fit=crop&w=1000&q=80" alt="Climatisation" class="h-44 w-full object-cover"><div class="p-5"><h3 class="mb-2 text-lg font-bold">Climatisation</h3><p class="text-sm text-slate-600">Confort ete/hiver avec systemes de climatisation economes et silencieux.</p></div></article>
                <article data-category="isolation toiture" class="service-card overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1523419409543-a5e549c1f4f5?auto=format&fit=crop&w=1000&q=80" alt="Isolation combles" class="h-44 w-full object-cover"><div class="p-5"><h3 class="mb-2 text-lg font-bold">Isolation des combles</h3><p class="text-sm text-slate-600">L'un des leviers les plus efficaces pour baisser vos depenses energetiques.</p></div></article>
                <article data-category="electricite energie" class="service-card overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1584277261846-c6a1672ed979?auto=format&fit=crop&w=1000&q=80" alt="Borne de recharge" class="h-44 w-full object-cover"><div class="p-5"><h3 class="mb-2 text-lg font-bold">Borne de recharge</h3><p class="text-sm text-slate-600">Installation de bornes pour vehicules electriques a domicile ou en entreprise.</p></div></article>
            </div>
        </div>
    </section>

    <section id="realisations" class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="mb-3 text-3xl font-extrabold sm:text-4xl">Avant / Apres</h2>
            <p class="mb-8 text-base text-slate-600 sm:text-lg">Des resultats visibles immediatement avec un comparateur interactif.</p>
            <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft">
                <div class="relative h-[300px] bg-slate-200 sm:h-[380px] lg:h-[440px]">
                    <div class="absolute inset-0 bg-cover bg-center" style="background-image:url('https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=1400&q=80')"></div>
                    <div id="afterLayer" class="absolute inset-0 bg-cover bg-center" style="clip-path: inset(0 0 0 50%); background-image:url('https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&w=1400&q=80')"></div>
                </div>
                <input id="baRange" type="range" min="0" max="100" value="50" class="w-full accent-brand-blue">
                <div class="flex items-center justify-between bg-slate-50 px-4 py-3 text-xs font-bold uppercase tracking-wide text-slate-600 sm:text-sm"><span>Avant</span><span>Apres</span></div>
            </div>
        </div>
    </section>

    <section class="bg-slate-50/70 py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="mb-8 text-3xl font-extrabold sm:text-4xl">Pourquoi nous ?</h2>
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <article class="rounded-xl border border-slate-100 bg-white p-5"><h3 class="mb-2 font-bold">Expertise technique</h3><p class="text-sm text-slate-600">Des equipes qualifiees et des conseils adaptes a votre maison.</p></article>
                <article class="rounded-xl border border-slate-100 bg-white p-5"><h3 class="mb-2 font-bold">Entreprise certifiee RGE</h3><p class="text-sm text-slate-600">Un accompagnement conforme aux normes et aides en vigueur.</p></article>
                <article class="rounded-xl border border-slate-100 bg-white p-5"><h3 class="mb-2 font-bold">Solutions durables</h3><p class="text-sm text-slate-600">Des choix techniques performants pour un impact long terme.</p></article>
                <article class="rounded-xl border border-slate-100 bg-white p-5"><h3 class="mb-2 font-bold">Accompagnement complet</h3><p class="text-sm text-slate-600">Un interlocuteur unique du devis jusqu'a la fin de chantier.</p></article>
            </div>
        </div>
    </section>

    <section class="bg-brand-dark py-14 text-white sm:py-20">
        <div class="mx-auto grid max-w-7xl gap-5 px-4 text-center sm:grid-cols-2 sm:px-6 lg:grid-cols-4 lg:px-8">
            <article><strong class="block text-4xl font-extrabold text-brand-yellow">+1000</strong><span class="text-sm sm:text-base">chantiers realises</span></article>
            <article><strong class="block text-4xl font-extrabold text-brand-yellow">98%</strong><span class="text-sm sm:text-base">satisfaction client</span></article>
            <article><strong class="block text-4xl font-extrabold text-brand-yellow">48h</strong><span class="text-sm sm:text-base">prise en charge rapide</span></article>
            <article><strong class="block text-4xl font-extrabold text-brand-yellow">100%</strong><span class="text-sm sm:text-base">devis gratuit</span></article>
        </div>
    </section>

    <section class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="mb-3 text-3xl font-extrabold sm:text-4xl">Avis clients</h2>
            <p class="mb-8 text-base text-slate-600 sm:text-lg">Ils nous font confiance pour leurs travaux de renovation.</p>
            <div class="grid gap-4 lg:grid-cols-3">
                <article class="rounded-xl border border-slate-100 bg-white p-5 shadow-soft"><div class="mb-2 text-yellow-500">★★★★★</div><p class="mb-3 text-slate-600">Equipe serieuse, chantier propre et tres bon resultat.</p><b class="text-sm">Claire M.</b></article>
                <article class="rounded-xl border border-slate-100 bg-white p-5 shadow-soft"><div class="mb-2 text-yellow-500">★★★★★</div><p class="mb-3 text-slate-600">Accompagnement pro du debut a la fin et tres bons conseils.</p><b class="text-sm">Julien R.</b></article>
                <article class="rounded-xl border border-slate-100 bg-white p-5 shadow-soft"><div class="mb-2 text-yellow-500">★★★★★</div><p class="mb-3 text-slate-600">Travail de qualite, delais tenus et equipe tres a l'ecoute.</p><b class="text-sm">Sophie L.</b></article>
            </div>
        </div>
    </section>

    <section id="devis" class="bg-brand-dark py-16 text-white sm:py-20">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-[1.15fr_.85fr] lg:items-center lg:px-8">
            <div>
                <h2 class="mb-3 text-3xl font-extrabold leading-tight sm:text-4xl">Vous avez un projet de renovation ?</h2>
                <p class="text-slate-200">Simulez votre besoin et recevez rapidement un accompagnement personnalise.</p>
            </div>
            <form class="rounded-2xl bg-white p-5 text-brand-dark sm:p-6">
                <label for="name" class="mb-1 block text-sm font-semibold">Nom</label>
                <input id="name" type="text" class="mb-3 w-full rounded-lg border border-slate-200 px-3 py-2.5">
                <label for="phone" class="mb-1 block text-sm font-semibold">Telephone</label>
                <input id="phone" type="tel" class="mb-3 w-full rounded-lg border border-slate-200 px-3 py-2.5">
                <label for="project" class="mb-1 block text-sm font-semibold">Projet</label>
                <select id="project" class="mb-4 w-full rounded-lg border border-slate-200 px-3 py-2.5">
                    <option>Isolation</option>
                    <option>Toiture</option>
                    <option>Electricite</option>
                    <option>Photovoltaique</option>
                    <option>Climatisation</option>
                </select>
                <button type="button" class="w-full rounded-xl bg-brand-yellow px-4 py-3 text-sm font-extrabold text-brand-dark transition hover:bg-yellow-300">Recevoir mon devis gratuit</button>
            </form>
        </div>
    </section>

    <section id="franchise" class="bg-slate-50/70 py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="mb-8 text-3xl font-extrabold sm:text-4xl">Bonus</h2>
            <div class="grid gap-4 lg:grid-cols-3">
                <article class="rounded-xl border border-slate-100 bg-white p-5"><h3 class="mb-2 text-xl font-bold">Simulateur de devis</h3><p class="text-slate-600">Un parcours simple pour qualifier rapidement votre projet.</p></article>
                <article class="rounded-xl border border-slate-100 bg-white p-5"><h3 class="mb-2 text-xl font-bold">Page realisations</h3><p class="text-slate-600">Mise en avant des chantiers avant/apres pour rassurer.</p></article>
                <article class="rounded-xl border border-slate-100 bg-white p-5"><h3 class="mb-2 text-xl font-bold">Blog SEO 2026</h3><p class="text-slate-600">Contenus sur les aides, l'isolation et les economies d'energie.</p></article>
            </div>
        </div>
    </section>

    <footer class="bg-brand-dark py-10 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h3 class="mb-2 text-2xl font-bold">Normes & Renovation</h3>
            <p class="text-slate-300">6 rue Pierre de Coubertin, 71100 Chalon-sur-Saone</p>
            <p class="text-slate-300">03 85 41 98 86</p>
            <p class="text-slate-300">bourgogne-agence@normesrenovation.fr</p>
        </div>
    </footer>

    <a href="tel:+33385419886" class="fixed bottom-4 right-4 z-50 inline-flex rounded-full bg-brand-blue px-4 py-3 text-sm font-bold text-white shadow-soft transition hover:bg-sky-500 lg:hidden">Appeler maintenant</a>

    <script>
        (function () {
            const menuBtn = document.getElementById('menuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
                mobileMenu.querySelectorAll('a').forEach((link) => {
                    link.addEventListener('click', () => mobileMenu.classList.add('hidden'));
                });
            }

            const hero = document.getElementById('heroBg');
            const thumbs = Array.from(document.querySelectorAll('.hero-thumb'));
            const backgrounds = {
                1: "linear-gradient(110deg, rgba(47,66,81,.74), rgba(47,66,81,.32)), url('https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=1600&q=80')",
                2: "linear-gradient(110deg, rgba(47,66,81,.74), rgba(47,66,81,.32)), url('https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=1600&q=80')",
                3: "linear-gradient(110deg, rgba(47,66,81,.74), rgba(47,66,81,.32)), url('https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1600&q=80')"
            };
            thumbs.forEach((thumb) => {
                thumb.addEventListener('click', () => {
                    hero.style.backgroundImage = backgrounds[thumb.dataset.bg];
                    thumbs.forEach((t) => t.classList.remove('border-brand-blue'));
                    thumb.classList.add('border-brand-blue');
                });
            });

            const range = document.getElementById('baRange');
            const afterLayer = document.getElementById('afterLayer');
            if (range && afterLayer) {
                range.addEventListener('input', () => {
                    afterLayer.style.clipPath = `inset(0 0 0 ${Number(range.value)}%)`;
                });
            }

            const filterButtons = Array.from(document.querySelectorAll('.service-filter'));
            const serviceCards = Array.from(document.querySelectorAll('.service-card'));
            if (filterButtons.length && serviceCards.length) {
                filterButtons.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const selected = btn.dataset.filter;

                        filterButtons.forEach((item) => {
                            item.classList.remove('bg-brand-dark', 'text-white', 'border-brand-dark');
                            item.classList.add('bg-white', 'text-slate-700', 'border-slate-300');
                        });
                        btn.classList.remove('bg-white', 'text-slate-700', 'border-slate-300');
                        btn.classList.add('bg-brand-dark', 'text-white', 'border-brand-dark');

                        serviceCards.forEach((card) => {
                            const categories = (card.dataset.category || '').split(' ');
                            const visible = selected === 'all' || categories.includes(selected);
                            card.classList.toggle('hidden', !visible);
                        });
                    });
                });
            }
        })();
    </script>
</body>
</html>
