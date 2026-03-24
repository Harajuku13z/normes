<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Normes & Renovation - Rénovation énergétique en Bourgogne</title>
    <meta name="description" content="Normes & Renovation accompagne vos projets de rénovation énergétique, thermique et électrique en Bourgogne. Devis gratuit, entreprise certifiée RGE.">
    <link rel="icon" type="image/png" href="/iconne.png">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
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
    <style>
        @keyframes avisFloat {
            0%, 100% { transform: translateY(-50%); }
            50% { transform: translateY(calc(-50% - 6px)); }
        }

        #agencyMap {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body class="bg-white font-sans text-brand-dark antialiased">
    <header class="sticky top-0 z-[1000] border-b border-slate-100 bg-white/95 backdrop-blur-md">
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
                    <a href="#" aria-label="Facebook" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#1877F2] text-white shadow-soft transition hover:opacity-90">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" aria-label="LinkedIn" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#0A66C2] text-white shadow-soft transition hover:opacity-90">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    <a href="#" aria-label="Instagram" class="inline-flex h-9 w-9 items-center justify-center rounded-full shadow-soft ring-2 ring-slate-200/80 transition hover:opacity-90">
                        <svg class="h-9 w-9" viewBox="0 0 24 24" aria-hidden="true">
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
                </div>
            </nav>

            <button id="menuBtn" type="button" class="inline-flex items-center rounded-lg border border-slate-200 p-2 text-brand-dark lg:hidden" aria-label="Ouvrir le menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <div id="mobileMenu" class="hidden border-t-4 border-brand-blue bg-white lg:hidden">
            <div class="mx-auto flex max-w-7xl flex-col gap-1 px-4 py-3 sm:px-6">
                <a href="#top" class="rounded-lg px-3 py-2 font-semibold hover:bg-slate-50">Acceuil</a>
                <a href="#services" class="rounded-lg px-3 py-2 font-semibold hover:bg-slate-50">nos services</a>
                <a href="#franchise" class="rounded-lg px-3 py-2 font-semibold hover:bg-slate-50">agences</a>
                <a href="#realisations" class="rounded-lg px-3 py-2 font-semibold hover:bg-slate-50">nos realisation</a>
                <a href="#devis" class="mt-2 inline-flex w-full items-center justify-center rounded-xl bg-brand-blue px-4 py-3 text-sm font-extrabold text-white shadow-soft">Nous contacter</a>
                <div class="mt-2 flex items-center gap-2">
                    <a href="#" aria-label="Facebook" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#1877F2] text-white shadow-soft transition hover:opacity-90">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" aria-label="LinkedIn" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#0A66C2] text-white shadow-soft transition hover:opacity-90">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    <a href="#" aria-label="Instagram" class="inline-flex h-9 w-9 items-center justify-center rounded-full shadow-soft ring-2 ring-slate-200 transition hover:opacity-90">
                        <svg class="h-9 w-9" viewBox="0 0 24 24" aria-hidden="true">
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
                </div>
            </div>
        </div>
    </header>

    <section id="top" class="relative min-h-[540px] overflow-hidden sm:min-h-[620px]">
        <div id="heroBg" class="absolute inset-0 bg-cover bg-center transition-all duration-500" style="background-image:linear-gradient(110deg, rgba(47,66,81,.74), rgba(47,66,81,.32)), url('https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=1600&q=80')"></div>
        <div class="relative z-10 mx-auto flex min-h-[540px] max-w-7xl flex-col justify-end gap-5 px-4 py-8 sm:min-h-[620px] sm:px-6 lg:flex-row lg:items-end lg:justify-between lg:px-8">
            <div class="max-w-3xl text-white">
                <h1 id="heroTitle" class="mb-3 text-4xl font-extrabold leading-[1.03] tracking-tight sm:text-5xl lg:text-6xl">Travaux de toiture durables et performants</h1>
                <p id="heroSubtitle" class="mb-5 text-lg text-slate-100 sm:text-xl">Protection, etancheite et renovation complete de votre toiture pour valoriser votre maison.</p>
                <div class="flex flex-wrap gap-3">
                    <a id="heroPrimaryCta" href="#devis" class="rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:-translate-y-0.5 hover:bg-sky-500">Devis toiture</a>
                    <a id="heroSecondaryCta" href="#devis" class="rounded-xl bg-brand-yellow px-5 py-3 text-sm font-extrabold text-brand-dark shadow-soft transition hover:-translate-y-0.5 hover:bg-yellow-300">Nous contacter</a>
                </div>
            </div>

            <div id="heroThumbs" class="flex w-full gap-2 pb-1 lg:w-auto">
                <button class="hero-thumb h-20 min-w-0 flex-1 rounded-xl border-2 border-brand-blue bg-cover bg-center shadow-soft lg:h-24 lg:w-32 lg:flex-none" data-bg="1" style="background-image:url('https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=600&q=80')" aria-label="Slider travaux de toiture"></button>
                <button class="hero-thumb h-20 min-w-0 flex-1 rounded-xl border-2 border-transparent bg-cover bg-center shadow-soft lg:h-24 lg:w-32 lg:flex-none" data-bg="2" style="background-image:url('https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=600&q=80')" aria-label="Slider simulateur de devis"></button>
                <button class="hero-thumb h-20 min-w-0 flex-1 rounded-xl border-2 border-transparent bg-cover bg-center shadow-soft lg:h-24 lg:w-32 lg:flex-none" data-bg="3" style="background-image:url('https://images.unsplash.com/photo-1509391366360-2e959784a276?auto=format&fit=crop&w=600&q=80')" aria-label="Slider photovoltaique"></button>
            </div>
        </div>
    </section>

    <section class="border-b border-yellow-300 bg-[#FADF70] py-8 sm:py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <form class="grid gap-3 rounded-2xl border-2 border-white bg-white p-4 shadow-soft ring-2 ring-white/70 sm:grid-cols-[1fr_auto] sm:items-end sm:gap-4 sm:p-5">
                <div>
                    <label for="address" class="mb-2 block text-sm font-extrabold text-brand-dark">Entrez votre adresse (simulateur)</label>
                    <input id="address" type="text" placeholder="Ex: 6 rue Pierre de Coubertin, Chalon-sur-Saone" class="w-full rounded-xl border-2 border-brand-blue bg-white px-4 py-3 text-sm text-brand-dark outline-none transition placeholder:text-slate-500 focus:border-brand-dark">
                </div>
                <button type="button" class="rounded-xl bg-brand-blue px-6 py-3 text-sm font-extrabold text-white transition hover:bg-brand-dark">Lancer le simulateur</button>
            </form>
        </div>
    </section>

    <aside class="fixed bottom-4 left-4 z-40 rounded-xl border border-brand-blue/30 bg-white px-3 py-2 shadow-soft xl:hidden">
        <a href="https://share.google/14Nu70a8PfwWT4P4p" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2">
            <img src="/iconne.png" alt="Icone Normes & Renovation" class="h-7 w-7 rounded-full border border-brand-blue/40 bg-white object-cover">
            <div>
                <p class="text-[11px] font-extrabold leading-none text-brand-dark">5.0/5 Avis Google</p>
                <p class="text-[10px] leading-none text-yellow-500">★★★★★ <span class="text-slate-600">+100 avis</span></p>
            </div>
        </a>
    </aside>

    <aside class="fixed left-0 top-1/2 z-40 hidden w-32 -translate-y-1/2 rounded-r-2xl bg-gradient-to-b from-brand-blue to-brand-dark px-4 py-6 text-white shadow-soft xl:block" style="animation: avisFloat 4s ease-in-out infinite;">
        <a href="https://share.google/14Nu70a8PfwWT4P4p" target="_blank" rel="noopener noreferrer" class="block">
            <img src="/iconne.png" alt="Icone Normes & Renovation" class="h-10 w-10 rounded-full border border-white/50 bg-white object-cover">
            <p class="mt-3 text-[11px] font-bold uppercase tracking-wider text-white/80">Avis Google</p>
            <div class="mt-2 text-3xl font-extrabold">5.0/5</div>
            <div class="text-sm text-brand-yellow">★★★★★</div>
            <p class="mt-3 text-[12px] leading-tight text-white/90">Plus de 100 avis clients</p>
        </a>
    </aside>

    <section id="services" class="bg-slate-50/70 py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="mb-3 text-4xl font-extrabold leading-tight text-brand-dark sm:text-5xl"><span class="text-brand-blue">Nos services</span> de renovation</h2>
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
                <article data-category="toiture" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1632759145351-1d592ac9b238?auto=format&fit=crop&w=1000&q=80" alt="Toiture couverture" class="h-44 w-full object-cover"><div class="flex h-full flex-col p-5"><h3 class="mb-2 text-lg font-bold">Toiture & couverture</h3><p class="text-sm text-slate-600">Renovation de toiture, etancheite et protection durable de votre maison.</p><a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a></div></article>
                <article data-category="toiture" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1628744448840-55bdb2497bd4?auto=format&fit=crop&w=1000&q=80" alt="Zinguerie" class="h-44 w-full object-cover"><div class="flex h-full flex-col p-5"><h3 class="mb-2 text-lg font-bold">Zinguerie</h3><p class="text-sm text-slate-600">Gestion des eaux pluviales, gouttieres et finitions toiture haute qualite.</p><a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a></div></article>
                <article data-category="isolation" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1581094271901-8022df4466f9?auto=format&fit=crop&w=1000&q=80" alt="Isolation thermique" class="h-44 w-full object-cover"><div class="flex h-full flex-col p-5"><h3 class="mb-2 text-lg font-bold">Isolation thermique</h3><p class="text-sm text-slate-600">Isolation des combles, murs et planchers pour limiter les pertes d'energie.</p><a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a></div></article>
                <article data-category="isolation" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=1000&q=80" alt="Ravalement facade" class="h-44 w-full object-cover"><div class="flex h-full flex-col p-5"><h3 class="mb-2 text-lg font-bold">Facade & ravalement</h3><p class="text-sm text-slate-600">Traitements et finitions facade pour proteger et valoriser votre bien.</p><a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a></div></article>
                <article data-category="isolation air" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1000&q=80" alt="Traitement humidite" class="h-44 w-full object-cover"><div class="flex h-full flex-col p-5"><h3 class="mb-2 text-lg font-bold">Traitement de l'humidite</h3><p class="text-sm text-slate-600">Solutions anti-humidite pour un habitat sain, durable et confortable.</p><a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a></div></article>
                <article data-category="air" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?auto=format&fit=crop&w=1000&q=80" alt="Ventilation" class="h-44 w-full object-cover"><div class="flex h-full flex-col p-5"><h3 class="mb-2 text-lg font-bold">Ventilation</h3><p class="text-sm text-slate-600">VMC simple et double flux pour une qualite d'air optimale au quotidien.</p><a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a></div></article>
                <article data-category="electricite" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1621905252507-b35492cc74b4?auto=format&fit=crop&w=1000&q=80" alt="Electricite" class="h-44 w-full object-cover"><div class="flex h-full flex-col p-5"><h3 class="mb-2 text-lg font-bold">Mise aux normes electriques</h3><p class="text-sm text-slate-600">Securisation complete du reseau electrique selon les normes en vigueur.</p><a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a></div></article>
                <article data-category="electricite energie" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1466611653911-95081537e5b7?auto=format&fit=crop&w=1000&q=80" alt="Photovoltaique" class="h-44 w-full object-cover"><div class="flex h-full flex-col p-5"><h3 class="mb-2 text-lg font-bold">Photovoltaique</h3><p class="text-sm text-slate-600">Panneaux solaires pour produire votre electricite et reduire vos factures.</p><a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a></div></article>
                <article data-category="air energie" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1000&q=80" alt="Pompe a chaleur" class="h-44 w-full object-cover"><div class="flex h-full flex-col p-5"><h3 class="mb-2 text-lg font-bold">Pompe a chaleur</h3><p class="text-sm text-slate-600">Performance energetique elevee pour chauffer et rafraichir votre maison.</p><a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a></div></article>
                <article data-category="air" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1556911220-bff31c812dba?auto=format&fit=crop&w=1000&q=80" alt="Climatisation" class="h-44 w-full object-cover"><div class="flex h-full flex-col p-5"><h3 class="mb-2 text-lg font-bold">Climatisation</h3><p class="text-sm text-slate-600">Confort ete/hiver avec systemes de climatisation economes et silencieux.</p><a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a></div></article>
                <article data-category="isolation toiture" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1523419409543-a5e549c1f4f5?auto=format&fit=crop&w=1000&q=80" alt="Isolation combles" class="h-44 w-full object-cover"><div class="flex h-full flex-col p-5"><h3 class="mb-2 text-lg font-bold">Isolation des combles</h3><p class="text-sm text-slate-600">L'un des leviers les plus efficaces pour baisser vos depenses energetiques.</p><a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a></div></article>
                <article data-category="electricite energie" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1"><img src="https://images.unsplash.com/photo-1584277261846-c6a1672ed979?auto=format&fit=crop&w=1000&q=80" alt="Borne de recharge" class="h-44 w-full object-cover"><div class="flex h-full flex-col p-5"><h3 class="mb-2 text-lg font-bold">Borne de recharge</h3><p class="text-sm text-slate-600">Installation de bornes pour vehicules electriques a domicile ou en entreprise.</p><a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a></div></article>
            </div>
        </div>
    </section>

    <section id="realisations" class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-2 lg:items-stretch">
                <div class="flex min-h-0 flex-col lg:min-h-[560px]">
                    <h2 class="mb-3 text-4xl font-extrabold leading-tight text-brand-dark sm:text-5xl"><span class="text-brand-blue">Avant</span> / Apres</h2>
                    <p class="mb-5 text-base text-slate-600 sm:text-lg">Comparez plusieurs chantiers et voyez l'impact concret de nos renovations.</p>
                    <div class="mb-4 flex flex-wrap gap-2">
                        <button type="button" data-ba-case="1" class="ba-case-btn rounded-full bg-brand-dark px-4 py-2 text-xs font-bold uppercase tracking-wide text-white sm:text-sm">Toiture</button>
                        <button type="button" data-ba-case="2" class="ba-case-btn rounded-full border border-slate-300 bg-white px-4 py-2 text-xs font-bold uppercase tracking-wide text-slate-700 sm:text-sm">Facade</button>
                        <button type="button" data-ba-case="3" class="ba-case-btn rounded-full border border-slate-300 bg-white px-4 py-2 text-xs font-bold uppercase tracking-wide text-slate-700 sm:text-sm">Isolation</button>
                    </div>
                    <div class="flex min-h-0 flex-1 flex-col gap-4">
                        <div class="flex min-h-0 flex-1 flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft">
                            <div class="relative min-h-[260px] flex-1 bg-slate-200 sm:min-h-[320px] lg:min-h-0">
                                <div id="beforeLayer" class="absolute inset-0 bg-cover bg-center" style="background-image:url('https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=1400&q=80')"></div>
                                <div id="afterLayer" class="absolute inset-0 bg-cover bg-center" style="clip-path: inset(0 0 0 50%); background-image:url('https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&w=1400&q=80')"></div>
                            </div>
                            <input id="baRange" type="range" min="0" max="100" value="50" class="w-full shrink-0 accent-brand-blue">
                            <div class="flex shrink-0 items-center justify-between bg-slate-50 px-4 py-3 text-xs font-bold uppercase tracking-wide text-slate-600 sm:text-sm"><span>Avant</span><span>Apres</span></div>
                        </div>
                    <a href="#realisations" class="group relative mt-0 block shrink-0 overflow-hidden rounded-2xl border border-slate-200 shadow-soft">
                        <div class="absolute inset-0 bg-cover bg-center transition duration-300 group-hover:scale-105" style="background-image:url('https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=1400&q=80')"></div>
                        <div class="relative bg-gradient-to-r from-brand-dark/85 to-brand-dark/55 px-5 py-5">
                            <p class="text-xs font-bold uppercase tracking-wide text-brand-yellow">Realisations</p>
                            <h3 class="text-xl font-extrabold text-white">Voir toutes nos realisations</h3>
                            <p class="mt-1 text-sm text-slate-200">Decouvrez nos chantiers avant/apres et les transformations deja realisees pour nos clients.</p>
                            <span class="mt-3 inline-flex rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition group-hover:bg-sky-500">Explorer les realisations</span>
                        </div>
                    </a>
                    </div>
                </div>

                <aside class="flex min-h-0 flex-col rounded-2xl border border-white/25 bg-brand-blue p-6 shadow-soft lg:min-h-[560px]">
                    <h2 class="mb-3 text-4xl font-extrabold leading-tight sm:text-5xl"><span class="text-brand-yellow">A propos de</span> <span class="text-brand-dark">Normes & Renovation</span></h2>
                    <p class="mb-5 text-base leading-relaxed text-white sm:text-lg">Normes & Renovation accompagne les particuliers et professionnels dans leurs projets de renovation energetique, thermique et electrique. Notre equipe combine expertise technique, suivi de chantier et conseils sur-mesure pour des resultats fiables et durables. Nous sommes certifies RGE, engages dans le respect de l'environnement et nous privilegions des materiaux de qualite pour des renovations performantes et responsables.</p>
                    <ul class="mb-5 space-y-2 text-base text-white">
                        <li class="flex items-start gap-2"><span class="mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-dark text-xs font-black text-brand-yellow">✓</span><span>Profitez de notre garantie sur les travaux realises</span></li>
                        <li class="flex items-start gap-2"><span class="mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-dark text-xs font-black text-brand-yellow">✓</span><span>Nous nous occupons de tout pour vous simplifier la vie</span></li>
                        <li class="flex items-start gap-2"><span class="mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-dark text-xs font-black text-brand-yellow">✓</span><span>Tous nos Techniciens sont qualifies & formes en continus</span></li>
                        <li class="flex items-start gap-2"><span class="mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-dark text-xs font-black text-brand-yellow">✓</span><span>Entreprise certifiee et orientee qualite</span></li>
                        <li class="flex items-start gap-2"><span class="mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-dark text-xs font-black text-brand-yellow">✓</span><span>Accompagnement complet de l'etude a la livraison</span></li>
                        <li class="flex items-start gap-2"><span class="mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-dark text-xs font-black text-brand-yellow">✓</span><span>Solutions performantes pour valoriser votre bien</span></li>
                    </ul>
                    <div class="mb-5 grid grid-cols-1 gap-3 sm:grid-cols-3">
                        <div class="rounded-xl border border-white/30 bg-white p-2 shadow-sm">
                            <img src="/nous/rge.png" alt="Logo RGE Qualibat" class="h-20 w-full rounded-lg object-contain sm:h-24">
                        </div>
                        <div class="rounded-xl border border-white/30 bg-white p-2 shadow-sm">
                            <img src="/nous/rge ventilation_.png" alt="Logo RGE Ventilation" class="h-20 w-full rounded-lg object-contain sm:h-24">
                        </div>
                        <div class="rounded-xl border border-white/30 bg-white p-2 shadow-sm">
                            <img src="/nous/ECO.png" alt="Logo Eco Responsable" class="h-20 w-full rounded-lg object-contain sm:h-24">
                        </div>
                    </div>
                    <div class="mt-auto overflow-hidden rounded-xl border border-white/30 shadow-sm">
                        <img src="/nous/equipe.jpeg" alt="Equipe Normes & Renovation" class="h-48 w-full object-cover sm:h-56">
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <section id="agences" class="bg-slate-50/70 py-16 sm:py-20">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-[.95fr_1.05fr] lg:items-start lg:px-8">
            <div>
                <h2 class="mb-3 text-4xl font-extrabold text-brand-dark sm:text-5xl"><span class="text-brand-blue">Nos</span> agences</h2>
                <p class="mb-6 text-base text-slate-600 sm:text-lg">Retrouvez nos 2 agences principales et les departements mis en avant sur la carte.</p>
                <div class="space-y-3">
                    <article class="rounded-xl border border-slate-200 bg-white p-4">
                        <p class="text-xs font-bold uppercase tracking-wide text-brand-blue">Departement 71</p>
                        <h3 class="text-lg font-extrabold text-brand-dark">Agence Chalon-sur-Saone</h3>
                        <p class="text-sm text-slate-600">6 rue Pierre de Coubertin, 71100 Chalon-sur-Saone</p>
                        <p class="mt-1 text-sm font-semibold text-brand-dark">Tel: 03 85 41 98 86</p>
                    </article>
                    <article class="rounded-xl border border-slate-200 bg-white p-4">
                        <p class="text-xs font-bold uppercase tracking-wide text-brand-blue">Departement 22 - Bretagne</p>
                        <h3 class="text-lg font-extrabold text-brand-dark">Agence Bretagne</h3>
                        <p class="text-sm text-slate-600">ZA de Mikez - 22540 Pedernec</p>
                        <p class="mt-1 text-sm font-semibold text-brand-dark">Tel: 02 96 40 07 55</p>
                    </article>
                </div>
                <a href="#franchise" class="group relative mt-5 hidden overflow-hidden rounded-xl border border-slate-200 shadow-soft lg:block">
                    <div class="absolute inset-0 bg-cover bg-center transition duration-300 group-hover:scale-105" style="background-image:url('https://images.unsplash.com/photo-1556155092-490a1ba16284?auto=format&fit=crop&w=1200&q=80')"></div>
                    <div class="relative bg-gradient-to-r from-brand-dark/85 to-brand-dark/55 px-4 py-4">
                        <p class="text-xs font-bold uppercase tracking-wide text-brand-yellow">Reseau Normes</p>
                        <h3 class="text-lg font-extrabold text-white">Devenir franchiser</h3>
                        <p class="mt-1 text-xs text-slate-200">Rejoignez notre reseau et developpez votre agence avec un accompagnement complet.</p>
                    </div>
                </a>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-soft sm:p-6">
                <h2 class="mb-3 text-4xl font-extrabold text-brand-dark sm:text-5xl"><span class="text-brand-blue">Carte</span> des implantations</h2>
                <div id="agencyMap" class="min-h-[380px] rounded-xl border border-slate-200"></div>
                <div class="mt-3 flex flex-wrap gap-2 text-xs font-semibold">
                    <span class="inline-flex items-center gap-1 rounded-full bg-brand-blue/20 px-3 py-1 text-brand-dark"><span class="h-2 w-2 rounded-full bg-brand-blue"></span>Region Bretagne</span>
                    <span class="inline-flex items-center gap-1 rounded-full bg-brand-yellow/70 px-3 py-1 text-brand-dark"><span class="h-2 w-2 rounded-full bg-brand-yellow"></span>Departements 71 & 21</span>
                </div>
            </div>
            <a href="#franchise" class="group relative block overflow-hidden rounded-xl border border-slate-200 shadow-soft lg:hidden">
                <div class="absolute inset-0 bg-cover bg-center transition duration-300 group-hover:scale-105" style="background-image:url('https://images.unsplash.com/photo-1556155092-490a1ba16284?auto=format&fit=crop&w=1200&q=80')"></div>
                <div class="relative bg-gradient-to-r from-brand-dark/85 to-brand-dark/55 px-4 py-4">
                    <p class="text-xs font-bold uppercase tracking-wide text-brand-yellow">Reseau Normes</p>
                    <h3 class="text-lg font-extrabold text-white">Devenir franchiser</h3>
                    <p class="mt-1 text-xs text-slate-200">Rejoignez notre reseau et developpez votre agence avec un accompagnement complet.</p>
                </div>
            </a>
        </div>
    </section>

    <section class="bg-slate-50/70 py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="mb-2 text-4xl font-extrabold leading-tight text-brand-dark sm:text-5xl"><span class="text-brand-blue">Pourquoi</span> nous ?</h2>
            <p class="mb-8 max-w-2xl text-base text-slate-600 sm:text-lg">Des engagements concrets, visibles en un coup d'œil.</p>
            <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
                <article class="group relative flex flex-col overflow-hidden rounded-2xl border-2 border-brand-blue/35 bg-gradient-to-br from-brand-blue/20 via-white to-white p-6 shadow-soft transition duration-300 hover:-translate-y-1 hover:border-brand-blue/60 hover:shadow-lg">
                    <div class="pointer-events-none absolute -right-6 -top-6 h-24 w-24 rounded-full bg-brand-blue/15 transition group-hover:bg-brand-blue/25"></div>
                    <div class="relative mb-4 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-blue text-2xl shadow-md shadow-brand-blue/25">🛠️</div>
                    <h3 class="relative mb-2 text-lg font-extrabold text-brand-dark">Expertise technique</h3>
                    <p class="relative text-sm leading-relaxed text-slate-700 sm:text-base">Des equipes qualifiees et des conseils adaptes a votre maison.</p>
                </article>
                <article class="group relative flex flex-col overflow-hidden rounded-2xl border-2 border-brand-yellow/50 bg-gradient-to-br from-brand-yellow/25 via-white to-amber-50/40 p-6 shadow-soft transition duration-300 hover:-translate-y-1 hover:border-brand-yellow hover:shadow-lg">
                    <div class="pointer-events-none absolute -right-6 -top-6 h-24 w-24 rounded-full bg-brand-yellow/20 transition group-hover:bg-brand-yellow/35"></div>
                    <div class="relative mb-4 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-dark text-2xl text-brand-yellow shadow-md">✅</div>
                    <h3 class="relative mb-2 text-lg font-extrabold text-brand-dark">Entreprise certifiee RGE</h3>
                    <p class="relative text-sm leading-relaxed text-slate-700 sm:text-base">Un accompagnement conforme aux normes et aides en vigueur.</p>
                </article>
                <article class="group relative flex flex-col overflow-hidden rounded-2xl border-2 border-brand-dark/25 bg-gradient-to-br from-brand-dark/10 via-white to-emerald-50/30 p-6 shadow-soft transition duration-300 hover:-translate-y-1 hover:border-brand-dark/45 hover:shadow-lg">
                    <div class="pointer-events-none absolute -right-6 -top-6 h-24 w-24 rounded-full bg-emerald-500/10 transition group-hover:bg-emerald-500/15"></div>
                    <div class="relative mb-4 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-dark text-2xl text-white shadow-md">🌿</div>
                    <h3 class="relative mb-2 text-lg font-extrabold text-brand-dark">Solutions durables</h3>
                    <p class="relative text-sm leading-relaxed text-slate-700 sm:text-base">Des choix techniques performants pour un impact long terme.</p>
                </article>
                <article class="group relative flex flex-col overflow-hidden rounded-2xl border-2 border-brand-blue/25 bg-gradient-to-br from-brand-yellow/15 via-white to-brand-blue/15 p-6 shadow-soft transition duration-300 hover:-translate-y-1 hover:border-brand-dark/30 hover:shadow-lg">
                    <div class="pointer-events-none absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-brand-blue via-brand-yellow to-brand-dark"></div>
                    <div class="relative mb-4 mt-1 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-blue to-sky-500 text-2xl text-white shadow-md">🤝</div>
                    <h3 class="relative mb-2 text-lg font-extrabold text-brand-dark">Accompagnement complet</h3>
                    <p class="relative text-sm leading-relaxed text-slate-700 sm:text-base">Un interlocuteur unique du devis jusqu'a la fin de chantier.</p>
                </article>
            </div>

            <div class="mt-12 overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-6 shadow-soft sm:p-8">
                <h2 class="mb-2 text-4xl font-extrabold leading-tight text-brand-dark sm:text-5xl"><span class="text-brand-blue">Processus</span> de prise en charge</h2>
                <p class="mb-8 max-w-3xl text-base text-slate-600 sm:text-lg">Quatre etapes claires, de l'estimation de vos aides au suivi de chantier.</p>
                <div class="grid gap-5 md:grid-cols-2">
                    <article class="relative flex flex-col rounded-2xl border-l-4 border-brand-blue bg-gradient-to-r from-brand-blue/12 to-white p-5 pl-6 shadow-sm transition hover:shadow-md sm:p-6">
                        <span class="mb-3 inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-blue text-sm font-black text-white shadow-md shadow-brand-blue/30">1</span>
                        <h4 class="text-lg font-extrabold text-brand-dark">Calcul de Primes et Devis precis</h4>
                        <p class="mt-2 text-sm leading-relaxed text-slate-700 sm:text-base">Nous nous occupons de tout le calcul de vos primes, des CEE (Certificats d'Economies d'Energie) et des differentes options de financement disponibles. Profitez de travaux couverts jusqu'a 90 % sans avance de frais.</p>
                    </article>
                    <article class="relative flex flex-col rounded-2xl border-l-4 border-brand-yellow bg-gradient-to-r from-brand-yellow/20 to-white p-5 pl-6 shadow-sm transition hover:shadow-md sm:p-6">
                        <span class="mb-3 inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-dark text-sm font-black text-brand-yellow shadow-md">2</span>
                        <h4 class="text-lg font-extrabold text-brand-dark">Solutions de Financement</h4>
                        <p class="mt-2 text-sm leading-relaxed text-slate-700 sm:text-base">Nous proposons des solutions de financement adaptees grace a nos partenaires, pour vous aider a gerer le cout parfois eleve des travaux de renovation.</p>
                    </article>
                    <article class="relative flex flex-col rounded-2xl border-l-4 border-brand-dark bg-gradient-to-r from-brand-dark/12 to-white p-5 pl-6 shadow-sm transition hover:shadow-md sm:p-6">
                        <span class="mb-3 inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-dark text-sm font-black text-white shadow-md">3</span>
                        <h4 class="text-lg font-extrabold text-brand-dark">Analyse Personnalisee</h4>
                        <p class="mt-2 text-sm leading-relaxed text-slate-700 sm:text-base">Un technicien qualifie se deplace gratuitement pour realiser un diagnostic approfondi et personnalise de vos besoins.</p>
                    </article>
                    <article class="relative flex flex-col rounded-2xl border-l-4 border-sky-500 bg-gradient-to-r from-sky-500/10 via-brand-blue/8 to-white p-5 pl-6 shadow-sm transition hover:shadow-md sm:p-6">
                        <span class="mb-3 inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-brand-blue to-sky-600 text-sm font-black text-white shadow-md">4</span>
                        <h4 class="text-lg font-extrabold text-brand-dark">Suivi et Assistance Continus</h4>
                        <p class="mt-2 text-sm leading-relaxed text-slate-700 sm:text-base">De la premiere consultation a la finalisation des travaux, nous vous accompagnons a chaque etape. Vous beneficiez d'un suivi regulier et d'une assistance dediee pour garantir que vos travaux se deroulent en toute serenite.</p>
                    </article>
                </div>
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
            <h2 class="mb-3 text-4xl font-extrabold text-brand-dark sm:text-5xl"><span class="text-brand-blue">Avis</span> clients</h2>
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
                <h2 class="mb-3 text-4xl font-extrabold leading-tight text-white sm:text-5xl"><span class="text-brand-yellow">Vous avez</span> un projet de renovation ?</h2>
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
            <h2 class="mb-3 text-4xl font-extrabold text-brand-dark sm:text-5xl"><span class="text-brand-blue">Bonus</span></h2>
            <div class="grid gap-4 lg:grid-cols-3">
                <article class="rounded-xl border border-slate-100 bg-white p-5"><h3 class="mb-2 text-xl font-bold">Simulateur de devis</h3><p class="text-slate-600">Un parcours simple pour qualifier rapidement votre projet.</p></article>
                <article class="rounded-xl border border-slate-100 bg-white p-5"><h3 class="mb-2 text-xl font-bold">Page realisations</h3><p class="text-slate-600">Mise en avant des chantiers avant/apres pour rassurer.</p></article>
                <article class="rounded-xl border border-slate-100 bg-white p-5"><h3 class="mb-2 text-xl font-bold">Blog SEO 2026</h3><p class="text-slate-600">Contenus sur les aides, l'isolation et les economies d'energie.</p></article>
            </div>
        </div>
    </section>

    <footer class="border-t-4 border-brand-blue bg-brand-dark py-10 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="mb-2 text-4xl font-extrabold text-white sm:text-5xl">Normes & Renovation</h2>
            <p class="text-slate-300">6 rue Pierre de Coubertin, 71100 Chalon-sur-Saone</p>
            <p class="text-slate-300">03 85 41 98 86</p>
            <p class="text-slate-300">bourgogne-agence@normesrenovation.fr</p>
            <div class="mt-5 flex flex-wrap items-center gap-2">
                <a href="#" aria-label="Facebook" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#1877F2] text-white shadow-soft transition hover:opacity-90">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                <a href="#" aria-label="LinkedIn" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#0A66C2] text-white shadow-soft transition hover:opacity-90">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                </a>
                <a href="#" aria-label="Instagram" class="inline-flex h-10 w-10 items-center justify-center rounded-full shadow-soft ring-2 ring-white/25 transition hover:opacity-90">
                    <svg class="h-10 w-10" viewBox="0 0 24 24" aria-hidden="true">
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
            </div>
        </div>
    </footer>

    <a href="tel:+33385419886" class="fixed bottom-4 right-4 z-50 inline-flex h-14 w-14 items-center justify-center rounded-full bg-brand-blue text-white shadow-soft transition hover:scale-105 hover:bg-brand-dark lg:hidden animate-pulse" aria-label="Appeler">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5.25a2.25 2.25 0 012.25-2.25h2.1a2.25 2.25 0 012.214 1.848l.42 2.52a2.25 2.25 0 01-1.184 2.355l-1.34.67a16.521 16.521 0 006.246 6.246l.67-1.34a2.25 2.25 0 012.355-1.184l2.52.42A2.25 2.25 0 0121 16.65v2.1A2.25 2.25 0 0118.75 21h-.75C9.716 21 3 14.284 3 6v-.75z" />
        </svg>
    </a>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
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
            const heroTitle = document.getElementById('heroTitle');
            const heroSubtitle = document.getElementById('heroSubtitle');
            const heroPrimaryCta = document.getElementById('heroPrimaryCta');
            const heroSecondaryCta = document.getElementById('heroSecondaryCta');
            const thumbs = Array.from(document.querySelectorAll('.hero-thumb'));
            const slides = {
                1: {
                    bg: "linear-gradient(110deg, rgba(47,66,81,.74), rgba(47,66,81,.32)), url('https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=1600&q=80')",
                    title: "Travaux de toiture durables et performants",
                    subtitle: "Protection, etancheite et renovation complete de votre toiture pour valoriser votre maison.",
                    primaryText: "Devis toiture",
                    primaryHref: "#devis",
                    secondaryText: "Nous contacter",
                    secondaryHref: "#devis"
                },
                2: {
                    bg: "linear-gradient(110deg, rgba(47,66,81,.74), rgba(47,66,81,.32)), url('https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=1600&q=80')",
                    title: "Simulateur de devis renovation en 1 minute",
                    subtitle: "Entrez votre adresse et obtenez rapidement une estimation claire pour votre projet.",
                    primaryText: "Lancer le simulateur",
                    primaryHref: "#address",
                    secondaryText: "Parler a un conseiller",
                    secondaryHref: "#devis"
                },
                3: {
                    bg: "linear-gradient(110deg, rgba(47,66,81,.74), rgba(47,66,81,.32)), url('https://images.unsplash.com/photo-1509391366360-2e959784a276?auto=format&fit=crop&w=1600&q=80')",
                    title: "Photovoltaique: produisez votre propre energie",
                    subtitle: "Installez des panneaux solaires performants et reduisez durablement vos factures.",
                    primaryText: "Etude photovoltaique",
                    primaryHref: "#services",
                    secondaryText: "Nous contacter",
                    secondaryHref: "#devis"
                }
            };

            const applySlide = (slideId) => {
                const slide = slides[slideId];
                if (!slide || !hero) {
                    return;
                }
                hero.style.backgroundImage = slide.bg;
                if (heroTitle) heroTitle.textContent = slide.title;
                if (heroSubtitle) heroSubtitle.textContent = slide.subtitle;
                if (heroPrimaryCta) {
                    heroPrimaryCta.textContent = slide.primaryText;
                    heroPrimaryCta.setAttribute('href', slide.primaryHref);
                }
                if (heroSecondaryCta) {
                    heroSecondaryCta.textContent = slide.secondaryText;
                    heroSecondaryCta.setAttribute('href', slide.secondaryHref);
                }
            };

            let currentHeroSlide = 1;
            let heroAutoplay = null;
            const setHeroSlide = (slideId) => {
                currentHeroSlide = Number(slideId);
                applySlide(String(currentHeroSlide));
                thumbs.forEach((t) => t.classList.remove('border-brand-blue'));
                const activeThumb = thumbs.find((t) => Number(t.dataset.bg) === currentHeroSlide);
                if (activeThumb) {
                    activeThumb.classList.add('border-brand-blue');
                }
            };
            const startHeroAutoplay = () => {
                if (heroAutoplay) {
                    return;
                }
                heroAutoplay = setInterval(() => {
                    const nextSlide = currentHeroSlide >= 3 ? 1 : currentHeroSlide + 1;
                    setHeroSlide(nextSlide);
                }, 4500);
            };
            const stopHeroAutoplay = () => {
                if (heroAutoplay) {
                    clearInterval(heroAutoplay);
                    heroAutoplay = null;
                }
            };

            thumbs.forEach((thumb) => {
                thumb.addEventListener('click', () => {
                    setHeroSlide(thumb.dataset.bg);
                });
            });
            const heroSection = document.getElementById('top');
            if (heroSection) {
                heroSection.addEventListener('mouseenter', stopHeroAutoplay);
                heroSection.addEventListener('mouseleave', startHeroAutoplay);
            }
            setHeroSlide(1);
            startHeroAutoplay();

            const range = document.getElementById('baRange');
            const beforeLayer = document.getElementById('beforeLayer');
            const afterLayer = document.getElementById('afterLayer');
            if (range && afterLayer) {
                range.addEventListener('input', () => {
                    afterLayer.style.clipPath = `inset(0 0 0 ${Number(range.value)}%)`;
                });
            }

            const baCases = {
                1: {
                    before: "url('https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=1400&q=80')",
                    after: "url('https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&w=1400&q=80')"
                },
                2: {
                    before: "url('https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&w=1400&q=80')",
                    after: "url('https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=1400&q=80')"
                },
                3: {
                    before: "url('https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=1400&q=80')",
                    after: "url('https://images.unsplash.com/photo-1581094271901-8022df4466f9?auto=format&fit=crop&w=1400&q=80')"
                }
            };
            const baCaseButtons = Array.from(document.querySelectorAll('.ba-case-btn'));
            const applyBeforeAfterCase = (caseId) => {
                const selectedCase = baCases[caseId];
                if (!selectedCase || !beforeLayer || !afterLayer) {
                    return;
                }
                beforeLayer.style.backgroundImage = selectedCase.before;
                afterLayer.style.backgroundImage = selectedCase.after;
            };
            baCaseButtons.forEach((btn) => {
                btn.addEventListener('click', () => {
                    baCaseButtons.forEach((item) => {
                        item.classList.remove('bg-brand-dark', 'text-white', 'border-brand-dark');
                        item.classList.add('bg-white', 'text-slate-700', 'border-slate-300');
                    });
                    btn.classList.remove('bg-white', 'text-slate-700', 'border-slate-300');
                    btn.classList.add('bg-brand-dark', 'text-white', 'border-brand-dark');
                    applyBeforeAfterCase(btn.dataset.baCase);
                });
            });
            applyBeforeAfterCase('1');

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

            const serviceCtas = Array.from(document.querySelectorAll('#serviceGrid .service-card a'));
            serviceCtas.forEach((link) => {
                link.className = 'mt-4 inline-flex w-fit items-center gap-1 text-sm font-extrabold text-brand-blue transition hover:text-brand-dark';
                link.innerHTML = 'En savoir plus <span aria-hidden="true">→</span>';
            });

            const mapContainer = document.getElementById('agencyMap');
            if (mapContainer && typeof L !== 'undefined') {
                const map = L.map('agencyMap', {
                    scrollWheelZoom: false,
                    zoomControl: false,
                    attributionControl: false
                }).setView([46.8, 2.2], 6);

                const locations = [
                    { name: 'Agence 71 - Chalon-sur-Saone', coords: [46.781, 4.853], tag: '71' },
                    { name: 'Agence Bretagne - Pedernec', coords: [48.595, -3.286], tag: '22' }
                ];

                const basePane = map.createPane('regionsPane');
                basePane.style.zIndex = 300;
                const depPane = map.createPane('departementsPane');
                depPane.style.zIndex = 400;
                const markerPane = map.createPane('markersPane');
                markerPane.style.zIndex = 500;

                const isMetropolitan = (feature) => {
                    const code = feature?.properties?.code || '';
                    return !code.startsWith('97') && code !== '976';
                };

                const fetchGeoJsonWithFallback = async (urls) => {
                    for (const url of urls) {
                        try {
                            const response = await fetch(url);
                            if (response.ok) {
                                return await response.json();
                            }
                        } catch (error) {
                            // Try next source.
                        }
                    }
                    throw new Error('GeoJSON loading failed');
                };

                Promise.all([
                    fetchGeoJsonWithFallback([
                        'https://france-geojson.gregoiredavid.fr/repo/regions.geojson',
                        'https://raw.githubusercontent.com/gregoiredavid/france-geojson/master/regions.geojson'
                    ]),
                    fetchGeoJsonWithFallback([
                        'https://france-geojson.gregoiredavid.fr/repo/departements.geojson',
                        'https://raw.githubusercontent.com/gregoiredavid/france-geojson/master/departements.geojson'
                    ])
                ])
                    .then(([regionsGeoJson, departementsGeoJson]) => {
                        const regionsLayer = L.geoJSON(regionsGeoJson, {
                            pane: 'regionsPane',
                            filter: isMetropolitan,
                            style: (feature) => {
                                const regionName = feature?.properties?.nom || '';
                                if (regionName === 'Bretagne') {
                                    return {
                                        color: '#2F4251',
                                        weight: 1.8,
                                        fillColor: '#60B4F9',
                                        fillOpacity: 0.45
                                    };
                                }
                                return {
                                    color: '#cbd5e1',
                                    weight: 1,
                                    fillColor: '#f1f5f9',
                                    fillOpacity: 0.9
                                };
                            }
                        }).addTo(map);

                        const departementsLayer = L.geoJSON(departementsGeoJson, {
                            pane: 'departementsPane',
                            filter: isMetropolitan,
                            style: (feature) => {
                                const code = feature?.properties?.code || '';
                                if (code === '71' || code === '21') {
                                    return {
                                        color: '#2F4251',
                                        weight: 2.4,
                                        fillColor: '#FADF70',
                                        fillOpacity: 0.95
                                    };
                                }
                                return {
                                    color: '#94a3b8',
                                    weight: 0.9,
                                    fillColor: '#e2e8f0',
                                    fillOpacity: 0.15
                                };
                            },
                            onEachFeature: (feature, layer) => {
                                const depCode = feature?.properties?.code || '';
                                const depName = feature?.properties?.nom || 'Departement';
                                layer.bindTooltip(`${depName} (${depCode})`, {
                                    sticky: true,
                                    direction: 'top',
                                    opacity: 0.95
                                });
                            }
                        }).addTo(map);

                        locations.forEach((location) => {
                            L.circleMarker(location.coords, {
                                pane: 'markersPane',
                                radius: 8,
                                color: '#2F4251',
                                weight: 2,
                                fillColor: '#60B4F9',
                                fillOpacity: 0.95
                            })
                                .addTo(map)
                                .bindPopup(`<strong>${location.name}</strong><br>${location.tag}`);
                        });

                        const bounds = regionsLayer.getBounds();
                        if (bounds.isValid()) {
                            map.fitBounds(bounds.pad(-0.03));
                        }
                        map.setMaxBounds(bounds.pad(0.2));
                    })
                    .catch(() => {
                        // Keep map container rendered if remote geojson fails.
                    });
            }
        })();
    </script>
</body>
</html>
