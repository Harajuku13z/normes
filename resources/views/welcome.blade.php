<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NORMES - Accueil</title>
    <style>
        :root {
            --brand: #0f4c81;
            --text: #1f2937;
            --muted: #6b7280;
            --bg: #f3f6fb;
            --white: #ffffff;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
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
        }
        .topbar-inner {
            min-height: 86px;
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
        .logo-mark {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            background: var(--brand);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
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
            font-size: 15px;
        }
        .menu .contact-btn {
            border: 2px solid var(--brand);
            color: var(--brand);
            padding: 10px 16px;
            border-radius: 8px;
        }
        .socials {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .social-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #eef2ff;
            color: var(--brand);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .hero {
            padding: 26px 0 36px;
        }
        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 18px;
        }
        .slider {
            position: relative;
            height: 460px;
            border-radius: 14px;
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
            background: linear-gradient(to right, rgba(0, 0, 0, .62), rgba(0, 0, 0, .2));
        }
        .slide.active { opacity: 1; }
        .slide-content {
            position: absolute;
            z-index: 2;
            left: 36px;
            bottom: 36px;
            color: #fff;
            max-width: 520px;
        }
        .slide-title {
            margin: 0 0 8px;
            font-size: 34px;
            line-height: 1.2;
        }
        .slide-subtitle {
            margin: 0 0 16px;
            color: #e5e7eb;
            line-height: 1.5;
        }
        .slide-btn {
            display: inline-block;
            background: #fff;
            color: #111827;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
        }
        .thumbs {
            display: grid;
            gap: 12px;
        }
        .thumb {
            height: 145px;
            border-radius: 12px;
            background-size: cover;
            background-position: center;
            border: 2px solid transparent;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        .thumb::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, .2);
        }
        .thumb.active {
            border-color: var(--brand);
        }
        .thumb.active::after {
            background: rgba(0, 0, 0, .05);
        }
        @media (max-width: 980px) {
            .hero-grid { grid-template-columns: 1fr; }
            .thumbs { grid-template-columns: repeat(3, 1fr); }
            .thumb { height: 115px; }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="container topbar-inner">
            <div class="logo">
                <div class="logo-mark">N</div>
                <span>NORMES Entreprise</span>
            </div>

            <nav class="menu">
                <a href="#">Accueil</a>
                <a href="#">Nos services</a>
                <a href="#">Agences franchise</a>
                <a class="contact-btn" href="#">Nous contacter</a>
                <div class="socials">
                    <a class="social-icon" href="#" aria-label="Facebook">f</a>
                    <a class="social-icon" href="#" aria-label="LinkedIn">in</a>
                </div>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="container hero-grid">
            <div class="slider" id="main-slider">
                <article class="slide active" data-index="0" style="background-image:url('https://picsum.photos/1200/700?random=21');">
                    <div class="slide-content">
                        <h1 class="slide-title">Accompagnement professionnel</h1>
                        <p class="slide-subtitle">Des solutions sur mesure pour faire grandir votre entreprise sereinement.</p>
                        <a class="slide-btn" href="#">Nous contacter</a>
                    </div>
                </article>
                <article class="slide" data-index="1" style="background-image:url('https://picsum.photos/1200/700?random=22');">
                    <div class="slide-content">
                        <h2 class="slide-title">Expertise et performance</h2>
                        <p class="slide-subtitle">Une equipe engagee pour des resultats mesurables sur tous vos projets.</p>
                        <a class="slide-btn" href="#">Nous contacter</a>
                    </div>
                </article>
                <article class="slide" data-index="2" style="background-image:url('https://picsum.photos/1200/700?random=23');">
                    <div class="slide-content">
                        <h2 class="slide-title">Presence nationale</h2>
                        <p class="slide-subtitle">Nos agences franchise vous accompagnent au plus pres de vos besoins.</p>
                        <a class="slide-btn" href="#">Nous contacter</a>
                    </div>
                </article>
            </div>

            <aside class="thumbs" id="thumbs">
                <button class="thumb active" data-target="0" style="background-image:url('https://picsum.photos/400/300?random=21');" aria-label="Slide 1"></button>
                <button class="thumb" data-target="1" style="background-image:url('https://picsum.photos/400/300?random=22');" aria-label="Slide 2"></button>
                <button class="thumb" data-target="2" style="background-image:url('https://picsum.photos/400/300?random=23');" aria-label="Slide 3"></button>
            </aside>
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
