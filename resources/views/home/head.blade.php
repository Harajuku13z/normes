@php
    $h = $home ?? [];
    $metaPageUrl = isset($canonicalUrl) && is_string($canonicalUrl) && trim($canonicalUrl) !== '' ? trim($canonicalUrl) : url('/');
    $metaTitle = isset($title) && is_string($title) && trim($title) !== '' ? trim($title) : data_get($h, 'meta.title');
    $metaDescription = isset($description) && is_string($description) && trim($description) !== '' ? trim($description) : data_get($h, 'meta.description');
    // When a view passes an explicit meta description (e.g. service pages), OG/Twitter must use it too —
    // otherwise homepage `meta.description_social` wins and previews ignore the page-specific text.
    $descriptionWasPassed = isset($description) && is_string($description) && trim($description) !== '';
    $metaDescSocial = isset($descriptionSocial) && is_string($descriptionSocial) && trim($descriptionSocial) !== ''
        ? trim($descriptionSocial)
        : ($descriptionWasPassed ? $metaDescription : data_get($h, 'meta.description_social', $metaDescription));
    $metaImage = isset($ogImage) && is_string($ogImage) && trim($ogImage) !== '' ? \App\Support\HomeView::url(trim($ogImage)) : \App\Support\HomeView::url(data_get($h, 'meta.og_image', 'logo.png'));
    $metaKeywords = isset($keywords) && is_string($keywords) && trim($keywords) !== '' ? trim($keywords) : '';
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    @if ($metaKeywords !== '')
        <meta name="keywords" content="{{ $metaKeywords }}">
    @endif
    <link rel="canonical" href="{{ $metaPageUrl }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescSocial }}">
    <meta name="twitter:image" content="{{ $metaImage }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $metaPageUrl }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescSocial }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:image:alt" content="{{ data_get($h, 'meta.og_image_alt') }}">
    <meta property="og:locale" content="fr_FR">
    <meta property="og:site_name" content="{{ data_get($h, 'meta.site_name') }}">
    <meta name="theme-color" content="{{ data_get($h, 'meta.theme_color', '#2F4251') }}">
    <link rel="icon" type="image/png" href="{{ data_get($h, 'meta.favicon', '/iconne.png') }}">
    @if (isset($preloadImages) && is_array($preloadImages) && $preloadImages !== [])
        @foreach (array_slice($preloadImages, 0, 8) as $preloadHref)
            @if (is_string($preloadHref) && trim($preloadHref) !== '')
                <link rel="preload" as="image" href="{{ trim($preloadHref) }}">
            @endif
        @endforeach
    @endif
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
        :root {
            --footer-hero-bg: url({{ json_encode(\App\Support\HomeView::url(data_get($h, 'styles.footer_bg'))) }});
            --aides-renov-bg: url({{ json_encode(\App\Support\HomeView::url(data_get($h, 'styles.aides_bg'))) }});
        }

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
            background-image: linear-gradient(105deg, rgba(47, 66, 81, 0.92) 0%, rgba(47, 66, 81, 0.84) 45%, rgba(47, 66, 81, 0.72) 100%), var(--footer-hero-bg);
            background-size: cover;
            background-position: center;
        }

        .aides-renov-hero-bg {
            background-image: linear-gradient(120deg, rgba(47, 66, 81, 0.92) 0%, rgba(30, 58, 95, 0.88) 45%, rgba(15, 23, 42, 0.9) 100%), var(--aides-renov-bg);
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
