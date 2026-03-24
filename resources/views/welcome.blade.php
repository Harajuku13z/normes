<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NORMES - Accueil</title>
    <link rel="icon" type="image/png" href="/iconne.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <style>
        :root {
            --brand: #60b4f9;
            --text: #2f4251;
            --muted: #2f4251;
            --bg: #ffffff;
            --accent: #fadf70;
            --white: #ffffff;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Google Sans", "Product Sans", "Manrope", Arial, sans-serif;
            color: var(--text);
            background: var(--bg);
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .topbar {
            background: var(--white);
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 20;
            backdrop-filter: blur(8px);
        }
        .topbar-inner {
            min-height: 88px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: bold;
            font-size: 20px;
        }
        .logo img {
            height: 54px;
            width: auto;
            display: block;
        }
        .menu {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
        }
        .menu a {
            text-decoration: none;
            color: var(--text);
            font-weight: 600;
            font-size: 17px;
            transition: color .2s ease;
        }
        .menu a:hover {
            color: var(--brand);
        }
        .menu .contact-btn {
            border: 0;
            color: #ffffff;
            padding: 11px 20px;
            border-radius: 10px;
            background: var(--brand);
            font-weight: 700;
            box-shadow: 0 10px 25px rgba(96, 180, 249, 0.35);
            transition: background-color .2s ease, color .2s ease, transform .2s ease;
        }
        .menu .contact-btn:hover {
            background: var(--accent);
            color: var(--text);
            transform: translateY(-1px);
        }
        .socials {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .social-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            color: #ffffff;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 14px;
            border: 1px solid rgba(255, 255, 255, 0.65);
            box-shadow: 0 8px 18px rgba(47, 66, 81, 0.25);
            transition: transform .2s ease, background-color .2s ease, color .2s ease;
        }
        .social-icon:hover {
            transform: translateY(-2px);
            background: var(--accent);
            color: var(--text);
            border-color: var(--accent);
        }
        .social-icon.facebook {
            background: #60b4f9;
        }
        .social-icon.linkedin {
            background: #2f4251;
        }

        .hero { padding: 0; }
        .hero-shell {
            width: 100%;
        }
        .slider {
            position: relative;
            height: calc(72vh - 44px);
            min-height: 430px;
            max-height: 620px;
            overflow: hidden;
            background: #dbe4f0;
        }
        .slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity .55s ease;
            background-size: cover;
            background-position: center;
        }
        .slide::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(47, 66, 81, .70), rgba(47, 66, 81, .28));
        }
        .slide.active { opacity: 1; }
        .slide-content-wrap {
            position: absolute;
            z-index: 2;
            left: 0;
            right: 0;
            bottom: 38px;
        }
        .slide-content {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
        }
        .slide-copy {
            color: #fff;
            max-width: 650px;
        }
        .slide-title {
            margin: 0 0 8px;
            font-size: clamp(32px, 4.2vw, 56px);
            line-height: 1.1;
            font-weight: 800;
            letter-spacing: -0.02em;
        }
        .slide-subtitle {
            margin: 0 0 16px;
            color: #e5e7eb;
            line-height: 1.6;
            font-size: 18px;
            max-width: 560px;
        }
        .slide-btn {
            display: inline-block;
            background: var(--brand);
            color: #ffffff;
            padding: 12px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            box-shadow: 0 10px 20px rgba(96, 180, 249, 0.35);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .slide-btn:hover {
            background: var(--accent);
            color: var(--text);
            transform: translateY(-1px);
            box-shadow: 0 14px 26px rgba(250, 223, 112, 0.35);
        }
        .thumbs {
            display: flex;
            flex-direction: row;
            gap: 12px;
            width: auto;
        }
        .thumb {
            width: 122px;
            height: 86px;
            border-radius: 14px;
            background-size: cover;
            background-position: center;
            border: 2px solid transparent;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.22);
            transition: transform .22s ease, border-color .22s ease;
        }
        .thumb::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, .2);
        }
        .thumb.active {
            border-color: var(--brand);
            transform: translateY(-4px);
        }
        .thumb.active::after {
            background: rgba(0, 0, 0, .05);
        }
        @media (max-width: 980px) {
            .slider {
                height: 470px;
                min-height: 470px;
            }
            .slide-content-wrap { bottom: 20px; }
            .slide-content { flex-direction: column; align-items: flex-start; gap: 14px; }
            .slide-subtitle { font-size: 16px; }
            .thumbs { width: 100%; }
            .thumb {
                width: calc((100% - 24px) / 3);
                min-width: 88px;
            }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="container topbar-inner">
            <div class="logo">
                <img src="/logo.png" alt="Normes Rénovation">
            </div>

            <nav class="menu">
                <a href="#">Acceuil</a>
                <a href="#">nos services</a>
                <a href="#">agences</a>
                <a href="#">nos realisation</a>
                <a class="contact-btn" href="#">Nous contacter</a>
                <div class="socials">
                    <a class="social-icon facebook" href="#" aria-label="Facebook">F</a>
                    <a class="social-icon linkedin" href="#" aria-label="LinkedIn">in</a>
                </div>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="hero-shell">
            <div class="slider" id="main-slider">
                <article class="slide active" data-index="0" style="background-image:url('https://picsum.photos/1200/700?random=21');">
                    <div class="slide-content-wrap">
                        <div class="container slide-content">
                            <div class="slide-copy">
                                <h1 class="slide-title">Accompagnement professionnel</h1>
                                <p class="slide-subtitle">Des solutions sur mesure pour faire grandir votre entreprise sereinement.</p>
                                <a class="slide-btn" href="#">Simulateur de devis</a>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="slide" data-index="1" style="background-image:url('https://picsum.photos/1200/700?random=22');">
                    <div class="slide-content-wrap">
                        <div class="container slide-content">
                            <div class="slide-copy">
                                <h2 class="slide-title">Expertise et performance</h2>
                                <p class="slide-subtitle">Une equipe engagee pour des resultats mesurables sur tous vos projets.</p>
                                <a class="slide-btn" href="#">Nous contact</a>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="slide" data-index="2" style="background-image:url('https://picsum.photos/1200/700?random=23');">
                    <div class="slide-content-wrap">
                        <div class="container slide-content">
                            <div class="slide-copy">
                                <h2 class="slide-title">Presence nationale</h2>
                                <p class="slide-subtitle">Nos agences franchise vous accompagnent au plus pres de vos besoins.</p>
                                <a class="slide-btn" href="#">Devenir franchiser</a>
                            </div>
                        </div>
                    </div>
                </article>
                <div class="slide-content-wrap">
                    <div class="container" style="display:flex; justify-content:flex-end;">
                        <aside class="thumbs" id="thumbs">
                            <button class="thumb active" data-target="0" style="background-image:url('https://picsum.photos/400/300?random=21');" aria-label="Slide 1"></button>
                            <button class="thumb" data-target="1" style="background-image:url('https://picsum.photos/400/300?random=22');" aria-label="Slide 2"></button>
                            <button class="thumb" data-target="2" style="background-image:url('https://picsum.photos/400/300?random=23');" aria-label="Slide 3"></button>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        (function () {
            const slides = Array.from(document.querySelectorAll('.slide'));
            const thumbs = Array.from(document.querySelectorAll('.thumb'));
            let current = 0;
            let timerId = null;

            function show(index) {
                current = index;
                slides.forEach((slide, i) => slide.classList.toggle('active', i === index));
                thumbs.forEach((thumb, i) => thumb.classList.toggle('active', i === index));
            }

            function next() {
                show((current + 1) % slides.length);
            }

            function start() {
                timerId = setInterval(next, 4500);
            }

            function reset() {
                if (timerId) clearInterval(timerId);
                start();
            }

            thumbs.forEach((thumb, index) => {
                thumb.addEventListener('click', () => {
                    show(index);
                    reset();
                });
            });

            start();
        })();
    </script>
</body>
</html>
