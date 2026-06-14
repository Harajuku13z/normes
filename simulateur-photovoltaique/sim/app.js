/* =========================================================================
   Simulateur Photovoltaïque — Normes Rénovation
   Dynamic wizard wired to real APIs + Google Maps.
   ========================================================================= */
(() => {
  'use strict';

  const S = {
    step: 0,
    address: '',
    addressSuggestions: [],
    resolvedAddress: '',
    location: null,
    mapType: 'satellite',
    mapZoom: 20,
    polygon: [],
    surface: 0,
    orientEdge: -1,
    orientation: null,
    incline: 30,
    roofType: 'Tuiles',
    shading: 'Aucun',
    consoMode: 'kwh',
    consoValue: 4200,
    consoPeriod: 'year',
    billPeriod: 'year',
    vehicles: 0,
    heating: 'Gaz',
    contact: { prenom: '', nom: '', email: '', tel: '' },
    consent: false,
    estimate: null,
    leadStatus: { cta: 'idle', callback: 'idle' },
    projectType: 'autoconsommation',
    zoneType: 'roof',
    wantsBattery: false,
    wantsCharger: false,
    resultPanelCount: null,
    locateTutorialDismissed: false,
    drawTutorialDismissed: false,
    orientTutorialDismissed: false,
    loadingLabel: 'Calcul en cours…',
    loadingSub: 'Nous préparons votre simulation photovoltaïque.',
    error: '',
  };

  const RUNTIME = {
    config: null,
    googleReady: null,
    addressTimer: null,
    activeMap: null,
    activePolygon: null,
    activePathListeners: [],
    activeOverlays: [],
    pendingAddressRequest: 0,
    currentEstimatePromise: null,
    panelLayoutCacheKey: '',
    panelLayoutCache: null,
    resultMapInstance: null,
    resultRoofOverlay: null,
    resultPanelOverlays: [],
  };

  const PHASES = ['Votre toiture', 'Votre consommation', 'Votre résultat'];
  const STEP_PHASE = [0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 2, 2];
  const TOTAL = 12;
  const MAP_ID = 'nr-pv-map';
  const PANEL_WC = 425;
  const PANEL_DIMENSIONS = {
    portrait: { width: 1.15, height: 1.76 },
    landscape: { width: 1.76, height: 1.15 },
  };
  const PRESET_KITS = [
    { key: '3', kwc: 3, home: 'Maison 2-3 personnes', badge: 'Le plus choisi' },
    { key: '4', kwc: 4, home: 'Maison 3-4 personnes', badge: '' },
    { key: '6', kwc: 6, home: 'Maison familiale', badge: '' },
    { key: '9', kwc: 9, home: 'Grande maison', badge: '' },
  ].map((kit) => ({
    ...kit,
    panels: Math.max(1, Math.round((kit.kwc * 1000) / PANEL_WC)),
  }));

  const ORIENT_FACTOR = {
    'Sud': 1.0,
    'Sud-Est': 0.96,
    'Sud-Ouest': 0.96,
    'Est': 0.88,
    'Ouest': 0.88,
    'Nord-Est': 0.72,
    'Nord-Ouest': 0.72,
    'Nord': 0.60,
  };
  const INCLINE_FACTOR = { 0: 0.90, 15: 0.96, 30: 1.0, 45: 0.97 };
  const SHADE_FACTOR = { 'Aucun': 1.0, 'Cheminée': 0.95, 'Arbres': 0.82, 'Bâtiment voisin': 0.78 };

  const app = document.getElementById('card');
  const phasesEl = document.getElementById('phases');
  const microFill = document.getElementById('microFill');
  const microCount = document.getElementById('microCount');

  const fr = (n, digits = 0) =>
    Number(n || 0).toLocaleString('fr-FR', {
      minimumFractionDigits: digits,
      maximumFractionDigits: digits,
    });

  const el = (html) => {
    const t = document.createElement('template');
    t.innerHTML = html.trim();
    return t.content.firstElementChild;
  };

  const escapeHtml = (value) =>
    String(value ?? '')
      .replaceAll('&', '&amp;')
      .replaceAll('<', '&lt;')
      .replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;');

  const ICON = {
    pin: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
    bolt: '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>',
    trend: '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>',
    euro: '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/><line x1="4" y1="9" x2="13" y2="9"/><line x1="4" y1="15" x2="11" y2="15"/></svg>',
    tile: '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-5 9 5"/><path d="M5 10v8h14v-8"/><path d="M9 10v8M13 10v8M17 10v8"/></svg>',
    slate: '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-5 9 5-9 5z"/><path d="M3 9v6l9 5 9-5V9"/></svg>',
    steel: '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 8l9-4 9 4v3l-9 4-9-4z"/><path d="M3 14l9 4 9-4"/></svg>',
    flat: '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="9" width="18" height="7" rx="1"/><path d="M3 12h18"/></svg>',
    none: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M9 12l2 2 4-4"/></svg>',
    chimney: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11l9-6 9 6"/><path d="M5 12v7h14v-7"/><rect x="14" y="4" width="3" height="5"/></svg>',
    tree: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l4 6h-3l3 5h-3l3 4H8l3-4H8l3-5H8z"/><path d="M12 17v5"/></svg>',
    building: '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="16" height="18" rx="1"/><path d="M9 7h.01M15 7h.01M9 11h.01M15 11h.01M9 15h.01M15 15h.01"/></svg>',
  };

  function roofSVG() {
    return `<svg viewBox="0 0 340 210" fill="none" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <linearGradient id="roofPlane" x1="74" y1="76" x2="246" y2="164" gradientUnits="userSpaceOnUse">
          <stop offset="0" stop-color="#E7F6FF"/>
          <stop offset="1" stop-color="#C7EBFF"/>
        </linearGradient>
        <linearGradient id="roofSide" x1="248" y1="88" x2="300" y2="172" gradientUnits="userSpaceOnUse">
          <stop offset="0" stop-color="#F6FBFF"/>
          <stop offset="1" stop-color="#D8EEF9"/>
        </linearGradient>
      </defs>

      <path d="M74 120L196 58L272 104L146 168Z" fill="url(#roofPlane)" stroke="#38B6FF" stroke-width="4" stroke-linejoin="round"/>
      <path d="M272 104L272 162L146 162L146 168" stroke="#38B6FF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M196 58L272 104L272 162L196 116V58Z" fill="url(#roofSide)" stroke="#38B6FF" stroke-width="4" stroke-linejoin="round"/>
      <path d="M74 120L74 176" stroke="#38B6FF" stroke-width="4" stroke-linecap="round"/>
      <path d="M74 176H298" stroke="#38B6FF" stroke-width="4" stroke-linecap="round"/>

      <g stroke="#7FD3FF" stroke-width="2.6" stroke-linecap="round" opacity="0.95">
        <path d="M94 108L218 171"/>
        <path d="M110 100L232 162"/>
        <path d="M126 92L246 153"/>
        <path d="M142 84L260 144"/>
      </g>
      <g stroke="#7FD3FF" stroke-width="2.4" stroke-linecap="round" opacity="0.85">
        <path d="M116 120L152 102"/>
        <path d="M144 134L182 115"/>
        <path d="M172 148L212 128"/>
        <path d="M200 161L240 141"/>
      </g>

      <g stroke="#38B6FF" stroke-width="3.4" stroke-linecap="round" stroke-linejoin="round">
        <path d="M44 176H104"/>
        <path d="M74 176L74 128"/>
        <path d="M74 150A31 31 0 0 1 101 167"/>
      </g>
      <path d="M95 154L109 159L100 145" fill="#38B6FF"/>
      <text x="118" y="163" fill="#294352" font-family="Inter, Arial, sans-serif" font-size="18" font-weight="700">Inclinaison</text>
    </svg>`;
  }

  function locateDemoMedia() {
    return `<img src="assets/locate-tutorial.gif" alt="Démo pour centrer la toiture sous la punaise rouge">`;
  }

  function drawDemoSVG() {
    return `<img src="assets/draw-tutorial.gif" alt="Démo pour tracer le pan de toiture">`;
  }

  function orientDemoSVG() {
    return `<img src="assets/orient-tutorial.gif" alt="Démo pour sélectionner le côté le plus haut de la toiture">`;
  }

  function annualConsumptionKwh() {
    const raw = Number(S.consoValue || 0);
    if (S.consoMode === 'kwh') {
      return S.consoPeriod === 'month' ? Math.round(raw * 12) : Math.round(raw);
    }

    const annualBill = S.billPeriod === 'month' ? raw * 12 : raw;
    return Math.round(annualBill / 0.2516);
  }

  function roofCapacityFromSurface() {
    const divisor = S.zoneType === 'garden' ? 2.2 : 1.9;
    return Math.max(1, Math.floor((S.surface || 0) / divisor));
  }

  function resetResultSelection() {
    S.resultPanelCount = null;
    RUNTIME.panelLayoutCacheKey = '';
    RUNTIME.panelLayoutCache = null;
  }

  function pointInPolygon2D(point, polygon) {
    let inside = false;
    for (let i = 0, j = polygon.length - 1; i < polygon.length; j = i++) {
      const xi = polygon[i].x;
      const yi = polygon[i].y;
      const xj = polygon[j].x;
      const yj = polygon[j].y;
      const intersects = ((yi > point.y) !== (yj > point.y))
        && (point.x < (((xj - xi) * (point.y - yi)) / ((yj - yi) || 1e-9)) + xi);
      if (intersects) inside = !inside;
    }
    return inside;
  }

  function polygonCentroid2D(points) {
    if (!points.length) return { x: 0, y: 0 };

    let signedArea = 0;
    let cx = 0;
    let cy = 0;

    for (let i = 0; i < points.length; i += 1) {
      const current = points[i];
      const next = points[(i + 1) % points.length];
      const cross = (current.x * next.y) - (next.x * current.y);
      signedArea += cross;
      cx += (current.x + next.x) * cross;
      cy += (current.y + next.y) * cross;
    }

    if (Math.abs(signedArea) < 1e-6) {
      return points.reduce((acc, point) => ({
        x: acc.x + (point.x / points.length),
        y: acc.y + (point.y / points.length),
      }), { x: 0, y: 0 });
    }

    return {
      x: cx / (3 * signedArea),
      y: cy / (3 * signedArea),
    };
  }

  function dot2D(a, b) {
    return (a.x * b.x) + (a.y * b.y);
  }

  function latLngToLocalMeters(origin, point) {
    const originLatLng = origin instanceof google.maps.LatLng ? origin : new google.maps.LatLng(origin.lat, origin.lng);
    const pointLatLng = point instanceof google.maps.LatLng ? point : new google.maps.LatLng(point.lat, point.lng);
    const distance = google.maps.geometry.spherical.computeDistanceBetween(originLatLng, pointLatLng);
    if (!Number.isFinite(distance) || distance === 0) {
      return { x: 0, y: 0 };
    }
    const heading = google.maps.geometry.spherical.computeHeading(originLatLng, pointLatLng) * (Math.PI / 180);
    return {
      x: Math.sin(heading) * distance,
      y: Math.cos(heading) * distance,
    };
  }

  function localMetersToLatLng(origin, point) {
    const originLatLng = origin instanceof google.maps.LatLng ? origin : new google.maps.LatLng(origin.lat, origin.lng);
    const distance = Math.hypot(point.x, point.y);
    if (!Number.isFinite(distance) || distance === 0) {
      return { lat: originLatLng.lat(), lng: originLatLng.lng() };
    }
    const heading = Math.atan2(point.x, point.y) * (180 / Math.PI);
    const offset = google.maps.geometry.spherical.computeOffset(originLatLng, distance, heading);
    return { lat: offset.lat(), lng: offset.lng() };
  }

  function computePanelSlotsForAxis(projectedPolygon, uAxis, vAxis, origin, panelSize) {
    const gap = 0.12;
    const margin = 0.5;
    const minX = Math.min(...projectedPolygon.map((point) => point.x));
    const maxX = Math.max(...projectedPolygon.map((point) => point.x));
    const minY = Math.min(...projectedPolygon.map((point) => point.y));
    const maxY = Math.max(...projectedPolygon.map((point) => point.y));
    const slots = [];

    // Fill from the top side downward so panels align to the highest edge of the zone
    for (let y = maxY - margin - panelSize.height; y >= minY + margin; y -= panelSize.height + gap) {
      for (let x = minX + margin; x + panelSize.width <= maxX - margin; x += panelSize.width + gap) {
        const corners = [
          { x, y },
          { x: x + panelSize.width, y },
          { x: x + panelSize.width, y: y + panelSize.height },
          { x, y: y + panelSize.height },
        ];
        if (!corners.every((corner) => pointInPolygon2D(corner, projectedPolygon))) continue;

        slots.push({
          orientation: panelSize === PANEL_DIMENSIONS.landscape ? 'landscape' : 'portrait',
          corners: corners.map((corner) => localMetersToLatLng(origin, {
            x: (uAxis.x * corner.x) + (vAxis.x * corner.y),
            y: (uAxis.y * corner.x) + (vAxis.y * corner.y),
          })),
        });
      }
    }

    return slots;
  }

  function currentPanelLayout() {
    const fallbackCapacity = roofCapacityFromSurface();
    if (!window.google?.maps?.geometry || S.polygon.length < 3) {
      return {
        slots: [],
        capacity: fallbackCapacity,
        orientation: 'portrait',
      };
    }

    const cacheKey = JSON.stringify({
      polygon: S.polygon.map((point) => [Number(point.lat.toFixed(6)), Number(point.lng.toFixed(6))]),
      orientEdge: S.orientEdge,
      zoneType: S.zoneType,
    });

    if (RUNTIME.panelLayoutCacheKey === cacheKey && RUNTIME.panelLayoutCache) {
      return RUNTIME.panelLayoutCache;
    }

    const edgeIndex = S.orientEdge >= 0 ? S.orientEdge : 0;
    const origin = S.polygon[edgeIndex];
    const edgeTarget = S.polygon[(edgeIndex + 1) % S.polygon.length];
    const originLatLng = new google.maps.LatLng(origin.lat, origin.lng);
    const localPolygon = S.polygon.map((point) => latLngToLocalMeters(originLatLng, point));
    const edgeVector = latLngToLocalMeters(originLatLng, edgeTarget);
    const edgeLength = Math.hypot(edgeVector.x, edgeVector.y);

    if (!Number.isFinite(edgeLength) || edgeLength < 0.3) {
      const fallback = {
        slots: [],
        capacity: fallbackCapacity,
        orientation: 'portrait',
      };
      RUNTIME.panelLayoutCacheKey = cacheKey;
      RUNTIME.panelLayoutCache = fallback;
      return fallback;
    }

    const uAxis = {
      x: edgeVector.x / edgeLength,
      y: edgeVector.y / edgeLength,
    };
    const centroid = polygonCentroid2D(localPolygon);
    const midpoint = { x: edgeVector.x / 2, y: edgeVector.y / 2 };
    const normalA = { x: -uAxis.y, y: uAxis.x };
    const normalB = { x: uAxis.y, y: -uAxis.x };
    const toCentroid = { x: centroid.x - midpoint.x, y: centroid.y - midpoint.y };
    const vAxis = dot2D(toCentroid, normalA) >= 0 ? normalA : normalB;

    const projectedPolygon = localPolygon.map((point) => ({
      x: dot2D(point, uAxis),
      y: dot2D(point, vAxis),
    }));

    const portraitSlots = computePanelSlotsForAxis(projectedPolygon, uAxis, vAxis, originLatLng, PANEL_DIMENSIONS.portrait);
    const landscapeSlots = computePanelSlotsForAxis(projectedPolygon, uAxis, vAxis, originLatLng, PANEL_DIMENSIONS.landscape);
    const slots = landscapeSlots.length > 0 ? landscapeSlots : portraitSlots;
    const layout = {
      slots,
      capacity: Math.max(1, slots.length || fallbackCapacity),
      orientation: landscapeSlots.length > 0 ? 'landscape' : 'portrait',
    };

    RUNTIME.panelLayoutCacheKey = cacheKey;
    RUNTIME.panelLayoutCache = layout;
    return layout;
  }

  function recommendedPanelCount() {
    const capacity = currentPanelLayout().capacity;
    const estimateCount = Number(S.estimate?.panelCount || 0);
    if (estimateCount > 0) {
      return Math.max(1, Math.min(capacity, estimateCount));
    }
    return capacity;
  }

  function activePanelCount() {
    const capacity = currentPanelLayout().capacity;
    const base = S.resultPanelCount ?? recommendedPanelCount();
    return Math.max(1, Math.min(capacity, Number(base || 1)));
  }

  function estimateResults() {
    const panelLayout = currentPanelLayout();
    const panelCount = activePanelCount();
    const kwc = (panelCount * PANEL_WC) / 1000;

    const estimateKwh = Number(S.estimate?.yearlyKwh || 0);
    const estimateSavings = Number(S.estimate?.annualSavings || 0);
    const estimateArea = Number(S.estimate?.areaM2 || 0);
    const areaRatio = estimateArea > 0 && S.surface > 0 ? Math.min(1.5, Math.max(0.45, S.surface / estimateArea)) : 1;
    const panelRatio = Number(S.estimate?.panelCount || 0) > 0 ? panelCount / Number(S.estimate.panelCount) : 1;
    const orientFactor = ORIENT_FACTOR[S.orientation] || 0.9;
    const inclineFactor = INCLINE_FACTOR[S.incline] || 1.0;
    const shadeFactor = SHADE_FACTOR[S.shading] || 1.0;
    const performanceFactor = orientFactor * inclineFactor * shadeFactor;

    let production = estimateKwh > 0
      ? estimateKwh * areaRatio * panelRatio * performanceFactor
      : kwc * 1180 * performanceFactor;
    production = Math.round(production);

    const consumption = annualConsumptionKwh();
    let autoconsumption = 0.38 + (S.vehicles * 0.07);
    if (S.heating === 'Électrique' || S.heating === 'Pompe à chaleur') autoconsumption += 0.10;
    autoconsumption = Math.min(0.90, autoconsumption);
    const selfConsumed = Math.round(production * autoconsumption);
    const injected = Math.max(0, production - selfConsumed);
    const annualSavings = Math.round(
      estimateSavings > 0
        ? estimateSavings * areaRatio * panelRatio * performanceFactor
        : (selfConsumed * 0.2516) + (injected * 0.1269)
    );

    const cost = Math.round((Number(S.estimate?.budgetMin || kwc * 1950) / Math.max(Number(S.estimate?.kwc || kwc), 0.1)) * kwc / 100) * 100;
    const amort = annualSavings > 0 ? cost / annualSavings : 0;
    const coverage = consumption > 0 ? Math.min(100, Math.round((selfConsumed / consumption) * 100)) : 0;
    const co2 = Math.round(production * 0.05);
    const trees = Math.max(1, Math.round(co2 / 35));
    const homes = production / 2500;
    const cum = (years) => Math.round(annualSavings * years * (1 + (0.028 * years / 2)));
    const monthlyWeights = [0.045, 0.060, 0.085, 0.100, 0.115, 0.125, 0.130, 0.120, 0.095, 0.070, 0.045, 0.035];

    return {
      panels: panelCount,
      panelCapacity: panelLayout.capacity,
      panelLayoutOrientation: panelLayout.orientation,
      kwc,
      production,
      autoconsumption,
      selfConsumed,
      annualSavings,
      cost,
      amort,
      coverage,
      co2,
      trees,
      homes,
      cum10: cum(10),
      cum20: cum(20),
      cum30: cum(30),
      monthlyKwh: monthlyWeights.map((w) => Math.round(production * w)),
    };
  }

  function header(stepIdx, title, sub, note) {
    return `
      <div class="eyebrow">Étape ${stepIdx + 1} / ${TOTAL} · ${PHASES[STEP_PHASE[stepIdx]]}</div>
      <h1>${title}</h1>
      ${sub ? `<p class="sub">${sub}</p>` : ''}
      ${note ? `<p class="note">${note}</p>` : ''}
      ${S.error ? `<div class="inline-alert">${escapeHtml(S.error)}</div>` : ''}`;
  }

  function actions(primaryLabel, opts = {}) {
    const disabled = opts.disabled ? 'disabled' : '';
    const back = opts.hideBack
      ? ''
      : (S.step > 0
        ? '<button class="backlink" data-act="back">‹ Revenir à l’étape précédente</button>'
        : '<button class="backlink" data-act="restart">‹ Recommencer la simulation</button>');
    return `<div class="actions">
      <button class="btn btn--primary" data-act="next" ${disabled}>${primaryLabel}<span class="arrow">→</span></button>
      ${back}
    </div>`;
  }

  function mapTypeSwitch() {
    return `<div class="map-style-switch">
      <button class="${S.mapType === 'satellite' ? 'active' : ''}" data-map-type="satellite">Satellite</button>
      <button class="${S.mapType === 'roadmap' ? 'active' : ''}" data-map-type="roadmap">Plan</button>
    </div>`;
  }

  function mapSection(id, hintText, extra = '') {
    return `<div class="map-wrap">
      <div class="map real-map" id="${id}"></div>
      ${extra}
      ${mapTypeSwitch()}
      <div class="map-hint"><span class="pulse"></span> ${hintText}</div>
    </div>`;
  }

  const RENDER = {};

  RENDER[0] = () => {
    const ck = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
    const shield = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>';
    const gift = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="8" width="18" height="4" rx="1"/><path d="M12 8v13M5 12v9h14v-9M12 8C12 5 10 3 8 3a2 2 0 0 0 0 4zM12 8c0-3 2-5 4-5a2 2 0 0 1 0 4z"/></svg>';
    const home = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11l9-7 9 7"/><path d="M5 10v10h14V10"/></svg>';
    const s3icons = [
      '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
      '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11l9-7 9 7"/><path d="M5 10v10h14V10"/><rect x="9" y="13" width="6" height="7"/></svg>',
      '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>',
    ];

    app.innerHTML = `
      <div class="lp">
        <section class="lp-hero">
          <div class="lp-hero-text">
            <div class="eyebrow">Simulateur solaire · 100% gratuit</div>
            <h1>Votre toiture peut<br><span class="hl">vous rapporter</span><br>de l'argent.</h1>
            <p class="lp-sub">Découvrez en <b>2 minutes</b> combien de panneaux installer, votre production, vos économies et les <b>aides 2026</b> auxquelles vous avez droit.</p>

            <div class="suggest-wrap">
              <form class="addr-cta" id="startForm" autocomplete="off">
                <span class="pin">${ICON.pin}</span>
                <input id="addrLP" value="${escapeHtml(S.address)}" placeholder="Entrez l'adresse de votre maison…" aria-label="Adresse de votre maison">
                <button type="submit">Démarrer ma simulation<span class="arrow">→</span></button>
              </form>
              <div class="suggest-list ${S.addressSuggestions.length ? 'open' : ''}" id="addrSuggestions">
                ${S.addressSuggestions.map((item, index) => `
                  <button type="button" class="suggest-item" data-suggestion-index="${index}">
                    <span class="suggest-main">${escapeHtml(item.label)}</span>
                    <span class="suggest-sub">${escapeHtml(item.city || item.postcode || item.full || '')}</span>
                  </button>`).join('')}
              </div>
            </div>

            ${S.error ? `<div class="inline-alert lp-alert" role="alert">${escapeHtml(S.error)}</div>` : ''}

            <div class="cta-trust">
              <span><span class="ck">${ck}</span> Sans engagement</span>
              <span><span class="ck">${ck}</span> Résultat immédiat</span>
              <span><span class="ck">${ck}</span> Aucune carte requise</span>
            </div>
            <div class="badges">
              <span class="badge">${shield} RGE Certifié</span>
              <span class="badge gold">${gift} MaPrimeRénov'</span>
              <span class="badge">${home} +250 chantiers</span>
            </div>
          </div>

          <div class="lp-hero-aides">
            <div class="lp-aides-kicker">${gift} Prime 2026</div>
            <h2 class="lp-aides-title">JUSQU'À <span class="y">11 000 €</span><br>D'AIDES POUR<br>PASSER AU SOLAIRE</h2>
            <p class="lp-aides-body">MaPrimeRénov', prime à l'autoconsommation, TVA réduite : notre simulateur intègre toutes les aides auxquelles votre projet est éligible.</p>
          </div>
        </section>

        <section class="lp-band">
          <div class="lp-inner lp-center">
            <div class="eyebrow">Comment ça marche</div>
            <div class="lp-h2">Votre simulation en 3 phases</div>
            <div class="steps3">
              ${[['1', 'Votre adresse', 'On localise votre toiture sur une vue aérienne haute définition.'],
                ['2', 'Votre toiture', 'Vous tracez la surface et précisez orientation, inclinaison et ombrage.'],
                ['3', 'Votre résultat', 'Production, économies, aides et amortissement calculés instantanément.']]
                  .map(([n, t, p], i) => `<div class="s3"><div class="s3n">${n}</div><div class="s3i">${s3icons[i]}</div><h3>${t}</h3><p>${p}</p></div>`).join('')}
            </div>
          </div>
        </section>

        <section class="lp-band teal">
          <div class="lp-inner">
            <div class="stats4">
              <div class="stat4"><div class="v">+250</div><div class="k">chantiers livrés en Île-de-France</div></div>
              <div class="stat4"><div class="v"><span class="y">11 000€</span></div><div class="k">d'aides possibles en 2026</div></div>
              <div class="stat4"><div class="v">−70%</div><div class="k">sur la facture d'électricité</div></div>
              <div class="stat4"><div class="v">4,8<span class="y">/5</span></div><div class="k">note moyenne de nos clients</div></div>
            </div>
          </div>
        </section>

        <footer class="lp-footer">
          Estimation indicative basée sur des données d'ensoleillement. Vos données sont confidentielles et ne sont jamais revendues.
        </footer>
      </div>`;

    const form = app.querySelector('#startForm');
    const input = app.querySelector('#addrLP');
    const submit = form?.querySelector('button[type="submit"]');

    if (submit) submit.disabled = !S.address.trim();

    input?.addEventListener('input', (e) => {
      S.address = e.target.value;
      S.location = null;
      S.resolvedAddress = '';
      S.error = '';
      if (submit) submit.disabled = !S.address.trim();
      queueAddressSearch(e.target.value);
    });

    form?.addEventListener('submit', async (event) => {
      event.preventDefault();
      S.address = input?.value || S.address;
      if (!S.address.trim()) {
        input?.focus();
        return;
      }
      await next();
    });

    app.querySelector('[data-act="start2"]')?.addEventListener('click', async () => {
      S.address = input?.value || S.address;
      if (S.address.trim()) {
        await next();
        return;
      }
      document.querySelector('.app-scroll')?.scrollTo({ top: 0, behavior: 'smooth' });
      window.scrollTo({ top: 0, behavior: 'smooth' });
      input?.focus();
    });
  };

  RENDER[1] = () => {
    app.innerHTML = header(
      1,
      'Repérons<br>votre toiture',
      'Faites glisser la carte pour placer votre toiture <b>sous la punaise rouge</b>.'
    ) + `
      <div class="step-map-full">
        ${mapSection('locateMap', 'Déplacez la carte pour centrer votre toiture.', `
          <div class="map-pin map-pin--red">
            <svg width="48" height="60" viewBox="0 0 42 52"><path d="M21 0C9.4 0 0 9.4 0 21c0 15 21 31 21 31s21-16 21-31C42 9.4 32.6 0 21 0z" fill="#D64545"/><circle cx="21" cy="21" r="9" fill="#fff"/></svg>
          </div>
        `)}
      </div>
      ${!S.locateTutorialDismissed ? `
        <div class="tutorial-modal" id="locateTutorialModal">
          <div class="tutorial-backdrop" data-act="close-locate-tutorial"></div>
          <div class="tutorial-card">
            <button class="tutorial-close" data-act="close-locate-tutorial">fermer le tutoriel</button>
            <button class="tutorial-icon-close" type="button" aria-label="Fermer la modale" data-act="close-locate-tutorial">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round">
                <path d="M6 6L18 18"/>
                <path d="M18 6L6 18"/>
              </svg>
            </button>
            <div class="tutorial-visual tutorial-visual--gif">${locateDemoMedia()}</div>
            <div class="tutorial-step-badge">ÉTAPE 2</div>
            <div class="tutorial-title">Glissez votre maison sous la punaise rouge</div>
            <div class="tutorial-copy">Déplacez la carte jusqu’à ce que votre toiture soit bien centrée sous le repère, puis validez l’emplacement pour passer au tracé.</div>
          </div>
        </div>` : ''}
      ${actions('Valider mon emplacement', { disabled: !S.location })}`;
    setupLocateMap();
  };

  RENDER[2] = () => {
    app.innerHTML = header(
      2,
      'Calculons la surface<br>de votre toiture',
      'Cliquez sur la carte pour placer les <b>coins du pan</b> de toiture qui accueillera les panneaux.',
      'Vous pourrez ajuster les points directement sur la carte une fois la forme créée.'
    ) + `
      <div class="step-map-full">
        ${mapSection('drawMap', 'Cliquez pour ajouter les coins de votre toiture.', `
          <div class="map-tools">
            <button data-act="undo-point" title="Annuler le dernier point">↶</button>
            <button data-act="clear-points" title="Effacer le tracé">✕</button>
          </div>
        `)}
      </div>
      ${!S.drawTutorialDismissed ? `
        <div class="tutorial-modal" id="drawTutorialModal">
          <div class="tutorial-backdrop" data-act="close-draw-tutorial"></div>
          <div class="tutorial-card tutorial-card--narrow">
            <button class="tutorial-close" data-act="close-draw-tutorial">fermer le tutoriel</button>
            <button class="tutorial-icon-close" type="button" aria-label="Fermer la modale" data-act="close-draw-tutorial">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round">
                <path d="M6 6L18 18"/>
                <path d="M18 6L6 18"/>
              </svg>
            </button>
            <div class="tutorial-visual">${drawDemoSVG()}</div>
            <div class="tutorial-step-badge">ÉTAPE 3</div>
            <div class="tutorial-title">Tracez le pan de toiture</div>
            <div class="tutorial-copy">Ajoutez les coins un par un. Une fois la forme fermée, vous pourrez la retoucher.</div>
          </div>
        </div>` : ''}
      <div class="readout" style="margin-top:18px">
        <div class="lbl">Surface estimée de votre toiture</div>
        <div class="big"><span id="surf">${fr(S.surface, 1)}</span> <small>m²</small></div>
      </div>
      ${actions('Valider la surface', { disabled: S.polygon.length < 3 || S.surface <= 0 })}`;
    setupDrawMap();
  };

  RENDER[3] = () => {
    app.innerHTML = header(
      3,
      'Déterminons<br>l’orientation',
      'Cliquez sur le <b>côté le plus haut</b> de votre toiture.'
    ) + `
      <div class="step-map-full">
        ${mapSection('orientMap', 'Cliquez sur le bord le plus haut de la toiture.')}
      </div>
      ${!S.orientTutorialDismissed ? `
        <div class="tutorial-modal" id="orientTutorialModal">
          <div class="tutorial-backdrop" data-act="close-orient-tutorial"></div>
          <div class="tutorial-card tutorial-card--narrow">
            <button class="tutorial-close" data-act="close-orient-tutorial">fermer le tutoriel</button>
            <button class="tutorial-icon-close" type="button" aria-label="Fermer la modale" data-act="close-orient-tutorial">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round">
                <path d="M6 6L18 18"/>
                <path d="M18 6L6 18"/>
              </svg>
            </button>
            <div class="tutorial-visual">${orientDemoSVG()}</div>
            <div class="tutorial-step-badge">ÉTAPE 4</div>
            <div class="tutorial-title">Sélectionnez le côté haut</div>
            <div class="tutorial-copy">Cliquez sur le côté le plus haut de votre toiture. La ligne rouge représente le bord sélectionné pour calculer l’orientation.</div>
          </div>
        </div>` : ''}
      <div class="readout" style="margin-top:18px">
        <div class="lbl">Votre toiture est exposée</div>
        <div class="big" id="orientValue">${escapeHtml(S.orientation || '—')}</div>
      </div>
      ${actions('Valider l’orientation', { disabled: !S.orientation })}`;
    setupOrientMap();
  };

  RENDER[4] = () => {
    const opts = [0, 15, 30, 45];
    app.innerHTML = header(4, 'Quelle est l’inclinaison<br>de votre toiture ?', '') +
      `<div class="roof-illo">${roofSVG()}</div>
       <div class="opt-grid cols-4" id="incl">
         ${opts.map((d) => `<button class="chip ${S.incline === d ? 'sel' : ''}" data-v="${d}"><span class="chip-val">${d}°</span></button>`).join('')}
       </div>
       <p class="note" style="text-align:center">Vous ne savez pas ? Choisissez <b>30°</b>, l’inclinaison la plus courante en France.</p>` +
      actions('Valider l’inclinaison');
    app.querySelectorAll('#incl .chip').forEach((c) => c.addEventListener('click', () => { S.incline = Number(c.dataset.v); render(); }));
  };

  RENDER[5] = () => {
    const opts = [['Tuiles', ICON.tile], ['Ardoise', ICON.slate], ['Bac acier', ICON.steel], ['Toit plat', ICON.flat]];
    app.innerHTML = header(5, 'Quel est le type<br>de votre toiture ?', 'La couverture influence le mode de fixation des panneaux.') +
      `<div class="opt-grid cols-4" id="rt">
        ${opts.map(([n, ic]) => `<button class="chip ${S.roofType === n ? 'sel' : ''}" data-v="${n}"><span class="chip-ico">${ic}</span><span class="chip-lbl">${n}</span></button>`).join('')}
       </div>` +
      actions('Valider le type de toiture');
    app.querySelectorAll('#rt .chip').forEach((c) => c.addEventListener('click', () => { S.roofType = c.dataset.v; render(); }));
  };

  RENDER[6] = () => {
    const opts = [
      ['Aucun', ICON.none, 'Toiture dégagée'],
      ['Cheminée', ICON.chimney, 'Ombre ponctuelle'],
      ['Arbres', ICON.tree, 'Ombrage saisonnier'],
      ['Bâtiment voisin', ICON.building, 'Masque proche'],
    ];
    app.innerHTML = header(6, 'Des obstacles<br>sur votre toiture ?', 'Les masques et ombrages réduisent la production. Sélectionnez le plus présent.') +
      `<div class="opt-grid cols-2" id="sh">
        ${opts.map(([n, ic, d]) => `<button class="chip ${S.shading === n ? 'sel' : ''}" data-v="${n}" style="flex-direction:row;justify-content:flex-start;gap:14px;text-align:left;padding:18px 18px"><span class="chip-ico">${ic}</span><span><span class="chip-lbl" style="display:block">${n}</span><span class="chip-sub">${d}</span></span></button>`).join('')}
       </div>` +
      actions('Continuer');
    app.querySelectorAll('#sh .chip').forEach((c) => c.addEventListener('click', () => { S.shading = c.dataset.v; render(); }));
  };

  RENDER[7] = () => {
    const kwhSel = S.consoMode === 'kwh';
    app.innerHTML = header(7, 'Quelle est votre conso<br>d’électricité ?', 'Renseignez ce que vous connaissez : vos kWh annuels <b>ou</b> le montant de votre facture.') +
      `<div class="field" style="margin-top:6px">
         <label>Je connais ma consommation en kWh</label>
         <div class="input-group">
           <input class="input" id="cKwh" type="number" min="0" placeholder="en kWh" value="${kwhSel ? escapeHtml(S.consoValue) : ''}">
           <span class="unit">kWh</span>
           <div class="selectbox"><select id="cKwhPeriod"><option value="year" ${S.consoPeriod === 'year' ? 'selected' : ''}>par an</option><option value="month" ${S.consoPeriod === 'month' ? 'selected' : ''}>par mois</option></select></div>
         </div>
       </div>
       <div class="divider-or">ou</div>
       <div class="field" style="margin-top:0">
         <label>Je connais le montant de ma facture</label>
         <div class="input-group">
           <input class="input" id="cEur" type="number" min="0" placeholder="en €" value="${!kwhSel ? escapeHtml(S.consoValue) : ''}">
           <span class="unit">€</span>
           <div class="selectbox"><select id="cEurPeriod"><option value="year" ${S.billPeriod === 'year' ? 'selected' : ''}>par an</option><option value="month" ${S.billPeriod === 'month' ? 'selected' : ''}>par mois</option></select></div>
         </div>
       </div>` +
      actions('Valider ma consommation');

    const kwh = app.querySelector('#cKwh');
    const eur = app.querySelector('#cEur');
    const kwhPeriod = app.querySelector('#cKwhPeriod');
    const eurPeriod = app.querySelector('#cEurPeriod');
    kwh?.addEventListener('input', () => {
      S.consoMode = 'kwh';
      S.consoValue = Number(kwh.value || 0);
      eur.value = '';
    });
    eur?.addEventListener('input', () => {
      S.consoMode = 'euro';
      S.consoValue = Number(eur.value || 0);
      kwh.value = '';
    });
    kwhPeriod?.addEventListener('change', () => { S.consoPeriod = kwhPeriod.value; });
    eurPeriod?.addEventListener('change', () => { S.billPeriod = eurPeriod.value; });
  };

  RENDER[8] = () => {
    const opts = ['0', '1', '2', '3+'];
    app.innerHTML = header(8, 'Avez-vous des<br>véhicules électriques ?', 'La recharge à domicile augmente votre autoconsommation et vos économies.') +
      `<div class="round-grid" id="veh">
        ${opts.map((o, i) => `<button class="round ${S.vehicles === i ? 'sel' : ''}" data-v="${i}">${o}</button>`).join('')}
       </div>` +
      actions('Continuer');
    app.querySelectorAll('#veh .round').forEach((b) => b.addEventListener('click', () => { S.vehicles = Number(b.dataset.v); render(); }));
  };

  RENDER[9] = () => {
    const opts = ['Électrique', 'Pompe à chaleur', 'Gaz', 'Fioul', 'Bois'];
    app.innerHTML = header(9, 'Comment chauffez-vous<br>votre logement ?', 'Un chauffage électrique se marie particulièrement bien au photovoltaïque.') +
      `<div class="opt-grid cols-3" id="ht">
        ${opts.map((n) => `<button class="chip ${S.heating === n ? 'sel' : ''}" data-v="${n}"><span class="chip-lbl">${n}</span></button>`).join('')}
       </div>` +
      actions('Valider et lancer la simulation');
    app.querySelectorAll('#ht .chip').forEach((c) => c.addEventListener('click', () => { S.heating = c.dataset.v; render(); }));
  };

  RENDER[10] = () => {
    app.innerHTML = header(10, 'À qui envoyons-nous<br>votre étude ?', 'Recevez votre étude photovoltaïque personnalisée et gratuite.') +
      `<div class="form-grid" style="margin-top:6px">
         <div class="field" style="margin:0"><label>Prénom</label><input class="input" id="f_prenom" value="${escapeHtml(S.contact.prenom)}" placeholder="Votre prénom"></div>
         <div class="field" style="margin:0"><label>Nom</label><input class="input" id="f_nom" value="${escapeHtml(S.contact.nom)}" placeholder="Votre nom"></div>
         <div class="field full" style="margin:0"><label>Adresse e-mail</label><input class="input" id="f_email" type="email" value="${escapeHtml(S.contact.email)}" placeholder="vous@email.fr"></div>
         <div class="field full" style="margin:0"><label>Téléphone</label><input class="input" id="f_tel" type="tel" value="${escapeHtml(S.contact.tel)}" placeholder="06 00 00 00 00"></div>
       </div>
       <label class="consent"><input type="checkbox" id="f_cgu" ${S.consent ? 'checked' : ''}> J’accepte d’être recontacté par Normes Rénovation au sujet de mon projet photovoltaïque et j’ai lu la politique de confidentialité.</label>` +
      actions('Recevoir mon étude complète');
    ['prenom', 'nom', 'email', 'tel'].forEach((k) => {
      app.querySelector('#f_' + k)?.addEventListener('input', (e) => { S.contact[k] = e.target.value; });
    });
    app.querySelector('#f_cgu')?.addEventListener('change', (e) => { S.consent = Boolean(e.target.checked); });
  };

  RENDER[11] = () => {
    if (!S.estimate && !RUNTIME.currentEstimatePromise) {
      app.innerHTML = `<div class="loader">
        <div class="spinner"></div>
        <div class="lt">${escapeHtml(S.loadingLabel)}</div>
        <div class="ls">${escapeHtml(S.loadingSub)}</div>
      </div>`;
      computeEstimateFlow();
      return;
    }

    if (!S.estimate && RUNTIME.currentEstimatePromise) {
      app.innerHTML = `<div class="loader">
        <div class="spinner"></div>
        <div class="lt">${escapeHtml(S.loadingLabel)}</div>
        <div class="ls">${escapeHtml(S.loadingSub)}</div>
      </div>`;
      return;
    }

    renderResults();
  };

  function resultViewModel() {
    const panelLayout = currentPanelLayout();
    const r = estimateResults();
    const recommended = recommendedPanelCount();
    const maxMonth = Math.max(...r.monthlyKwh, 1);
    const labels = ['J', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D'];
    const ctaPending = S.leadStatus.cta === 'loading';
    const callbackPending = S.leadStatus.callback === 'loading';
    const selectedKit = PRESET_KITS.find((kit) => kit.panels === r.panels) || null;
    const counterNote = r.panels === recommended
      ? `Configuration recommandée sur votre toiture : ${recommended} panneaux.`
      : `Configuration personnalisée : ${r.panels} panneaux au lieu des ${recommended} recommandés.`;

    return {
      panelLayout,
      r,
      recommended,
      maxMonth,
      labels,
      ctaPending,
      callbackPending,
      selectedKit,
      counterNote,
    };
  }

  function resultScaffold() {
    return `
      <div id="resultStepLayout">
        <div class="eyebrow">Votre simulation est prête</div>
        <h1 style="margin-bottom:18px">Le potentiel solaire<br>de votre toiture</h1>
        <div id="resultHero"></div>

        <div class="results-layout">
          <section class="result-map-card">
            <div class="section-q" style="margin-top:0">Implantation simulée sur votre toiture</div>
            ${mapSection('resultMap', 'Simulation de pose estimée à partir de votre tracé validé.', `
              <div class="result-map-chip"></div>
            `)}
            <p class="result-map-note">La carte reprend votre zone de toiture et affiche automatiquement les panneaux qui tiennent dans l’emprise sélectionnée.</p>
          </section>

          <div id="resultAdjust"></div>
        </div>

        <div id="resultMetrics"></div>
      </div>`;
  }

  function resultHeroMarkup(view) {
    const { r } = view;
    return `
      <div class="res-hero">
        <div class="loc">${ICON.pin} ${escapeHtml(S.resolvedAddress || S.address)}</div>
        <div class="grid3">
          <div class="stat"><div class="v">${fr(S.surface, 1)}<small> m²</small></div><div class="k">Surface exploitable</div></div>
          <div class="stat"><div class="v">${r.panels}</div><div class="k">Panneaux</div></div>
          <div class="stat"><div class="v">${r.kwc.toFixed(1).replace('.', ',')}<small> kWc</small></div><div class="k">Puissance</div></div>
        </div>
      </div>`;
  }

  function resultAdjustMarkup(view) {
    const { r, selectedKit, counterNote } = view;

    return `
      <section class="result-adjust-card">
        <div class="result-config-head">
          <div>
            <div class="result-kicker">Ajustement instantané</div>
            <h2 class="result-config-title">Ajoutez, retirez ou choisissez un kit prêt à poser</h2>
          </div>
          <div class="result-status-pill">${selectedKit ? `${selectedKit.key} kWc` : 'Sur mesure'}</div>
        </div>

        <div class="result-adjust-body">
          <div class="counter result-counter">
            <button type="button" data-act="panel-minus" ${r.panels <= 1 ? 'disabled' : ''} aria-label="Retirer un panneau">−</button>
            <div class="disp">
              <b>${r.panels}</b>
              <span>Panneaux / ${r.panelCapacity} max</span>
            </div>
            <button type="button" data-act="panel-plus" ${r.panels >= r.panelCapacity ? 'disabled' : ''} aria-label="Ajouter un panneau">+</button>
          </div>

          <div class="kit-grid">
            ${PRESET_KITS.map((kit) => {
              const disabled = kit.panels > r.panelCapacity;
              const selected = !disabled && kit.panels === r.panels;
              const approxKwc = ((kit.panels * PANEL_WC) / 1000).toFixed(1).replace('.', ',');
              return `
                <button
                  type="button"
                  class="kit-card ${selected ? 'sel' : ''}"
                  data-act="panel-kit"
                  data-panels="${kit.panels}"
                  ${disabled ? 'disabled' : ''}
                >
                  <span class="kit-card-badge">${escapeHtml(kit.badge || 'Kit prêt à poser')}</span>
                  <span class="kit-card-kwc">${escapeHtml(kit.key)} kWc</span>
                  <span class="kit-card-home">${escapeHtml(kit.home)}</span>
                  <span class="kit-card-meta">${kit.panels} panneaux · env. ${approxKwc} kWc</span>
                </button>`;
            }).join('')}
          </div>
        </div>

        <div class="result-adjust-foot">
          <p class="result-counter-note">${escapeHtml(counterNote)}</p>
          <p class="result-kit-note">Les chiffres ci-dessous se mettent à jour automatiquement selon la configuration choisie.</p>
        </div>
      </section>`;
  }

  function resultMetricsMarkup(view) {
    const { r, maxMonth, labels, ctaPending, callbackPending } = view;

    return `
      <div class="metric"><div class="mi">${ICON.trend}</div><div><div class="mk">Production annuelle estimée</div><div class="mv">${fr(r.production)}<small>kWh / an</small></div></div></div>
      <div class="metric hl"><div class="mi">${ICON.euro}</div><div><div class="mk">Économies annuelles</div><div class="mv">${fr(r.annualSavings)}<small>€ / an</small></div></div></div>
      <div class="metric"><div class="mi">${ICON.bolt}</div><div><div class="mk">Autoconsommation</div><div class="mv">${Math.round(r.autoconsumption * 100)}<small>% · ${fr(r.selfConsumed)} kWh valorisés</small></div></div></div>

      <div class="chart-card">
        <div class="ck">Production mensuelle estimée (kWh)</div>
        <div class="chart">${r.monthlyKwh.map((value, index) => {
          const cls = index >= 5 && index <= 7 ? 's' : ((index >= 3 && index <= 4) || (index >= 8 && index <= 9) ? 'm' : '');
          return `<div class="bar ${cls}" style="height:${Math.round((value / maxMonth) * 100)}%" title="${labels[index]} — ${fr(value)} kWh"></div>`;
        }).join('')}</div>
        <div class="chart-months">${labels.map((m) => `<span>${m}</span>`).join('')}</div>
      </div>

      <div class="callout">
        <div class="big">Jusqu’à <span class="y">${r.coverage}%</span> de votre facture couverte</div>
        <p>Avec votre orientation ${escapeHtml(S.orientation || 'estimée')} et une toiture ${escapeHtml(S.roofType.toLowerCase())}, votre production peut alimenter une grande partie de vos usages.</p>
      </div>

      <div class="section-q">Économies cumulées</div>
      <div class="savings-row">
        <div class="sv"><div class="k">sur 10 ans</div><div class="v">${fr(r.cum10)} €</div></div>
        <div class="sv"><div class="k">sur 20 ans</div><div class="v">${fr(r.cum20)} €</div></div>
        <div class="sv"><div class="k">sur 30 ans</div><div class="v">${fr(r.cum30)} €</div></div>
      </div>
      <div class="metric"><div class="mi">${ICON.euro}</div><div><div class="mk">Coût estimé de l’installation</div><div class="mv">${fr(r.cost)}<small>€</small></div></div></div>
      <div class="metric"><div class="mi">${ICON.trend}</div><div><div class="mk">Amortissement</div><div class="mv">${r.amort.toFixed(1).replace('.', ',')}<small> ans</small></div></div></div>

      <div class="section-q">Votre impact environnemental</div>
      <div class="eco-row">
        <div class="eco"><div class="v">${fr(r.co2)} kg</div><div class="k">de CO₂ évités par an</div></div>
        <div class="eco"><div class="v">${r.trees}</div><div class="k">arbres plantés / an</div></div>
        <div class="eco"><div class="v">${r.homes.toFixed(1).replace('.', ',')}</div><div class="k">foyers alimentés</div></div>
      </div>

      <div class="lead">
        <div class="section-q" style="margin-top:0">Recevez votre étude complète</div>
        <p class="sub" style="margin-bottom:16px">Bonjour${S.contact.prenom ? ' ' + escapeHtml(S.contact.prenom) : ''}, votre récapitulatif détaillé est prêt à être envoyé.</p>
        <button class="btn btn--primary" data-act="cta" ${ctaPending ? 'disabled' : ''}>${S.leadStatus.cta === 'success' ? '✓ Étude envoyée par e-mail' : (ctaPending ? 'Envoi en cours…' : 'Recevoir l’étude détaillée')}<span class="arrow">→</span></button>
        <button class="btn btn--yellow" style="margin-top:12px" data-act="callback" ${callbackPending ? 'disabled' : ''}>${S.leadStatus.callback === 'success' ? '✓ Un conseiller vous rappellera' : (callbackPending ? 'Demande en cours…' : 'Être recontacté par un conseiller')}</button>
      </div>
      <div class="actions" style="margin-top:18px"><button class="backlink" data-act="restart">‹ Recommencer la simulation</button></div>`;
  }

  function renderResults() {
    const view = resultViewModel();

    if (!app.querySelector('#resultStepLayout')) {
      app.innerHTML = resultScaffold();
    }

    const hero = app.querySelector('#resultHero');
    const adjust = app.querySelector('#resultAdjust');
    const metrics = app.querySelector('#resultMetrics');

    if (hero) hero.innerHTML = resultHeroMarkup(view);
    if (adjust) adjust.innerHTML = resultAdjustMarkup(view);
    if (metrics) metrics.innerHTML = resultMetricsMarkup(view);

    setupResultMap(view.r, view.panelLayout);
  }

  function setupResultMap(result, panelLayout) {
    const container = app.querySelector('#resultMap');
    if (!container || !window.google?.maps || !S.location || S.polygon.length < 3) return;

    let map = RUNTIME.resultMapInstance;
    const isFreshMap = !map || map.getDiv() !== container;
    if (isFreshMap) {
      map = new google.maps.Map(container, baseMapOptions(S.location));
      RUNTIME.resultMapInstance = map;
    } else {
      map.setMapTypeId(S.mapType);
    }
    RUNTIME.activeMap = map;

    if (!RUNTIME.resultRoofOverlay || isFreshMap) {
      if (RUNTIME.resultRoofOverlay?.setMap) RUNTIME.resultRoofOverlay.setMap(null);
      RUNTIME.resultRoofOverlay = new google.maps.Polygon({
        map,
        paths: S.polygon,
        editable: false,
        draggable: false,
        strokeColor: '#60D36C',
        strokeOpacity: 1,
        strokeWeight: 3,
        fillColor: '#60D36C',
        fillOpacity: 0.16,
      });
    } else {
      RUNTIME.resultRoofOverlay.setMap(map);
      RUNTIME.resultRoofOverlay.setPaths(S.polygon);
    }

    if (isFreshMap) {
      const bounds = new google.maps.LatLngBounds();
      S.polygon.forEach((point) => bounds.extend(point));
      map.fitBounds(bounds, 40);

      google.maps.event.addListenerOnce(map, 'idle', () => {
        if (map.getZoom() > 22) map.setZoom(22);
      });
    }

    RUNTIME.resultPanelOverlays.forEach((overlay) => overlay.setMap(null));
    RUNTIME.resultPanelOverlays = [];

    const lerp = (a, b, t) => ({ lat: a.lat + (b.lat - a.lat) * t, lng: a.lng + (b.lng - a.lng) * t });

    panelLayout.slots.slice(0, result.panels).forEach((slot) => {
      // Main panel body — dark navy monocrystalline with metallic frame
      const panel = new google.maps.Polygon({
        map,
        paths: slot.corners,
        clickable: false,
        strokeColor: '#90B8D0',
        strokeOpacity: 1,
        strokeWeight: 1.8,
        fillColor: '#0E1E32',
        fillOpacity: 0.92,
      });
      RUNTIME.resultPanelOverlays.push(panel);

      // Cell grid lines — corners: [bottom-left, bottom-right, top-right, top-left] in local projection
      const [c0, c1, c2, c3] = slot.corners;
      const isLandscape = slot.orientation === 'landscape';
      // Long axis → 4 dividers (5 columns); short axis → 2 dividers (3 rows)
      const hDivs = isLandscape ? 2 : 4;  // horizontal (divides short Y dimension)
      const vDivs = isLandscape ? 4 : 2;  // vertical (divides long X dimension)

      for (let r = 1; r <= hDivs; r++) {
        const t = r / (hDivs + 1);
        const line = new google.maps.Polyline({
          map,
          path: [lerp(c0, c3, t), lerp(c1, c2, t)],
          clickable: false,
          strokeColor: '#5A9ABF',
          strokeOpacity: 0.6,
          strokeWeight: 0.7,
        });
        RUNTIME.resultPanelOverlays.push(line);
      }

      for (let c = 1; c <= vDivs; c++) {
        const t = c / (vDivs + 1);
        const line = new google.maps.Polyline({
          map,
          path: [lerp(c0, c1, t), lerp(c3, c2, t)],
          clickable: false,
          strokeColor: '#5A9ABF',
          strokeOpacity: 0.6,
          strokeWeight: 0.7,
        });
        RUNTIME.resultPanelOverlays.push(line);
      }
    });

    const chip = app.querySelector('.result-map-chip');
    if (chip) chip.textContent = `${result.panels} panneaux simulés`;
    syncMapSwitchButtons();
  }

  function resetMapState() {
    RUNTIME.activePathListeners.forEach((listener) => listener.remove());
    RUNTIME.activePathListeners = [];
    RUNTIME.activeOverlays.forEach((overlay) => {
      if (overlay?.setMap) overlay.setMap(null);
    });
    RUNTIME.activeOverlays = [];
    RUNTIME.resultPanelOverlays.forEach((overlay) => {
      if (overlay?.setMap) overlay.setMap(null);
    });
    RUNTIME.resultPanelOverlays = [];
    if (RUNTIME.resultRoofOverlay?.setMap) RUNTIME.resultRoofOverlay.setMap(null);
    RUNTIME.resultRoofOverlay = null;
    RUNTIME.resultMapInstance = null;
    if (RUNTIME.activePolygon?.setMap) RUNTIME.activePolygon.setMap(null);
    RUNTIME.activePolygon = null;
    RUNTIME.activeMap = null;
  }

  function baseMapOptions(center) {
    return {
      center,
      zoom: S.mapZoom,
      mapTypeId: S.mapType,
      mapId: MAP_ID,
      streetViewControl: false,
      fullscreenControl: false,
      mapTypeControl: false,
      rotateControl: false,
      tilt: 0,
      gestureHandling: 'greedy',
      clickableIcons: false,
      keyboardShortcuts: false,
      zoomControl: true,
      styles: S.mapType === 'roadmap' ? [] : undefined,
    };
  }

  function createMap(containerId) {
    const container = app.querySelector('#' + containerId);
    if (!container || !window.google?.maps || !S.location) return null;
    const map = new google.maps.Map(container, baseMapOptions(S.location));
    RUNTIME.activeMap = map;
    return map;
  }

  function syncMapSwitchButtons() {
    app.querySelectorAll('[data-map-type]').forEach((button) => {
      button.classList.toggle('active', button.dataset.mapType === S.mapType);
    });
  }

  function handleMapTypeSwitch(type) {
    if (!type || S.mapType === type) return;
    S.mapType = type;
    if (RUNTIME.activeMap) {
      RUNTIME.activeMap.setMapTypeId(type);
    }
    syncMapSwitchButtons();
    if (S.step >= 1 && S.step <= 3) {
      render();
    }
  }

  function setupLocateMap() {
    const map = createMap('locateMap');
    if (!map) return;

    google.maps.event.addListenerOnce(map, 'idle', () => {
      S.location = {
        lat: map.getCenter().lat(),
        lng: map.getCenter().lng(),
      };
      S.mapZoom = map.getZoom();
      refreshActionDisabled();
    });

    map.addListener('idle', () => {
      const center = map.getCenter();
      if (!center) return;
      S.location = { lat: center.lat(), lng: center.lng() };
      S.mapZoom = map.getZoom();
      refreshActionDisabled();
    });
  }

  function setupDrawMap() {
    const map = createMap('drawMap');
    if (!map) return;

    const refreshPolygon = () => {
      if (RUNTIME.activePolygon) RUNTIME.activePolygon.setMap(null);
      RUNTIME.activePathListeners.forEach((listener) => listener.remove());
      RUNTIME.activePathListeners = [];
      RUNTIME.activePolygon = null;
      RUNTIME.activeOverlays.forEach((overlay) => overlay?.setMap && overlay.setMap(null));
      RUNTIME.activeOverlays = [];

      if (!S.polygon.length) {
        updateSurfaceDisplay();
        return;
      }

      const polygon = new google.maps.Polygon({
        map,
        paths: S.polygon,
        editable: S.polygon.length >= 3,
        draggable: false,
        strokeColor: '#38B6FF',
        strokeOpacity: 1,
        strokeWeight: 3,
        fillColor: '#38B6FF',
        fillOpacity: 0.20,
      });

      RUNTIME.activePolygon = polygon;

      S.polygon.forEach((point, index) => {
        const marker = new google.maps.Marker({
          map,
          position: point,
          clickable: false,
          zIndex: 20 + index,
          icon: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 9,
            fillColor: '#FFFFFF',
            fillOpacity: 1,
            strokeColor: '#60D36C',
            strokeWeight: 4,
          },
        });

        const label = new google.maps.Marker({
          map,
          position: point,
          clickable: false,
          zIndex: 30 + index,
          icon: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 0,
            fillOpacity: 0,
            strokeOpacity: 0,
          },
          label: {
            text: String(index + 1),
            color: '#1A2D38',
            fontSize: '12px',
            fontWeight: '700',
          },
        });

        RUNTIME.activeOverlays.push(marker, label);
      });

      if (S.polygon.length >= 3) {
        const path = polygon.getPath();
        const syncPath = () => {
          S.polygon = path.getArray().map((point) => ({ lat: point.lat(), lng: point.lng() }));
          resetResultSelection();
          recalculateSurface();
          refreshActionDisabled();
        };
        RUNTIME.activePathListeners = [
          path.addListener('set_at', syncPath),
          path.addListener('insert_at', syncPath),
          path.addListener('remove_at', syncPath),
        ];
      }

      recalculateSurface();
      refreshActionDisabled();
    };

    map.addListener('click', (event) => {
      if (!event.latLng) return;
      S.polygon = [...S.polygon, { lat: event.latLng.lat(), lng: event.latLng.lng() }];
      resetResultSelection();
      refreshPolygon();
    });

    refreshPolygon();
  }

  function setupOrientMap() {
    const map = createMap('orientMap');
    if (!map || S.polygon.length < 3) return;

    new google.maps.Polygon({
      map,
      paths: S.polygon,
      editable: false,
      draggable: false,
      strokeColor: '#60D36C',
      strokeOpacity: 1,
      strokeWeight: 3,
      fillColor: '#60D36C',
      fillOpacity: 0.16,
    });

    const bounds = new google.maps.LatLngBounds();
    S.polygon.forEach((point) => bounds.extend(point));
    map.fitBounds(bounds, 40);

    S.polygon.forEach((point, index) => {
      const nextPoint = S.polygon[(index + 1) % S.polygon.length];
      const selected = S.orientEdge === index;
      const edge = new google.maps.Polyline({
        map,
        path: [point, nextPoint],
        strokeColor: selected ? '#FF4D4D' : '#60D36C',
        strokeOpacity: 1,
        strokeWeight: selected ? 7 : 5,
        clickable: true,
      });

      edge.addListener('click', () => {
        S.orientEdge = index;
        S.orientation = orientationFromEdge(index);
        resetResultSelection();
        render();
      });

      RUNTIME.activeOverlays.push(edge);
    });
  }

  function polygonCentroid(path) {
    const total = path.reduce((acc, point) => ({
      lat: acc.lat + point.lat,
      lng: acc.lng + point.lng,
    }), { lat: 0, lng: 0 });

    return {
      lat: total.lat / path.length,
      lng: total.lng / path.length,
    };
  }

  function orientationFromEdge(edgeIndex) {
    if (!window.google?.maps?.geometry || edgeIndex < 0 || S.polygon.length < 3) return null;
    const a = S.polygon[edgeIndex];
    const b = S.polygon[(edgeIndex + 1) % S.polygon.length];
    const mid = { lat: (a.lat + b.lat) / 2, lng: (a.lng + b.lng) / 2 };
    const center = polygonCentroid(S.polygon);
    const heading = google.maps.geometry.spherical.computeHeading(mid, center);
    const deg = (heading + 360) % 360;
    const names = ['Nord', 'Nord-Est', 'Est', 'Sud-Est', 'Sud', 'Sud-Ouest', 'Ouest', 'Nord-Ouest'];
    return names[Math.round(deg / 45) % 8];
  }

  function recalculateSurface() {
    if (!window.google?.maps?.geometry || S.polygon.length < 3) {
      S.surface = 0;
      updateSurfaceDisplay();
      return;
    }

    const path = S.polygon.map((point) => new google.maps.LatLng(point.lat, point.lng));
    S.surface = google.maps.geometry.spherical.computeArea(path);
    updateSurfaceDisplay();
  }

  function updateSurfaceDisplay() {
    const surf = app.querySelector('#surf');
    if (surf) surf.textContent = fr(S.surface, 1);
  }

  async function fetchPublicConfig() {
    try {
      const response = await fetch('/api/solar-public-config', {
        headers: { Accept: 'application/json' },
        credentials: 'same-origin',
      });

      if (!response.ok) {
        throw new Error('config-endpoint-unavailable');
      }

      RUNTIME.config = await response.json();
    } catch (_) {
      const response = await fetch('/simulateur-photovoltaique', {
        headers: { Accept: 'text/html' },
        credentials: 'same-origin',
      });

      if (!response.ok) {
        throw new Error('Impossible de charger la configuration du simulateur.');
      }

      const html = await response.text();
      const csrfToken = html.match(/<meta name="csrf-token" content="([^"]+)"/)?.[1] || '';
      const googleMapsKey = html.match(/window\.__mapsKey = "([^"]+)"/)?.[1] || '';
      const geocode = html.match(/window\.__geocodeUrl\s*=\s*"([^"]+)"/)?.[1] || '/api/solar-geocode';
      const autocomplete = html.match(/window\.__autocompleteUrl\s*=\s*"([^"]+)"/)?.[1] || '/api/solar-autocomplete';
      const estimate = html.match(/window\.__estimateUrl\s*=\s*"([^"]+)"/)?.[1] || '/api/solar-estimate';

      RUNTIME.config = {
        googleMapsKey,
        csrfToken,
        endpoints: {
          autocomplete,
          geocode,
          estimate,
          lead: '/api/solar-lead',
        },
        defaults: {
          country: 'fr',
          language: 'fr',
          address: '',
        },
      };
    }

    if (!S.address && RUNTIME.config?.defaults?.address) {
      S.address = RUNTIME.config.defaults.address;
    }
  }

  function loadGoogleMaps() {
    if (RUNTIME.googleReady) return RUNTIME.googleReady;

    RUNTIME.googleReady = new Promise((resolve, reject) => {
      if (window.google?.maps) {
        resolve(window.google.maps);
        return;
      }

      const key = RUNTIME.config?.googleMapsKey;
      if (!key) {
        reject(new Error('Clé Google Maps absente.'));
        return;
      }

      const callbackName = '__nrPvMapsReady';
      window[callbackName] = () => {
        resolve(window.google.maps);
        delete window[callbackName];
      };

      const script = document.createElement('script');
      script.src = `https://maps.googleapis.com/maps/api/js?key=${encodeURIComponent(key)}&libraries=geometry&language=fr&region=FR&v=weekly&callback=${callbackName}`;
      script.async = true;
      script.defer = true;
      script.onerror = () => reject(new Error('Impossible de charger Google Maps.'));
      document.head.appendChild(script);
    });

    return RUNTIME.googleReady;
  }

  async function apiPost(endpoint, payload) {
    const response = await fetch(endpoint, {
      method: 'POST',
      credentials: 'same-origin',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': RUNTIME.config?.csrfToken || '',
      },
      body: JSON.stringify(payload),
    });

    const data = await response.json().catch(() => ({}));
    if (!response.ok) {
      throw new Error(data.error || data.message || 'Une erreur est survenue.');
    }

    return data;
  }

  function queueAddressSearch(query) {
    clearTimeout(RUNTIME.addressTimer);
    if (!query || query.trim().length < 3) {
      S.addressSuggestions = [];
      refreshAddressSuggestions();
      return;
    }

    RUNTIME.addressTimer = setTimeout(() => searchAddressSuggestions(query), 200);
  }

  async function searchAddressSuggestions(query) {
    const reqId = ++RUNTIME.pendingAddressRequest;

    try {
      const endpoint = new URL(RUNTIME.config.endpoints.autocomplete, window.location.origin);
      endpoint.searchParams.set('q', query);
      const response = await fetch(endpoint.toString(), {
        headers: { Accept: 'application/json' },
        credentials: 'same-origin',
      });
      const items = await response.json();
      if (reqId !== RUNTIME.pendingAddressRequest) return;
      S.addressSuggestions = Array.isArray(items) ? items : [];
      refreshAddressSuggestions();
    } catch (_) {
      if (reqId !== RUNTIME.pendingAddressRequest) return;
      S.addressSuggestions = [];
      refreshAddressSuggestions();
    }
  }

  function refreshAddressSuggestions() {
    const list = app.querySelector('#addrSuggestions');
    if (!list) return;
    list.classList.toggle('open', S.addressSuggestions.length > 0);
    list.innerHTML = S.addressSuggestions.map((item, index) => `
      <button type="button" class="suggest-item" data-suggestion-index="${index}">
        <span class="suggest-main">${escapeHtml(item.label)}</span>
        <span class="suggest-sub">${escapeHtml(item.city || item.postcode || item.full || '')}</span>
      </button>`).join('');
  }

  function refreshActionDisabled() {
    const primary = app.querySelector('[data-act="next"]');
    if (!primary) return;

    if (S.step === 0) {
      primary.disabled = !S.address.trim();
      return;
    }
    if (S.step === 1) {
      primary.disabled = !S.location;
      return;
    }
    if (S.step === 2) {
      primary.disabled = S.polygon.length < 3 || S.surface <= 0;
      return;
    }
    if (S.step === 3) {
      primary.disabled = !S.orientation;
      return;
    }
  }

  function refreshAddressActions() {
    const primary = app.querySelector('[data-act="next"]');
    if (primary) primary.disabled = !S.address.trim();
  }

  function selectSuggestion(index) {
    const item = S.addressSuggestions[index];
    if (!item) return;
    S.address = item.full || item.label;
    S.resolvedAddress = item.full || item.label;
    S.location = { lat: Number(item.lat), lng: Number(item.lng) };
    S.addressSuggestions = [];
    S.error = '';
    render();
  }

  async function resolveAddress() {
    if (S.location && S.resolvedAddress) return true;
    S.error = '';
    const payload = { address: S.address.trim() };
    const result = await apiPost(RUNTIME.config.endpoints.geocode, payload);
    S.location = { lat: Number(result.lat), lng: Number(result.lng) };
    S.resolvedAddress = result.formatted_address || S.address.trim();
    return true;
  }

  async function computeEstimateFlow() {
    S.loadingLabel = 'Calcul en cours…';
    S.loadingSub = 'Nous récupérons les données solaires réelles de votre adresse.';
    RUNTIME.currentEstimatePromise = apiPost(RUNTIME.config.endpoints.estimate, {
      lat: Number(S.location?.lat),
      lng: Number(S.location?.lng),
    })
      .then((estimate) => {
        S.estimate = estimate;
        S.error = '';
      })
      .catch((error) => {
        S.estimate = {
          panelCount: roofCapacityFromSurface(),
          areaM2: S.surface,
          kwc: roofCapacityFromSurface() * PANEL_WC / 1000,
          yearlyKwh: Math.round((roofCapacityFromSurface() * PANEL_WC / 1000) * 1050),
          annualSavings: Math.round((roofCapacityFromSurface() * PANEL_WC / 1000) * 260),
          budgetMin: Math.round((roofCapacityFromSurface() * PANEL_WC / 1000) * 1900 / 100) * 100,
        };
        S.error = error.message || 'Les données solaires avancées sont indisponibles pour cette adresse.';
      })
      .finally(() => {
        RUNTIME.currentEstimatePromise = null;
        render();
      });
  }

  function validateContactStep() {
    const { prenom, nom, email, tel } = S.contact;
    if (!prenom.trim() || !nom.trim() || !email.trim() || !tel.trim()) {
      S.error = 'Merci de compléter vos coordonnées avant de continuer.';
      render();
      return false;
    }
    if (!S.consent) {
      S.error = 'Merci d’accepter le rappel au sujet de votre projet photovoltaïque.';
      render();
      return false;
    }
    return true;
  }

  function leadPayload(actionType) {
    const r = estimateResults();
    return {
      prenom: S.contact.prenom.trim(),
      nom: S.contact.nom.trim(),
      telephone: S.contact.tel.trim(),
      email: S.contact.email.trim(),
      adresse: S.resolvedAddress || S.address.trim(),
      type_projet: actionType === 'callback' ? 'je-ne-sais-pas' : S.projectType,
      kwc: Number(r.kwc.toFixed(2)),
      budget_min: Math.round(r.cost * 0.92),
      budget_max: Math.round(r.cost * 1.12),
      yearly_kwh: r.production,
      panel_count: r.panels,
      annual_savings: r.annualSavings,
      surface_m2: Number(S.surface.toFixed(1)),
      orientation: S.orientation,
      inclination: S.incline,
      consumption_kwh: annualConsumptionKwh(),
      bill_amount: S.consoMode === 'euro' ? Number(S.consoValue || 0) : null,
      bill_period: S.billPeriod === 'month' ? 'month' : 'year',
      vehicle_count: S.vehicles,
      heating_mode: S.heating,
      zone_type: S.zoneType,
      wants_battery: Boolean(S.wantsBattery),
      wants_charger: Boolean(S.wantsCharger),
      consumption_source: S.consoMode,
    };
  }

  async function submitLead(actionType) {
    if (S.leadStatus[actionType] === 'loading' || S.leadStatus[actionType] === 'success') return;
    S.leadStatus[actionType] = 'loading';
    render();

    try {
      await apiPost(RUNTIME.config.endpoints.lead, leadPayload(actionType));
      S.leadStatus[actionType] = 'success';
      S.error = '';
    } catch (error) {
      S.leadStatus[actionType] = 'idle';
      S.error = error.message || 'Impossible d’envoyer votre demande pour le moment.';
    }

    render();
  }

  async function next() {
    S.error = '';

    if (S.step === 0) {
      try {
        await resolveAddress();
      } catch (error) {
        S.error = error.message || 'Adresse introuvable.';
        render();
        return;
      }
    }

    if (S.step === 2 && (S.polygon.length < 3 || S.surface <= 0)) {
      S.error = 'Tracez au moins 3 points pour définir votre toiture.';
      render();
      return;
    }

    if (S.step === 3 && !S.orientation) {
      S.error = 'Sélectionnez le côté le plus haut de votre toiture.';
      render();
      return;
    }

    if (S.step === 10 && !validateContactStep()) {
      return;
    }

    if (S.step < TOTAL - 1) {
      S.step += 1;
      render();
    }
  }

  function back() {
    S.error = '';
    if (S.step > 0) {
      S.step -= 1;
      render();
    }
  }

  function restart() {
    S.step = 0;
    S.location = null;
    S.resolvedAddress = '';
    S.addressSuggestions = [];
    S.polygon = [];
    S.surface = 0;
    S.orientEdge = -1;
    S.orientation = null;
    S.estimate = null;
    S.resultPanelCount = null;
    S.locateTutorialDismissed = false;
    S.drawTutorialDismissed = false;
    S.orientTutorialDismissed = false;
    S.error = '';
    S.leadStatus = { cta: 'idle', callback: 'idle' };
    RUNTIME.panelLayoutCacheKey = '';
    RUNTIME.panelLayoutCache = null;
    render();
  }

  function render() {
    resetMapState();
    document.body.classList.toggle('landing', S.step === 0);
    app.classList.toggle('card--landing', S.step === 0);
    (RENDER[S.step] || RENDER[0])();
    app.classList.remove('anim');
    void app.offsetWidth;
    app.classList.add('anim');

    phasesEl.querySelectorAll('.phase').forEach((phase, index) => {
      phase.classList.toggle('active', index === STEP_PHASE[S.step]);
      phase.classList.toggle('done', index < STEP_PHASE[S.step]);
    });

    microFill.style.width = `${((S.step + 1) / TOTAL) * 100}%`;
    microCount.textContent = `${S.step + 1} / ${TOTAL}`;
    app.parentElement.scrollTop = 0;
    const sc = document.querySelector('.app-scroll');
    if (sc) sc.scrollTop = 0;
    window.scrollTo(0, 0);
  }

  document.addEventListener('click', async (event) => {
    const actionEl = event.target.closest('[data-act]');
    if (actionEl) {
      const action = actionEl.dataset.act;
      if (action === 'next') await next();
      else if (action === 'back') back();
      else if (action === 'restart') restart();
      else if (action === 'close-locate-tutorial') {
        S.locateTutorialDismissed = true;
        render();
      } else if (action === 'close-draw-tutorial') {
        S.drawTutorialDismissed = true;
        render();
      } else if (action === 'close-orient-tutorial') {
        S.orientTutorialDismissed = true;
        render();
      }
      else if (action === 'undo-point') {
        S.polygon = S.polygon.slice(0, -1);
        resetResultSelection();
        recalculateSurface();
        render();
      } else if (action === 'clear-points') {
        S.polygon = [];
        S.surface = 0;
        resetResultSelection();
        render();
      } else if (action === 'panel-minus') {
        if (activePanelCount() > 1) {
          S.resultPanelCount = activePanelCount() - 1;
          renderResults();
        }
      } else if (action === 'panel-plus') {
        if (activePanelCount() < currentPanelLayout().capacity) {
          S.resultPanelCount = activePanelCount() + 1;
          renderResults();
        }
      } else if (action === 'panel-kit') {
        const panels = Number(actionEl.dataset.panels || 0);
        if (panels > 0) {
          S.resultPanelCount = Math.min(currentPanelLayout().capacity, panels);
          renderResults();
        }
      } else if (action === 'cta' || action === 'callback') {
        await submitLead(action);
      }
      return;
    }

    const suggestionEl = event.target.closest('[data-suggestion-index]');
    if (suggestionEl) {
      selectSuggestion(Number(suggestionEl.dataset.suggestionIndex));
      return;
    }

    const mapTypeEl = event.target.closest('[data-map-type]');
    if (mapTypeEl) {
      handleMapTypeSwitch(mapTypeEl.dataset.mapType);
    }
  });

  async function boot() {
    app.innerHTML = `<div class="loader">
      <div class="spinner"></div>
      <div class="lt">Chargement…</div>
      <div class="ls">Préparation du simulateur photovoltaïque.</div>
    </div>`;

    try {
      await fetchPublicConfig();
      await loadGoogleMaps();
      render();
    } catch (error) {
      app.innerHTML = `<div class="loader">
        <div class="lt">Impossible de charger la carte</div>
        <div class="ls">${escapeHtml(error.message || 'Une erreur est survenue.')}</div>
      </div>`;
    }
  }

  boot();
})();
