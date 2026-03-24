<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Normes & Renovation - Rénovation énergétique en Bourgogne</title>
    <meta name="description" content="Normes & Renovation accompagne vos projets de rénovation énergétique, thermique et électrique en Bourgogne. Devis gratuit, solutions durables, entreprise certifiée RGE.">
    <link rel="icon" type="image/png" href="/iconne.png">
    <style>
        :root {
            --blue: #60b4f9;
            --yellow: #fadf70;
            --dark: #2f4251;
            --white: #ffffff;
            --light: #f8fbfe;
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: "Google Sans", "Product Sans", "Segoe UI", Arial, sans-serif;
            color: var(--dark);
            background: var(--white);
            line-height: 1.5;
        }
        a { color: inherit; text-decoration: none; }
        .container {
            width: min(1180px, 100% - 32px);
            margin: 0 auto;
        }
        .section { padding: 78px 0; }
        .alt { background: var(--light); }
        .title {
            margin: 0 0 10px;
            font-size: clamp(30px, 4.4vw, 48px);
            line-height: 1.1;
            color: var(--dark);
        }
        .subtitle {
            margin: 0 0 28px;
            color: #4a5f70;
            font-size: 18px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 20px;
            border-radius: 12px;
            border: 0;
            font-weight: 700;
            cursor: pointer;
            transition: transform .2s ease, background-color .2s ease, box-shadow .2s ease;
        }
        .btn:hover { transform: translateY(-1px); }
        .btn-primary {
            background: var(--blue);
            color: #fff;
            box-shadow: 0 10px 24px rgba(96, 180, 249, .35);
        }
        .btn-primary:hover { background: #4aa8f6; }
        .btn-secondary {
            background: var(--yellow);
            color: var(--dark);
            box-shadow: 0 10px 24px rgba(250, 223, 112, .35);
        }
        .btn-secondary:hover { background: #f6d65a; }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255, 255, 255, .95);
            border-bottom: 1px solid #e8eef4;
            backdrop-filter: blur(8px);
        }
        .topbar-inner {
            min-height: 86px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }
        .logo img {
            height: 52px;
            width: auto;
            display: block;
        }
        .menu {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
            font-size: 17px;
            font-weight: 600;
        }
        .menu a:hover { color: var(--blue); }
        .socials {
            display: flex;
            gap: 8px;
            margin-left: 4px;
        }
        .social {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 800;
            border: 1px solid rgba(255,255,255,.7);
            transition: background-color .2s ease, color .2s ease;
        }
        .social.fb { background: var(--blue); }
        .social.in { background: var(--dark); }
        .social:hover {
            background: var(--yellow);
            color: var(--dark);
            border-color: var(--yellow);
        }

        .hero {
            min-height: clamp(520px, 78vh, 720px);
            display: grid;
            align-items: end;
            padding: 0 0 34px;
            position: relative;
            overflow: hidden;
            background-image: linear-gradient(110deg, rgba(47, 66, 81, .72), rgba(47, 66, 81, .28)), url('https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
        }
        .hero-inner {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 18px;
        }
        .hero-copy { max-width: 690px; color: #fff; }
        .hero-copy h1 {
            margin: 0 0 10px;
            font-size: clamp(34px, 5.2vw, 62px);
            line-height: 1.06;
            letter-spacing: -.02em;
        }
        .hero-copy p {
            margin: 0 0 20px;
            font-size: clamp(17px, 2.2vw, 22px);
            color: #e8edf2;
        }
        .hero-cta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        .hero-thumbs {
            display: flex;
            gap: 10px;
        }
        .thumb {
            width: 126px;
            height: 86px;
            border-radius: 12px;
            border: 2px solid transparent;
            overflow: hidden;
            cursor: pointer;
            position: relative;
            box-shadow: 0 8px 22px rgba(0, 0, 0, .28);
            transition: transform .2s ease, border-color .2s ease;
            background-size: cover;
            background-position: center;
        }
        .thumb::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, .22);
        }
        .thumb.active { border-color: var(--blue); transform: translateY(-3px); }
        .thumb.active::after { background: rgba(0, 0, 0, .04); }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }
        .service-card {
            background: #fff;
            border-radius: 14px;
            padding: 18px;
            border: 1px solid #ebf1f7;
            box-shadow: 0 8px 20px rgba(47, 66, 81, .06);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .service-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 28px rgba(47, 66, 81, .12);
        }
        .service-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #e8f5ff;
            color: var(--blue);
            display: grid;
            place-items: center;
            font-size: 20px;
            margin-bottom: 12px;
        }
        .service-card h3 { margin: 0 0 6px; font-size: 18px; }
        .service-card p { margin: 0; color: #4f6475; font-size: 14px; }

        .before-after {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #ebf1f7;
            overflow: hidden;
            box-shadow: 0 10px 24px rgba(47, 66, 81, .08);
        }
        .ba-wrap {
            position: relative;
            height: 420px;
            background: #dfe8f0;
        }
        .ba-before, .ba-after {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
        }
        .ba-before { background-image: url('https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=1400&q=80'); }
        .ba-after {
            background-image: url('https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&w=1400&q=80');
            clip-path: inset(0 0 0 50%);
        }
        .ba-range {
            width: 100%;
            margin: 0;
            accent-color: var(--blue);
        }
        .ba-labels {
            display: flex;
            justify-content: space-between;
            padding: 12px 16px;
            color: #4f6475;
            font-weight: 700;
            background: #f9fbfe;
        }

        .why-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }
        .why-item {
            border: 1px solid #e7eef5;
            border-radius: 12px;
            padding: 16px;
            background: #fff;
        }
        .why-item b { color: var(--dark); display: block; margin-bottom: 6px; }
        .why-item p { margin: 0; color: #4f6475; }

        .stats {
            background: var(--dark);
            color: #fff;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }
        .stat {
            text-align: center;
            padding: 12px;
        }
        .stat strong {
            display: block;
            color: var(--yellow);
            font-size: clamp(28px, 4vw, 44px);
            line-height: 1.1;
        }

        .reviews-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }
        .review {
            border: 1px solid #e8eef5;
            border-radius: 12px;
            padding: 16px;
            background: #fff;
        }
        .stars { color: #ffbe00; letter-spacing: 1px; margin-bottom: 8px; }
        .review p { margin: 0 0 10px; color: #4f6475; }
        .review b { font-size: 14px; }

        .cta-final {
            background: var(--dark);
            color: #fff;
        }
        .cta-wrap {
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            gap: 18px;
            align-items: center;
        }
        .cta-final h2 { margin: 0 0 10px; font-size: clamp(30px, 4vw, 46px); line-height: 1.1; }
        .cta-final p { margin: 0; color: #d5dee7; }
        .quote-form {
            background: #fff;
            border-radius: 14px;
            padding: 16px;
            color: var(--dark);
        }
        .quote-form label { display: block; margin: 8px 0 6px; font-weight: 600; }
        .quote-form input, .quote-form select, .quote-form textarea {
            width: 100%;
            border: 1px solid #d9e3ec;
            border-radius: 10px;
            padding: 10px 12px;
            font-family: inherit;
        }
        .quote-form textarea { min-height: 86px; resize: vertical; }

        .bonus-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }
        .bonus {
            border: 1px solid #e7eef5;
            border-radius: 12px;
            background: #fff;
            padding: 16px;
        }
        .bonus h3 { margin: 0 0 6px; font-size: 18px; }
        .bonus p { margin: 0; color: #4f6475; }

        .footer {
            background: var(--dark);
            color: #fff;
            padding: 32px 0;
        }
        .footer p { margin: 6px 0; color: #d7e0e8; }

        .call-mobile {
            position: fixed;
            right: 16px;
            bottom: 16px;
            z-index: 130;
            background: var(--blue);
            color: #fff;
            border-radius: 999px;
            padding: 12px 16px;
            font-weight: 700;
            box-shadow: 0 12px 26px rgba(96, 180, 249, .4);
            display: none;
        }
        .call-mobile:hover { background: #4aa8f6; }

        @media (max-width: 1020px) {
            .menu { gap: 12px; font-size: 15px; }
            .services-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .why-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .reviews-grid { grid-template-columns: 1fr; }
            .cta-wrap { grid-template-columns: 1fr; }
            .bonus-grid { grid-template-columns: 1fr; }
            .hero {
                min-height: 620px;
                padding-bottom: 22px;
            }
            .hero-inner {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
            .hero-thumbs { width: 100%; }
            .thumb { width: calc((100% - 20px) / 3); min-width: 90px; }
            .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .call-mobile { display: inline-flex; }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="container topbar-inner">
            <a class="logo" href="#top"><img src="/logo.png" alt="Normes & Renovation"></a>
            <nav class="menu">
                <a href="#top">Acceuil</a>
                <a href="#services">nos services</a>
                <a href="#franchise">agences</a>
                <a href="#realisations">nos realisation</a>
                <a class="btn btn-primary" href="#devis">Nous contacter</a>
                <div class="socials">
                    <a class="social fb" href="#" aria-label="Facebook">F</a>
                    <a class="social in" href="#" aria-label="LinkedIn">in</a>
                </div>
            </nav>
        </div>
    </header>

    <section class="hero" id="top">
        <div class="container hero-inner">
            <div class="hero-copy">
                <h1>Renovez, Economisez, Valorisez votre maison</h1>
                <p>Expert en renovation energetique en Bourgogne. Nous vous accompagnons de l'etude a la realisation avec des solutions performantes et durables.</p>
                <div class="hero-cta">
                    <a class="btn btn-primary" href="#devis">Devis gratuit</a>
                    <a class="btn btn-secondary" href="#devis">Etre rappele</a>
                </div>
            </div>
            <div class="hero-thumbs" id="heroThumbs">
                <button class="thumb active" data-hero="1" style="background-image:url('https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=600&q=80')" aria-label="Slide 1"></button>
                <button class="thumb" data-hero="2" style="background-image:url('https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=600&q=80')" aria-label="Slide 2"></button>
                <button class="thumb" data-hero="3" style="background-image:url('https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=600&q=80')" aria-label="Slide 3"></button>
            </div>
        </div>
    </section>

    <section class="section alt" id="services">
        <div class="container">
            <h2 class="title">Nos services de renovation</h2>
            <p class="subtitle">Des prestations completes pour améliorer votre confort thermique, réduire vos consommations et valoriser votre bien.</p>
            <div class="services-grid">
                <article class="service-card"><div class="service-icon">🏠</div><h3>Toiture & couverture</h3><p>Protection durable et etancheite optimisee de votre habitat.</p></article>
                <article class="service-card"><div class="service-icon">🧱</div><h3>Isolation thermique</h3><p>Confort hiver/ete et baisse de vos depenses energetiques.</p></article>
                <article class="service-card"><div class="service-icon">🧰</div><h3>Façade & ravalement</h3><p>Valorisation esthetique et protection longue duree de votre facade.</p></article>
                <article class="service-card"><div class="service-icon">💧</div><h3>Traitement humidite</h3><p>Diagnostic et traitement durable contre infiltrations et moisissures.</p></article>
                <article class="service-card"><div class="service-icon">🌬️</div><h3>Ventilation</h3><p>Air interieur sain et qualite de vie amelioree au quotidien.</p></article>
                <article class="service-card"><div class="service-icon">⚡</div><h3>Electricite</h3><p>Mise en securite et modernisation de vos installations electriques.</p></article>
                <article class="service-card"><div class="service-icon">☀️</div><h3>Photovoltaique</h3><p>Production d'electricite locale pour plus d'autonomie energetique.</p></article>
                <article class="service-card"><div class="service-icon">❄️</div><h3>Climatisation</h3><p>Solutions performantes pour un confort optimal toute l'annee.</p></article>
            </div>
        </div>
    </section>

    <section class="section" id="realisations">
        <div class="container">
            <h2 class="title">Avant / Apres : des resultats visibles immediatement</h2>
            <p class="subtitle">Comparez en un coup d'oeil la transformation de votre habitat.</p>
            <div class="before-after">
                <div class="ba-wrap">
                    <div class="ba-before"></div>
                    <div class="ba-after" id="afterLayer"></div>
                </div>
                <input class="ba-range" type="range" min="0" max="100" value="50" id="baRange" aria-label="Comparateur avant apres">
                <div class="ba-labels"><span>Avant</span><span>Apres</span></div>
            </div>
        </div>
    </section>

    <section class="section alt">
        <div class="container">
            <h2 class="title">Pourquoi nous choisir ?</h2>
            <div class="why-grid">
                <article class="why-item"><b>Expertise technique</b><p>Des equipes qualifiees pour des solutions adaptees a votre maison.</p></article>
                <article class="why-item"><b>Entreprise certifiee RGE</b><p>Un accompagnement eligible aux dispositifs et aides en vigueur.</p></article>
                <article class="why-item"><b>Solutions durables</b><p>Des materiaux et equipements performants, pensés pour durer.</p></article>
                <article class="why-item"><b>Accompagnement complet</b><p>Un interlocuteur unique du devis jusqu'a la fin des travaux.</p></article>
            </div>
        </div>
    </section>

    <section class="section stats">
        <div class="container">
            <div class="stats-grid">
                <article class="stat"><strong>+1000</strong><span>chantiers realises</span></article>
                <article class="stat"><strong>98%</strong><span>de satisfaction client</span></article>
                <article class="stat"><strong>48h</strong><span>pour une prise en charge rapide</span></article>
                <article class="stat"><strong>100%</strong><span>devis gratuit et detaille</span></article>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h2 class="title">Avis clients</h2>
            <p class="subtitle">La confiance de nos clients est notre meilleure référence.</p>
            <div class="reviews-grid">
                <article class="review"><div class="stars">★★★★★</div><p>Equipe serieuse, chantier propre et resultat impeccable. Nous avons immediatement ressenti le gain de confort.</p><b>Claire M. - Chalon-sur-Saone</b></article>
                <article class="review"><div class="stars">★★★★★</div><p>Accompagnement tres pro du debut a la fin. Les conseils sur l'isolation nous ont permis de mieux maitriser nos factures.</p><b>Julien R. - Bourgogne</b></article>
                <article class="review"><div class="stars">★★★★★</div><p>Travail de qualite et delais respectes. Une equipe a l'ecoute avec une vraie expertise technique.</p><b>Sophie L. - Saone-et-Loire</b></article>
            </div>
        </div>
    </section>

    <section class="section cta-final" id="devis">
        <div class="container cta-wrap">
            <div>
                <h2>Vous avez un projet de renovation ?</h2>
                <p>Simulez votre besoin, obtenez un premier niveau d'estimation et recevez un accompagnement personnalise en Bourgogne.</p>
            </div>
            <form class="quote-form">
                <label for="name">Nom</label>
                <input id="name" type="text" placeholder="Votre nom">
                <label for="phone">Telephone</label>
                <input id="phone" type="tel" placeholder="Votre numero">
                <label for="type">Type de projet</label>
                <select id="type">
                    <option>Isolation</option>
                    <option>Toiture</option>
                    <option>Electricite</option>
                    <option>Photovoltaique</option>
                    <option>Climatisation</option>
                </select>
                <label for="msg">Message</label>
                <textarea id="msg" placeholder="Decrivez votre besoin"></textarea>
                <div style="margin-top:12px;">
                    <button class="btn btn-secondary" type="button">Recevoir mon devis gratuit</button>
                </div>
            </form>
        </div>
    </section>

    <section class="section alt" id="franchise">
        <div class="container">
            <h2 class="title">Bonus conversion</h2>
            <div class="bonus-grid">
                <article class="bonus"><h3>Simulateur de devis</h3><p>Un parcours simple pour qualifier votre projet en quelques clics.</p></article>
                <article class="bonus"><h3>Page realisations</h3><p>Mise en avant de chantiers avant/apres pour rassurer et convertir.</p></article>
                <article class="bonus"><h3>Blog SEO 2026</h3><p>Contenus aides 2026, isolation, chauffage et renovation energetique.</p></article>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <h3 style="margin:0 0 8px;">Normes & Renovation</h3>
            <p>6 rue Pierre de Coubertin, 71100 Chalon-sur-Saone</p>
            <p>03 85 41 98 86</p>
            <p>bourgogne-agence@normesrenovation.fr</p>
        </div>
    </footer>

    <a class="call-mobile" href="tel:+33385419886">Appeler maintenant</a>

    <script>
        (function () {
            const hero = document.querySelector('.hero');
            const thumbs = Array.from(document.querySelectorAll('#heroThumbs .thumb'));
            const backgrounds = {
                1: "linear-gradient(110deg, rgba(47,66,81,.72), rgba(47,66,81,.28)), url('https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=1600&q=80')",
                2: "linear-gradient(110deg, rgba(47,66,81,.72), rgba(47,66,81,.28)), url('https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=1600&q=80')",
                3: "linear-gradient(110deg, rgba(47,66,81,.72), rgba(47,66,81,.28)), url('https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1600&q=80')"
            };
            thumbs.forEach((thumb) => {
                thumb.addEventListener('click', () => {
                    const id = thumb.getAttribute('data-hero');
                    hero.style.backgroundImage = backgrounds[id];
                    thumbs.forEach((t) => t.classList.remove('active'));
                    thumb.classList.add('active');
                });
            });

            const range = document.getElementById('baRange');
            const afterLayer = document.getElementById('afterLayer');
            if (range && afterLayer) {
                range.addEventListener('input', () => {
                    const value = Number(range.value);
                    afterLayer.style.clipPath = `inset(0 0 0 ${value}%)`;
                });
            }
        })();
    </script>
</body>
</html>
