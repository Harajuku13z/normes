@php
    use App\Support\HomeView;
    $h = $home ?? [];
    $logo = HomeView::url((string) data_get($h, 'header.logo', '/logo.png'));
    $siteName = (string) data_get($h, 'meta.site_name', 'Normes Rénovation');
    $mapsKey = $googleMapsKey ?? '';
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Simulateur Solaire — {{ $siteName }}</title>
<meta name="description" content="Estimez votre potentiel solaire et obtenez un devis gratuit pour l'installation de panneaux photovoltaïques.">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{
  --ink:#0f2231;
  --ink-2:#1a3346;
  --slate:#5a6b78;
  --muted:#8a96a0;
  --line:#e6ebef;
  --line-2:#eef2f5;
  --bg:#f4f6f8;
  --card:#ffffff;
  --accent:#13a6e8;
  --accent-deep:#0f8fc9;
  --accent-soft:#e7f6fd;
  --ok:#1f8a5b;
  --ok-soft:#eaf7ef;
  --danger:#e23a3a;
  --danger-soft:#fdecec;
  --yellow:#f5c400;
  --shadow:0 1px 2px rgba(15,34,49,.04),0 8px 24px rgba(15,34,49,.06);
  --shadow-lg:0 4px 12px rgba(15,34,49,.06),0 24px 48px rgba(15,34,49,.10);
  --radius:14px;
}
*{box-sizing:border-box;margin:0;padding:0}
html,body{
  font-family:'Inter',system-ui,-apple-system,Segoe UI,sans-serif;
  color:var(--ink);
  background:
    radial-gradient(1200px 600px at 80% -10%,#eaf4fb 0%,transparent 60%),
    radial-gradient(900px 500px at -10% 110%,#eef4f8 0%,transparent 60%),
    var(--bg);
  min-height:100vh;
  -webkit-font-smoothing:antialiased;
}
.app{max-width:1440px;margin:0 auto;padding:20px 24px 40px}

/* ── Topbar ── */
.topbar{
  background:var(--card);border:1px solid var(--line);border-radius:18px;
  padding:14px 22px;display:flex;align-items:center;gap:20px;box-shadow:var(--shadow);
}
.brand{display:flex;align-items:center;min-width:200px}
.brand img{height:44px;width:auto;display:block}
.stepper{flex:1;display:flex;align-items:center;justify-content:center;gap:10px}
.step{display:flex;align-items:center;gap:9px;color:var(--muted);font-weight:500;font-size:14px}
.step .num{
  width:28px;height:28px;border-radius:50%;background:#eef2f5;color:#8a96a0;
  display:grid;place-items:center;font-weight:700;font-size:12px;flex-shrink:0;transition:.2s
}
.step.active .num{background:var(--ink);color:#fff}
.step.active{color:var(--ink);font-weight:600}
.step.done .num{background:var(--ok);color:#fff}
.step.done{color:var(--ink-2)}
.step-sep{width:40px;height:2px;background:linear-gradient(90deg,#dfe5ea,#eef2f5);border-radius:2px;flex-shrink:0}
.step-sep.done{background:var(--ok);opacity:.45}
.help-btn{
  border:1px solid var(--line);background:#fff;border-radius:12px;padding:9px 15px;
  display:flex;align-items:center;gap:9px;font:600 13.5px/1 'Inter',sans-serif;
  color:var(--ink);cursor:pointer;transition:.15s ease;white-space:nowrap;
  text-decoration:none;
}
.help-btn:hover{border-color:#cdd6dd;box-shadow:var(--shadow)}
.help-btn .q{
  width:18px;height:18px;border-radius:50%;border:1.5px solid #b9c4cc;color:#8a96a0;
  display:grid;place-items:center;font-weight:700;font-size:10px;flex-shrink:0;
}

/* ── Layout grid ── */
.grid{display:grid;grid-template-columns:300px 1fr 320px;gap:20px;margin-top:20px}

/* ── Card ── */
.card{
  background:var(--card);border:1px solid var(--line);border-radius:var(--radius);
  padding:20px;box-shadow:var(--shadow);
}
.card+.card{margin-top:16px}
.card h2{margin:0 0 6px;font-size:17px;font-weight:700;color:var(--ink);line-height:1.25;letter-spacing:-.01em}
.card p.lede{margin:0 0 16px;color:var(--slate);font-size:13px;line-height:1.55}
.meta-label{text-transform:uppercase;letter-spacing:.12em;font-size:10px;font-weight:600;color:var(--muted);margin-bottom:5px}

/* Address input */
.addr-wrap{position:relative;margin-bottom:12px}
.addr-icon{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--accent);pointer-events:none}
.addr-input{
  width:100%;border:1.5px solid var(--line);border-radius:11px;
  padding:13px 42px 13px 40px;font:500 14px 'Inter',sans-serif;color:var(--ink);
  transition:.15s ease;outline:none;background:#fff;
}
.addr-input:focus{border-color:var(--accent);box-shadow:0 0 0 3px var(--accent-soft)}
.addr-input::placeholder{color:var(--muted)}
.pac-container{border-radius:10px!important;box-shadow:0 8px 32px rgba(15,34,49,.15)!important;border:1px solid var(--line)!important;font-family:'Inter',sans-serif!important;margin-top:4px!important}
.pac-item{padding:10px 14px!important;font-size:13px!important;cursor:pointer!important}
.pac-item:hover{background:var(--accent-soft)!important}
.pac-item-selected{background:var(--accent-soft)!important}

/* Buttons */
.btn{
  width:100%;border:0;padding:13px 16px;border-radius:11px;
  font:600 14px/1 'Inter',sans-serif;display:flex;align-items:center;
  justify-content:center;gap:9px;cursor:pointer;transition:.15s ease;
}
.btn-primary{background:var(--ink);color:#fff}
.btn-primary:hover:not(:disabled){background:#0a1a26;transform:translateY(-1px);box-shadow:0 4px 12px rgba(15,34,49,.2)}
.btn-primary:disabled{background:#cbd2d8;color:#fff;cursor:not-allowed;transform:none;box-shadow:none}
.btn-accent{background:var(--accent);color:#fff}
.btn-accent:hover:not(:disabled){background:var(--accent-deep);transform:translateY(-1px);box-shadow:0 4px 12px rgba(19,166,232,.3)}
.btn-outline{background:#fff;border:1.5px solid var(--line);color:var(--ink)}
.btn-outline:hover{border-color:#cdd6dd;box-shadow:var(--shadow)}
.btn-yellow{background:var(--yellow);color:var(--ink);font-weight:700}
.btn-yellow:hover{background:#e6b700;transform:translateY(-1px);box-shadow:0 4px 12px rgba(245,196,0,.3)}

/* Orientation / incl fields */
.field{margin-top:12px}
.field label{display:block;font-size:12.5px;font-weight:600;color:var(--ink-2);margin-bottom:5px}
.select{position:relative}
.select select{
  appearance:none;width:100%;background:#fff;border:1px solid var(--line);
  border-radius:10px;padding:11px 36px 11px 13px;font:500 13.5px 'Inter',sans-serif;
  color:var(--ink);cursor:pointer;outline:none;
}
.select select:focus{border-color:var(--accent);box-shadow:0 0 0 3px var(--accent-soft)}
.select::after{
  content:"";position:absolute;right:13px;top:50%;
  width:7px;height:7px;border-right:2px solid #5a6b78;border-bottom:2px solid #5a6b78;
  transform:translateY(-70%) rotate(45deg);pointer-events:none;
}

/* Roof info card */
.roof-info-row{display:flex;gap:8px;align-items:center;padding:10px 12px;background:var(--line-2);border-radius:10px;margin-bottom:8px;font-size:13px}
.roof-info-row .ri-icon{width:32px;height:32px;border-radius:8px;background:var(--accent-soft);color:var(--accent);display:grid;place-items:center;flex-shrink:0}
.roof-info-row .ri-label{font-size:10.5px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.08em}
.roof-info-row .ri-val{font-size:14px;font-weight:700;color:var(--ink)}

/* ── Map ── */
.map-wrap{
  position:relative;border-radius:var(--radius);overflow:hidden;
  box-shadow:var(--shadow-lg);background:#1a1a2e;border:1px solid var(--line);
  min-height:500px;
}
#mapDiv{position:absolute;inset:0}
.map-overlay-search{
  position:absolute;top:16px;left:16px;right:16px;z-index:10;
  background:#fff;border-radius:10px;box-shadow:0 4px 16px rgba(0,0,0,.2);
  display:flex;align-items:center;height:44px;overflow:hidden;
}
.map-overlay-search .map-pin{padding:0 12px;color:var(--accent);flex-shrink:0}
.map-overlay-search input{
  flex:1;border:0;outline:0;font:500 13.5px 'Inter',sans-serif;color:var(--ink);
  background:transparent;height:100%;
}
.map-overlay-search .map-search-btn{
  border:0;background:transparent;color:#5a6b78;padding:0 14px;cursor:pointer;
  height:100%;border-left:1px solid var(--line-2);flex-shrink:0;
}
.layer-switch{
  position:absolute;top:16px;right:16px;z-index:10;
  display:flex;background:#fff;border-radius:10px;padding:4px;
  box-shadow:0 4px 14px rgba(0,0,0,.18);height:44px;align-items:center;
}
.layer-switch button{
  border:0;background:transparent;padding:7px 14px;border-radius:7px;
  font:600 12.5px 'Inter',sans-serif;color:var(--slate);cursor:pointer;
}
.layer-switch button.active{background:var(--ink);color:#fff}
.map-info-bar{
  position:absolute;left:16px;right:16px;bottom:16px;z-index:10;
  background:rgba(255,255,255,.95);border-radius:12px;padding:12px 14px;
  display:flex;gap:10px;align-items:flex-start;box-shadow:0 4px 14px rgba(0,0,0,.18);
  font-size:12.5px;color:var(--slate);line-height:1.5;backdrop-filter:blur(8px);
}
.map-info-bar .ico{
  width:24px;height:24px;border-radius:50%;background:var(--accent-soft);color:var(--accent);
  display:grid;place-items:center;flex-shrink:0;font-weight:700;font-size:13px;
}
.map-info-bar b{color:var(--ink)}
.map-loading{
  position:absolute;inset:0;z-index:20;
  background:rgba(15,34,49,.75);display:flex;flex-direction:column;
  align-items:center;justify-content:center;gap:16px;
  backdrop-filter:blur(4px);
}
.map-loading.hidden{display:none}
.spinner{
  width:44px;height:44px;border-radius:50%;
  border:4px solid rgba(255,255,255,.2);
  border-top-color:var(--accent);
  animation:spin .8s linear infinite;
}
@keyframes spin{to{transform:rotate(360deg)}}
.map-loading p{color:#fff;font-weight:600;font-size:14px}

/* ── Results panel ── */
.estim-header{margin:0 0 14px;font-size:16px;font-weight:700;color:var(--ink);letter-spacing:-.01em}
.metric{
  background:#fff;border:1px solid var(--line);border-radius:12px;
  padding:13px 14px;display:flex;align-items:center;gap:12px;
  margin-bottom:9px;transition:.18s ease;
}
.metric:hover{border-color:#cdd9e0;box-shadow:0 2px 8px rgba(15,34,49,.05)}
.metric .ico{
  width:40px;height:40px;border-radius:10px;background:#f3f6f8;color:var(--ink-2);
  display:grid;place-items:center;flex-shrink:0;transition:.18s ease;
}
.metric:hover .ico{background:var(--accent-soft);color:var(--accent)}
.metric .lbl{font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);font-weight:600;margin-bottom:2px}
.metric .val{font-size:21px;font-weight:800;color:var(--ink);letter-spacing:-.01em;font-variant-numeric:tabular-nums;line-height:1}
.metric .val small{font-size:12px;font-weight:600;color:var(--accent);margin-left:4px}
.metric.skeleton .val{background:#eef2f5;color:transparent;border-radius:6px;animation:shimmer 1.5s infinite}
.metric.skeleton .lbl{background:#eef2f5;color:transparent;border-radius:4px}
.metric.skeleton .ico{background:#eef2f5;color:transparent}
@keyframes shimmer{0%,100%{opacity:1}50%{opacity:.5}}

.budget-card{background:var(--accent-soft);border:1px solid rgba(19,166,232,.2);border-radius:12px;padding:14px;margin-bottom:9px}
.budget-card .lbl{font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:var(--accent-deep);font-weight:600;margin-bottom:6px}
.budget-range{font-size:20px;font-weight:800;color:var(--ink);letter-spacing:-.01em}
.budget-range small{font-size:12px;font-weight:600;color:var(--slate);margin-left:4px}
.budget-card.skeleton .budget-range{background:#cce9f7;color:transparent;border-radius:6px}

.chart-card{padding:16px;margin-bottom:9px}
.chart-card .lbl{font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);font-weight:600;margin-bottom:12px}
.chart{display:grid;grid-template-columns:repeat(12,1fr);align-items:end;gap:5px;height:90px}
.bar{background:#dbe3e9;border-radius:4px 4px 0 0;transition:background .2s,transform .15s;min-height:4px;cursor:pointer}
.bar:hover{transform:translateY(-2px);filter:brightness(1.08)}
.bar.summer{background:var(--accent)}
.bar.shoulder{background:#1f4257}
.month-row{display:grid;grid-template-columns:repeat(12,1fr);gap:5px;font-size:9.5px;color:var(--muted);text-align:center;margin-top:7px;font-weight:600;letter-spacing:.04em}

.empty-state{
  padding:32px 20px;text-align:center;color:var(--muted);
}
.empty-state .es-icon{font-size:48px;margin-bottom:12px;opacity:.4}
.empty-state p{font-size:13.5px;line-height:1.6;color:var(--slate)}
.empty-state strong{color:var(--ink)}

/* Validated address pill */
.addr-pill{
  display:flex;align-items:center;gap:8px;padding:10px 12px;
  background:var(--ok-soft);border:1px solid #c9ead6;border-radius:10px;
  margin-bottom:12px;font-size:13px;color:#13643f;font-weight:600;
}
.addr-pill .check{width:18px;height:18px;border-radius:50%;background:var(--ok);color:#fff;display:grid;place-items:center;flex-shrink:0}
.addr-pill .change{margin-left:auto;background:transparent;border:0;color:#13643f;font-weight:700;font-size:12px;cursor:pointer;text-decoration:underline;text-underline-offset:2px}

/* ── Modal lead form ── */
.modal-backdrop{
  position:fixed;inset:0;background:rgba(15,34,49,.55);z-index:100;
  display:flex;align-items:center;justify-content:center;padding:20px;
  backdrop-filter:blur(6px);
}
.modal-backdrop.hidden{display:none}
.modal-box{
  background:#fff;border-radius:20px;max-width:540px;width:100%;
  box-shadow:0 24px 64px rgba(15,34,49,.2);overflow:hidden;max-height:90vh;
  display:flex;flex-direction:column;
}
.modal-head{
  background:var(--ink);padding:24px 28px;
  display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-shrink:0;
}
.modal-head h3{color:#fff;font-size:20px;font-weight:800;letter-spacing:-.01em;line-height:1.2}
.modal-head p{color:rgba(255,255,255,.7);font-size:13px;margin-top:4px;line-height:1.5}
.modal-close{background:rgba(255,255,255,.1);border:0;color:#fff;width:32px;height:32px;border-radius:8px;cursor:pointer;display:grid;place-items:center;flex-shrink:0;transition:.15s ease}
.modal-close:hover{background:rgba(255,255,255,.2)}
.modal-summary{
  display:grid;grid-template-columns:1fr 1fr;gap:8px;padding:16px 28px;background:#f8fafc;border-bottom:1px solid var(--line);flex-shrink:0;
}
.ms-item{text-align:center;padding:10px 8px;background:#fff;border-radius:10px;border:1px solid var(--line)}
.ms-item .ms-val{font-size:18px;font-weight:800;color:var(--ink);letter-spacing:-.01em}
.ms-item .ms-lbl{font-size:10px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.08em;margin-top:2px}
.modal-body{padding:20px 28px 28px;overflow-y:auto}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.form-field{margin-bottom:14px}
.form-field label{display:block;font-size:12.5px;font-weight:600;color:var(--ink-2);margin-bottom:5px}
.form-field input,.form-field select{
  width:100%;border:1.5px solid var(--line);border-radius:10px;
  padding:11px 13px;font:500 13.5px 'Inter',sans-serif;color:var(--ink);
  outline:none;transition:.15s ease;appearance:none;background:#fff;
}
.form-field input:focus,.form-field select:focus{border-color:var(--accent);box-shadow:0 0 0 3px var(--accent-soft)}
.form-field input.error,.form-field select.error{border-color:var(--danger)}
.project-type-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:14px}
.project-type-btn{
  border:1.5px solid var(--line);background:#fff;border-radius:10px;
  padding:12px 10px;cursor:pointer;text-align:center;transition:.15s ease;
}
.project-type-btn:hover{border-color:var(--accent);background:var(--accent-soft)}
.project-type-btn.active{border-color:var(--accent);background:var(--accent-soft);color:var(--accent-deep)}
.project-type-btn .ptb-icon{font-size:22px;display:block;margin-bottom:4px}
.project-type-btn .ptb-label{font-size:12px;font-weight:600;display:block;color:var(--ink)}
.project-type-btn.active .ptb-label{color:var(--accent-deep)}
.submit-btn{width:100%;border:0;background:var(--accent);color:#fff;padding:15px;border-radius:12px;font:700 15px/1 'Inter',sans-serif;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:10px;transition:.15s ease;margin-top:4px}
.submit-btn:hover:not(:disabled){background:var(--accent-deep);transform:translateY(-1px);box-shadow:0 6px 16px rgba(19,166,232,.35)}
.submit-btn:disabled{background:#cbd2d8;cursor:not-allowed;transform:none;box-shadow:none}
.submit-note{text-align:center;font-size:11.5px;color:var(--muted);margin-top:10px;line-height:1.5}

/* Success state in modal */
.modal-success{padding:40px 28px;text-align:center}
.ms-check{width:64px;height:64px;border-radius:50%;background:var(--ok-soft);border:2px solid #c9ead6;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:28px}
.modal-success h4{font-size:20px;font-weight:800;color:var(--ink);margin-bottom:8px}
.modal-success p{font-size:14px;color:var(--slate);line-height:1.6}

/* Toast */
.toast{
  position:fixed;left:50%;bottom:28px;transform:translate(-50%,80px);
  background:var(--ok);color:#fff;padding:12px 20px;border-radius:10px;
  font:600 13.5px/1 'Inter',sans-serif;display:flex;align-items:center;gap:10px;
  opacity:0;transition:.3s cubic-bezier(.34,1.56,.64,1);z-index:200;white-space:nowrap;
  box-shadow:0 12px 30px rgba(31,138,91,.4);
}
.toast.error-toast{background:var(--danger);box-shadow:0 12px 30px rgba(226,58,58,.4)}
.toast.show{opacity:1;transform:translate(-50%,0)}

/* ── Responsive ── */
@media(max-width:1180px){.grid{grid-template-columns:280px 1fr 280px}}
@media(max-width:960px){
  .grid{grid-template-columns:1fr;grid-template-rows:auto 420px auto}
  .stepper{display:none}
  .map-wrap{min-height:420px}
}
@media(max-width:600px){
  .app{padding:12px 14px 32px}
  .topbar{border-radius:14px;padding:12px 16px}
  .form-row,.project-type-grid{grid-template-columns:1fr}
  .modal-summary{grid-template-columns:1fr 1fr}
  .modal-head,.modal-body{padding-left:20px;padding-right:20px}
}
</style>
</head>
<body>
<div class="app">

  {{-- ── Topbar ── --}}
  <header class="topbar">
    <div class="brand">
      <a href="{{ route('home') }}">
        <img src="{{ $logo }}" alt="{{ $siteName }}">
      </a>
    </div>
    <nav class="stepper" aria-label="Progression">
      <div class="step active" id="step1-nav"><div class="num">1</div><span>Adresse</span></div>
      <div class="step-sep" id="sep1"></div>
      <div class="step" id="step2-nav"><div class="num">2</div><span>Analyse</span></div>
      <div class="step-sep" id="sep2"></div>
      <div class="step" id="step3-nav"><div class="num">3</div><span>Résultats</span></div>
      <div class="step-sep" id="sep3"></div>
      <div class="step" id="step4-nav"><div class="num">4</div><span>Devis</span></div>
    </nav>
    <a href="{{ route('home') }}" class="help-btn">
      Retour au site <span class="q">←</span>
    </a>
  </header>

  {{-- ── Grid ── --}}
  <div class="grid">

    {{-- ── LEFT: controls ── --}}
    <aside id="leftCol">

      {{-- Address card ── --}}
      <section class="card" id="cardAddr">
        <h2>Votre adresse</h2>
        <p class="lede">Saisissez votre adresse pour analyser le potentiel solaire de votre toiture.</p>

        {{-- Pill quand adresse validée --}}
        <div class="addr-pill" id="addrPill" style="display:none">
          <span class="check">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
          </span>
          <span id="addrPillText" class="truncate" style="max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"></span>
          <button class="change" id="changeAddrBtn">Modifier</button>
        </div>

        <div id="addrSearchWrap">
          <div class="addr-wrap">
            <span class="addr-icon">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </span>
            <input type="text" id="addressInput" class="addr-input" placeholder="Ex. : 12 Rue de la Paix, 75002 Paris" autocomplete="off">
          </div>
          <button class="btn btn-primary" id="analyzeBtn" disabled>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Analyser mon toit
          </button>
        </div>
      </section>

      {{-- Roof config (appears after API response) --}}
      <section class="card" id="cardRoof" style="display:none">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:4px">
          <h2 style="font-size:16px">Informations toiture</h2>
          <span style="background:var(--accent-soft);color:var(--accent-deep);padding:3px 10px;border-radius:999px;font-weight:700;font-size:11px;letter-spacing:.04em">SOLAIRE</span>
        </div>
        <p class="lede" style="margin-bottom:12px">Affinez les paramètres pour une estimation précise.</p>

        <div id="roofInfoRows"></div>

        <div class="field">
          <label for="orientSelect">Orientation principale</label>
          <div class="select">
            <select id="orientSelect">
              <option value="Sud" selected>Sud (optimal)</option>
              <option value="Sud-Est">Sud-Est</option>
              <option value="Sud-Ouest">Sud-Ouest</option>
              <option value="Est">Est</option>
              <option value="Ouest">Ouest</option>
              <option value="Nord">Nord (déconseillé)</option>
            </select>
          </div>
        </div>
        <div class="field">
          <label for="inclSelect">Inclinaison du toit</label>
          <div class="select">
            <select id="inclSelect">
              <option value="0">Plat (0°)</option>
              <option value="15">15°</option>
              <option value="30" selected>30° (optimal)</option>
              <option value="45">45°</option>
              <option value="60">60°</option>
            </select>
          </div>
        </div>
        <div class="field" style="margin-bottom:16px">
          <label for="ttypeSelect">Type de toiture</label>
          <div class="select">
            <select id="ttypeSelect">
              <option value="tuiles">Tuiles</option>
              <option value="ardoise">Ardoise</option>
              <option value="bac-acier">Bac acier</option>
              <option value="toit-plat">Toit plat</option>
              <option value="zinc">Zinc</option>
            </select>
          </div>
        </div>

        <button class="btn btn-yellow" id="quoteBtn">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
          Obtenir mon devis gratuit
        </button>
      </section>

    </aside>

    {{-- ── MAP CENTER ── --}}
    <section class="map-wrap" style="position:relative">
      <div id="mapDiv"></div>

      <div class="map-loading" id="mapLoading">
        <div class="spinner"></div>
        <p id="mapLoadingText">Chargement de la carte…</p>
      </div>

      <div class="map-info-bar" id="mapInfoBar">
        <div class="ico">i</div>
        <div id="mapInfoText">
          Saisissez votre adresse pour afficher votre toiture et analyser son potentiel solaire.
        </div>
      </div>
    </section>

    {{-- ── RIGHT: results ── --}}
    <aside>
      <p class="estim-header">Estimation de votre installation</p>

      {{-- Metrics --}}
      <div class="metric skeleton" id="metricPanels">
        <div class="ico">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
        </div>
        <div>
          <div class="lbl">Panneaux solaires</div>
          <div class="val" id="valPanels">— <small>panneaux</small></div>
        </div>
      </div>
      <div class="metric skeleton" id="metricKwc">
        <div class="ico">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
        </div>
        <div>
          <div class="lbl">Puissance installée</div>
          <div class="val" id="valKwc">— <small>kWc</small></div>
        </div>
      </div>
      <div class="metric skeleton" id="metricKwh">
        <div class="ico">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
        </div>
        <div>
          <div class="lbl">Production annuelle</div>
          <div class="val" id="valKwh">— <small>kWh/an</small></div>
        </div>
      </div>
      <div class="metric skeleton" id="metricSavings">
        <div class="ico">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div>
          <div class="lbl">Économies annuelles</div>
          <div class="val" id="valSavings">— <small>€/an</small></div>
        </div>
      </div>

      <div class="budget-card skeleton" id="budgetCard">
        <div class="lbl">Budget estimé TTC</div>
        <div class="budget-range" id="valBudget">— <small>€</small></div>
      </div>

      <div class="card chart-card" id="chartCard">
        <div class="lbl">Production mensuelle (kWh)</div>
        <div class="chart" id="monthChart">
          @for ($i = 0; $i < 12; $i++)
          <div class="bar" style="height:{{ rand(20,80) }}%;opacity:.25"></div>
          @endfor
        </div>
        <div class="month-row">
          <span>J</span><span>F</span><span>M</span><span>A</span><span>M</span><span>J</span>
          <span>J</span><span>A</span><span>S</span><span>O</span><span>N</span><span>D</span>
        </div>
      </div>

    </aside>
  </div>
</div>

{{-- ── Lead form modal ── --}}
<div class="modal-backdrop hidden" id="leadModal" role="dialog" aria-modal="true" aria-label="Demande de devis">
  <div class="modal-box">
    <div class="modal-head">
      <div>
        <h3>Votre devis gratuit</h3>
        <p>Nos experts vous recontactent sous 24 h pour affiner votre projet solaire.</p>
      </div>
      <button class="modal-close" id="modalClose" aria-label="Fermer">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>

    {{-- Result summary in modal --}}
    <div class="modal-summary" id="modalSummary"></div>

    <div class="modal-body" id="modalBody">
      <div class="form-row">
        <div class="form-field">
          <label for="fPrenom">Prénom *</label>
          <input type="text" id="fPrenom" placeholder="Jean" autocomplete="given-name">
        </div>
        <div class="form-field">
          <label for="fNom">Nom *</label>
          <input type="text" id="fNom" placeholder="Dupont" autocomplete="family-name">
        </div>
      </div>
      <div class="form-field">
        <label for="fTel">Téléphone *</label>
        <input type="tel" id="fTel" placeholder="06 12 34 56 78" autocomplete="tel">
      </div>
      <div class="form-field">
        <label for="fEmail">Email *</label>
        <input type="email" id="fEmail" placeholder="jean@exemple.fr" autocomplete="email">
      </div>
      <div class="form-field">
        <label for="fAdresse">Adresse du projet *</label>
        <input type="text" id="fAdresse" placeholder="12 Rue des Fleurs, 35000 Rennes" autocomplete="street-address">
      </div>

      <div class="form-field" style="margin-bottom:8px">
        <label>Type de projet *</label>
      </div>
      <div class="project-type-grid" id="projectTypeGrid">
        <button class="project-type-btn active" data-type="autoconsommation">
          <span class="ptb-icon">⚡</span>
          <span class="ptb-label">Autoconsommation</span>
        </button>
        <button class="project-type-btn" data-type="revente">
          <span class="ptb-icon">↗️</span>
          <span class="ptb-label">Revente totale</span>
        </button>
        <button class="project-type-btn" data-type="batterie">
          <span class="ptb-icon">🔋</span>
          <span class="ptb-label">Avec batterie</span>
        </button>
        <button class="project-type-btn" data-type="je-ne-sais-pas">
          <span class="ptb-icon">🤔</span>
          <span class="ptb-label">Je ne sais pas</span>
        </button>
      </div>

      <button class="submit-btn" id="submitLeadBtn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
        Envoyer ma demande de devis
      </button>
      <p class="submit-note">🔒 Vos données sont confidentielles et ne seront jamais revendues.</p>
    </div>

    {{-- Success view (hidden initially) --}}
    <div class="modal-success hidden" id="modalSuccess">
      <div class="ms-check">✅</div>
      <h4>Demande envoyée !</h4>
      <p>Merci <strong id="successName"></strong> ! Nos experts vous contacteront dans les <strong>24 heures</strong> pour personnaliser votre devis solaire.</p>
      <button class="btn btn-outline" style="width:auto;margin:20px auto 0;padding:10px 24px;border-radius:10px" id="closeSuccessBtn">Fermer</button>
    </div>
  </div>
</div>

<div class="toast" id="toast">
  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
  <span id="toastMsg"></span>
</div>

{{-- ── Google Maps API ── --}}
<script>
window.__mapsKey = @json($mapsKey);
window.__csrfToken = @json(csrf_token());
window.__estimateUrl = @json(route('api.solar.estimate'));
window.__leadUrl = @json(route('api.solar.lead'));
</script>
<script>
(function(){
'use strict';

// ── State ──────────────────────────────────────────────────────────
const state = {
  lat: null, lng: null,
  address: '',
  results: null,
  currentStep: 1,
};

// ── DOM refs ────────────────────────────────────────────────────────
const $ = id => document.getElementById(id);
const addressInput = $('addressInput');
const analyzeBtn   = $('analyzeBtn');
const addrPill     = $('addrPill');
const addrPillText = $('addrPillText');
const changeAddrBtn= $('changeAddrBtn');
const addrSearchWrap = $('addrSearchWrap');
const cardRoof     = $('cardRoof');
const mapLoading   = $('mapLoading');
const mapLoadingText = $('mapLoadingText');
const mapInfoText  = $('mapInfoText');
const roofInfoRows = $('roofInfoRows');
const quoteBtn     = $('quoteBtn');
const leadModal    = $('leadModal');
const modalClose   = $('modalClose');
const modalBody    = $('modalBody');
const modalSuccess = $('modalSuccess');
const modalSummary = $('modalSummary');
const submitLeadBtn= $('submitLeadBtn');
const fPrenom = $('fPrenom'), fNom = $('fNom'), fTel = $('fTel'),
      fEmail = $('fEmail'), fAdresse = $('fAdresse');
const successName  = $('successName');

let projectType = 'autoconsommation';
let map, marker, autocomplete;

// ── Stepper ─────────────────────────────────────────────────────────
function setStep(n){
  state.currentStep = n;
  [1,2,3,4].forEach(i => {
    const s = $('step'+i+'-nav');
    s.className = 'step' + (i < n ? ' done' : i === n ? ' active' : '');
    if(i < n) s.querySelector('.num').innerHTML = '✓';
    else s.querySelector('.num').textContent = i;
    if(i < 4){
      const sep = $('sep'+i);
      sep.className = 'step-sep' + (i < n ? ' done' : '');
    }
  });
}

// ── Toast ────────────────────────────────────────────────────────────
function showToast(msg, isError = false){
  const t = $('toast');
  $('toastMsg').textContent = msg;
  t.className = 'toast' + (isError ? ' error-toast' : '');
  void t.offsetWidth;
  t.classList.add('show');
  clearTimeout(showToast._t);
  showToast._t = setTimeout(() => t.classList.remove('show'), 3000);
}

// ── Number formatting ─────────────────────────────────────────────
const fmt = n => Math.round(n).toLocaleString('fr-FR');

// ── Update metrics in right panel ────────────────────────────────
function displayResults(r){
  ['metricPanels','metricKwc','metricKwh','metricSavings','budgetCard'].forEach(id => {
    const el = $(id);
    if(el) el.classList.remove('skeleton');
  });

  $('valPanels').innerHTML = `${fmt(r.panelCount)} <small>panneaux</small>`;
  $('valKwc').innerHTML    = `${r.kwc.toLocaleString('fr-FR',{minimumFractionDigits:2,maximumFractionDigits:2})} <small>kWc</small>`;
  $('valKwh').innerHTML    = `${fmt(r.yearlyKwh)} <small>kWh/an</small>`;
  $('valSavings').innerHTML= `${fmt(r.annualSavings)} <small>€/an</small>`;
  $('valBudget').innerHTML = `${fmt(r.budgetMin)}&nbsp;€ – ${fmt(r.budgetMax)}&nbsp;<small>€ TTC</small>`;

  drawChart(r.monthlyKwh);

  if(r.roofSegments && r.roofSegments.length){
    const seg = r.roofSegments[0];
    const azimuthToLabel = az => {
      if(az >= 337.5 || az < 22.5) return 'Nord';
      if(az < 67.5) return 'Nord-Est'; if(az < 112.5) return 'Est';
      if(az < 157.5) return 'Sud-Est'; if(az < 202.5) return 'Sud';
      if(az < 247.5) return 'Sud-Ouest'; if(az < 292.5) return 'Ouest';
      return 'Nord-Ouest';
    };
    roofInfoRows.innerHTML = `
      <div class="roof-info-row">
        <div class="ri-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 11 12 2 21 11"/><path d="M3 11v10h5v-7h8v7h5V11"/></svg></div>
        <div><div class="ri-label">Surface utilisable</div><div class="ri-val">${fmt(r.areaM2)} m²</div></div>
      </div>
      <div class="roof-info-row">
        <div class="ri-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
        <div><div class="ri-label">Orientation détectée</div><div class="ri-val">${azimuthToLabel(seg.azimuthDeg)} (${seg.azimuthDeg}°)</div></div>
      </div>
      <div class="roof-info-row">
        <div class="ri-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M2 12h20"/></svg></div>
        <div><div class="ri-label">Inclinaison détectée</div><div class="ri-val">${seg.pitchDeg}°</div></div>
      </div>`;
  }
}

// ── Monthly chart ─────────────────────────────────────────────────
function drawChart(monthly){
  const max = Math.max(...monthly);
  const months = ['Janv','Févr','Mars','Avr','Mai','Juin','Juil','Août','Sept','Oct','Nov','Déc'];
  $('monthChart').innerHTML = monthly.map((v,i) => {
    let cls = 'bar';
    if(i >= 5 && i <= 7) cls += ' summer';
    else if((i >= 3 && i <= 4)||(i >= 8 && i <= 9)) cls += ' shoulder';
    const h = max > 0 ? Math.max(4, (v/max)*100) : 6;
    return `<div class="${cls}" style="height:${h}%" title="${months[i]} — ${fmt(v)} kWh"></div>`;
  }).join('');
}

// ── Call Solar API (backend) ───────────────────────────────────────
async function fetchSolarData(){
  mapLoading.classList.remove('hidden');
  mapLoadingText.textContent = 'Analyse du potentiel solaire…';
  setStep(2);

  try {
    const resp = await fetch(window.__estimateUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': window.__csrfToken,
        'Accept': 'application/json',
      },
      body: JSON.stringify({ lat: state.lat, lng: state.lng }),
    });

    const data = await resp.json();

    if(!resp.ok || data.error){
      throw new Error(data.error || 'Erreur serveur');
    }

    state.results = data;
    displayResults(data);
    cardRoof.style.display = 'block';
    mapInfoText.innerHTML = `<b>Analyse complète !</b> ${fmt(data.panelCount)} panneaux potentiels · ${fmt(data.areaM2)} m² de surface exploitable.`;
    setStep(3);
    showToast('Analyse solaire complète ✓');
    fAdresse.value = state.address;

  } catch(e){
    mapInfoText.innerHTML = `<b>Données non disponibles</b> pour cette adresse. Essayez une adresse voisine ou contactez-nous directement.`;
    showToast(e.message || 'Erreur lors de l\'analyse', true);
    setStep(1);
  } finally {
    mapLoading.classList.add('hidden');
  }
}

// ── Address selection ─────────────────────────────────────────────
function onAddressSelected(place){
  if(!place || !place.geometry) return;
  const loc = place.geometry.location;
  state.lat  = loc.lat();
  state.lng  = loc.lng();
  state.address = place.formatted_address || addressInput.value;

  // Show pill
  addrPillText.textContent = state.address;
  addrPill.style.display = 'flex';
  addrSearchWrap.style.display = 'none';

  // Move map
  map.setCenter({lat: state.lat, lng: state.lng});
  map.setZoom(19);
  if(marker) marker.setPosition({lat: state.lat, lng: state.lng});

  fetchSolarData();
}

// ── Init Google Maps ─────────────────────────────────────────────
function initMap(){
  map = new google.maps.Map($('mapDiv'), {
    center: {lat: 46.603354, lng: 1.888334},
    zoom: 5,
    mapTypeId: 'satellite',
    tilt: 0,
    disableDefaultUI: true,
    zoomControl: true,
    zoomControlOptions: {position: google.maps.ControlPosition.RIGHT_CENTER},
    scaleControl: false,
    streetViewControl: false,
    fullscreenControl: false,
    mapTypeControl: false,
  });

  marker = new google.maps.Marker({
    map,
    icon: {
      path: google.maps.SymbolPath.CIRCLE,
      scale: 10,
      fillColor: '#13a6e8',
      fillOpacity: 1,
      strokeColor: '#fff',
      strokeWeight: 3,
    },
    visible: false,
  });

  // Layer switch
  document.querySelector('.layer-switch [data-type="satellite"]').addEventListener('click', () => {
    map.setMapTypeId('satellite');
    document.querySelectorAll('.layer-switch button').forEach(b => b.classList.toggle('active', b.dataset.type === 'satellite'));
  });
  document.querySelector('.layer-switch [data-type="roadmap"]').addEventListener('click', () => {
    map.setMapTypeId('roadmap');
    document.querySelectorAll('.layer-switch button').forEach(b => b.classList.toggle('active', b.dataset.type === 'roadmap'));
  });

  // Places Autocomplete on left panel input
  autocomplete = new google.maps.places.Autocomplete(addressInput, {
    componentRestrictions: {country: 'fr'},
    fields: ['geometry', 'formatted_address', 'address_components'],
  });
  autocomplete.addListener('place_changed', () => {
    const place = autocomplete.getPlace();
    analyzeBtn.disabled = !place?.geometry;
    onAddressSelected(place);
  });

  addressInput.addEventListener('input', () => {
    analyzeBtn.disabled = addressInput.value.trim().length < 5;
  });

  analyzeBtn.addEventListener('click', () => {
    const place = autocomplete.getPlace();
    if(place?.geometry){
      onAddressSelected(place);
    } else {
      // Trigger geocode manually
      geocodeAddress(addressInput.value);
    }
  });

  mapLoading.classList.add('hidden');
}

// ── Manual geocode fallback ───────────────────────────────────────
function geocodeAddress(addr){
  const geocoder = new google.maps.Geocoder();
  geocoder.geocode({address: addr, region: 'fr'}, (results, status) => {
    if(status === 'OK' && results[0]){
      const place = results[0];
      state.lat  = place.geometry.location.lat();
      state.lng  = place.geometry.location.lng();
      state.address = place.formatted_address;
      addrPillText.textContent = state.address;
      addrPill.style.display = 'flex';
      addrSearchWrap.style.display = 'none';
      map.setCenter({lat: state.lat, lng: state.lng});
      map.setZoom(19);
      if(marker){ marker.setPosition({lat: state.lat, lng: state.lng}); marker.setVisible(true); }
      fetchSolarData();
    } else {
      showToast('Adresse introuvable. Essayez d\'être plus précis.', true);
    }
  });
}

// ── Change address ────────────────────────────────────────────────
changeAddrBtn.addEventListener('click', () => {
  addrPill.style.display = 'none';
  addrSearchWrap.style.display = 'block';
  addressInput.value = '';
  addressInput.focus();
  analyzeBtn.disabled = true;
  cardRoof.style.display = 'none';
  setStep(1);
});

// ── Lead modal ────────────────────────────────────────────────────
quoteBtn.addEventListener('click', openModal);
modalClose.addEventListener('click', closeModal);
leadModal.addEventListener('click', e => { if(e.target === leadModal) closeModal(); });

function openModal(){
  if(!state.results){ showToast('Veuillez d\'abord analyser votre adresse', true); return; }

  // Populate summary
  const r = state.results;
  modalSummary.innerHTML = `
    <div class="ms-item"><div class="ms-val">${r.panelCount}</div><div class="ms-lbl">panneaux</div></div>
    <div class="ms-item"><div class="ms-val">${r.kwc}</div><div class="ms-lbl">kWc</div></div>
    <div class="ms-item"><div class="ms-val">${fmt(r.yearlyKwh)}</div><div class="ms-lbl">kWh/an</div></div>
    <div class="ms-item"><div class="ms-val">${fmt(r.annualSavings)} €</div><div class="ms-lbl">éco/an</div></div>
  `;

  fAdresse.value = state.address;
  modalSuccess.classList.add('hidden');
  modalBody.style.display = 'block';
  leadModal.classList.remove('hidden');
  document.body.style.overflow = 'hidden';
  setStep(4);
}

function closeModal(){
  leadModal.classList.add('hidden');
  document.body.style.overflow = '';
}

$('closeSuccessBtn').addEventListener('click', closeModal);

// ── Project type selection ────────────────────────────────────────
document.querySelectorAll('#projectTypeGrid .project-type-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('#projectTypeGrid .project-type-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    projectType = btn.dataset.type;
  });
});

// ── Submit lead ───────────────────────────────────────────────────
submitLeadBtn.addEventListener('click', async () => {
  // Validate
  let valid = true;
  [fPrenom, fNom, fTel, fEmail, fAdresse].forEach(el => {
    el.classList.remove('error');
    if(!el.value.trim()){ el.classList.add('error'); valid = false; }
  });
  if(!valid){ showToast('Remplissez tous les champs obligatoires', true); return; }
  if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(fEmail.value)){ fEmail.classList.add('error'); showToast('Email invalide', true); return; }

  submitLeadBtn.disabled = true;
  submitLeadBtn.innerHTML = '<div class="spinner" style="width:18px;height:18px;border-width:3px;margin:0"></div> Envoi…';

  const r = state.results || {};

  try {
    const resp = await fetch(window.__leadUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': window.__csrfToken,
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        prenom: fPrenom.value.trim(),
        nom: fNom.value.trim(),
        telephone: fTel.value.trim(),
        email: fEmail.value.trim(),
        adresse: fAdresse.value.trim(),
        type_projet: projectType,
        kwc: r.kwc,
        budget_min: r.budgetMin,
        budget_max: r.budgetMax,
        yearly_kwh: r.yearlyKwh,
        panel_count: r.panelCount,
        annual_savings: r.annualSavings,
      }),
    });

    const data = await resp.json();
    if(!resp.ok) throw new Error(data.message || 'Erreur serveur');

    successName.textContent = fPrenom.value.trim();
    modalBody.style.display = 'none';
    modalSuccess.classList.remove('hidden');
    showToast('Demande envoyée ! Nous vous contactons sous 24 h ✓');
  } catch(e){
    showToast(e.message || 'Erreur lors de l\'envoi', true);
  } finally {
    submitLeadBtn.disabled = false;
    submitLeadBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg> Envoyer ma demande de devis';
  }
});

// ── Load Google Maps ──────────────────────────────────────────────
window.initMapCallback = initMap;
const mapsScript = document.createElement('script');
mapsScript.src = `https://maps.googleapis.com/maps/api/js?key=${window.__mapsKey}&libraries=places&callback=initMapCallback&loading=async&language=fr&region=FR`;
mapsScript.async = true;
mapsScript.defer = true;
document.head.appendChild(mapsScript);

})();
</script>

{{-- Layer switch buttons inside map (injected after map container) --}}
<script>
// Insert layer switch and map info bar controls after DOM ready
document.addEventListener('DOMContentLoaded', function(){
  const mapWrap = document.querySelector('.map-wrap');

  // Layer switch
  const ls = document.createElement('div');
  ls.className = 'layer-switch';
  ls.innerHTML = `
    <button data-type="satellite" class="active">Satellite</button>
    <button data-type="roadmap">Plan</button>
  `;
  mapWrap.appendChild(ls);
});
</script>
</body>
</html>
