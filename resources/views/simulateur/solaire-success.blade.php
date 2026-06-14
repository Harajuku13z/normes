@php
    use App\Support\HomeView;
    $h = $home ?? [];
    $logo = HomeView::url((string) data_get($h, 'header.logo', '/logo.png'));
    $siteName = (string) data_get($h, 'meta.site_name', 'Normes Renovation');
    $backUrl = route('simulateur.photovoltaique.confirmation');
    $restartUrl = route('simulateur.photovoltaique');
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Votre résultat solaire - {{ $siteName }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{
  --ink:#0f2231;
  --ink-soft:#5a6b78;
  --muted:#8aa3bb;
  --line:#d6e4f1;
  --card:#ffffff;
  --bg:#f4f6f8;
  --blue:#13a6e8;
  --blue-soft:#eaf6fe;
  --navy:#0f2231;
  --ok:#46b461;
  --ok-soft:#eef9f1;
  --shadow:0 4px 12px rgba(15,34,49,.06),0 24px 48px rgba(15,34,49,.10);
}
*{box-sizing:border-box}
html,body{
  margin:0;
  min-height:100vh;
  font-family:'Inter',system-ui,-apple-system,Segoe UI,sans-serif;
  color:var(--ink);
  background:
    linear-gradient(180deg,var(--blue) 0 240px,#fff 240px 100%),
    var(--bg);
}
body{padding:24px 12px 40px}
.shell{max-width:480px;margin:0 auto}
.header{
  display:flex;align-items:center;justify-content:center;gap:18px;flex-wrap:wrap;
  color:#fff;margin-bottom:16px;padding-top:2px;
}
.brand{display:none}
.brand img{height:42px;width:auto;display:block}
.steps{display:flex;align-items:flex-start;justify-content:center;gap:22px;width:100%}
.step{display:flex;flex-direction:column;align-items:center;gap:8px;color:rgba(255,255,255,.56);min-width:90px}
.step .num{
  width:36px;height:36px;border-radius:50%;border:2px solid rgba(255,255,255,.42);
  display:grid;place-items:center;font-size:18px;font-weight:700;
}
.step div:last-child{font-size:11px;line-height:1.2;text-align:center}
.step.active{color:#fff}
.step.active .num{background:#fff;color:#101010;border-color:#fff}
.page-card{
  background:var(--card);border-radius:26px;padding:16px 12px 26px;box-shadow:var(--shadow);border:1px solid #e6ebef;
}
.eyebrow{display:none}
h1{
  margin:0 0 8px;
  font-family:'Anton','Arial Narrow',sans-serif;
  font-size:26px;
  line-height:1.12;
  letter-spacing:-.02em;
  color:var(--blue);
  text-align:center;
  text-transform:uppercase;
}
.lede{
  margin:0 auto;
  color:var(--ink-soft);
  font-size:13px;
  line-height:1.5;
  text-align:center;
  max-width:310px;
}
.address{
  margin:10px auto 0;
  padding:10px 12px;
  border-radius:14px;
  background:#f8fbff;
  border:1px solid var(--line);
  font-size:12px;
  color:var(--ink-soft);
  text-align:center;
  max-width:360px;
}
.report-block{
  margin-top:14px;
  padding:16px 12px;
  border-radius:18px;
  border:1px solid var(--line);
  background:#fff;
}
.report-block h2{
  margin:0 0 12px;
  text-align:center;
  font-size:17px;
  line-height:1.25;
  color:var(--ink);
}
.metrics-two{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:10px;
}
.mini-stat{
  padding:14px 10px;
  border-radius:16px;
  background:#f8fbff;
  border:1px solid var(--line);
  text-align:center;
}
.mini-stat .label{
  font-size:10px;
  line-height:1.3;
  letter-spacing:.06em;
  text-transform:uppercase;
  color:var(--muted);
  font-weight:800;
}
.mini-stat .value{
  display:block;
  margin-top:8px;
  font-size:28px;
  font-weight:800;
  color:var(--navy);
  letter-spacing:-.03em;
}
.mini-stat .sub{
  margin-top:6px;
  font-size:11px;
  line-height:1.45;
  color:var(--ink-soft);
}
.hero-metric{
  margin-top:10px;
  padding:14px 14px 16px;
  border-radius:18px;
  background:linear-gradient(180deg,#fbfdff 0%,#eef7fd 100%);
  border:1px solid var(--line);
  text-align:center;
}
.hero-metric span{
  display:block;
  font-size:12px;
  color:var(--ink-soft);
}
.hero-metric strong{
  display:block;
  margin-top:8px;
  font-size:36px;
  font-weight:800;
  letter-spacing:-.04em;
  color:var(--navy);
}
.hero-metric small{
  display:block;
  margin-top:8px;
  font-size:11px;
  line-height:1.45;
  color:var(--ink-soft);
}
.offer-pills{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:8px;
  margin-top:12px;
}
.offer-pill{
  border:1px solid var(--line);
  background:#f8fbff;
  border-radius:12px;
  padding:8px 6px;
  text-align:center;
  font-size:10px;
  color:var(--ink-soft);
  font-weight:700;
}
.offer-pill.active{
  background:var(--navy);
  border-color:var(--navy);
  color:#fff;
}
.implantation-card{
  margin-top:12px;
  padding:14px 12px 16px;
  border-radius:18px;
  background:#fbfdff;
  border:1px solid var(--line);
}
.implantation-card h3{
  margin:0 0 10px;
  text-align:center;
  font-size:15px;
  color:var(--ink);
}
.implantation-map{
  position:relative;
  border-radius:18px;
  overflow:hidden;
  border:1px solid var(--line);
  background:linear-gradient(180deg,#eef7fe 0%,#e4f1fb 100%);
  min-height:220px;
}
.implantation-map svg{
  display:block;
  width:100%;
  height:auto;
}
.implantation-badge{
  position:absolute;
  left:10px;
  top:10px;
  padding:6px 10px;
  border-radius:999px;
  background:#fff;
  border:1px solid var(--line);
  color:var(--blue);
  font-size:11px;
  font-weight:800;
  letter-spacing:.05em;
  text-transform:uppercase;
}
.implantation-grid{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:10px;
  margin-top:12px;
}
.implantation-chip{
  padding:12px 10px;
  border-radius:14px;
  background:#fff;
  border:1px solid var(--line);
  text-align:center;
}
.implantation-chip strong{
  display:block;
  font-size:11px;
  color:var(--muted);
  letter-spacing:.05em;
  text-transform:uppercase;
}
.implantation-chip span{
  display:block;
  margin-top:7px;
  font-size:22px;
  font-weight:800;
  color:var(--navy);
}
.adjust-wrap{
  margin-top:14px;
  padding:14px 12px;
  border-radius:16px;
  background:#fff;
  border:1px solid var(--line);
}
.adjust-wrap h3{
  margin:0 0 8px;
  text-align:center;
  font-size:15px;
  color:var(--ink);
}
.adjust-wrap p{
  margin:0 0 12px;
  text-align:center;
  font-size:12px;
  line-height:1.5;
  color:var(--ink-soft);
}
.adjust-counter{
  display:grid;
  grid-template-columns:50px 1fr 50px;
  gap:8px;
  align-items:center;
}
.adjust-btn{
  min-height:50px;
  border-radius:14px;
  border:1.5px solid var(--line);
  background:#fff;
  color:var(--ink);
  font:800 24px/1 'Inter',sans-serif;
  cursor:pointer;
}
.adjust-btn:hover:not(:disabled){border-color:var(--blue);background:var(--blue-soft)}
.adjust-btn:disabled{opacity:.35;cursor:not-allowed}
.adjust-display{
  min-height:50px;
  border-radius:14px;
  background:var(--navy);
  color:#fff;
  display:flex;
  align-items:center;
  justify-content:center;
  gap:8px;
}
.adjust-display strong{font-size:24px;font-weight:800}
.adjust-display span{font-size:11px;text-transform:uppercase;letter-spacing:.07em;color:#b9c4ea}
.adjust-presets{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:8px;
  margin-top:12px;
}
.adjust-preset{
  min-height:42px;
  border-radius:12px;
  border:1.5px solid var(--line);
  background:#fff;
  color:var(--ink-soft);
  font:700 12px/1.2 'Inter',sans-serif;
  cursor:pointer;
}
.adjust-preset:hover:not(:disabled){border-color:var(--blue);background:var(--blue-soft);color:var(--blue)}
.adjust-preset.active{
  background:var(--navy);
  border-color:var(--navy);
  color:#fff;
}
.adjust-preset:disabled{opacity:.35;cursor:not-allowed}
.adjust-note{
  margin-top:10px;
  text-align:center;
  font-size:11px;
  line-height:1.45;
  color:var(--muted);
}
.section-illustration{
  margin-top:10px;
  padding:14px 12px;
  border-radius:18px;
  background:#fbfdff;
  border:1px solid var(--line);
  text-align:center;
}
.section-illustration svg{
  width:100%;
  max-width:210px;
  height:auto;
  display:block;
  margin:0 auto;
}
.section-illustration .stack-note{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:10px;
  margin-top:10px;
}
.stack-chip{
  padding:10px 8px;
  border-radius:14px;
  background:#fff;
  border:1px solid var(--line);
}
.stack-chip strong{
  display:block;
  font-size:11px;
  color:var(--muted);
  text-transform:uppercase;
  letter-spacing:.05em;
}
.stack-chip span{
  display:block;
  margin-top:6px;
  font-size:20px;
  font-weight:800;
  color:var(--navy);
}
.energy-card{
  margin-top:10px;
  padding:14px 12px;
  border-radius:16px;
  background:#f8fbff;
  border:1px solid var(--line);
  text-align:center;
}
.energy-card span{
  display:block;
  font-size:12px;
  line-height:1.5;
  color:var(--ink-soft);
}
.energy-card strong{
  display:block;
  margin-top:8px;
  font-size:30px;
  font-weight:800;
  color:#95bf23;
  letter-spacing:-.03em;
}
.energy-note{
  margin-top:10px;
  padding:12px;
  border-radius:15px;
  background:#f4f9e6;
  text-align:center;
  border:1px solid #ddeab8;
  color:var(--ink);
  font-size:12px;
  line-height:1.5;
}
.timeline-grid{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:8px;
  margin-top:12px;
}
.timeline-card{
  padding:12px 8px;
  border-radius:14px;
  background:#fbfdff;
  border:1px solid var(--line);
  text-align:center;
}
.timeline-card .k{
  display:block;
  font-size:10px;
  color:var(--muted);
  font-weight:700;
}
.timeline-card .v{
  display:block;
  margin-top:7px;
  font-size:20px;
  font-weight:800;
  color:#d4b000;
}
.reminder{
  margin-top:12px;
  padding:12px;
  border-radius:14px;
  background:#f4f9e6;
  border:1px solid #ddeab8;
  text-align:center;
  color:var(--ink-soft);
  font-size:12px;
  line-height:1.45;
}
.impact-grid{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:10px;
}
.impact-card{
  padding:14px 10px;
  border-radius:16px;
  background:#f8fbff;
  border:1px solid var(--line);
  text-align:center;
}
.impact-card strong{
  display:block;
  color:#94be24;
  font-size:22px;
  line-height:1.2;
  letter-spacing:-.03em;
}
.impact-card span{
  display:block;
  margin-top:6px;
  font-size:11px;
  line-height:1.45;
  color:var(--ink-soft);
}
.form-card{
  margin-top:14px;
  padding:16px 12px 18px;
  border-radius:18px;
  border:2px solid rgba(27,151,234,.34);
  background:#fff;
}
.form-card h2{
  margin:0 0 8px;
  text-align:center;
  font-size:18px;
  color:var(--ink);
}
.form-card .lede{
  font-size:12px;
  max-width:330px;
}
.row{
  display:grid;
  grid-template-columns:1fr;
  gap:0;
}
.field{margin-top:10px}
.field label{
  display:block;
  margin-bottom:6px;
  font-size:11px;
  font-weight:700;
  color:var(--muted);
  text-transform:uppercase;
  letter-spacing:.04em;
}
.field input{
  width:100%;
  min-height:48px;
  border-radius:12px;
  border:1.5px solid var(--line);
  padding:0 14px;
  font:500 14px 'Inter',sans-serif;
  color:var(--ink);
  outline:none;
  background:#fff;
}
.field input:focus{border-color:var(--blue);box-shadow:0 0 0 4px rgba(25,152,235,.12)}
.options{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:10px;
  margin-top:14px;
}
.option{
  border:1.5px solid var(--line);
  border-radius:14px;
  padding:14px 12px;
  cursor:pointer;
  transition:.15s ease;
  background:#fff;
}
.option-icon{
  width:44px;height:44px;border-radius:12px;
  display:grid;place-items:center;
  margin:0 auto 10px;
  background:#f2f8fd;
  color:var(--blue);
}
.option strong{display:block;font-size:13px;color:var(--ink);text-align:center}
.option span{display:block;margin-top:6px;font-size:11px;line-height:1.5;color:var(--ink-soft);text-align:center}
.option.active{
  border-color:var(--blue);
  background:var(--blue-soft);
}
.checkline{
  display:flex;align-items:flex-start;gap:10px;
  margin-top:14px;font-size:11px;line-height:1.55;color:var(--ink-soft);
}
.checkline input{margin-top:4px}
.submit{
  width:100%;
  min-height:56px;
  border:0;
  border-radius:14px;
  margin-top:16px;
  background:var(--blue);
  color:#fff;
  font:800 16px/1.2 'Inter',sans-serif;
  cursor:pointer;
  transition:.15s ease;
}
.submit:hover:not(:disabled){background:#1188d7;transform:translateY(-1px)}
.submit:disabled{opacity:.55;cursor:not-allowed}
.feedback{
  display:none;
  margin-top:12px;
  padding:12px 14px;
  border-radius:14px;
  font-size:12px;
  line-height:1.55;
}
.feedback.error{background:#fff1f1;border:1px solid #f1c1c1;color:#a12626}
.feedback.success{background:#eef9f1;border:1px solid #cae9d2;color:#216a34}
.footer-links{
  display:flex;justify-content:center;gap:14px;flex-wrap:wrap;
  margin-top:18px;font-size:11px;text-align:center;
}
.footer-links a{color:var(--ink-soft);text-decoration:none}
.footer-links a:hover{text-decoration:underline}
.missing{
  display:none;
  margin-top:12px;
  padding:14px 12px;
  border-radius:16px;
  background:#fff1f1;
  border:1px solid #f1c1c1;
  color:#a12626;
  font-size:12px;
  line-height:1.55;
}
@media (max-width: 420px){
  .step{min-width:84px}
  .step div:last-child{font-size:10px}
  .metrics-two,.impact-grid,.options,.timeline-grid,.offer-pills,.section-illustration .stack-note,.implantation-grid,.adjust-presets{grid-template-columns:1fr}
}
</style>
</head>
<body>
<div class="shell">
  <header class="header">
    <a class="brand" href="{{ route('home') }}" aria-label="{{ $siteName }}">
      <img src="{{ $logo }}" alt="{{ $siteName }}">
    </a>
    <div class="steps" aria-label="Progression du simulateur">
      <div class="step"><div class="num">1</div><div>Votre toiture</div></div>
      <div class="step"><div class="num">2</div><div>Votre consommation</div></div>
      <div class="step active"><div class="num">3</div><div>Votre résultat</div></div>
    </div>
  </header>

  <main class="page-card">
    <span class="eyebrow">Résultat de votre simulation</span>
    <h1>Résultats de votre simulation</h1>
    <p class="lede">Retrouvez votre potentiel solaire, vos économies estimées et recevez votre étude complète en quelques secondes.</p>
    <div class="address"><strong>Projet simulé :</strong> <span id="summaryAddress">Chargement…</span></div>
    <div class="missing" id="missingBox">Impossible de retrouver votre simulation complète. Revenez à l’étape précédente pour relancer le parcours et recalculer votre résultat.</div>

    <section class="report-block">
      <h2>Potentiel photovoltaïque de votre toiture</h2>
      <div class="metrics-two">
        <article class="mini-stat">
          <div class="label">Surface exploitable</div>
          <span class="value" id="surfaceValue">0 m²</span>
          <div class="sub">zone retenue pour votre installation</div>
        </article>
        <article class="mini-stat">
          <div class="label">Panneaux installables</div>
          <span class="value" id="panelsValue">0</span>
          <div class="sub">positionnés dans le meilleur sens</div>
        </article>
      </div>
      <article class="hero-metric">
        <span>Puissance installée</span>
        <strong id="kwcValue">0 kWc</strong>
        <small>Orientation <span id="orientationValue">Sud</span> · inclinaison <span id="pitchValue">30°</span></small>
      </article>
      <div class="offer-pills" aria-hidden="true">
        <div class="offer-pill active">Installation recommandée</div>
        <div class="offer-pill">Surface optimisée</div>
        <div class="offer-pill">Pose orientée</div>
      </div>

      <div class="implantation-card">
        <h3>Visualisez l’implantation de vos panneaux</h3>
        <div class="implantation-map">
          <div class="implantation-badge" id="implantationBadge">Toiture</div>
          <svg id="implantationSvg" viewBox="0 0 360 230" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"></svg>
        </div>
        <div class="implantation-grid">
          <div class="implantation-chip">
            <strong>Nombre de panneaux</strong>
            <span id="implantationPanels">0</span>
          </div>
          <div class="implantation-chip">
            <strong>Puissance installée</strong>
            <span id="implantationKwc">0 kWc</span>
          </div>
        </div>
        <div class="adjust-wrap">
          <h3>Ajustez votre installation</h3>
          <p>Modifiez le nombre de panneaux ou la puissance pour voir immédiatement l’impact sur votre projet.</p>
          <div class="adjust-counter">
            <button type="button" class="adjust-btn" id="panelMinusBtn">−</button>
            <div class="adjust-display"><strong id="panelAdjustValue">0</strong><span>panneaux</span></div>
            <button type="button" class="adjust-btn" id="panelPlusBtn">+</button>
          </div>
          <div class="adjust-presets" id="panelPresetRow">
            <button type="button" class="adjust-preset" data-kwc="3">3 kWc</button>
            <button type="button" class="adjust-preset" data-kwc="4">4 kWc</button>
            <button type="button" class="adjust-preset" data-kwc="6">6 kWc</button>
            <button type="button" class="adjust-preset" data-kwc="9">9 kWc</button>
          </div>
          <div class="adjust-note" id="adjustNote">Le rendu s’adapte à votre zone sélectionnée, y compris pour une installation au sol dans le jardin.</div>
        </div>
      </div>
    </section>

    <section class="report-block">
      <h2>Vos économies</h2>
      <div class="section-illustration">
        <svg viewBox="0 0 220 150" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <rect x="44" y="70" width="96" height="54" rx="8" fill="#fff" stroke="#d6e4f1" stroke-width="3"/>
          <path d="M36 76L94 34L152 76" fill="none" stroke="#1b97ea" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M78 48H124L142 78H60L78 48Z" fill="#eaf6fe" stroke="#1b97ea" stroke-width="4" stroke-linejoin="round"/>
          <path d="M88 58H112" stroke="#1b97ea" stroke-width="3"/>
          <path d="M84 66H116" stroke="#1b97ea" stroke-width="3"/>
          <circle cx="176" cy="48" r="16" fill="#f4f9e6" stroke="#ddeab8" stroke-width="3"/>
          <path d="M176 38V58" stroke="#95bf23" stroke-width="4" stroke-linecap="round"/>
          <path d="M166 48H186" stroke="#95bf23" stroke-width="4" stroke-linecap="round"/>
          <circle cx="34" cy="116" r="14" fill="#f4f9e6" stroke="#ddeab8" stroke-width="3"/>
          <path d="M34 108V124" stroke="#95bf23" stroke-width="4" stroke-linecap="round"/>
          <path d="M26 116H42" stroke="#95bf23" stroke-width="4" stroke-linecap="round"/>
        </svg>
        <div class="stack-note">
          <div class="stack-chip">
            <strong>Coût de l'installation</strong>
            <span id="budgetValue">0 €</span>
          </div>
          <div class="stack-chip">
            <strong>Amortissement</strong>
            <span id="paybackValue">0 an</span>
          </div>
        </div>
      </div>
      <div class="energy-card">
        <span>Votre production annuelle d’électricité photovoltaïque</span>
        <strong id="productionValue">0 kWh</strong>
      </div>
      <div class="energy-card">
        <span>Économies annuelles estimées sur votre facture</span>
        <strong id="annualSavingsValue">0 €</strong>
      </div>
      <div class="energy-note">
        Nous estimons votre part d’autoconsommation à <strong id="selfShareValue">0 %</strong><br>
        soit environ <strong id="autoconsumedValue">0 kWh</strong> consommés sur place chaque année.
      </div>
    </section>

    <section class="report-block">
      <h2>Économies cumulées</h2>
      <div class="timeline-grid">
        <div class="timeline-card">
          <span class="k">Sur 10 ans</span>
          <span class="v" id="savings10Value">0 €</span>
        </div>
        <div class="timeline-card">
          <span class="k">Sur 20 ans</span>
          <span class="v" id="savings20Value">0 €</span>
        </div>
        <div class="timeline-card">
          <span class="k">Sur 30 ans</span>
          <span class="v" id="savings30Value">0 €</span>
        </div>
      </div>
      <div class="reminder">
        Sur un rythme de production annuel estimé à <strong id="injectedValue">0 kWh</strong> injectés ou valorisés, votre installation continue à créer de la valeur sur la durée.
      </div>
    </section>

    <section class="report-block">
      <h2>Votre impact sur l’environnement</h2>
      <div class="impact-grid">
        <article class="impact-card">
          <strong id="co2Value">0 kg de CO2 évités / an</strong>
          <span>équivalent aux émissions évitées grâce à votre production photovoltaïque</span>
        </article>
        <article class="impact-card">
          <strong><span id="treesValue">0</span> arbres / an</strong>
          <span>équivalent en plantations favorisées chaque année</span>
        </article>
      </div>
      <div class="section-illustration">
        <svg viewBox="0 0 220 150" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <circle cx="170" cy="34" r="16" fill="#f4f9e6"/>
          <path d="M170 16V8M182 20l7-7M188 34h10M182 48l7 7M170 52v10M158 48l-7 7M152 34h-10M158 20l-7-7" stroke="#95bf23" stroke-width="3" stroke-linecap="round"/>
          <rect x="44" y="76" width="98" height="48" rx="8" fill="#fff" stroke="#d6e4f1" stroke-width="3"/>
          <path d="M36 82L94 42L152 82" fill="none" stroke="#1b97ea" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M76 56H126L142 82H58L76 56Z" fill="#eaf6fe" stroke="#1b97ea" stroke-width="4" stroke-linejoin="round"/>
          <circle cx="170" cy="110" r="16" fill="#dff3e4"/>
          <path d="M170 96c8 0 14 6 14 14s-6 14-14 14-14-6-14-14 6-14 14-14Z" fill="#7fd38f"/>
          <path d="M170 106v20" stroke="#3c8b4d" stroke-width="4" stroke-linecap="round"/>
        </svg>
      </div>
    </section>

    <section class="form-card">
      <h2>Recevez votre étude complète</h2>
      <p class="lede">Renseignez vos coordonnées pour recevoir le récapitulatif de votre simulation et être recontacté rapidement.</p>

      <div class="row">
        <div class="field">
          <label for="nom">Nom *</label>
          <input id="nom" type="text" autocomplete="family-name">
        </div>
        <div class="field">
          <label for="prenom">Prénom *</label>
          <input id="prenom" type="text" autocomplete="given-name">
        </div>
      </div>
      <div class="row">
        <div class="field">
          <label for="email">Adresse mail *</label>
          <input id="email" type="email" autocomplete="email">
        </div>
        <div class="field">
          <label for="telephone">Téléphone *</label>
          <input id="telephone" type="tel" autocomplete="tel">
        </div>
      </div>

      <div class="options" id="projectOptions">
        <button type="button" class="option" data-option="battery">
          <span class="option-icon" aria-hidden="true">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="7" width="14" height="10" rx="2"/><path d="M18 10h2v4h-2"/><path d="M8 11h4"/><path d="M10 9v4"/></svg>
          </span>
          <strong>Batterie de stockage</strong>
          <span>Ajouter du stockage pour consommer davantage votre production solaire.</span>
        </button>
        <button type="button" class="option" data-option="charger">
          <span class="option-icon" aria-hidden="true">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 7h6a2 2 0 0 1 2 2v8H7V9a2 2 0 0 1 2-2Z"/><path d="M9 17v2a3 3 0 0 0 6 0v-2"/><path d="M10 10v4"/><path d="M14 10v4"/></svg>
          </span>
          <strong>Borne de recharge</strong>
          <span>Prévoir une borne pour alimenter votre véhicule électrique à domicile.</span>
        </button>
      </div>

      <label class="checkline">
        <input type="checkbox" id="consent">
        <span>J’accepte que mes informations soient utilisées pour recevoir mon étude complète et être recontacté au sujet de mon projet photovoltaïque.</span>
      </label>

      <button type="button" class="submit" id="submitBtn">Recevoir l'étude complète de votre projet</button>
      <div class="feedback error" id="errorBox"></div>
      <div class="feedback success" id="successBox"></div>

      <div class="footer-links">
        <a href="{{ $backUrl }}">&lt; Revenir à l'étape précédente</a>
        <a href="{{ $restartUrl }}">Refaire la simulation</a>
      </div>
    </section>
  </main>
</div>

<script>
window.__solarStep4StorageKey = 'solarSimulatorStep4';
window.__leadUrl = @json(route('api.solar.lead'));
window.__csrfToken = @json(csrf_token());

(function(){
  const storageKey = window.__solarStep4StorageKey;
  const missingBox = document.getElementById('missingBox');
  const summaryAddress = document.getElementById('summaryAddress');
  const submitBtn = document.getElementById('submitBtn');
  const errorBox = document.getElementById('errorBox');
  const successBox = document.getElementById('successBox');
  const projectOptions = document.getElementById('projectOptions');
  const implantationSvg = document.getElementById('implantationSvg');
  const implantationBadge = document.getElementById('implantationBadge');
  const panelMinusBtn = document.getElementById('panelMinusBtn');
  const panelPlusBtn = document.getElementById('panelPlusBtn');
  const panelAdjustValue = document.getElementById('panelAdjustValue');
  const panelPresetRow = document.getElementById('panelPresetRow');
  const adjustNote = document.getElementById('adjustNote');
  const PANEL_POWER_KWC = 0.425;

  function formatInt(value){
    return new Intl.NumberFormat('fr-FR', { maximumFractionDigits: 0 }).format(Number(value || 0));
  }

  function formatMoney(value){
    return `${formatInt(value)} €`;
  }

  function formatDecimal(value, suffix = ''){
    return `${new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(Number(value || 0))}${suffix}`;
  }

  function clamp(value, min, max){
    return Math.min(max, Math.max(min, value));
  }

  function loadSimulation(){
    try {
      const raw = window.sessionStorage.getItem(storageKey);
      return raw ? JSON.parse(raw) : null;
    } catch (_error) {
      return null;
    }
  }

  function showError(message){
    errorBox.textContent = message;
    errorBox.style.display = 'block';
    successBox.style.display = 'none';
  }

  function showSuccess(message){
    successBox.textContent = message;
    successBox.style.display = 'block';
    errorBox.style.display = 'none';
  }

  function setStat(id, value){
    const el = document.getElementById(id);
    if(el) el.textContent = value;
  }

  function panelCountFromKwc(value){
    return Math.max(1, Math.round((Number(value) || 0) / PANEL_POWER_KWC));
  }

  function getBounds(points){
    const xs = points.map(point => point.x);
    const ys = points.map(point => point.y);
    return {
      minX: Math.min(...xs),
      maxX: Math.max(...xs),
      minY: Math.min(...ys),
      maxY: Math.max(...ys),
    };
  }

  function cloneSnapshot(snapshot){
    try {
      return snapshot ? JSON.parse(JSON.stringify(snapshot)) : null;
    } catch (_error) {
      return null;
    }
  }

  function toPointList(path){
    return (path || []).map(point => ({
      x: Number(point?.lng ?? point?.x ?? 0),
      y: Number(point?.lat ?? point?.y ?? 0),
    })).filter(point => Number.isFinite(point.x) && Number.isFinite(point.y));
  }

  function convertSnapshot(snapshot){
    const rawZones = Array.isArray(snapshot?.zones) ? snapshot.zones : [];
    const zones = rawZones.map(zone => ({
      original: toPointList(zone.originalPoints),
      inset: toPointList(zone.insetPoints),
      placement: toPointList(zone.panelPlacementPoints),
    })).filter(zone => zone.original.length >= 3);
    const panels = (snapshot?.panelPolygons || []).map(toPointList).filter(panel => panel.length >= 3);
    return { zones, panels };
  }

  function buildPreviewData(snapshot){
    const converted = convertSnapshot(snapshot);
    const allPoints = [
      ...converted.zones.flatMap(zone => zone.original),
      ...converted.panels.flatMap(panel => panel),
    ];
    if(!allPoints.length){
      return { ...converted, zones: [], panels: [], bounds: null };
    }
    return { ...converted, bounds: getBounds(allPoints) };
  }

  function scalePoints(points, bounds, width, height, padding = 22){
    if(!bounds) return [];
    const rawWidth = Math.max(1, bounds.maxX - bounds.minX);
    const rawHeight = Math.max(1, bounds.maxY - bounds.minY);
    const scale = Math.min((width - padding * 2) / rawWidth, (height - padding * 2) / rawHeight);
    const offsetX = (width - rawWidth * scale) / 2;
    const offsetY = (height - rawHeight * scale) / 2;
    return points.map(point => ({
      x: offsetX + (point.x - bounds.minX) * scale,
      y: offsetY + (point.y - bounds.minY) * scale,
    }));
  }

  function pointsToString(points){
    return points.map(point => `${point.x.toFixed(2)},${point.y.toFixed(2)}`).join(' ');
  }

  function renderInstallationPreview(snapshot, panelCount, zoneType){
    if(!implantationSvg) return;
    const preview = buildPreviewData(snapshot);
    const width = 360;
    const height = 230;
    implantationSvg.innerHTML = '';

    const background = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
    background.setAttribute('x', '0');
    background.setAttribute('y', '0');
    background.setAttribute('width', String(width));
    background.setAttribute('height', String(height));
    background.setAttribute('rx', '20');
    background.setAttribute('fill', zoneType === 'garden' ? '#eaf7ef' : '#edf6fe');
    implantationSvg.appendChild(background);

    if(!preview.bounds || !preview.zones.length){
      const label = document.createElementNS('http://www.w3.org/2000/svg', 'text');
      label.setAttribute('x', '180');
      label.setAttribute('y', '118');
      label.setAttribute('text-anchor', 'middle');
      label.setAttribute('fill', '#5f7490');
      label.setAttribute('font-size', '14');
      label.setAttribute('font-family', 'Inter, sans-serif');
      label.textContent = 'Aperçu d’implantation indisponible';
      implantationSvg.appendChild(label);
      return;
    }

    preview.zones.forEach(zone => {
      const outer = scalePoints(zone.original, preview.bounds, width, height);
      if(outer.length >= 3){
        const shape = document.createElementNS('http://www.w3.org/2000/svg', 'polygon');
        shape.setAttribute('points', pointsToString(outer));
        shape.setAttribute('fill', zoneType === 'garden' ? 'rgba(56,182,95,.18)' : 'rgba(27,151,234,.16)');
        shape.setAttribute('stroke', zoneType === 'garden' ? '#46b461' : '#1b97ea');
        shape.setAttribute('stroke-width', '3');
        shape.setAttribute('stroke-linejoin', 'round');
        implantationSvg.appendChild(shape);
      }

      const inset = scalePoints(zone.inset, preview.bounds, width, height);
      if(inset.length >= 3){
        const inner = document.createElementNS('http://www.w3.org/2000/svg', 'polygon');
        inner.setAttribute('points', pointsToString(inset));
        inner.setAttribute('fill', zoneType === 'garden' ? 'rgba(70,180,97,.10)' : 'rgba(41,45,99,.06)');
        inner.setAttribute('stroke', zoneType === 'garden' ? 'rgba(70,180,97,.55)' : 'rgba(41,45,99,.22)');
        inner.setAttribute('stroke-width', '2');
        inner.setAttribute('stroke-dasharray', '6 6');
        inner.setAttribute('stroke-linejoin', 'round');
        implantationSvg.appendChild(inner);
      }
    });

    preview.panels.slice(0, panelCount).forEach(panel => {
      const scaled = scalePoints(panel, preview.bounds, width, height);
      if(scaled.length >= 3){
        const cell = document.createElementNS('http://www.w3.org/2000/svg', 'polygon');
        cell.setAttribute('points', pointsToString(scaled));
        cell.setAttribute('fill', zoneType === 'garden' ? '#2d7a4f' : '#1d3350');
        cell.setAttribute('stroke', '#ffffff');
        cell.setAttribute('stroke-opacity', '.24');
        cell.setAttribute('stroke-width', '.8');
        implantationSvg.appendChild(cell);
      }
    });
  }

  function computeAnnualConsumption(simulationState){
    const baseConsumption = Math.max(0, Number(simulationState.consumption?.annualConsumptionKwh) || 0);
    const evCount = Math.max(0, Number(simulationState.consumption?.vehicleCount) || 0);
    return {
      evCount,
      baseConsumption,
      heatingMode: simulationState.consumption?.heatingMode || simulationState.heatingMode || 'Gaz',
      totalConsumption: baseConsumption + (evCount * 2200),
    };
  }

  function computeResultState(simulationState){
    const annualProduction = Math.max(0, Number(simulationState.yearlyKwh) || 0);
    const roofArea = Math.max(0, Number(simulationState.surfaceM2) || 0);
    const panelCount = Math.max(0, Number(simulationState.panels) || 0);
    const kwc = Math.max(0, Number(simulationState.kwc) || 0);
    const budgetMin = Math.max(0, Number(simulationState.budgetMin) || 0);
    const budgetMax = Math.max(0, Number(simulationState.budgetMax) || 0);
    const averageBudget = Math.round((budgetMin + budgetMax) / 2);
    const orientation = simulationState.orientation || 'Sud';
    const inclination = Number(simulationState.inclination) || 30;
    const zoneType = simulationState.zoneType || 'roof';
    const consumption = computeAnnualConsumption(simulationState);
    const heatingBonus = ['Électrique', 'Pompe à chaleur'].includes(consumption.heatingMode) ? 12 : 0;
    const selfShare = annualProduction > 0
      ? clamp(Math.round((consumption.totalConsumption / annualProduction) * 55) + heatingBonus, 28, 88)
      : 0;
    const autoconsumedKwh = Math.round(annualProduction * (selfShare / 100));
    const injectedKwh = Math.max(0, annualProduction - autoconsumedKwh);
    const annualSavings = Math.round((autoconsumedKwh * 0.2276) + (injectedKwh * 0.1269));
    const payback = annualSavings > 0 ? (averageBudget / annualSavings) : 0;
    const savings10 = Math.round(annualSavings * 10 * 1.08);
    const savings20 = Math.round(annualSavings * 20 * 1.18);
    const savings30 = Math.round(annualSavings * 30 * 1.3);
    const co2Kg = Math.round(annualProduction * 0.4);
    const trees = Math.round(co2Kg / 30);
    return {
      annualProduction,
      roofArea,
      panelCount,
      kwc,
      budgetMin,
      budgetMax,
      averageBudget,
      orientation,
      inclination,
      zoneType,
      annualSavings,
      payback,
      savings10,
      savings20,
      savings30,
      co2Kg,
      trees,
      selfShare,
      autoconsumedKwh,
      injectedKwh,
      evCount: consumption.evCount,
      totalConsumption: consumption.totalConsumption,
      heatingMode: consumption.heatingMode,
    };
  }

  function updatePresetButtons(panelCount){
    panelPresetRow.querySelectorAll('.adjust-preset').forEach(btn => {
      const presetCount = panelCountFromKwc(btn.dataset.kwc);
      btn.classList.toggle('active', presetCount === panelCount);
      btn.disabled = presetCount > maxPanelCount;
    });
  }

  function setSimulationPanelCount(nextCount){
    const safeCount = clamp(Math.round(nextCount || 0), minPanelCount, maxPanelCount);
    currentSimulation.panels = safeCount;
    currentSimulation.kwc = +(safeCount * PANEL_POWER_KWC).toFixed(2);
    const zoneFactor = currentSimulation.zoneType === 'garden' ? 1.05 : 1;
    const productionPerKwc = baseKwc > 0 ? (baseYearlyKwh / baseKwc) : 1180;
    currentSimulation.yearlyKwh = Math.round(currentSimulation.kwc * productionPerKwc * zoneFactor);
    currentSimulation.budgetMin = Math.round(currentSimulation.kwc * pricingMin / 100) * 100;
    currentSimulation.budgetMax = Math.round(currentSimulation.kwc * pricingMax / 100) * 100;
    renderSimulation();
  }

  function renderSimulation(){
    const result = computeResultState(currentSimulation);

    setStat('surfaceValue', `${formatInt(result.roofArea)} m²`);
    setStat('panelsValue', formatInt(result.panelCount));
    setStat('kwcValue', `${formatDecimal(result.kwc)} kWc`);
    setStat('orientationValue', result.zoneType === 'garden' ? 'Au sol' : result.orientation);
    setStat('pitchValue', result.zoneType === 'garden' ? '0°' : `${formatInt(result.inclination)}°`);
    setStat('productionValue', `${formatInt(result.annualProduction)} kWh`);
    setStat('annualSavingsValue', formatMoney(result.annualSavings));
    setStat('budgetValue', result.budgetMin && result.budgetMax ? `${formatMoney(result.budgetMin)} - ${formatMoney(result.budgetMax)}` : formatMoney(result.averageBudget));
    setStat('paybackValue', result.payback > 0 ? `${formatDecimal(result.payback)} ans` : '—');
    setStat('selfShareValue', `${formatInt(result.selfShare)} %`);
    setStat('autoconsumedValue', `${formatInt(result.autoconsumedKwh)} kWh`);
    setStat('injectedValue', `${formatInt(result.injectedKwh)} kWh`);
    setStat('savings10Value', formatMoney(result.savings10));
    setStat('savings20Value', formatMoney(result.savings20));
    setStat('savings30Value', formatMoney(result.savings30));
    setStat('co2Value', `${formatInt(result.co2Kg)} kg de CO2`);
    setStat('treesValue', formatInt(result.trees));
    setStat('implantationPanels', formatInt(result.panelCount));
    setStat('implantationKwc', `${formatDecimal(result.kwc)} kWc`);
    panelAdjustValue.textContent = formatInt(result.panelCount);
    implantationBadge.textContent = result.zoneType === 'garden' ? 'Installation jardin' : 'Installation toiture';
    adjustNote.textContent = result.zoneType === 'garden'
      ? 'Le rendu ci-dessus correspond à une implantation au sol dans le jardin, optimisée dans votre zone sélectionnée.'
      : 'Le rendu ci-dessus correspond à la pose sur votre pan de toiture, avec orientation et inclinaison prises en compte.';

    panelMinusBtn.disabled = result.panelCount <= minPanelCount;
    panelPlusBtn.disabled = result.panelCount >= maxPanelCount;
    updatePresetButtons(result.panelCount);
    renderInstallationPreview(currentSimulation.snapshotPayload, result.panelCount, result.zoneType);
  }

  let selectedOptions = { battery: false, charger: false };
  projectOptions.querySelectorAll('.option').forEach(btn => {
    btn.addEventListener('click', () => {
      const key = btn.dataset.option;
      selectedOptions[key] = !selectedOptions[key];
      btn.classList.toggle('active', !!selectedOptions[key]);
    });
  });

  const simulation = loadSimulation();
  if(!simulation){
    missingBox.style.display = 'block';
    summaryAddress.textContent = 'Simulation introuvable';
    submitBtn.disabled = true;
    return;
  }

  summaryAddress.textContent = simulation.address || 'Adresse non renseignée';

  const currentSimulation = {
    ...simulation,
    snapshotPayload: cloneSnapshot(simulation.snapshotPayload),
  };
  const maxPanelCount = Math.max(
    1,
    Number(simulation.snapshotPayload?.panelPolygons?.length) || 0,
    Number(simulation.panels) || 0
  );
  const minPanelCount = Math.max(1, Math.min(4, maxPanelCount));
  const baseKwc = Math.max(0.1, Number(simulation.kwc) || 0.1);
  const baseYearlyKwh = Math.max(0, Number(simulation.yearlyKwh) || 0);
  const pricingMin = Math.max(0, Number(simulation.budgetMin) || 0) / baseKwc;
  const pricingMax = Math.max(0, Number(simulation.budgetMax) || 0) / baseKwc;

  renderSimulation();

  panelMinusBtn.addEventListener('click', () => setSimulationPanelCount((Number(currentSimulation.panels) || 0) - 1));
  panelPlusBtn.addEventListener('click', () => setSimulationPanelCount((Number(currentSimulation.panels) || 0) + 1));
  panelPresetRow.querySelectorAll('.adjust-preset').forEach(btn => {
    btn.addEventListener('click', () => setSimulationPanelCount(panelCountFromKwc(btn.dataset.kwc)));
  });

  async function submitLead(){
    errorBox.style.display = 'none';
    successBox.style.display = 'none';

    const nom = document.getElementById('nom').value.trim();
    const prenom = document.getElementById('prenom').value.trim();
    const email = document.getElementById('email').value.trim();
    const telephone = document.getElementById('telephone').value.trim();
    const consent = document.getElementById('consent').checked;

    if(!nom || !prenom || !email || !telephone){
      showError('Merci de renseigner votre nom, prénom, email et téléphone.');
      return;
    }

    if(!consent){
      showError('Merci de confirmer votre accord pour recevoir votre étude complète.');
      return;
    }

    submitBtn.disabled = true;
    submitBtn.textContent = 'Envoi en cours...';

    const payload = {
      nom,
      prenom,
      email,
      telephone,
      adresse: simulation.address || '',
      type_projet: selectedOptions.battery ? 'batterie' : 'autoconsommation',
      kwc: currentSimulation.kwc,
      budget_min: currentSimulation.budgetMin,
      budget_max: currentSimulation.budgetMax,
      yearly_kwh: currentSimulation.yearlyKwh,
      panel_count: currentSimulation.panels,
      annual_savings: computeResultState(currentSimulation).annualSavings,
      surface_m2: currentSimulation.surfaceM2,
      orientation: currentSimulation.zoneType === 'garden' ? 'Au sol' : (currentSimulation.orientation || 'Sud'),
      inclination: currentSimulation.zoneType === 'garden' ? 0 : currentSimulation.inclination,
      consumption_kwh: computeResultState(currentSimulation).totalConsumption,
      bill_amount: currentSimulation.consumption?.billAmount || null,
      bill_period: currentSimulation.consumption?.billPeriod || 'year',
      vehicle_count: computeResultState(currentSimulation).evCount,
      heating_mode: currentSimulation.consumption?.heatingMode || currentSimulation.heatingMode || null,
      zone_type: currentSimulation.zoneType || 'roof',
      wants_battery: selectedOptions.battery,
      wants_charger: selectedOptions.charger,
      consumption_source: currentSimulation.consumption?.source || 'kwh',
      snapshot_payload: currentSimulation.snapshotPayload ? JSON.stringify(currentSimulation.snapshotPayload) : '',
    };

    try {
      const response = await fetch(window.__leadUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': window.__csrfToken,
        },
        body: JSON.stringify(payload),
      });

      const data = await response.json();
      if(!response.ok || !data.success){
        throw new Error(data.message || 'Impossible d’envoyer votre demande pour le moment.');
      }

      showSuccess('Votre étude complète a bien été envoyée. Nous revenons vers vous rapidement avec la suite de votre projet.');
      submitBtn.textContent = 'Étude envoyée';
    } catch (error) {
      submitBtn.disabled = false;
      submitBtn.textContent = "Recevoir l'étude complète de votre projet";
      showError(error.message || 'Impossible d’envoyer votre demande pour le moment.');
    }
  }

  submitBtn.addEventListener('click', submitLead);
})();
</script>
</body>
</html>
