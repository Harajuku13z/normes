@php
    $slidesJs = data_get($home, 'hero.slides_js', []);
    $casesJs = data_get($home, 'realisations.cases_js', []);
    $mapLocs = data_get($home, 'map.locations', []);
@endphp
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    (function () {
        const banner = document.getElementById('cookieConsent');
        const manageBtn = document.getElementById('cookieManageBtn');
        if (!banner) return;

        const closeBtn = document.getElementById('cookieConsentClose');
        const rejectBtn = document.getElementById('cookieReject');
        const acceptBtn = document.getElementById('cookieAccept');
        const customizeBtn = document.getElementById('cookieCustomize');
        const saveBtn = document.getElementById('cookieSave');
        const prefsPanel = document.getElementById('cookiePrefsPanel');
        const analyticsInput = document.getElementById('cookieAnalytics');
        const marketingInput = document.getElementById('cookieMarketing');

        const CONSENT_KEY = 'nr_cookie_consent_v1';
        const TTL_DAYS = 180;

        const readConsent = () => {
            try {
                const raw = localStorage.getItem(CONSENT_KEY);
                if (!raw) return null;
                const parsed = JSON.parse(raw);
                if (!parsed || typeof parsed !== 'object') return null;
                if (!parsed.ts) return null;
                const age = Date.now() - Number(parsed.ts);
                const maxAge = TTL_DAYS * 24 * 60 * 60 * 1000;
                if (!Number.isFinite(age) || age > maxAge) return null;
                return parsed;
            } catch (e) {
                return null;
            }
        };

        const saveConsent = (value) => {
            const payload = { ...value, ts: Date.now() };
            try {
                localStorage.setItem(CONSENT_KEY, JSON.stringify(payload));
            } catch (e) {
                // ignore
            }
            window.dispatchEvent(new CustomEvent('nr-cookie-consent-changed', { detail: payload }));
        };

        const openBanner = () => {
            banner.classList.remove('hidden');
            banner.classList.remove('pointer-events-none');
            banner.setAttribute('aria-hidden', 'false');
        };
        const closeBanner = () => {
            banner.classList.add('hidden');
            banner.classList.add('pointer-events-none');
            banner.setAttribute('aria-hidden', 'true');
        };

        const setPrefsOpen = (open) => {
            if (!prefsPanel || !saveBtn || !customizeBtn) return;
            prefsPanel.classList.toggle('hidden', !open);
            saveBtn.classList.toggle('hidden', !open);
            customizeBtn.classList.toggle('hidden', open);
        };

        const applyConsentToInputs = (consent) => {
            if (analyticsInput) analyticsInput.checked = Boolean(consent?.analytics);
            if (marketingInput) marketingInput.checked = Boolean(consent?.marketing);
        };

        const acceptAll = () => {
            saveConsent({ necessary: true, analytics: true, marketing: true, choice: 'accept_all' });
            closeBanner();
        };
        const rejectAll = () => {
            saveConsent({ necessary: true, analytics: false, marketing: false, choice: 'reject_all' });
            closeBanner();
        };
        const saveCustom = () => {
            saveConsent({
                necessary: true,
                analytics: Boolean(analyticsInput?.checked),
                marketing: Boolean(marketingInput?.checked),
                choice: 'custom',
            });
            closeBanner();
            setPrefsOpen(false);
        };

        if (acceptBtn) acceptBtn.addEventListener('click', acceptAll);
        if (rejectBtn) rejectBtn.addEventListener('click', rejectAll);
        if (saveBtn) saveBtn.addEventListener('click', saveCustom);
        if (customizeBtn) customizeBtn.addEventListener('click', () => setPrefsOpen(true));
        if (closeBtn) closeBtn.addEventListener('click', closeBanner);
        if (manageBtn) manageBtn.addEventListener('click', () => {
            openBanner();
            setPrefsOpen(true);
            if (manageBtn) manageBtn.classList.add('hidden');
        });

        const stored = readConsent();
        if (!stored) {
            applyConsentToInputs({ analytics: false, marketing: false });
            openBanner();
            return;
        }

        applyConsentToInputs(stored);
        window.dispatchEvent(new CustomEvent('nr-cookie-consent-changed', { detail: stored }));
    })();

    (function () {
        const popup = document.getElementById('leadPopup');
        if (!popup) return;

        const backdrop = document.getElementById('leadPopupBackdrop');
        const closeBtn = document.getElementById('leadPopupClose');
        const ctaSim = document.getElementById('leadPopupCtaSimulator');
        const ctaForm = document.getElementById('leadPopupCtaForm');

        const KEY = 'nr_lead_popup_dismissed_at';
        const DISMISS_FOR_MS = 7 * 24 * 60 * 60 * 1000;

        const now = () => Date.now();
        const getDismissedAt = () => {
            try {
                const v = Number(localStorage.getItem(KEY));
                return Number.isFinite(v) ? v : 0;
            } catch (e) {
                return 0;
            }
        };
        const setDismissed = () => {
            try {
                localStorage.setItem(KEY, String(now()));
            } catch (e) {
                // ignore
            }
        };

        const open = () => {
            popup.classList.remove('hidden');
            popup.setAttribute('aria-hidden', 'false');
            document.documentElement.classList.add('overflow-hidden');
            document.body.classList.add('overflow-hidden');
        };
        const close = () => {
            popup.classList.add('hidden');
            popup.setAttribute('aria-hidden', 'true');
            document.documentElement.classList.remove('overflow-hidden');
            document.body.classList.remove('overflow-hidden');
        };

        const dismissAndClose = () => {
            setDismissed();
            close();
        };

        if (backdrop) backdrop.addEventListener('click', dismissAndClose);
        if (closeBtn) closeBtn.addEventListener('click', dismissAndClose);

        const focusSimulator = () => {
            const input = document.getElementById('address');
            if (!input) return;
            setTimeout(() => input.focus({ preventScroll: true }), 250);
        };
        const focusForm = () => {
            const input = document.getElementById('devisPrenom');
            if (!input) return;
            setTimeout(() => input.focus({ preventScroll: true }), 250);
        };

        if (ctaSim) ctaSim.addEventListener('click', () => { dismissAndClose(); focusSimulator(); });
        if (ctaForm) ctaForm.addEventListener('click', () => { dismissAndClose(); focusForm(); });

        document.addEventListener('keydown', (e) => {
            if (popup.classList.contains('hidden')) return;
            if (e.key === 'Escape') {
                dismissAndClose();
            }
        });

        const dismissedAt = getDismissedAt();
        const shouldShow = dismissedAt === 0 || (now() - dismissedAt) > DISMISS_FOR_MS;
        if (!shouldShow) return;

        const reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const delay = reduced ? 0 : 1200;
        window.setTimeout(open, delay);
    })();

    (function () {
        const y = document.getElementById('footerYear');
        if (y) y.textContent = String(new Date().getFullYear());
    })();
    (function () {
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const floatingAvis = document.getElementById('mobileFloatingAvis');
        const aboutSection = document.getElementById('a-propos');
        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
            mobileMenu.querySelectorAll('a').forEach((link) => {
                link.addEventListener('click', () => mobileMenu.classList.add('hidden'));
            });
        }

        // Affiche le widget avis mobile seulement APRES la section "A propos".
        if (floatingAvis && aboutSection) {
            const toggleFloatingAvis = () => {
                const isDesktop = window.matchMedia('(min-width: 1280px)').matches;
                if (isDesktop) {
                    floatingAvis.classList.add('hidden');
                    return;
                }
                const rect = aboutSection.getBoundingClientRect();
                const passedAbout = rect.bottom <= 0;
                floatingAvis.classList.toggle('hidden', !passedAbout);
                floatingAvis.classList.toggle('flex', passedAbout);
            };

            window.addEventListener('scroll', toggleFloatingAvis, { passive: true });
            window.addEventListener('resize', toggleFloatingAvis);
            toggleFloatingAvis();
        }

        const hero = document.getElementById('heroBg');
        const heroTitle = document.getElementById('heroTitle');
        const heroSubtitle = document.getElementById('heroSubtitle');
        const heroPrimaryCta = document.getElementById('heroPrimaryCta');
        const heroSecondaryCta = document.getElementById('heroSecondaryCta');
        const heroLearnMoreCta = document.getElementById('heroLearnMoreCta');
        const heroIdentityBlock = document.getElementById('heroIdentityBlock');
        const heroRegularBlock = document.getElementById('heroRegularBlock');
        const heroSection = document.getElementById('top');
        const thumbs = Array.from(document.querySelectorAll('.hero-thumb'));
        const slides = @json($slidesJs);
        const identitySlideId = @json(data_get($home, 'hero.slides.0.identity') ? 1 : 0);

        const slideIds = Object.keys(slides).map((k) => Number(k)).filter((n) => !Number.isNaN(n)).sort((a, b) => a - b);
        const maxSlideId = slideIds.length ? slideIds[slideIds.length - 1] : 1;

        const applySlide = (slideId) => {
            const slide = slides[String(slideId)] || slides[slideId];
            if (!slide || !hero) return;

            const isIdentity = identitySlideId && Number(slideId) === identitySlideId;

            // Toggle layout blocks
            if (heroIdentityBlock) heroIdentityBlock.classList.toggle('hidden', !isIdentity);
            if (heroIdentityBlock) heroIdentityBlock.classList.toggle('flex', isIdentity);
            if (heroRegularBlock) heroRegularBlock.classList.toggle('hidden', isIdentity);
            if (heroRegularBlock) heroRegularBlock.classList.toggle('flex', !isIdentity);
            if (heroSection) heroSection.classList.toggle('min-h-[600px]', isIdentity);
            if (heroSection) heroSection.classList.toggle('sm:min-h-[700px]', isIdentity);
            if (heroSection) heroSection.classList.toggle('min-h-[540px]', !isIdentity);
            if (heroSection) heroSection.classList.toggle('sm:min-h-[620px]', !isIdentity);

            hero.style.backgroundImage = slide.bg;
            if (!isIdentity) {
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
                if (heroLearnMoreCta) {
                    heroLearnMoreCta.style.display = '';
                    if (!heroLearnMoreCta.getAttribute('href')) heroLearnMoreCta.setAttribute('href', '#services');
                }
            }
        };

        let currentHeroSlide = slideIds[0] || 1;
        let heroAutoplay = null;
        const setHeroSlide = (slideId) => {
            currentHeroSlide = Number(slideId);
            applySlide(String(currentHeroSlide));
            // Update pill dots (identity block)
            thumbs.forEach((t) => {
                const isActive = Number(t.dataset.bg) === currentHeroSlide;
                if (t.closest('#heroIdentityBlock') !== null || !t.style.backgroundImage || t.style.backgroundImage === 'none') {
                    t.classList.toggle('w-8', isActive);
                    t.classList.toggle('bg-brand-yellow', isActive);
                    t.classList.toggle('w-2', !isActive);
                    t.classList.toggle('bg-white/40', !isActive);
                } else {
                    t.classList.remove('border-brand-blue');
                    if (isActive) t.classList.add('border-brand-blue');
                }
            });
        };
        const startHeroAutoplay = () => {
            if (heroAutoplay) {
                return;
            }
            heroAutoplay = setInterval(() => {
                const idx = slideIds.indexOf(currentHeroSlide);
                const next = idx >= 0 && idx < slideIds.length - 1 ? slideIds[idx + 1] : slideIds[0];
                setHeroSlide(next || 1);
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
        if (heroSection) {
            heroSection.addEventListener('mouseenter', stopHeroAutoplay);
            heroSection.addEventListener('mouseleave', startHeroAutoplay);
        }
        setHeroSlide(slideIds[0] || 1);
        startHeroAutoplay();

        const initBeforeAfterComparators = () => {
            // Nouveau format (grille) : plusieurs comparateurs sur la même page.
            const blocks = Array.from(document.querySelectorAll('.ba-compare'));
            blocks.forEach((block) => {
                const rangeEl = block.querySelector('input.ba-range');
                const afterEl = block.querySelector('.ba-after');
                if (!rangeEl || !afterEl) {
                    return;
                }
                const apply = () => {
                    afterEl.style.clipPath = `inset(0 0 0 ${Number(rangeEl.value)}%)`;
                };
                rangeEl.addEventListener('input', apply);
                apply();
            });

            // Ancien format (un seul comparateur avec IDs) : conservé si présent.
            const range = document.getElementById('baRange');
            const afterLayer = document.getElementById('afterLayer');
            if (range && afterLayer) {
                const apply = () => {
                    afterLayer.style.clipPath = `inset(0 0 0 ${Number(range.value)}%)`;
                };
                range.addEventListener('input', apply);
                apply();
            }
        };
        initBeforeAfterComparators();

        const beforeLayer = document.getElementById('beforeLayer');
        const afterLayer = document.getElementById('afterLayer');

        const baCases = @json($casesJs);
        const baCaseButtons = Array.from(document.querySelectorAll('.ba-case-btn'));
        const applyBeforeAfterCase = (caseId) => {
            const selectedCase = baCases[String(caseId)] || baCases[caseId];
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
        if (baCaseButtons.length > 0) {
            applyBeforeAfterCase('1');
        }

        const serviceCtas = Array.from(document.querySelectorAll('#serviceGrid .service-card a'));
        serviceCtas.forEach((link) => {
            link.className = 'mt-5 inline-flex w-fit items-center justify-center gap-2 rounded-xl border-2 border-white/70 bg-transparent px-5 py-3 text-sm font-extrabold uppercase tracking-wide text-white shadow-soft transition hover:-translate-y-0.5 hover:border-white hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow';
            link.innerHTML = 'En savoir plus <span aria-hidden=\"true\">→</span>';
        });

        const mapContainer = document.getElementById('agencyMap');
        const locations = @json($mapLocs);
        if (mapContainer && typeof L !== 'undefined') {
            const map = L.map('agencyMap', {
                scrollWheelZoom: false,
                zoomControl: false,
                attributionControl: false
            }).setView([46.8, 2.2], 6);

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
                    requestAnimationFrame(() => {
                        map.invalidateSize();
                        const b = regionsLayer.getBounds();
                        if (b.isValid()) {
                            map.fitBounds(b.pad(-0.03));
                        }
                    });
                })
                .catch(() => {
                    // Keep map container rendered if remote geojson fails.
                });
        }
    })();
</script>
