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

        @keyframes navCtaPulse {
            0%, 100% {
                box-shadow: 0 4px 18px rgba(96, 180, 249, 0.42), 0 0 0 0 rgba(96, 180, 249, 0.35);
            }
            50% {
                box-shadow: 0 6px 26px rgba(96, 180, 249, 0.55), 0 0 0 8px rgba(96, 180, 249, 0);
            }
        }

        .nav-cta-contact {
            animation: navCtaPulse 2.8s ease-in-out infinite;
        }

        @media (prefers-reduced-motion: reduce) {
            .nav-cta-contact {
                animation: none;
                box-shadow: 0 4px 18px rgba(96, 180, 249, 0.4);
            }
        }

        #agencyMap {
            position: relative;
            z-index: 1;
        }

        @media (min-width: 1024px) {
            .nav-dropdown:focus-within .nav-dropdown-panel,
            .nav-dropdown:hover .nav-dropdown-panel {
                visibility: visible;
                opacity: 1;
                transform: translateY(0);
                pointer-events: auto;
            }
        }

        .footer-hero-bg {
            background-image: linear-gradient(105deg, rgba(47, 66, 81, 0.94) 0%, rgba(47, 66, 81, 0.88) 45%, rgba(47, 66, 81, 0.82) 100%), url('https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=2000&q=80');
            background-size: cover;
            background-position: center;
        }

        .devis-simulator-bg {
            background-image: linear-gradient(145deg, rgba(47, 66, 81, 0.72) 0%, rgba(47, 66, 81, 0.65) 35%, rgba(30, 41, 59, 0.78) 100%), url('/nous/simulateur.png');
            background-size: cover;
            background-position: center;
        }

        .aides-renov-hero-bg {
            background-image: linear-gradient(120deg, rgba(47, 66, 81, 0.92) 0%, rgba(30, 58, 95, 0.88) 45%, rgba(15, 23, 42, 0.9) 100%), url('https://images.unsplash.com/photo-1565538810643-b5bdb714032a?auto=format&fit=crop&w=2000&q=80');
            background-size: cover;
            background-position: center;
        }

        @keyframes partners-marquee {
            from { transform: translateX(0); }
            to { transform: translateX(-50%); }
        }

        .partners-marquee-track {
            display: flex;
            width: max-content;
            animation: partners-marquee 42s linear infinite;
        }

        .partners-marquee:hover .partners-marquee-track {
            animation-play-state: paused;
        }

        @media (prefers-reduced-motion: reduce) {
            .partners-marquee-track {
                animation: none;
            }
        }
    </style>
</head>
<body class="bg-white font-sans text-brand-dark antialiased">
    <header class="sticky top-0 z-[1000] border-b-4 border-brand-blue bg-white/95 shadow-[0_1px_0_rgba(15,23,42,0.06)] backdrop-blur-md">
        <div class="mx-auto flex min-h-[84px] max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="#top" class="shrink-0">
                <img src="/logo.png" alt="Normes & Renovation" class="h-12 w-auto sm:h-14">
            </a>

            <nav class="hidden items-center gap-1 lg:flex xl:gap-2" aria-label="Navigation principale">
                <a href="#top" class="rounded-lg px-3 py-2 text-[15px] font-semibold text-brand-dark transition hover:bg-slate-50 hover:text-brand-blue xl:text-[16px]">Accueil</a>

                <div class="nav-dropdown relative">
                    <button type="button" class="inline-flex items-center gap-0.5 rounded-lg px-3 py-2 text-[15px] font-semibold text-brand-dark transition hover:bg-slate-50 hover:text-brand-blue xl:text-[16px]" aria-expanded="false" aria-haspopup="true" aria-controls="nav-mega-entreprise">
                        Normes &amp; Rénovation
                        <svg class="h-4 w-4 opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div id="nav-mega-entreprise" class="nav-dropdown-panel invisible absolute left-0 top-full z-[1100] min-w-[220px] translate-y-1 pt-1 opacity-0 transition-all duration-150 pointer-events-none">
                        <div class="rounded-xl border border-slate-200 bg-white py-2 shadow-lg ring-1 ring-black/5">
                            <a href="#a-propos" class="block px-4 py-2.5 text-sm font-semibold text-brand-dark hover:bg-slate-50 hover:text-brand-blue">À propos</a>
                            <a href="#agences" class="block px-4 py-2.5 text-sm font-semibold text-brand-dark hover:bg-slate-50 hover:text-brand-blue">Nos agences</a>
                            <a href="#franchise" class="block px-4 py-2.5 text-sm font-semibold text-brand-dark hover:bg-slate-50 hover:text-brand-blue">Franchise</a>
                        </div>
                    </div>
                </div>

                <div class="nav-dropdown relative">
                    <button type="button" class="inline-flex items-center gap-0.5 rounded-lg px-3 py-2 text-[15px] font-semibold text-brand-dark transition hover:bg-slate-50 hover:text-brand-blue xl:text-[16px]" aria-expanded="false" aria-haspopup="true" aria-controls="nav-mega-services">
                        Services
                        <svg class="h-4 w-4 opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div id="nav-mega-services" class="nav-dropdown-panel invisible absolute left-0 top-full z-[1100] min-w-[260px] translate-y-1 pt-1 opacity-0 transition-all duration-150 pointer-events-none">
                        <div class="rounded-xl border border-slate-200 bg-white py-2 shadow-lg ring-1 ring-black/5">
                            <a href="#services" data-service-filter-group="toiture facade" class="service-submenu-link block px-4 py-2.5 text-sm font-semibold text-brand-dark hover:bg-slate-50 hover:text-brand-blue">Toiture &amp; façade</a>
                            <a href="#services" data-service-filter-group="isolation" class="service-submenu-link block px-4 py-2.5 text-sm font-semibold text-brand-dark hover:bg-slate-50 hover:text-brand-blue">Isolation</a>
                            <a href="#services" data-service-filter-group="traitement air" class="service-submenu-link block px-4 py-2.5 text-sm font-semibold text-brand-dark hover:bg-slate-50 hover:text-brand-blue">Humidité &amp; ventilation</a>
                            <a href="#services" data-service-filter-group="electricite" class="service-submenu-link block px-4 py-2.5 text-sm font-semibold text-brand-dark hover:bg-slate-50 hover:text-brand-blue">Électricité</a>
                            <a href="#services" data-service-filter-group="energie" class="service-submenu-link block px-4 py-2.5 text-sm font-semibold text-brand-dark hover:bg-slate-50 hover:text-brand-blue">Photovoltaïque</a>
                            <a href="#services" data-service-filter-group="air" class="service-submenu-link block px-4 py-2.5 text-sm font-semibold text-brand-dark hover:bg-slate-50 hover:text-brand-blue">Climatisation</a>
                        </div>
                    </div>
                </div>

                <a href="#realisations" class="rounded-lg px-3 py-2 text-[15px] font-semibold text-brand-dark transition hover:bg-slate-50 hover:text-brand-blue xl:text-[16px]">Réalisations</a>
                <a href="#conseils" class="rounded-lg px-3 py-2 text-[15px] font-semibold text-brand-dark transition hover:bg-slate-50 hover:text-brand-blue xl:text-[16px]">Conseils</a>
                <a href="#devis" class="rounded-lg px-3 py-2 text-[15px] font-semibold text-brand-dark transition hover:bg-slate-50 hover:text-brand-blue xl:text-[16px]">Contact</a>

                <a href="#devis" class="nav-cta-contact ml-2 inline-flex items-center rounded-xl bg-brand-blue px-5 py-2.5 text-sm font-extrabold text-white ring-2 ring-white/20 transition hover:-translate-y-0.5 hover:bg-sky-500 hover:ring-brand-yellow/40">Devis gratuit</a>

                <ul class="ml-3 flex list-none items-center gap-2 border-l border-slate-200 pl-3 xl:ml-4 xl:gap-3 xl:pl-4" aria-label="Réseaux sociaux">
                    <li>
                        <a href="#" aria-label="Facebook" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#1877F2] text-white shadow-soft transition hover:opacity-90 hover:ring-2 hover:ring-[#1877F2]/35 hover:ring-offset-2">
                            <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                    </li>
                    <li>
                        <a href="#" aria-label="LinkedIn" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#0A66C2] text-white shadow-soft transition hover:opacity-90 hover:ring-2 hover:ring-[#0A66C2]/35 hover:ring-offset-2">
                            <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    </li>
                    <li>
                        <a href="#" aria-label="Instagram" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white shadow-soft ring-2 ring-slate-200 transition hover:opacity-90 hover:ring-brand-blue/40">
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
                </ul>
            </nav>

            <button id="menuBtn" type="button" class="inline-flex items-center rounded-lg border border-slate-200 p-2 text-brand-dark lg:hidden" aria-label="Ouvrir le menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <div id="mobileMenu" class="hidden border-t border-slate-100 bg-white lg:hidden">
            <div class="mx-auto flex max-w-7xl flex-col gap-0.5 px-4 py-3 sm:px-6">
                <a href="#top" class="rounded-lg px-3 py-2.5 text-[15px] font-semibold text-brand-dark hover:bg-slate-50">Accueil</a>

                <details class="group rounded-lg">
                    <summary class="cursor-pointer list-none px-3 py-2.5 text-[15px] font-semibold text-brand-dark marker:content-none [&::-webkit-details-marker]:hidden hover:bg-slate-50">
                        <span class="inline-flex w-full items-center justify-between">Normes &amp; Rénovation <span class="text-slate-400" aria-hidden="true">▼</span></span>
                    </summary>
                    <div class="border-l-2 border-brand-blue/30 py-1 pl-4">
                        <a href="#a-propos" class="block rounded-lg py-2 text-sm font-medium text-slate-700 hover:text-brand-blue">À propos</a>
                        <a href="#agences" class="block rounded-lg py-2 text-sm font-medium text-slate-700 hover:text-brand-blue">Nos agences</a>
                        <a href="#franchise" class="block rounded-lg py-2 text-sm font-medium text-slate-700 hover:text-brand-blue">Franchise</a>
                    </div>
                </details>

                <details class="group rounded-lg">
                    <summary class="cursor-pointer list-none px-3 py-2.5 text-[15px] font-semibold text-brand-dark marker:content-none [&::-webkit-details-marker]:hidden hover:bg-slate-50">
                        <span class="inline-flex w-full items-center justify-between">Services <span class="text-slate-400" aria-hidden="true">▼</span></span>
                    </summary>
                    <div class="border-l-2 border-brand-blue/30 py-1 pl-4">
                        <a href="#services" data-service-filter-group="toiture facade" class="service-submenu-link block rounded-lg py-2 text-sm font-medium text-slate-700 hover:text-brand-blue">Toiture &amp; façade</a>
                        <a href="#services" data-service-filter-group="isolation" class="service-submenu-link block rounded-lg py-2 text-sm font-medium text-slate-700 hover:text-brand-blue">Isolation</a>
                        <a href="#services" data-service-filter-group="traitement air" class="service-submenu-link block rounded-lg py-2 text-sm font-medium text-slate-700 hover:text-brand-blue">Humidité &amp; ventilation</a>
                        <a href="#services" data-service-filter-group="electricite" class="service-submenu-link block rounded-lg py-2 text-sm font-medium text-slate-700 hover:text-brand-blue">Électricité</a>
                        <a href="#services" data-service-filter-group="energie" class="service-submenu-link block rounded-lg py-2 text-sm font-medium text-slate-700 hover:text-brand-blue">Photovoltaïque</a>
                        <a href="#services" data-service-filter-group="air" class="service-submenu-link block rounded-lg py-2 text-sm font-medium text-slate-700 hover:text-brand-blue">Climatisation</a>
                    </div>
                </details>

                <a href="#realisations" class="rounded-lg px-3 py-2.5 text-[15px] font-semibold text-brand-dark hover:bg-slate-50">Réalisations</a>
                <a href="#conseils" class="rounded-lg px-3 py-2.5 text-[15px] font-semibold text-brand-dark hover:bg-slate-50">Conseils</a>
                <a href="#devis" class="rounded-lg px-3 py-2.5 text-[15px] font-semibold text-brand-dark hover:bg-slate-50">Contact</a>

                <a href="#devis" class="nav-cta-contact mt-2 inline-flex w-full items-center justify-center rounded-xl bg-brand-blue px-4 py-3.5 text-sm font-extrabold text-white ring-2 ring-brand-blue/30 transition hover:bg-sky-500">Devis gratuit</a>
                <div class="mt-4 flex flex-col items-center gap-2 border-t border-slate-100 pt-4 sm:items-start">
                    <p class="text-center text-xs font-bold uppercase tracking-wide text-slate-500 sm:text-left">Suivez-nous</p>
                    <ul class="flex list-none items-center justify-center gap-4 sm:justify-start" aria-label="Réseaux sociaux">
                        <li>
                            <a href="#" aria-label="Facebook" class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-[#1877F2] text-white shadow-soft transition hover:opacity-90 active:scale-95">
                                <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        </li>
                        <li>
                            <a href="#" aria-label="LinkedIn" class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-[#0A66C2] text-white shadow-soft transition hover:opacity-90 active:scale-95">
                                <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                        </li>
                        <li>
                            <a href="#" aria-label="Instagram" class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white shadow-soft ring-2 ring-slate-200 transition hover:opacity-90 active:scale-95">
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
                    </ul>
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

    <section id="services" class="scroll-mt-24 bg-slate-50/70 py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="mb-3 text-4xl font-extrabold leading-tight text-brand-dark sm:text-5xl"><span class="text-brand-blue">Nos services</span> de renovation</h2>
            <p class="mb-6 max-w-3xl text-base text-slate-600 sm:text-lg">Douze expertises pour votre maison. Filtrez par type de travaux pour afficher les prestations correspondantes.</p>
            <div id="serviceFilters" class="mb-6 flex flex-wrap gap-2">
                <button type="button" data-filter="all" class="service-filter rounded-full border border-brand-dark bg-brand-dark px-4 py-2 text-xs font-bold uppercase tracking-wide text-white sm:text-sm">Tous</button>
                <button type="button" data-filter="toiture" class="service-filter rounded-full border border-slate-300 bg-white px-4 py-2 text-xs font-bold uppercase tracking-wide text-slate-700 sm:text-sm">Toiture</button>
                <button type="button" data-filter="facade" class="service-filter rounded-full border border-slate-300 bg-white px-4 py-2 text-xs font-bold uppercase tracking-wide text-slate-700 sm:text-sm">Facade</button>
                <button type="button" data-filter="isolation" class="service-filter rounded-full border border-slate-300 bg-white px-4 py-2 text-xs font-bold uppercase tracking-wide text-slate-700 sm:text-sm">Isolation</button>
                <button type="button" data-filter="air" class="service-filter rounded-full border border-slate-300 bg-white px-4 py-2 text-xs font-bold uppercase tracking-wide text-slate-700 sm:text-sm">Ventilation & climatisation</button>
                <button type="button" data-filter="electricite" class="service-filter rounded-full border border-slate-300 bg-white px-4 py-2 text-xs font-bold uppercase tracking-wide text-slate-700 sm:text-sm">Electricite</button>
                <button type="button" data-filter="energie" class="service-filter rounded-full border border-slate-300 bg-white px-4 py-2 text-xs font-bold uppercase tracking-wide text-slate-700 sm:text-sm">Solaire</button>
                <button type="button" data-filter="traitement" class="service-filter rounded-full border border-slate-300 bg-white px-4 py-2 text-xs font-bold uppercase tracking-wide text-slate-700 sm:text-sm">Humidite & eau</button>
            </div>
            <div id="serviceGrid" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                <article data-category="toiture" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1">
                    <img src="{{ asset('services/toiture et couverture.jpeg') }}" alt="Toiture et couverture" class="h-44 w-full object-cover">
                    <div class="flex h-full flex-col p-5">
                        <h3 class="mb-2 text-lg font-bold leading-snug">Toiture &amp; couverture</h3>
                        <p class="text-sm text-slate-600">Nettoyage, reparation et remplacement de toiture pour proteger durablement votre maison.</p>
                        <a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a>
                    </div>
                </article>
                <article data-category="toiture" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1">
                    <img src="{{ asset('services/Nettoyage & Demoussage de Toiture.jpeg') }}" alt="Nettoyage et démoussage de toiture" class="h-44 w-full object-cover">
                    <div class="flex h-full flex-col p-5">
                        <h3 class="mb-2 text-lg font-bold leading-snug">Nettoyage &amp; démoussage de toiture</h3>
                        <p class="text-sm text-slate-600">Elimination des mousses et lichens pour prolonger la duree de vie de votre toit.</p>
                        <a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a>
                    </div>
                </article>
                <article data-category="toiture" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1">
                    <img src="{{ asset('services/Traitement Hydrofuge (Incolore ou Colore).png') }}" alt="Traitement hydrofuge toiture" class="h-44 w-full object-cover">
                    <div class="flex h-full flex-col p-5">
                        <h3 class="mb-2 text-lg font-bold leading-snug">Traitement hydrofuge (incolore ou coloré)</h3>
                        <p class="text-sm text-slate-600">Protection impermeable de votre toiture contre l'humidite et les infiltrations.</p>
                        <a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a>
                    </div>
                </article>
                <article data-category="facade" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1">
                    <img src="{{ asset('services/Rénovation de Façade.jpeg') }}" alt="Rénovation de façade" class="h-44 w-full object-cover">
                    <div class="flex h-full flex-col p-5">
                        <h3 class="mb-2 text-lg font-bold leading-snug">Rénovation de façade</h3>
                        <p class="text-sm text-slate-600">Nettoyage, peinture et protection pour redonner vie a votre habitation.</p>
                        <a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a>
                    </div>
                </article>
                <article data-category="isolation" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1">
                    <img src="{{ asset('services/Isolation Thermique.jpeg') }}" alt="Isolation thermique" class="h-44 w-full object-cover">
                    <div class="flex h-full flex-col p-5">
                        <h3 class="mb-2 text-lg font-bold leading-snug">Isolation thermique</h3>
                        <p class="text-sm text-slate-600">Isolation des combles, rampants et planchers pour reduire les pertes de chaleur jusqu'a 30&nbsp;%.</p>
                        <a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a>
                    </div>
                </article>
                <article data-category="air" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1">
                    <img src="{{ asset('services/Ventilation (VMC : VMI).jpg') }}" alt="Ventilation VMC / VMI" class="h-44 w-full object-cover">
                    <div class="flex h-full flex-col p-5">
                        <h3 class="mb-2 text-lg font-bold leading-snug">Ventilation (VMC / VMI)</h3>
                        <p class="text-sm text-slate-600">Systemes de ventilation pour ameliorer la qualite de l'air et reduire l'humidite.</p>
                        <a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a>
                    </div>
                </article>
                <article data-category="electricite" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1">
                    <img src="{{ asset('services/Mise aux Normes Électriques.jpg') }}" alt="Mise aux normes électriques" class="h-44 w-full object-cover">
                    <div class="flex h-full flex-col p-5">
                        <h3 class="mb-2 text-lg font-bold leading-snug">Mise aux normes électriques</h3>
                        <p class="text-sm text-slate-600">Securisation de votre installation electrique pour proteger votre maison et votre famille.</p>
                        <a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a>
                    </div>
                </article>
                <article data-category="energie" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1">
                    <img src="{{ asset('services/Installation Photovoltaïque.jpg') }}" alt="Installation photovoltaïque" class="h-44 w-full object-cover">
                    <div class="flex h-full flex-col p-5">
                        <h3 class="mb-2 text-lg font-bold leading-snug">Installation photovoltaïque</h3>
                        <p class="text-sm text-slate-600">Production d'electricite solaire pour reduire vos factures et gagner en autonomie.</p>
                        <a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a>
                    </div>
                </article>
                <article data-category="air" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1">
                    <img src="{{ asset("services/Climatisation & Confort d'Été.jpg") }}" alt="Climatisation et confort d'été" class="h-44 w-full object-cover">
                    <div class="flex h-full flex-col p-5">
                        <h3 class="mb-2 text-lg font-bold leading-snug">Climatisation &amp; confort d'été</h3>
                        <p class="text-sm text-slate-600">Installation de systemes mono, bi ou tri split pour un interieur frais et agreable.</p>
                        <a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a>
                    </div>
                </article>
                <article data-category="traitement" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1">
                    <img src="{{ asset("services/Traitement de l'Humidité.webp") }}" alt="Traitement de l'humidité" class="h-44 w-full object-cover">
                    <div class="flex h-full flex-col p-5">
                        <h3 class="mb-2 text-lg font-bold leading-snug">Traitement de l'humidité</h3>
                        <p class="text-sm text-slate-600">Solutions contre l'humidite (diagnostic, inverseur de polarite, traitement murs).</p>
                        <a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a>
                    </div>
                </article>
                <article data-category="traitement" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1">
                    <img src="{{ asset("services/Installation d'Adoucisseur d'Eau.jpeg") }}" alt="Installation d'adoucisseur d'eau" class="h-44 w-full object-cover">
                    <div class="flex h-full flex-col p-5">
                        <h3 class="mb-2 text-lg font-bold leading-snug">Installation d'adoucisseur d'eau</h3>
                        <p class="text-sm text-slate-600">Reduction du calcaire pour proteger vos equipements et ameliorer votre confort.</p>
                        <a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a>
                    </div>
                </article>
                <article data-category="toiture" class="service-card flex h-full flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-soft transition hover:-translate-y-1">
                    <img src="{{ asset('services/Traitement de Charpente.webp') }}" alt="Traitement de charpente" class="h-44 w-full object-cover">
                    <div class="flex h-full flex-col p-5">
                        <h3 class="mb-2 text-lg font-bold leading-snug">Traitement de charpente</h3>
                        <p class="text-sm text-slate-600">Traitement preventif et curatif contre les insectes et champignons.</p>
                        <a href="#devis" class="mt-4 inline-flex w-fit rounded-lg bg-brand-blue px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-dark sm:text-sm">En savoir plus</a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section id="realisations" class="scroll-mt-24 py-16 sm:py-20">
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
                        <div class="shrink-0 rounded-2xl border border-brand-dark/25 bg-gradient-to-br from-brand-dark via-brand-dark to-slate-900 p-5 shadow-lg sm:p-6">
                            <p class="text-lg font-extrabold leading-snug text-white sm:text-xl">Vous avez un projet de rénovation ?</p>
                            <p class="mt-2 text-sm leading-relaxed text-slate-200 sm:text-base">Décrivez votre besoin : nous vous recontactons rapidement avec un accompagnement personnalisé, vos options d'aides et une première base pour votre devis.</p>
                            <a href="#devis" class="mt-4 inline-flex rounded-xl bg-brand-yellow px-4 py-2.5 text-sm font-extrabold text-brand-dark shadow-md transition hover:bg-yellow-300">Ouvrir le simulateur de devis</a>
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

                <aside id="a-propos" class="flex min-h-0 scroll-mt-28 flex-col lg:min-h-[560px] lg:flex-row">
                    <div class="flex flex-1 flex-col justify-center bg-white px-6 py-10 text-brand-dark sm:px-8 sm:py-12">
                        <h2 class="text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl">
                            <span class="text-brand-blue">À propos de</span>
                            <span class="mt-2 block text-brand-dark">Normes &amp; Rénovation</span>
                        </h2>
                        <p class="mt-6 text-base leading-relaxed text-slate-700 sm:text-lg">Normes &amp; Rénovation accompagne les particuliers et professionnels dans leurs projets de rénovation énergétique, thermique et électrique. Notre équipe combine expertise technique, suivi de chantier et conseils sur mesure pour des résultats fiables et durables. Nous sommes certifiés RGE, engagés dans le respect de l'environnement et nous privilégions des matériaux de qualité pour des rénovations performantes et responsables.</p>
                    </div>
                    <div class="flex flex-1 flex-col justify-center bg-brand-dark px-6 py-10 text-white sm:px-8 sm:py-12">
                        <p class="text-xs font-bold uppercase tracking-wider text-brand-yellow">Nos engagements</p>
                        <ul class="mt-4 space-y-3 text-base leading-snug text-slate-200">
                            <li class="flex gap-2"><span class="font-bold text-brand-yellow">·</span><span>Garantie sur les travaux réalisés</span></li>
                            <li class="flex gap-2"><span class="font-bold text-brand-yellow">·</span><span>Nous nous occupons de tout pour vous simplifier la vie</span></li>
                            <li class="flex gap-2"><span class="font-bold text-brand-yellow">·</span><span>Techniciens qualifiés et formés en continu</span></li>
                            <li class="flex gap-2"><span class="font-bold text-brand-yellow">·</span><span>Entreprise certifiée et orientée qualité</span></li>
                            <li class="flex gap-2"><span class="font-bold text-brand-yellow">·</span><span>Accompagnement complet de l'étude à la livraison</span></li>
                            <li class="flex gap-2"><span class="font-bold text-brand-yellow">·</span><span>Solutions performantes pour valoriser votre bien</span></li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <section id="agences" class="scroll-mt-24 bg-slate-50/70 py-16 sm:py-20">
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
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-soft sm:p-6">
                <h2 class="mb-3 text-4xl font-extrabold text-brand-dark sm:text-5xl"><span class="text-brand-blue">Carte</span> des implantations</h2>
                <div id="agencyMap" class="min-h-[380px] rounded-xl border border-slate-200"></div>
                <div class="mt-3 flex flex-wrap gap-2 text-xs font-semibold">
                    <span class="inline-flex items-center gap-1 rounded-full bg-brand-blue/20 px-3 py-1 text-brand-dark"><span class="h-2 w-2 rounded-full bg-brand-blue"></span>Region Bretagne</span>
                    <span class="inline-flex items-center gap-1 rounded-full bg-brand-yellow/70 px-3 py-1 text-brand-dark"><span class="h-2 w-2 rounded-full bg-brand-yellow"></span>Departements 71 & 21</span>
                </div>
            </div>

            <a id="franchise" href="#devis" class="group relative col-span-full mt-2 block scroll-mt-28 overflow-hidden rounded-xl border border-slate-200 shadow-soft lg:mt-0">
                <div class="absolute inset-0 bg-cover bg-center transition duration-300 group-hover:scale-105" style="background-image:url('https://images.unsplash.com/photo-1556155092-490a1ba16284?auto=format&fit=crop&w=1200&q=80')"></div>
                <div class="relative bg-gradient-to-r from-brand-dark/85 to-brand-dark/55 px-5 py-5 sm:px-6 sm:py-6">
                    <p class="text-xs font-bold uppercase tracking-wide text-brand-yellow">Reseau Normes</p>
                    <h3 class="text-xl font-extrabold text-white sm:text-2xl">Devenir franchisé</h3>
                    <p class="mt-1 max-w-2xl text-sm text-slate-200 sm:text-base">Rejoignez notre reseau et developpez votre agence avec un accompagnement complet — contactez-nous pour en discuter.</p>
                    <span class="mt-4 inline-flex rounded-lg bg-brand-blue px-4 py-2.5 text-xs font-extrabold text-white transition group-hover:bg-sky-500 sm:text-sm">Demander une presentation</span>
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
                <p class="mb-2 max-w-3xl text-base text-slate-600 sm:text-lg">Quatre etapes claires, de l'estimation de vos aides au suivi de chantier.</p>
                <p class="mb-8 text-sm text-slate-500 lg:hidden">Faites defiler horizontalement pour voir les etapes.</p>

                <div class="relative">
                    <div class="pointer-events-none absolute left-0 right-0 top-7 hidden h-0.5 bg-gradient-to-r from-brand-blue via-brand-dark/40 to-brand-blue lg:block" aria-hidden="true"></div>
                    <ol class="flex snap-x snap-mandatory gap-4 overflow-x-auto pb-4 [-ms-overflow-style:none] [scrollbar-width:none] lg:grid lg:snap-none lg:grid-cols-4 lg:gap-6 lg:overflow-visible lg:pb-0 [&::-webkit-scrollbar]:hidden">
                        <li class="min-w-[85vw] snap-center rounded-2xl border border-slate-200 bg-slate-50/80 p-5 sm:min-w-[320px] lg:min-w-0 lg:border-0 lg:bg-transparent lg:p-0 lg:pt-2 lg:text-center">
                            <span class="relative z-[1] mb-4 inline-flex h-12 w-12 items-center justify-center rounded-full bg-brand-blue text-base font-black text-white shadow-md shadow-brand-blue/30 lg:mx-auto">1</span>
                            <h4 class="text-lg font-extrabold text-brand-dark">Calcul de Primes et Devis precis</h4>
                            <p class="mt-2 text-sm leading-relaxed text-slate-700 sm:text-base">Nous nous occupons de tout le calcul de vos primes, des CEE (Certificats d'Economies d'Energie) et des differentes options de financement disponibles. Profitez de travaux couverts jusqu'a 90 % sans avance de frais.</p>
                        </li>
                        <li class="min-w-[85vw] snap-center rounded-2xl border border-slate-200 bg-slate-50/80 p-5 sm:min-w-[320px] lg:min-w-0 lg:border-0 lg:bg-transparent lg:p-0 lg:pt-2 lg:text-center">
                            <span class="relative z-[1] mb-4 inline-flex h-12 w-12 items-center justify-center rounded-full bg-brand-dark text-base font-black text-brand-yellow shadow-md lg:mx-auto">2</span>
                            <h4 class="text-lg font-extrabold text-brand-dark">Solutions de Financement</h4>
                            <p class="mt-2 text-sm leading-relaxed text-slate-700 sm:text-base">Nous proposons des solutions de financement adaptees grace a nos partenaires, pour vous aider a gerer le cout parfois eleve des travaux de renovation.</p>
                        </li>
                        <li class="min-w-[85vw] snap-center rounded-2xl border border-slate-200 bg-slate-50/80 p-5 sm:min-w-[320px] lg:min-w-0 lg:border-0 lg:bg-transparent lg:p-0 lg:pt-2 lg:text-center">
                            <span class="relative z-[1] mb-4 inline-flex h-12 w-12 items-center justify-center rounded-full bg-brand-dark text-base font-black text-white shadow-md lg:mx-auto">3</span>
                            <h4 class="text-lg font-extrabold text-brand-dark">Analyse Personnalisee</h4>
                            <p class="mt-2 text-sm leading-relaxed text-slate-700 sm:text-base">Un technicien qualifie se deplace gratuitement pour realiser un diagnostic approfondi et personnalise de vos besoins.</p>
                        </li>
                        <li class="min-w-[85vw] snap-center rounded-2xl border border-slate-200 bg-slate-50/80 p-5 sm:min-w-[320px] lg:min-w-0 lg:border-0 lg:bg-transparent lg:p-0 lg:pt-2 lg:text-center">
                            <span class="relative z-[1] mb-4 inline-flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-brand-blue to-sky-600 text-base font-black text-white shadow-md lg:mx-auto">4</span>
                            <h4 class="text-lg font-extrabold text-brand-dark">Suivi et Assistance Continus</h4>
                            <p class="mt-2 text-sm leading-relaxed text-slate-700 sm:text-base">De la premiere consultation a la finalisation des travaux, nous vous accompagnons a chaque etape. Vous beneficiez d'un suivi regulier et d'une assistance dediee pour garantir que vos travaux se deroulent en toute serenite.</p>
                        </li>
                    </ol>
                </div>

                <div class="aides-renov-hero-bg relative mt-10 overflow-hidden rounded-3xl border border-slate-200/60 shadow-2xl ring-1 ring-black/5">
                    <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-brand-blue/25 blur-3xl"></div>
                    <div class="pointer-events-none absolute -bottom-24 -left-16 h-72 w-72 rounded-full bg-brand-yellow/15 blur-3xl"></div>
                    <div class="relative z-[1] grid gap-8 p-6 sm:p-8 lg:grid-cols-12 lg:items-center lg:gap-10 lg:p-10">
                        <div class="flex justify-center lg:col-span-4 lg:justify-start">
                            <div class="relative w-full max-w-[340px]">
                                <div class="absolute -inset-1 rounded-[1.35rem] bg-gradient-to-br from-brand-yellow/80 via-white/40 to-brand-blue/50 opacity-90 blur-[2px]"></div>
                                <div class="relative rounded-3xl bg-white p-6 shadow-[0_20px_50px_rgba(0,0,0,0.35)] ring-2 ring-white/80 sm:p-8">
                                    <div class="flex min-h-[140px] items-center justify-center rounded-2xl bg-gradient-to-b from-slate-50 to-white p-4 ring-1 ring-slate-200/80">
                                        <img src="/nous/ma prime.png" alt="Programme MaPrimeRénov' — Mieux chez moi, mieux pour la planète" width="520" height="200" class="h-auto max-h-36 w-full object-contain object-center sm:max-h-40">
                                    </div>
                                    <p class="mt-4 text-center text-[11px] font-bold uppercase tracking-wider text-brand-dark/70">MaPrimeRénov' · dispositif national</p>
                                    <p class="mt-1 text-center text-xs text-slate-500">Accompagnement dossier &amp; cumul avec les CEE</p>
                                </div>
                            </div>
                        </div>
                        <div class="lg:col-span-8">
                            <p class="text-[11px] font-extrabold uppercase tracking-[0.22em] text-brand-yellow">Aides à la rénovation</p>
                            <h3 class="mt-3 text-2xl font-extrabold leading-tight text-white sm:text-3xl lg:text-4xl">On vous accompagne pour vos aides MaPrimeRénov' et CEE</h3>
                            <p class="mt-4 max-w-3xl text-base leading-relaxed text-slate-100 sm:text-lg">Notre équipe vous aide à comprendre vos droits, à monter les dossiers <strong class="font-semibold text-white">MaPrimeRénov'</strong> et à valoriser les <strong class="font-semibold text-white">certificats d'économies d'énergie (CEE)</strong> éligibles sur votre projet. Nous optimisons le cumul des dispositifs pour limiter votre reste à charge et sécuriser vos travaux.</p>
                            <div class="mt-6 flex flex-wrap items-center gap-4">
                                <a href="#devis" class="inline-flex rounded-xl bg-brand-yellow px-6 py-3.5 text-sm font-extrabold text-brand-dark shadow-lg transition hover:bg-yellow-300">Demander un accompagnement</a>
                                <span class="text-xs text-slate-300">RGE · Devis gratuit · Réponse rapide</span>
                            </div>
                        </div>
                    </div>
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

    <section id="devis" class="scroll-mt-24 bg-brand-dark py-16 text-white sm:py-20">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[1fr_1.05fr] lg:items-start lg:gap-12 lg:px-8">
            <div class="space-y-6">
                <div>
                    <h2 class="mb-3 text-4xl font-extrabold leading-tight sm:text-5xl"><span class="text-brand-yellow">Vous avez</span> <span class="text-white">un projet de rénovation ?</span></h2>
                    <p class="max-w-xl text-base leading-relaxed text-slate-200 sm:text-lg">Décrivez votre besoin : nous vous recontactons rapidement avec un accompagnement personnalisé, vos options d'aides et une première base pour votre devis.</p>
                </div>
                <div class="space-y-4 rounded-2xl border border-white/15 bg-white/5 p-5 backdrop-blur-sm sm:p-6">
                    <p class="text-xs font-bold uppercase tracking-wide text-brand-yellow">Nous contacter</p>
                    <div class="space-y-3 text-sm sm:text-base">
                        <div class="flex gap-3">
                            <span class="mt-0.5 shrink-0 text-brand-blue" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </span>
                            <div>
                                <p class="font-semibold text-white">Agence Chalon-sur-Saone</p>
                                <p class="text-slate-300">6 rue Pierre de Coubertin<br>71100 Chalon-sur-Saone</p>
                                <a href="tel:+33385419886" class="mt-1 inline-block font-extrabold text-brand-yellow transition hover:text-white">03 85 41 98 86</a>
                            </div>
                        </div>
                        <div class="flex gap-3 border-t border-white/10 pt-3">
                            <span class="mt-0.5 shrink-0 text-brand-blue" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </span>
                            <div>
                                <p class="font-semibold text-white">Agence Bretagne</p>
                                <p class="text-slate-300">ZA de Mikez<br>22540 Pedernec</p>
                                <a href="tel:+33296400755" class="mt-1 inline-block font-extrabold text-brand-yellow transition hover:text-white">02 96 40 07 55</a>
                            </div>
                        </div>
                        <div class="border-t border-white/10 pt-3">
                            <a href="mailto:bourgogne-agence@normesrenovation.fr" class="inline-flex items-center gap-2 font-semibold text-white transition hover:text-brand-yellow">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-brand-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                bourgogne-agence@normesrenovation.fr
                            </a>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400">Horaires : du lundi au vendredi, sur rendez-vous — reponse sous 48h en general.</p>
                </div>
            </div>
            <div class="flex flex-col gap-8">
                <div class="devis-simulator-bg relative overflow-hidden rounded-2xl border border-white/20 shadow-2xl ring-1 ring-white/10">
                <div class="relative z-[1] p-6 sm:p-8">
                    <div class="max-w-lg">
                        <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-brand-yellow">Simulateur de devis</p>
                        <p class="mt-3 text-xl font-bold text-white sm:text-2xl">Estimation personnalisée &amp; rappel d'un conseiller</p>
                        <p class="mt-2 text-sm leading-relaxed text-slate-200 sm:text-base">Visualisez les grandes lignes de votre projet (toiture, surfaces, état du bien) — un interlocuteur vous rappelle pour affiner chiffrage et aides.</p>
                        <p class="mt-2 text-sm text-slate-300">Réponse sous 48h en général — sans engagement.</p>
                        <a href="#formulaire-contact" class="mt-5 inline-flex rounded-xl bg-brand-yellow px-5 py-3 text-sm font-extrabold text-brand-dark shadow-lg transition hover:bg-yellow-300">Passer au formulaire de contact</a>
                    </div>
                </div>
                </div>

                <div id="formulaire-contact" class="scroll-mt-28 rounded-2xl border border-slate-200/90 bg-white p-5 text-brand-dark shadow-xl sm:p-7">
                    <div class="mb-5 border-b border-slate-100 pb-4">
                        <h3 class="text-xl font-extrabold text-brand-dark">Formulaire de contact</h3>
                        <p class="mt-1 text-sm text-slate-600">Bloc à part du simulateur visuel : transmettez vos coordonnées et votre projet pour être rappelé(e) et recevoir une base de devis.</p>
                    </div>
                    <form class="text-brand-dark" action="#" method="post">
                @csrf
                <p class="mb-4 text-sm font-semibold text-slate-600">Ces informations nous permettent de préparer un devis pertinent.</p>
                <div class="grid gap-3 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <label for="devisPrenom" class="mb-1 block text-sm font-semibold">Prenom</label>
                        <input id="devisPrenom" name="prenom" type="text" autocomplete="given-name" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                    </div>
                    <div class="sm:col-span-1">
                        <label for="devisNom" class="mb-1 block text-sm font-semibold">Nom</label>
                        <input id="devisNom" name="nom" type="text" autocomplete="family-name" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                    </div>
                </div>
                <div class="mt-3 grid gap-3 sm:grid-cols-2">
                    <div>
                        <label for="devisEmail" class="mb-1 block text-sm font-semibold">Email</label>
                        <input id="devisEmail" name="email" type="email" autocomplete="email" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                    </div>
                    <div>
                        <label for="devisPhone" class="mb-1 block text-sm font-semibold">Telephone</label>
                        <input id="devisPhone" name="telephone" type="tel" autocomplete="tel" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                    </div>
                </div>
                <div class="mt-3 grid gap-3 sm:grid-cols-3">
                    <div class="sm:col-span-1">
                        <label for="devisCp" class="mb-1 block text-sm font-semibold">Code postal</label>
                        <input id="devisCp" name="code_postal" type="text" inputmode="numeric" maxlength="10" autocomplete="postal-code" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="devisVille" class="mb-1 block text-sm font-semibold">Ville</label>
                        <input id="devisVille" name="ville" type="text" autocomplete="address-level2" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                    </div>
                </div>
                <div class="mt-3">
                    <label for="devisBien" class="mb-1 block text-sm font-semibold">Type de bien</label>
                    <select id="devisBien" name="type_bien" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                        <option value="">Selectionnez</option>
                        <option value="maison">Maison</option>
                        <option value="appartement">Appartement</option>
                        <option value="local">Local professionnel</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
                <div class="mt-3">
                    <label for="devisProject" class="mb-1 block text-sm font-semibold">Nature du projet</label>
                    <select id="devisProject" name="projet" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25">
                        <option value="toiture_couverture">Toiture &amp; couverture</option>
                        <option value="demoussage">Nettoyage &amp; demoussage de toiture</option>
                        <option value="hydrofuge">Traitement hydrofuge</option>
                        <option value="facade">Renovation de facade</option>
                        <option value="isolation">Isolation thermique</option>
                        <option value="vmc">Ventilation (VMC / VMI)</option>
                        <option value="electricite">Mise aux normes electriques</option>
                        <option value="solaire">Installation photovoltaique</option>
                        <option value="clim">Climatisation &amp; confort d'ete</option>
                        <option value="humidite">Traitement de l'humidite</option>
                        <option value="adoucisseur">Adoucisseur d'eau</option>
                        <option value="charpente">Traitement de charpente</option>
                        <option value="multiple">Plusieurs travaux</option>
                        <option value="conseil">Je souhaite etre conseille(e)</option>
                    </select>
                </div>
                <div class="mt-3">
                    <label for="devisMessage" class="mb-1 block text-sm font-semibold">Message et precisions</label>
                    <textarea id="devisMessage" name="message" rows="4" placeholder="Surface approximative, urgence, questions sur MaPrimeRénov ou CEE..." class="w-full resize-y rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/25"></textarea>
                </div>
                <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-start">
                    <label class="flex cursor-pointer gap-2 text-xs text-slate-600 sm:max-w-lg">
                        <input type="checkbox" name="rgpd" value="1" class="mt-0.5 h-4 w-4 shrink-0 rounded border-slate-300 text-brand-blue focus:ring-brand-blue">
                        <span>J'accepte que mes informations soient utilisees pour me recontacter concernant ma demande (voir les engagements RGPD de l'entreprise).</span>
                    </label>
                </div>
                <button type="submit" class="mt-5 w-full rounded-xl bg-brand-yellow px-4 py-3.5 text-sm font-extrabold text-brand-dark shadow-soft transition hover:bg-yellow-300 sm:text-base">Envoyer ma demande — devis gratuit</button>
                <p class="mt-3 text-center text-xs text-slate-500">Sans engagement. Un conseiller vous rappelle pour affiner votre projet.</p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section id="conseils" class="bg-slate-50/70 py-16 sm:py-20 scroll-mt-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="mb-2 text-4xl font-extrabold leading-tight text-brand-dark sm:text-5xl"><span class="text-brand-blue">Astuces</span> & blog</h2>
            <p class="mb-8 max-w-2xl text-base text-slate-600 sm:text-lg">Conseils pratiques pour preparer vos travaux, mieux comprendre les aides et entretenir votre logement durablement.</p>
            <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                <article class="flex h-full flex-col rounded-2xl border border-slate-200 bg-white p-6 shadow-soft transition hover:border-brand-blue/30">
                    <p class="mb-2 text-xs font-bold uppercase tracking-wide text-brand-blue">Isolation</p>
                    <h3 class="mb-2 text-xl font-extrabold text-brand-dark">Combles perdus ou amenages : par ou commencer ?</h3>
                    <p class="flex-1 text-sm leading-relaxed text-slate-600">Les bonnes questions sur l'epaisseur, la ventilation et l'humidite avant de signer un devis d'isolation.</p>
                    <a href="#devis" class="mt-4 inline-flex text-sm font-bold text-brand-blue transition hover:text-brand-dark">Demander un avis technique →</a>
                </article>
                <article class="flex h-full flex-col rounded-2xl border border-slate-200 bg-white p-6 shadow-soft transition hover:border-brand-blue/30">
                    <p class="mb-2 text-xs font-bold uppercase tracking-wide text-brand-blue">Aides</p>
                    <h3 class="mb-2 text-xl font-extrabold text-brand-dark">MaPrimeRénov' & CEE : cumul et dossier sans prise de tete</h3>
                    <p class="flex-1 text-sm leading-relaxed text-slate-600">Ce qui change souvent, les pieces a anticiper et comment une entreprise RGE vous aide a securiser vos droits.</p>
                    <a href="#devis" class="mt-4 inline-flex text-sm font-bold text-brand-blue transition hover:text-brand-dark">Parler a un conseiller →</a>
                </article>
                <article class="flex h-full flex-col rounded-2xl border border-slate-200 bg-white p-6 shadow-soft transition hover:border-brand-blue/30 md:col-span-2 lg:col-span-1">
                    <p class="mb-2 text-xs font-bold uppercase tracking-wide text-brand-blue">Entretien</p>
                    <h3 class="mb-2 text-xl font-extrabold text-brand-dark">Toiture : signes qui doivent declencher un controle</h3>
                    <p class="flex-1 text-sm leading-relaxed text-slate-600">Tuiles, zinguerie, isolation — reperer tot les traces d'infiltration limite les grosses reparations.</p>
                    <a href="#realisations" class="mt-4 inline-flex text-sm font-bold text-brand-blue transition hover:text-brand-dark">Voir nos chantiers →</a>
                </article>
            </div>
        </div>
    </section>

    <section class="partners-marquee border-y border-white/10 bg-neutral-950 py-9 text-white" aria-label="Partenaires et labels">
        <p class="mx-auto max-w-7xl px-4 text-center text-[11px] font-extrabold uppercase tracking-[0.28em] text-slate-500 sm:px-6 lg:px-8">Nos partenaires &amp; certifications</p>
        <div class="relative mt-6 overflow-hidden [mask-image:linear-gradient(to_right,transparent,black_12%,black_88%,transparent)]">
            <div class="partners-marquee-track">
                <div class="flex shrink-0 items-center gap-x-14 gap-y-6 px-8 sm:gap-x-20">
                    <img src="/logo.png" alt="Normes et Rénovation" class="h-9 w-auto object-contain opacity-80 grayscale invert sm:h-11" width="160" height="44">
                    <img src="/nous/rge.png" alt="RGE Qualibat" class="h-10 w-auto max-w-[130px] object-contain opacity-80 grayscale invert sm:h-12" width="130" height="48">
                    <img src="/nous/rge ventilation_.png" alt="RGE Ventilation" class="h-10 w-auto max-w-[130px] object-contain opacity-80 grayscale invert sm:h-12" width="130" height="48">
                    <img src="/nous/ECO.png" alt="Éco-responsable" class="h-10 w-auto max-w-[100px] object-contain opacity-80 grayscale invert sm:h-12" width="100" height="48">
                    <img src="/iconne.png" alt="Normes et Rénovation" class="h-10 w-10 rounded-full object-cover opacity-80 grayscale invert ring-2 ring-white/20 sm:h-12 sm:w-12" width="48" height="48">
                    <img src="/nous/ma prime.png" alt="MaPrimeRénov'" class="h-9 w-auto max-w-[120px] object-contain opacity-80 grayscale invert sm:h-11" width="120" height="40">
                </div>
                <div class="flex shrink-0 items-center gap-x-14 gap-y-6 px-8 sm:gap-x-20" aria-hidden="true">
                    <img src="/logo.png" alt="" class="h-9 w-auto object-contain opacity-80 grayscale invert sm:h-11" width="160" height="44">
                    <img src="/nous/rge.png" alt="" class="h-10 w-auto max-w-[130px] object-contain opacity-80 grayscale invert sm:h-12" width="130" height="48">
                    <img src="/nous/rge ventilation_.png" alt="" class="h-10 w-auto max-w-[130px] object-contain opacity-80 grayscale invert sm:h-12" width="130" height="48">
                    <img src="/nous/ECO.png" alt="" class="h-10 w-auto max-w-[100px] object-contain opacity-80 grayscale invert sm:h-12" width="100" height="48">
                    <img src="/iconne.png" alt="" class="h-10 w-10 rounded-full object-cover opacity-80 grayscale invert ring-2 ring-white/20 sm:h-12 sm:w-12" width="48" height="48">
                    <img src="/nous/ma prime.png" alt="" class="h-9 w-auto max-w-[120px] object-contain opacity-80 grayscale invert sm:h-11" width="120" height="40">
                </div>
            </div>
        </div>
    </section>

    <footer class="footer-hero-bg relative border-t-4 border-brand-blue text-white">
        <div class="absolute inset-0 bg-brand-dark/86 pointer-events-none"></div>
        <div class="relative z-10 mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-14">
            <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-12 lg:gap-x-10 lg:gap-y-8">
                <div class="lg:col-span-4">
                    <a href="#top" class="inline-block rounded-lg bg-white/95 px-3 py-2">
                        <img src="/logo.png" alt="Normes &amp; Rénovation" class="h-10 w-auto sm:h-11">
                    </a>
                    <h3 class="mt-8 text-xs font-bold uppercase tracking-wider text-brand-yellow">Siège social</h3>
                    <p class="mt-2 text-sm font-semibold">Normes et Rénovation</p>
                    <p class="mt-1 text-sm leading-relaxed text-slate-300">6 rue Pierre de Coubertin<br>71100 Chalon-sur-Saône</p>
                    <dl class="mt-5 space-y-2 border-t border-white/15 pt-5 text-xs text-slate-400">
                        <div><dt class="inline text-slate-500">Représentant légal ·</dt> <dd class="inline text-slate-300">Conformément aux statuts.</dd></div>
                        <div><dt class="text-slate-500">RCS</dt> <dd class="font-mono text-slate-200">Chalon-sur-Saône — 900&nbsp;571&nbsp;696&nbsp;00013</dd></div>
                        <div><dt class="text-slate-500">SIREN</dt> <dd class="font-mono text-slate-200">900&nbsp;571&nbsp;696</dd></div>
                        <div><dt class="text-slate-500">SIRET (siège)</dt> <dd class="font-mono text-slate-200">900&nbsp;571&nbsp;696&nbsp;00013</dd></div>
                        <div><dt class="text-slate-500">TVA</dt> <dd class="font-mono text-slate-200">FR96&nbsp;900&nbsp;571&nbsp;696</dd></div>
                    </dl>
                </div>
                <div class="lg:col-span-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-brand-yellow">Contact</h3>
                    <p class="mt-4 text-sm text-slate-300">Téléphone</p>
                    <a href="tel:+33385419886" class="text-base font-bold text-brand-blue transition hover:text-white">03&nbsp;85&nbsp;41&nbsp;98&nbsp;86</a>
                    <p class="mt-4 text-sm text-slate-300">E-mail</p>
                    <a href="mailto:bourgogne-agence@normesrenovation.fr" class="break-all text-sm text-white underline-offset-2 transition hover:text-brand-yellow hover:underline">bourgogne-agence@normesrenovation.fr</a>

                    <h3 class="mt-10 text-xs font-bold uppercase tracking-wider text-brand-yellow">Nos agences</h3>
                    <div class="mt-3 space-y-5 text-sm">
                        <div>
                            <p class="font-semibold text-white">Chalon-sur-Saône (71)</p>
                            <p class="mt-1 text-slate-300">6 rue Pierre de Coubertin<br>71100 Chalon-sur-Saône</p>
                            <a href="tel:+33385419886" class="mt-1 inline-block font-semibold text-brand-blue transition hover:text-white">03&nbsp;85&nbsp;41&nbsp;98&nbsp;86</a>
                        </div>
                        <div class="border-t border-white/10 pt-5">
                            <p class="font-semibold text-white">Bretagne (22)</p>
                            <p class="mt-1 text-slate-300">ZA de Mikez<br>22540 Pédernec</p>
                            <a href="tel:+33296400755" class="mt-1 inline-block font-semibold text-brand-blue transition hover:text-white">02&nbsp;96&nbsp;40&nbsp;07&nbsp;55</a>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-2">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-brand-yellow">Liens rapides</h3>
                    <ul class="mt-4 space-y-2 text-sm text-slate-300">
                        <li><a href="#services" class="transition hover:text-white">Nos services</a></li>
                        <li><a href="#realisations" class="transition hover:text-white">Réalisations</a></li>
                        <li><a href="#agences" class="transition hover:text-white">Agences &amp; carte</a></li>
                        <li><a href="#conseils" class="transition hover:text-white">Conseils</a></li>
                        <li><a href="#devis" class="font-semibold text-brand-blue transition hover:text-white">Contact / devis</a></li>
                    </ul>
                </div>
                <div class="lg:col-span-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-brand-yellow">Réseaux</h3>
                    <p class="mt-4 text-xs leading-relaxed text-slate-400">Lundi au vendredi sur rendez-vous. En urgence, appelez l'agence la plus proche.</p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="#" aria-label="Facebook Normes &amp; Rénovation" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#1877F2] text-white transition hover:opacity-90">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" aria-label="LinkedIn Normes &amp; Rénovation" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#0A66C2] text-white transition hover:opacity-90">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                        <a href="#" aria-label="Instagram Normes &amp; Rénovation" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white transition hover:opacity-90">
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
                    </div>
                </div>
            </div>
            <div class="mt-12 flex flex-col gap-3 border-t border-white/15 pt-8 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">
                <p>&copy; <span id="footerYear"></span> Normes et Rénovation. Tous droits réservés.</p>
                <p class="sm:text-right">Entreprise RGE — Rénovation énergétique — <a href="#devis" class="text-slate-400 underline-offset-2 transition hover:text-white hover:underline">Demander un devis</a></p>
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
            const y = document.getElementById('footerYear');
            if (y) y.textContent = String(new Date().getFullYear());
        })();
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
                    title: "Besoin d'un devis clair pour votre projet ?",
                    subtitle: "Expliquez-nous vos travaux : nos equipes vous repondent et vous orientent sur les aides et le financement.",
                    primaryText: "Demander un devis gratuit",
                    primaryHref: "#devis",
                    secondaryText: "Nous contacter",
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
            const serviceSection = document.getElementById('services');

            const setServiceFilter = (selected) => {
                if (!serviceCards.length) return;
                const tokens = !selected || selected === 'all' ? null : String(selected).split(/\s+/).filter(Boolean);
                serviceCards.forEach((card) => {
                    const categories = (card.dataset.category || '').split(' ').filter(Boolean);
                    const visible = !tokens || tokens.some((t) => categories.includes(t));
                    card.classList.toggle('hidden', !visible);
                });
            };

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

                        setServiceFilter(selected);
                    });
                });
            }

            document.querySelectorAll('a.service-submenu-link[data-service-filter-group]').forEach((link) => {
                link.addEventListener('click', (e) => {
                    const group = link.dataset.serviceFilterGroup;
                    if (!group || !serviceCards.length) return;
                    e.preventDefault();
                    setServiceFilter(group);
                    filterButtons.forEach((item) => {
                        item.classList.remove('bg-brand-dark', 'text-white', 'border-brand-dark');
                        item.classList.add('bg-white', 'text-slate-700', 'border-slate-300');
                    });
                    serviceSection?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    document.getElementById('mobileMenu')?.classList.add('hidden');
                });
            });

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
