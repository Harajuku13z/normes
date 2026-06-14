@php
    use App\Support\HomeView;
    $h = $home ?? [];
    $logo = HomeView::url((string) data_get($h, 'header.logo', '/logo.png'));
    $siteName = (string) data_get($h, 'meta.site_name', 'Normes Rénovation');
    $mapsKey = $googleMapsKey ?? '';
    $pricing = $pricingSettings ?? [];
    $restartUrl = route('simulateur.photovoltaique');
    $step4Url = route('simulateur.photovoltaique.confirmation');
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
<link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
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
    radial-gradient(1200px 600px at 80% -10%, #eaf4fb 0%, transparent 60%),
    radial-gradient(900px 500px at -10% 110%, #eef4f8 0%, transparent 60%),
    var(--bg);
  min-height:100vh;
  -webkit-font-smoothing:antialiased;
}
.app{max-width:1440px;margin:0 auto;padding:24px 28px 40px}

/* ── Topbar ── */
.topbar{
  background:var(--card);
  border:1px solid var(--line);
  border-radius:18px;
  padding:14px 22px;
  display:flex;
  align-items:center;
  gap:24px;
  box-shadow:var(--shadow);
}
.brand{display:flex;align-items:center;min-width:220px}
.brand img{height:46px;width:auto;display:block}
.stepper{flex:1;display:flex;align-items:center;justify-content:center;gap:10px}
.step{display:flex;align-items:center;gap:10px;color:var(--muted);font-weight:500;font-size:14.5px}
.step .num{
  width:30px;height:30px;border-radius:50%;
  background:#eef2f5;color:#8a96a0;
  display:grid;place-items:center;font-weight:700;font-size:13px;flex-shrink:0;transition:.2s
}
.step.done .num{background:var(--ok);color:#fff}
.step.active .num{background:var(--ink);color:#fff}
.step.active{color:var(--ink);font-weight:600}
.step.done{color:var(--ink-2)}
.step-sep{width:48px;height:2px;background:linear-gradient(90deg,#dfe5ea, #eef2f5);border-radius:2px;flex-shrink:0}
.step-sep.done{background:var(--ok);opacity:.4}
.help-btn{
  border:1px solid var(--line);
  background:#fff;
  border-radius:12px;
  padding:10px 16px;
  display:flex;align-items:center;gap:10px;
  font:600 14px/1 'Inter',sans-serif;
  color:var(--ink);
  text-decoration:none;
  transition:.15s ease;
}
.help-btn:hover{border-color:#cdd6dd;box-shadow:var(--shadow)}
.help-btn .q{
  width:20px;height:20px;border-radius:50%;border:1.5px solid #b9c4cc;color:#8a96a0;
  display:grid;place-items:center;font-weight:700;font-size:11px;
}

/* ── Layout grid ── */
.grid{display:block;margin-top:22px}
#leftCol{display:block}

/* ── Card ── */
.card{
  background:var(--card);
  border:1px solid var(--line);
  border-radius:28px;
  padding:22px;
  box-shadow:var(--shadow);
}
.card+.card{margin-top:16px}
.card h2{margin:0 0 6px;font-size:18px;font-weight:700;color:var(--ink);line-height:1.25;letter-spacing:-.01em}
.card p.lede{margin:0 0 16px;color:var(--slate);font-size:13.5px;line-height:1.55}
.meta-label{text-transform:uppercase;letter-spacing:.12em;font-size:10px;font-weight:600;color:var(--muted);margin-bottom:5px}

#cardAddr{max-width:1040px;margin:0 auto 18px}
#cardDraw,#cardRoof{
  max-width:1240px;
  margin:0 auto 20px;
  padding:34px 40px 32px;
}
#cardDraw h2,#cardRoof h2{
  font-family:'Anton','Arial Narrow',sans-serif;
  font-size:clamp(34px,4vw,54px)!important;
  line-height:1.04;
  letter-spacing:-.01em;
  text-transform:uppercase;
  text-align:center;
  color:#294352;
  margin:0 0 12px;
}
#drawCardLead,#roofStageLead{
  max-width:760px;
  margin:0 auto 16px!important;
  text-align:center;
  font-size:16px!important;
  line-height:1.55!important;
  color:#5a6b78!important;
}
#drawModeBadge,
#surfaceMetaLabel,
.surface-display,
#surfaceSub,
#ridgeHelper,
#rightCol,
#roofInfoRows,
#panelAdjustWrap{
  display:none!important;
}
#drawCardNote{
  display:none;
  max-width:860px;
  margin:0 auto 18px;
  padding:0;
  border:0;
  background:transparent;
  text-align:center;
  font-size:15px;
  line-height:1.55;
  color:#2c2f66;
  font-style:italic;
}
#drawCardNote strong{display:none}
#journeyMapWrap{margin-top:16px}
#cardDraw .btn,#cardRoof .btn{
  width:100%;
  min-height:86px;
  border-radius:18px;
  font-size:28px;
  font-weight:800;
  box-shadow:none;
}
#cardDraw .btn-primary,
#cardRoof .btn-yellow{
  background:#1b97ea;
  color:#fff;
}
#cardDraw .btn-primary:hover,
#cardRoof .btn-yellow:hover{
  background:#1188d7;
  transform:translateY(-1px);
  box-shadow:0 10px 22px rgba(17,136,215,.24);
}
#clearZoneBtn{display:none!important}
#drawBackLink,#roofBackBtn{
  display:block;
  margin-top:24px;
  text-align:center;
  color:#24285b;
  font-size:18px;
  text-decoration:none;
}
#drawBackLink:hover,#roofBackBtn:hover{text-decoration:underline}
#pitchGrid{
  max-width:760px;
  margin:28px auto 0;
  gap:18px;
}
#pitchGrid .pitch-btn{
  min-height:136px;
  border-radius:18px;
  font-size:46px;
}
#cardRoof .pitch-help{
  max-width:860px;
  margin:26px auto 0;
  font-size:18px;
  line-height:1.5;
}
#cardRoof .inclination-illustration{
  max-width:760px;
  margin:10px auto 0;
}
#journeyMapWrap .map-info-bar,
#journeyMapWrap .layer-switch{
  display:none!important;
}

#cardDraw.stage-locate{
  max-width:1780px;
  padding:22px;
  display:flex;
  flex-direction:column;
  gap:24px;
  align-items:stretch;
  background:
    radial-gradient(circle at top right,rgba(27,151,234,.10),transparent 24%),
    linear-gradient(180deg,rgba(19,166,232,.04) 0%,rgba(19,166,232,0) 24%),
    #ffffff;
}
#cardDraw.stage-locate #journeyMapWrap{
  order:-1;
  margin-top:0;
  min-height:520px;
  border-radius:30px;
  overflow:hidden;
  border:1px solid #dce8f3;
  box-shadow:0 18px 44px rgba(20,40,80,.12), inset 0 0 0 1px rgba(255,255,255,.78);
  background:#eef3f7;
  position:relative;
}
#cardDraw.stage-locate #journeyMapWrap::before{
  content:"";
  position:absolute;
  inset:0;
  pointer-events:none;
  background:
    radial-gradient(circle at 14% 10%,rgba(255,255,255,.85),transparent 18%),
    radial-gradient(circle at 90% 6%,rgba(255,255,255,.42),transparent 22%);
  z-index:1;
}
#cardDraw.stage-locate > div:first-child{
  margin:0;
}
#cardDraw.stage-locate h2{
  font-size:27px!important;
  text-align:left;
  line-height:1.08;
  letter-spacing:-.03em;
  color:#1a2433;
  margin:0!important;
}
#cardDraw.stage-locate #drawCardLead{
  margin:2px 0 10px!important;
  max-width:none;
  text-align:left;
  font-size:18px!important;
  line-height:1.45!important;
  color:#6a7689!important;
}
#cardDraw.stage-locate #drawModeBadge{
  display:inline-flex!important;
  align-items:center;
  justify-content:center;
  padding:10px 16px!important;
  border-radius:999px;
  background:#eaf6fe!important;
  color:#4999d8!important;
  font-size:15px!important;
  font-weight:800;
  letter-spacing:.04em;
}
#cardDraw.stage-locate .surface-display,
#cardDraw.stage-locate #surfaceMetaLabel,
#cardDraw.stage-locate #surfaceSub,
#cardDraw.stage-locate #validateZoneBtn{
  max-width:100%;
}
#cardDraw.stage-locate .locate-stage-demo{
  display:block!important;
}
#cardDraw.stage-locate #drawCardNote,
#cardDraw.stage-locate #drawBackLink,
#cardDraw.stage-locate #clearZoneBtn,
#cardDraw.stage-locate #drawResultBox,
#cardDraw.stage-locate #drawToolbar,
#cardDraw.stage-locate #drawHint{
  display:none!important;
}
#cardDraw.stage-locate #surfaceMetaLabel{
  display:block!important;
  margin-top:10px;
  font-size:12px;
  color:#9aa7b6;
}
#cardDraw.stage-locate .surface-display{
  display:flex!important;
  align-items:flex-end;
  gap:8px;
  margin:4px 0 4px;
}
#cardDraw.stage-locate .surface-display .s-val{
  font-size:78px;
  line-height:.9;
  color:#182230;
}
#cardDraw.stage-locate .surface-display .s-unit{
  font-size:22px;
  line-height:1.2;
  color:#4e6175;
  margin-bottom:12px;
}
#cardDraw.stage-locate #surfaceSub{
  display:block!important;
  margin-bottom:20px;
  font-size:16px;
  line-height:1.55;
  color:#8a96a7;
}
#cardDraw.stage-locate #validateZoneBtn{
  min-height:72px;
  border-radius:18px;
  background:#162434;
  font-size:20px;
  font-weight:800;
  margin-top:10px;
  box-shadow:0 14px 30px rgba(22,36,52,.20);
}
#cardDraw.stage-locate #validateZoneBtn:hover:not(:disabled){
  background:#0f1a28;
}
#cardDraw.stage-locate #journeyMapWrap .layer-switch{
  display:flex!important;
}
#cardDraw.stage-locate #journeyMapWrap .map-info-bar{
  display:flex!important;
}

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
/* ── Zone type toggle ── */
.zone-toggle{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:16px}
.zone-btn{
  border:1.5px solid var(--line);background:#fff;border-radius:11px;
  padding:12px 8px;cursor:pointer;text-align:center;transition:.15s ease;
}
.zone-btn:hover{border-color:var(--accent);background:var(--accent-soft)}
.zone-btn.active{border-color:var(--accent);background:var(--accent-soft)}
.zone-btn .zb-icon{font-size:26px;display:block;margin-bottom:5px}
.zone-btn .zb-label{font-size:12.5px;font-weight:700;color:var(--ink);display:block}
.zone-btn .zb-sub{font-size:11px;color:var(--muted);display:block;margin-top:2px}
.zone-btn.active .zb-label{color:var(--accent-deep)}
.zone-toggle{display:none}

/* Surface display */
.surface-display{display:flex;align-items:baseline;gap:6px;margin:10px 0 4px}
.surface-display .s-val{font-size:40px;font-weight:800;color:var(--ink);letter-spacing:-.02em;font-variant-numeric:tabular-nums;line-height:1}
.surface-display .s-unit{font-size:16px;font-weight:600;color:var(--slate)}
.surface-sub{font-size:12px;color:var(--muted);font-style:italic;margin-bottom:16px}
.panel-adjust-wrap{
  margin:14px 0 16px;padding:14px;border:1px solid var(--line);border-radius:12px;background:#f8fbfd;position:relative;z-index:2;
}
.panel-adjust-head{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:8px}
.panel-adjust-head .meta-label{margin:0}
.panel-adjust-max{font-size:11px;color:var(--muted);font-weight:600}
.panel-counter{display:grid;grid-template-columns:48px 1fr 48px;gap:8px;align-items:center}
.panel-counter-btn{
  height:48px;border-radius:12px;border:1.5px solid var(--line);background:#fff;color:var(--ink);
  font:700 22px/1 'Inter',sans-serif;display:grid;place-items:center;cursor:pointer;transition:.15s ease;pointer-events:auto;
}
.panel-counter-btn:hover:not(:disabled){border-color:var(--accent);background:var(--accent-soft);color:var(--accent-deep)}
.panel-counter-btn:disabled{opacity:.35;cursor:not-allowed}
.panel-counter-display{
  height:48px;border-radius:12px;background:var(--ink);color:#fff;display:flex;align-items:center;justify-content:center;gap:8px;
}
.panel-counter-display strong{font-size:22px;font-weight:800;letter-spacing:-.02em;font-variant-numeric:tabular-nums}
.panel-counter-display span{font-size:11px;color:#a8b8c5;font-weight:700;letter-spacing:.08em;text-transform:uppercase}
.panel-quick-picks{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-top:10px}
.panel-quick-btn{
  min-height:42px;border-radius:10px;border:1px solid var(--line);background:#fff;color:var(--ink);
  font:700 12px/1.2 'Inter',sans-serif;padding:8px 6px;cursor:pointer;transition:.15s ease;text-align:center;pointer-events:auto;
}
.panel-quick-btn:hover:not(:disabled){border-color:var(--accent);background:var(--accent-soft);color:var(--accent-deep)}
.panel-quick-btn.active{border-color:var(--accent);background:var(--accent);color:#fff}
.panel-quick-btn:disabled{opacity:.38;cursor:not-allowed}
.panel-adjust-sub{font-size:11.5px;color:var(--muted);margin-top:8px;line-height:1.45}

/* Draw hint overlay on map */
.draw-hint{
  position:absolute;left:50%;bottom:80px;transform:translateX(-50%);top:auto;
  background:rgba(15,34,49,.85);color:#fff;
  padding:14px 22px;border-radius:12px;
  font:600 13.5px 'Inter',sans-serif;
  display:flex;align-items:center;gap:12px;
  pointer-events:none;backdrop-filter:blur(6px);
  box-shadow:0 8px 24px rgba(0,0,0,.3);z-index:8;
  transition:opacity .3s ease, transform .3s ease, background .2s ease;
  max-width:min(92%,420px);
  justify-content:center;
  text-align:center;
}
.draw-hint.hidden{opacity:0;pointer-events:none}
.draw-hint .dot{
  width:10px;height:10px;border-radius:50%;background:var(--accent);flex-shrink:0;
  box-shadow:0 0 0 4px rgba(19,166,232,.35);animation:pulse 1.6s infinite;
}
.draw-hint.attention{
  background:rgba(18,32,48,.94);
  border:1px solid rgba(73,213,61,.35);
  transform:translateX(-50%) translateY(-4px);
}
.draw-hint.attention .dot{
  background:#49d53d;
  box-shadow:0 0 0 4px rgba(73,213,61,.22);
}
.draw-hint.success{
  background:rgba(19,100,63,.92);
  border:1px solid rgba(255,255,255,.14);
}
.draw-hint.success .dot{
  background:#fff;
  box-shadow:0 0 0 4px rgba(255,255,255,.18);
}
@keyframes pulse{0%,100%{box-shadow:0 0 0 4px rgba(19,166,232,.35)}50%{box-shadow:0 0 0 10px rgba(19,166,232,0)}}

/* ── Popup démo ── */
.demo-backdrop{
  position:fixed;inset:0;background:rgba(15,34,49,.7);z-index:500;
  display:flex;align-items:center;justify-content:center;padding:20px;
  backdrop-filter:blur(6px);animation:fadeIn .25s ease;
}
.demo-backdrop.closing{animation:fadeOut .25s ease forwards}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}
@keyframes fadeOut{from{opacity:1}to{opacity:0}}
.demo-box{
  background:#fff;border-radius:18px;max-width:680px;width:100%;
  box-shadow:0 24px 56px rgba(15,34,49,.24);overflow:hidden;
  animation:slideUp .3s cubic-bezier(.34,1.56,.64,1);
}
@keyframes slideUp{from{transform:translateY(30px);opacity:0}to{transform:translateY(0);opacity:1}}
.demo-head{
  display:flex;align-items:center;justify-content:space-between;
  padding:16px 18px 14px;border-bottom:1px solid #e6eef5;
  background:linear-gradient(180deg,#ffffff 0%,#f7fbff 100%);
}
.demo-head h3{font-size:15px;font-weight:800;color:#18263a}
.demo-head p{font-size:12px;color:#738194;margin-top:2px}
.demo-close{
  width:32px;height:32px;border-radius:9px;border:1.5px solid var(--line);
  background:#fff;cursor:pointer;display:grid;place-items:center;
  flex-shrink:0;transition:.15s;color:var(--ink);
}
.demo-close:hover{background:var(--line-2);border-color:#cdd6dd}
.demo-img-wrap{
  position:relative;overflow:hidden;background:linear-gradient(180deg,#eef6fe 0%,#e5f1fb 100%);line-height:0;
  aspect-ratio:4 / 3;min-height:340px;
}
.demo-svg{position:absolute;inset:0;width:100%;height:100%;pointer-events:none}
.dp-dot{
  fill:#fff;stroke:#52e33f;stroke-width:4;
  vector-effect:non-scaling-stroke;
  transform-origin:center;
}
.dp-line{
  stroke:#52e33f;stroke-width:4;fill:none;
  stroke-linecap:round;stroke-linejoin:round;
  vector-effect:non-scaling-stroke;
  stroke-dasharray:1200;stroke-dashoffset:1200;
}
.dp-fill{fill:url(#demoShapeFill);stroke:none;opacity:0}
.dp-selected-edge{
  stroke:#ff3b30;stroke-width:7;fill:none;stroke-linecap:round;stroke-linejoin:round;
  vector-effect:non-scaling-stroke;opacity:0;
}
.dp-badge{opacity:0}
.dp-badge rect{
  fill:rgba(15,34,49,.78);
  stroke:rgba(255,255,255,.16);
  stroke-width:1.5;
}
.dp-badge text{
  fill:#fff;
  font-family:'Inter',system-ui,sans-serif;
  font-size:20px;
  font-weight:800;
  text-anchor:middle;
}
.dp-caption{opacity:0}
.dp-caption text{
  fill:#fff;
  font-family:'Inter',system-ui,sans-serif;
  font-weight:800;
  text-anchor:middle;
}
.dp-caption .main{font-size:34px}
.dp-caption .sub{font-size:34px}
.dp-scene-band{fill:rgba(23,37,54,.08)}
.dp-scene-band.alt{fill:rgba(23,37,54,.05)}
.dp-scene-guide{
  stroke:rgba(23,37,54,.18);
  stroke-width:2;
  stroke-dasharray:3 10;
}
.dp-scene-grid{
  stroke:rgba(23,37,54,.08);
  stroke-width:1.5;
}
.dp-scene-lawn{fill:#1a6c4c}
.dp-scene-lawn-patch{fill:rgba(255,255,255,.08)}
.dp-scene-sky-glow{fill:rgba(19,166,232,.12)}
.dp-roof-shadow{fill:rgba(15,34,49,.12)}
.dp-roof-wall{fill:#dbe8f3}
.dp-roof-plane{
  fill:#ffffff;
  stroke:#d8e6f3;
  stroke-width:3;
  stroke-linejoin:round;
}
.dp-roof-plane.alt{fill:#f4f9fd}
.dp-roof-outline{
  stroke:#d8e6f3;
  stroke-width:2.5;
  stroke-linejoin:round;
  fill:none;
}
.dp-roof-ridge{
  stroke:#87c8ef;
  stroke-width:4;
  stroke-linecap:round;
}
.dp-roof-tile{
  stroke:rgba(59,168,233,.42);
  stroke-width:3;
  stroke-linecap:round;
}
.dp-roof-highlight{
  fill:rgba(255,255,255,.56);
}
.dp-scene-zone{fill:rgba(255,255,255,.92);stroke:#52e33f;stroke-width:5}
.dp-scene-zone.shadow{fill:rgba(0,0,0,.14);stroke:none}
.dp-ghost-zone{
  fill:rgba(255,255,255,.16);
  stroke:rgba(23,37,54,.2);
  stroke-width:3;
  stroke-dasharray:10 12;
}
.dp-cursor{
  opacity:0;
  transform-origin:center;
}
.dp-cursor-shadow{fill:rgba(0,0,0,.18)}
.dp-cursor-shape{fill:#1fa8ff}
.dp-cursor-tip{fill:#ffffff}
.dp-cursor-pulse{
  fill:none;
  stroke:rgba(31,168,255,.55);
  stroke-width:3;
  opacity:0;
}

/* Keyframes points */
@keyframes dotPop{
  0%,4%    {transform:scale(0);opacity:0}
  12%,78%  {transform:scale(1);opacity:1}
  90%,100% {transform:scale(0);opacity:0}
}
/* Ligne tracée */
@keyframes lineTrace{
  0%,8%    {stroke-dashoffset:1200}
  55%,80%  {stroke-dashoffset:0}
  92%,100% {stroke-dashoffset:1200}
}
/* Fill + labels + badge */
@keyframes fadeInOut{
  0%,52%   {opacity:0}
  65%,80%  {opacity:1}
  92%,100% {opacity:0}
}
@keyframes edgeReveal{
  0%,54%   {opacity:0}
  66%,84%  {opacity:1}
  92%,100% {opacity:0}
}
@keyframes cursorPulse{
  0%,8%    {opacity:0;transform:translate(0,0) scale(.72)}
  14%,18%  {opacity:1;transform:translate(0,0) scale(1)}
  24%,28%  {opacity:1;transform:translate(194px,52px) scale(1)}
  34%,38%  {opacity:1;transform:translate(148px,184px) scale(1)}
  44%,48%  {opacity:1;transform:translate(-44px,132px) scale(1)}
  52%,82%  {opacity:0;transform:translate(-44px,132px) scale(.88)}
  100%     {opacity:0;transform:translate(0,0) scale(.72)}
}
@keyframes cursorRing{
  0%,12%   {opacity:0;transform:scale(.4)}
  18%,20%  {opacity:1;transform:scale(1)}
  26%,30%  {opacity:1;transform:scale(1)}
  36%,40%  {opacity:1;transform:scale(1)}
  46%,50%  {opacity:1;transform:scale(1)}
  58%,100% {opacity:0;transform:scale(1.85)}
}

/* Application des animations (cycle 5s en boucle) */
.demo-anim-running .dp-dot#dp1{animation:dotPop 5s ease infinite;animation-delay:0s}
.demo-anim-running .dp-dot#dp2{animation:dotPop 5s ease infinite;animation-delay:.55s}
.demo-anim-running .dp-dot#dp3{animation:dotPop 5s ease infinite;animation-delay:1.1s}
.demo-anim-running .dp-dot#dp4{animation:dotPop 5s ease infinite;animation-delay:1.65s}
.demo-anim-running .dp-line    {animation:lineTrace 5s ease infinite}
.demo-anim-running .dp-fill    {animation:fadeInOut 5s ease infinite}
.demo-anim-running .dp-badge   {animation:fadeInOut 5s ease infinite}
.demo-anim-running .dp-selected-edge{animation:edgeReveal 5s ease infinite}
.demo-anim-running .dp-caption {animation:fadeInOut 5s ease infinite}
.demo-anim-running .dp-cursor {animation:cursorPulse 5s ease infinite}
.demo-anim-running .dp-cursor-pulse {animation:cursorRing 5s ease infinite}
/* type badge in demo */
.demo-type-badge{
  position:absolute;top:10px;left:10px;
  background:#eef6fe;color:#4596d7;
  padding:4px 10px;border-radius:8px;font:700 11px 'Inter',sans-serif;
  border:1px solid rgba(69,150,215,.18);
}
.demo-steps{display:flex;gap:0;border-top:1px solid var(--line)}
.demo-step{flex:1;padding:10px 12px;border-right:1px solid var(--line);text-align:center}
.demo-step:last-child{border-right:0}
.demo-step .ds-num{width:22px;height:22px;border-radius:50%;background:var(--accent);color:#fff;
  font:800 11px 'Inter',sans-serif;display:grid;place-items:center;margin:0 auto 5px}
.demo-step .ds-label{font-size:11px;font-weight:600;color:var(--ink);line-height:1.35}
.demo-step .ds-sub{font-size:10px;color:var(--muted);margin-top:2px}
.demo-foot{padding:14px 18px;display:flex;gap:10px;align-items:center;border-top:1px solid #e6eef5;background:#f7fbff}
.demo-foot p{font-size:11.5px;color:#6f7d90;flex:1}
.demo-start-btn{
  border:0;background:var(--ink);color:#fff;padding:10px 16px;
  border-radius:10px;font:700 12px 'Inter',sans-serif;cursor:pointer;
  display:flex;align-items:center;gap:8px;transition:.15s ease;white-space:nowrap;
}
.demo-start-btn:hover{background:#0a1a26;transform:translateY(-1px)}

.locate-tutorial-backdrop{
  position:fixed;
  inset:0;
  z-index:520;
  display:none;
  align-items:center;
  justify-content:center;
  padding:24px 20px 40px;
  background:rgba(10,19,31,.38);
  backdrop-filter:blur(10px);
}

.locate-tutorial-box{
  width:min(100%, 1240px);
  display:flex;
  flex-direction:column;
  align-items:center;
}

.locate-tutorial-close{
  border:0;
  background:transparent;
  color:#1b97ea;
  font:700 18px/1.2 'Inter',sans-serif;
  cursor:pointer;
  margin-bottom:14px;
  padding:6px 14px;
  border-radius:999px;
}

.locate-tutorial-close:hover{background:rgba(255,255,255,.74)}

.locate-tutorial-card{
  width:100%;
  background:rgba(255,255,255,.92);
  border-radius:32px;
  overflow:hidden;
  box-shadow:0 32px 72px rgba(17,32,54,.18);
  display:grid;
  grid-template-columns:1fr;
  justify-items:center;
  padding:26px 0 34px;
}

.locate-tutorial-caption{
  padding:18px 20px 8px;
  color:#fff;
  text-align:center;
  font-size:22px;
  font-weight:800;
  line-height:1.3;
}

.locate-tutorial-card .locate-demo-copy{display:none}
.locate-tutorial-card .locate-demo-layout{display:block}
.locate-tutorial-card .locate-demo-stage{
  width:min(100%, 430px);
  margin:0 auto;
  padding:0;
  background:transparent;
}

/* Map cursor override during drawing */
.map-wrap.drawing #mapDiv{cursor:crosshair!important}
.map-wrap.drawing .gm-style{cursor:crosshair!important}

/* Validated zone row */
.zone-validated{
  display:flex;align-items:center;gap:8px;padding:10px 12px;
  background:var(--ok-soft);border:1px solid #c9ead6;border-radius:10px;
  margin-top:12px;font-size:13px;color:#13643f;font-weight:600;
}
.zone-validated .check{width:18px;height:18px;border-radius:50%;background:var(--ok);color:#fff;display:grid;place-items:center;flex-shrink:0}
.zone-validated button{margin-left:auto;background:transparent;border:0;color:#13643f;font-weight:700;font-size:12px;cursor:pointer;text-decoration:underline;text-underline-offset:2px}
.ridge-helper{
  display:none;align-items:flex-start;gap:10px;padding:12px 13px;
  margin-top:12px;border-radius:12px;border:1px solid #d9edf9;background:#f7fbff;
  font-size:12.5px;line-height:1.45;color:var(--ink-2);
}
.ridge-helper .rh-swatches{display:flex;flex-direction:column;gap:5px;padding-top:4px;flex-shrink:0}
.ridge-helper .rh-swatches span{
  display:block;width:18px;height:4px;border-radius:999px;
}
.ridge-helper .rh-swatches span:first-child{background:#52e33f}
.ridge-helper .rh-swatches span:last-child{background:#ff3b30}
.ridge-helper strong{display:block;color:var(--ink);margin-bottom:2px}
.ridge-helper.is-selected{
  background:var(--ok-soft);
  border-color:#c9ead6;
  color:#13643f;
}
.ridge-helper.is-selected strong{color:#13643f}

.sim-note{
  margin-top:12px;
  padding:12px 14px;
  border-radius:12px;
  background:#f6fbff;
  border:1px solid #d9edf9;
  color:var(--ink-2);
  font-size:12.5px;
  line-height:1.55;
}

.sim-note strong{
  color:var(--ink);
  display:block;
  margin-bottom:3px;
}

.selection-summary{
  display:none;
  margin-top:18px;
  padding:24px 20px;
  border-radius:18px;
  border:2px solid rgba(19,166,232,.9);
  background:#fff;
  text-align:center;
}

.selection-summary .selection-label{
  font-size:18px;
  color:var(--ink-2);
  margin-bottom:8px;
}

.selection-summary .selection-value{
  font-size:54px;
  font-weight:800;
  color:var(--ink);
  letter-spacing:-.02em;
}

.locate-stage-demo{
  display:none!important;
  margin:14px 0 16px;
  padding:18px;
  border-radius:30px;
  background:
    linear-gradient(180deg,rgba(19,166,232,.06) 0%,rgba(19,166,232,.015) 100%),
    #ffffff;
  border:1px solid #dcebf8;
  box-shadow:inset 0 0 0 1px rgba(255,255,255,.82), 0 14px 30px rgba(20,40,80,.06);
}

.locate-stage-demo__panel{
  width:100%;
  margin:0 auto;
  border-radius:26px;
  overflow:hidden;
  border:1px solid rgba(19,166,232,.14);
  box-shadow:0 20px 44px rgba(17,32,54,.10);
  background:linear-gradient(180deg,#2b2c68 0%,#25265d 100%);
}

.locate-stage-demo__caption{
  margin-top:18px;
  text-align:center;
  color:#18263a;
  font-size:18px;
  font-weight:800;
  line-height:1.35;
}

.locate-stage-demo__sub{
  margin-top:10px;
  text-align:center;
  color:#728095;
  font-size:14px;
  line-height:1.55;
}

.locate-demo-layout{
  display:grid;
  grid-template-columns:320px minmax(0,1fr);
  align-items:stretch;
}

.locate-demo-copy{
  padding:34px 30px 30px;
  background:linear-gradient(180deg,#ffffff 0%,#f7fbff 100%);
  border-right:1px solid #e5eef6;
}

.locate-demo-kicker{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:8px 12px;
  border-radius:999px;
  background:#eef6fe;
  color:#4e96d9;
  font-size:12px;
  font-weight:800;
  letter-spacing:.06em;
  text-transform:uppercase;
}

.locate-demo-copy h3{
  margin:16px 0 10px;
  color:#172536;
  font-size:34px;
  line-height:1.05;
  letter-spacing:-.04em;
}

.locate-demo-copy p{
  margin:0;
  color:#627084;
  font-size:16px;
  line-height:1.6;
}

.locate-demo-steps{
  display:grid;
  gap:12px;
  margin-top:20px;
}

.locate-demo-step{
  display:flex;
  gap:12px;
  align-items:flex-start;
  padding:14px 14px 13px;
  border-radius:18px;
  background:#fff;
  border:1px solid #dbe8f5;
}

.locate-demo-step strong{
  display:grid;
  place-items:center;
  width:28px;
  height:28px;
  border-radius:50%;
  background:#ffeded;
  color:#e84c4f;
  font-size:13px;
  font-weight:800;
  flex-shrink:0;
}

.locate-demo-step span{
  color:#334054;
  font-size:14px;
  line-height:1.5;
}

.locate-demo-stage{
  padding:24px;
  background:
    radial-gradient(circle at top right,rgba(19,166,232,.12),transparent 28%),
    linear-gradient(180deg,#f1f8fe 0%,#e8f2fb 100%);
}

.locate-demo-svg{
  display:block;
  width:100%;
  height:auto;
}

.loc-stage-glow{fill:rgba(19,166,232,.12)}
.loc-stage-band{fill:rgba(255,255,255,.20)}
.loc-stage-guide{
  stroke:rgba(255,255,255,.22);
  stroke-width:3;
  stroke-dasharray:4 11;
}
.loc-roof-shadow{fill:rgba(15,34,49,.12)}
.loc-roof-wall{fill:#dfeaf4}
.loc-roof-plane{
  fill:#ffffff;
  stroke:#d9e8f6;
  stroke-width:2;
}
.loc-roof-plane.alt{fill:#f5f9fd}
.loc-roof-ridge{
  stroke:#8cc8ee;
  stroke-width:3;
  stroke-linecap:round;
}
.loc-roof-tile{
  stroke:rgba(59,168,233,.42);
  stroke-width:2.5;
  stroke-linecap:round;
}
.loc-roof-outline{
  stroke:#d6e5f3;
  stroke-width:2;
  fill:none;
}
.loc-pin-shadow{fill:rgba(0,0,0,.16)}
.loc-pin-body{fill:#ff4d4f}
.loc-pin-core{fill:#fff}
.loc-cursor{
  transform-origin:222px 228px;
  animation:locCursorFlash 3.8s ease-in-out infinite;
}
.loc-pin-ring{
  fill:none;
  stroke:rgba(255,77,79,.42);
  stroke-width:3;
  transform-origin:144px 154px;
  animation:locPinRing 2.4s ease-out infinite;
}
.loc-roof-group{
  transform-origin:140px 236px;
  animation:locHouseDrift 3.8s ease-in-out infinite;
}

@keyframes locHouseDrift{
  0%,100%{transform:translate(0px,0px) rotate(0deg)}
  22%{transform:translate(12px,-10px) rotate(5deg)}
  52%{transform:translate(22px,-2px) rotate(5deg)}
  74%{transform:translate(8px,8px) rotate(0deg)}
}

@keyframes locCursorFlash{
  0%,14%,100%{opacity:0;transform:translate(0,0) scale(.88)}
  20%,34%{opacity:1;transform:translate(0,0) scale(1)}
  48%,60%{opacity:1;transform:translate(-18px,8px) scale(1)}
  72%{opacity:0;transform:translate(-18px,8px) scale(.9)}
}

@keyframes locPinRing{
  0%{transform:scale(.55);opacity:.72}
  70%{transform:scale(1.75);opacity:0}
  100%{transform:scale(1.75);opacity:0}
}

@media (max-width: 1100px){
  .locate-tutorial-card,
  .locate-demo-layout{
    grid-template-columns:1fr;
  }
  .locate-demo-copy{
    border-right:0;
    border-bottom:1px solid #e5eef6;
  }
}

.stage-link{
  display:block;
  margin-top:14px;
  text-align:center;
  font-size:13px;
  color:var(--ink-2);
  text-decoration:none;
}

.stage-link:hover{text-decoration:underline}

.pitch-grid{
  display:grid;
  grid-template-columns:repeat(4,minmax(0,1fr));
  gap:10px;
  margin-top:18px;
}

.pitch-btn{
  min-height:84px;
  border-radius:14px;
  border:1.5px solid var(--line);
  background:#fff;
  color:var(--ink-2);
  font:800 20px/1 'Inter',sans-serif;
  cursor:pointer;
  transition:.15s ease;
}

.pitch-btn:hover{
  border-color:var(--accent);
  background:var(--accent-soft);
  color:var(--accent-deep);
}

.pitch-btn.active{
  background:#27285d;
  border-color:#27285d;
  color:#fff;
}

.pitch-help{
  margin-top:18px;
  text-align:center;
  color:var(--ink-2);
  font-size:13px;
  line-height:1.6;
}

.inclination-illustration{
  width:100%;
  max-width:320px;
  margin:4px auto 0;
  display:block;
}

.center-locator{
  position:absolute;
  left:50%;
  top:50%;
  transform:translate(-50%,-100%);
  z-index:12;
  pointer-events:none;
  display:none;
}

.center-locator svg{
  width:66px;
  height:88px;
  display:block;
  filter:drop-shadow(0 10px 18px rgba(15,34,49,.22));
}

.center-locator.visible{display:block}

.center-locator::after{
  content:"";
  position:absolute;
  left:50%;
  top:30px;
  width:24px;
  height:24px;
  border-radius:50%;
  border:2px solid rgba(255,77,79,.35);
  transform:translate(-50%,-50%);
  animation:locatorPulse 1.8s ease infinite;
}

@keyframes locatorPulse{
  0%{transform:translate(-50%,-50%) scale(.65);opacity:.85}
  70%{transform:translate(-50%,-50%) scale(2.2);opacity:0}
  100%{transform:translate(-50%,-50%) scale(2.2);opacity:0}
}

.wizard-hidden{display:none!important}

/* Undo / clear map toolbar */
.map-draw-toolbar{
  position:absolute;left:50%;bottom:80px;transform:translateX(-50%);z-index:10;
  display:flex;gap:8px;background:rgba(255,255,255,.95);
  border-radius:12px;padding:8px;box-shadow:0 4px 14px rgba(0,0,0,.18);
  backdrop-filter:blur(6px);
}
.map-draw-toolbar.hidden{display:none}
.mdt-btn{
  border:1px solid var(--line);background:#fff;border-radius:9px;
  padding:8px 14px;font:600 12.5px 'Inter',sans-serif;color:var(--ink);
  cursor:pointer;display:flex;align-items:center;gap:7px;transition:.15s ease;
}
.mdt-btn:hover{border-color:var(--accent);color:var(--accent);background:var(--accent-soft)}
.mdt-btn.danger:hover{border-color:var(--danger);color:var(--danger);background:var(--danger-soft)}

/* Custom autocomplete dropdown */
.autocomplete-list{
  position:absolute;top:calc(100% + 4px);left:0;right:0;z-index:200;
  background:#fff;border:1px solid var(--line);border-radius:11px;
  box-shadow:0 8px 32px rgba(15,34,49,.15);overflow:hidden;display:none;
}
.autocomplete-list.open{display:block}
.autocomplete-item{
  display:flex;align-items:flex-start;gap:10px;padding:11px 14px;
  cursor:pointer;border-bottom:1px solid var(--line-2);transition:.12s ease;font-size:13px;
}
.autocomplete-item:last-child{border-bottom:0}
.autocomplete-item:hover,.autocomplete-item.focused{background:var(--accent-soft)}
.autocomplete-item .ai-icon{color:var(--accent);flex-shrink:0;margin-top:1px}
.autocomplete-item .ai-label{color:var(--ink);font-weight:500;line-height:1.4}
.autocomplete-item .ai-sub{color:var(--muted);font-size:11.5px;margin-top:1px}

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
  position:relative;border-radius:18px;overflow:hidden;
  box-shadow:none;background:#1a1a2e;border:0;
  min-height:620px;
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
  position:absolute;top:26px;right:26px;z-index:10;
  display:flex;background:#fff;border-radius:18px;padding:10px;
  box-shadow:0 16px 32px rgba(17,32,54,.16);height:auto;align-items:center;gap:8px;
}
.layer-switch button{
  border:0;background:transparent;padding:14px 22px;border-radius:14px;
  font:700 16px 'Inter',sans-serif;color:var(--slate);cursor:pointer;
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
  .stepper{gap:10px}
  .step{font-size:12px}
  .step .num{width:56px;height:56px;font-size:24px}
  .step-sep{width:32px}
  .map-wrap{min-height:420px}
  #cardDraw.stage-locate{
    grid-template-columns:1fr;
    max-width:980px;
    padding:22px 18px;
  }
  #cardDraw.stage-locate #journeyMapWrap{
    grid-column:1;
    grid-row:auto;
    min-height:440px;
  }
  #cardDraw.stage-locate > div:first-child{
    align-items:center!important;
  }
  #cardDraw.stage-locate h2,
  #cardDraw.stage-locate #drawCardLead{
    text-align:center;
  }
  #cardDraw.stage-locate #drawCardLead{
    font-size:17px!important;
  }
  #cardDraw.stage-locate .surface-display,
  #cardDraw.stage-locate #surfaceMetaLabel,
  #cardDraw.stage-locate #surfaceSub{
    justify-content:center;
    text-align:center;
  }
}
@media(max-width:600px){
  .app{padding:16px 10px 32px}
  .form-row,.project-type-grid{grid-template-columns:1fr}
  .modal-summary{grid-template-columns:1fr 1fr}
  .modal-head,.modal-body{padding-left:20px;padding-right:20px}
  .pitch-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
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
      <div class="step active" id="journeyStep1"><div class="num">1</div><span>Votre toiture</span></div>
      <div class="step-sep" id="journeySep1"></div>
      <div class="step" id="journeyStep2"><div class="num">2</div><span>Votre consommation</span></div>
      <div class="step-sep" id="journeySep2"></div>
      <div class="step" id="journeyStep3"><div class="num">3</div><span>Votre résultat</span></div>
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
        <p class="lede">Saisissez votre adresse pour lancer le repérage de votre toiture.</p>

        {{-- Pill quand adresse validée --}}
        <div class="addr-pill" id="addrPill" style="display:none">
          <span class="check">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
          </span>
          <span id="addrPillText" class="truncate" style="max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"></span>
          <button class="change" id="changeAddrBtn">Modifier</button>
        </div>

        <div id="addrSearchWrap">
          <div class="addr-wrap" style="position:relative">
            <span class="addr-icon">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </span>
            <input type="text" id="addressInput" class="addr-input" placeholder="Ex. : 12 Rue de la Paix, 75002 Paris" autocomplete="off" role="combobox" aria-expanded="false" aria-autocomplete="list">
            <div class="autocomplete-list" id="autocompleteList" role="listbox"></div>
          </div>
          <button class="btn btn-primary" id="analyzeBtn" disabled>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Analyser mon toit
          </button>
        </div>
      </section>

      {{-- ── Étape 2 : Dessiner la zone ── --}}
      <section class="card" id="cardDraw" style="display:none">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:4px">
          <h2 style="font-size:16px" id="drawCardTitle">Repérons votre toiture</h2>
          <span style="background:var(--accent-soft);color:var(--accent-deep);padding:3px 10px;border-radius:999px;font-weight:700;font-size:11px;letter-spacing:.04em" id="drawModeBadge">ÉTAPE 1</span>
        </div>
        <p class="lede" style="margin-bottom:12px" id="drawCardLead">Faites glisser la carte pour placer le repère rouge sur votre toiture.</p>
        <div class="sim-note wizard-hidden" id="drawCardNote">
          <strong>Conseil</strong>
          Si votre toiture comporte plusieurs pans, faites une simulation par pan de toiture.
        </div>
        <div class="locate-stage-demo" id="locateStageDemo">
          <div class="locate-stage-demo__panel" aria-hidden="true">
            <svg class="locate-demo-svg" viewBox="0 0 280 420" xmlns="http://www.w3.org/2000/svg">
              <rect width="280" height="420" fill="#eef6fe"/>
              <circle class="loc-stage-glow" cx="226" cy="78" r="104"/>
              <rect class="loc-stage-band" x="-32" y="38" width="350" height="34" rx="6" transform="rotate(24 140 210)"/>
              <rect class="loc-stage-band" x="138" y="286" width="168" height="26" rx="6" transform="rotate(-18 220 300)"/>
              <line class="loc-stage-guide" x1="50" y1="182" x2="28" y2="282"/>
              <line class="loc-stage-guide" x1="238" y1="224" x2="220" y2="316"/>
              <g class="loc-roof-group">
                <polygon class="loc-roof-shadow" points="64,214 116,226 104,286 52,272"/>
                <polygon class="loc-roof-wall" points="118,206 166,220 154,278 104,286"/>
                <polygon class="loc-roof-plane alt" points="68,198 122,212 108,270 56,254"/>
                <polygon class="loc-roof-plane" points="122,212 170,226 156,282 108,270"/>
                <polyline class="loc-roof-outline" points="56,254 108,270 156,282"/>
                <line class="loc-roof-ridge" x1="122" y1="212" x2="108" y2="270"/>
                <line class="loc-roof-tile" x1="82" y1="210" x2="116" y2="218"/>
                <line class="loc-roof-tile" x1="76" y1="228" x2="112" y2="238"/>
                <line class="loc-roof-tile" x1="70" y1="246" x2="106" y2="256"/>
                <line class="loc-roof-tile" x1="132" y1="224" x2="162" y2="232"/>
                <line class="loc-roof-tile" x1="126" y1="242" x2="156" y2="250"/>
                <line class="loc-roof-tile" x1="120" y1="260" x2="150" y2="268"/>
              </g>
              <circle class="loc-pin-ring" cx="144" cy="154" r="16"/>
              <ellipse class="loc-pin-shadow" cx="144" cy="206" rx="18" ry="10"/>
              <path class="loc-pin-body" d="M144 118C128 118 115 131 115 147c0 20.5 29 54 29 54s29-33.5 29-54c0-16-13-29-29-29Z"/>
              <circle class="loc-pin-core" cx="144" cy="148" r="11"/>
              <path class="loc-cursor" d="M214 220L196 238L202 238L196 258L222 232L212 232L214 220Z" fill="#1FA8FF"/>
            </svg>
          </div>
          <div class="locate-stage-demo__caption">Glissez votre maison sous la punaise rouge</div>
          <div class="locate-stage-demo__sub">Placez le repère rouge sur votre toiture, puis validez l’emplacement avant de passer au tracé.</div>
        </div>

        <section class="map-wrap" id="journeyMapWrap" style="position:relative">
          <div id="mapDiv"></div>
          <div class="center-locator" id="centerLocator" aria-hidden="true">
            <svg viewBox="0 0 48 66" xmlns="http://www.w3.org/2000/svg">
              <path d="M24 0C12.4 0 3 9.4 3 21c0 15 21 45 21 45s21-30 21-45C45 9.4 35.6 0 24 0Z" fill="#ff4d4f"/>
              <circle cx="24" cy="21" r="9" fill="#fff"/>
            </svg>
          </div>

          <div class="map-loading" id="mapLoading">
            <div class="spinner"></div>
            <p id="mapLoadingText">Chargement de la carte…</p>
          </div>

          <div class="draw-hint hidden" id="drawHint">
            <span class="dot"></span>
            <span id="drawHintText">Cliquez sur la carte pour placer les premiers points</span>
          </div>

          <div class="map-draw-toolbar hidden" id="drawToolbar">
            <button class="mdt-btn" id="undoPointBtn">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7v6h6"/><path d="M21 17a9 9 0 0 0-15-6.7L3 13"/></svg>
              Annuler point
            </button>
            <button class="mdt-btn danger" id="clearDrawBtn">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
              Tout effacer
            </button>
          </div>

          <div class="map-info-bar" id="mapInfoBar">
            <div class="ico">i</div>
            <div id="mapInfoText">
              Saisissez votre adresse pour afficher votre toiture et analyser son potentiel solaire.
            </div>
          </div>
        </section>

        {{-- Toggle type --}}
        <div class="zone-toggle">
          <button class="zone-btn active" id="zoneBtnRoof" data-zone="roof">
            <span class="zb-icon">🏠</span>
            <span class="zb-label">Toiture</span>
            <span class="zb-sub">Panneaux inclinés</span>
          </button>
          <button class="zone-btn" id="zoneBtnGarden" data-zone="garden">
            <span class="zb-icon">🌿</span>
            <span class="zb-label">Sol / Jardin</span>
            <span class="zb-sub">Installation au sol</span>
          </button>
        </div>

        {{-- Surface --}}
        <div class="meta-label" id="surfaceMetaLabel">Surface tracée</div>
        <div class="surface-display">
          <span class="s-val" id="surfaceVal">0</span>
          <span class="s-unit">m²</span>
        </div>
        <div class="surface-sub" id="surfaceSub">Tracez votre zone sur la carte satellite</div>
        <div class="ridge-helper" id="ridgeHelper">
          <div class="rh-swatches" aria-hidden="true">
            <span></span>
            <span></span>
          </div>
          <div id="ridgeHelperTextWrap">
            <strong id="ridgeHelperTitle">Déterminons l'orientation de votre toiture</strong>
            <span id="ridgeHelperText">Après le tracé, cliquez sur le côté le plus haut pour orienter la toiture et placer automatiquement les panneaux dans la meilleure position.</span>
          </div>
        </div>

        {{-- Actions --}}
        <button class="btn btn-primary" id="validateZoneBtn" disabled>
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
          <span id="validateZoneBtnText">Valider mon emplacement</span>
        </button>
        <button class="btn btn-outline" id="clearZoneBtn" style="margin-top:8px">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
          <span id="clearZoneBtnLabel">Recommencer la simulation</span>
        </button>

        <div class="zone-validated" id="zoneValidatedRow" style="display:none">
          <span class="check"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
          <span>Zone validée — <span id="zoneValidatedArea">0</span> m²</span>
          <button id="editZoneBtn">Modifier</button>
        </div>
        <button class="btn btn-outline" id="addZoneBtn" style="display:none;margin-top:8px">
          Ajouter une autre zone
        </button>
        <div class="selection-summary" id="drawResultBox">
          <div class="selection-label" id="drawResultLabel">Votre toiture est exposée :</div>
          <div class="selection-value" id="drawResultValue">Sud</div>
        </div>
        <a href="{{ $restartUrl }}" class="stage-link" id="drawBackLink" style="display:none">&lt; Recommencer la simulation</a>
      </section>

      {{-- Roof recap (appears after zone validated) --}}
      <section class="card" id="cardRoof" style="display:none">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:4px">
          <h2 style="font-size:16px" id="roofStageTitle">Quelle est l'inclinaison de votre toiture ?</h2>
          <span style="background:var(--accent-soft);color:var(--accent-deep);padding:3px 10px;border-radius:999px;font-weight:700;font-size:11px;letter-spacing:.04em">ÉTAPE 1</span>
        </div>
        <p class="lede" style="margin-bottom:12px" id="roofStageLead">Si vous ne connaissez pas l'inclinaison exacte, choisissez 30°. C'est la configuration la plus courante.</p>

        <svg class="inclination-illustration" viewBox="0 0 340 180" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path d="M56 128L150 50H268L198 128H56Z" stroke="#3BA8E9" stroke-width="6" stroke-linejoin="round"/>
          <path d="M56 128V152" stroke="#3BA8E9" stroke-width="6" stroke-linecap="round"/>
          <path d="M198 128V152" stroke="#3BA8E9" stroke-width="6" stroke-linecap="round"/>
          <path d="M268 50L314 120V152" stroke="#3BA8E9" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M150 50L98 92" stroke="#3BA8E9" stroke-width="6" stroke-linecap="round"/>
          <path d="M198 128L146 92" stroke="#3BA8E9" stroke-width="6" stroke-linecap="round"/>
          <path d="M218 70H118" stroke="#9BD6F6" stroke-width="3"/>
          <path d="M232 88H132" stroke="#9BD6F6" stroke-width="3"/>
          <path d="M246 106H146" stroke="#9BD6F6" stroke-width="3"/>
          <path d="M110 70V116" stroke="#9BD6F6" stroke-width="3"/>
          <path d="M154 70V126" stroke="#9BD6F6" stroke-width="3"/>
          <path d="M198 70V126" stroke="#9BD6F6" stroke-width="3"/>
        </svg>

        <div class="pitch-grid" id="pitchGrid">
          <button type="button" class="pitch-btn" data-pitch="0">0°</button>
          <button type="button" class="pitch-btn" data-pitch="15">15°</button>
          <button type="button" class="pitch-btn active" data-pitch="30">30°</button>
          <button type="button" class="pitch-btn" data-pitch="45">45°</button>
        </div>
        <div class="pitch-help">Si vous ne connaissez pas l’inclinaison de votre toiture, choisissez 30°.</div>

        <div id="roofInfoRows"></div>

        <div class="panel-adjust-wrap" id="panelAdjustWrap" style="display:none">
          <div class="panel-adjust-head">
            <span>Ajuster les panneaux</span>
            <span class="panel-adjust-max" id="panelMaxVal">0 max</span>
          </div>
          <div class="panel-counter">
            <button type="button" class="panel-counter-btn" id="panelMinusBtn" aria-label="Réduire le nombre de panneaux">−</button>
            <div class="panel-counter-display">
              <strong id="panelCountVal">0</strong>
              <span>panneaux affichés</span>
            </div>
            <button type="button" class="panel-counter-btn" id="panelPlusBtn" aria-label="Ajouter un panneau">+</button>
          </div>
          <div class="panel-quick-picks" id="panelQuickPicks">
            <button type="button" class="panel-quick-btn" data-kwc="3">3 kWc</button>
            <button type="button" class="panel-quick-btn" data-kwc="4">4 kWc</button>
            <button type="button" class="panel-quick-btn" data-kwc="6">6 kWc</button>
            <button type="button" class="panel-quick-btn" data-kwc="9">9 kWc</button>
          </div>
          <div class="panel-adjust-sub" id="panelAdjustSub">Les panneaux restent bien disposés dans la zone utile.</div>
        </div>

        <button class="btn btn-yellow" id="quoteBtn">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
          Valider l'inclinaison de ma toiture
        </button>
        <a href="#" class="stage-link" id="roofBackBtn">&lt; Revenir à l'étape précédente</a>
      </section>

    </aside>

    {{-- ── RIGHT: results ── --}}
    <aside id="rightCol" style="display:none">
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

<div class="locate-tutorial-backdrop" id="locateTutorialOverlay" aria-hidden="true">
  <div class="locate-tutorial-box">
    <button type="button" class="locate-tutorial-close" id="locateTutorialClose">→ fermer le tutoriel</button>
    <div class="locate-tutorial-card">
      <div class="locate-demo-layout">
        <div class="locate-demo-copy">
          <div class="locate-demo-kicker">Tutoriel repérage</div>
          <h3>Placez votre toiture sous le repère rouge</h3>
          <p>Faites glisser la carte pour amener votre maison sous la punaise rouge. Une fois bien centrée, vous pourrez valider l’emplacement et commencer le tracé.</p>
          <div class="locate-demo-steps">
            <div class="locate-demo-step">
              <strong>1</strong>
              <span>Gardez le repère rouge fixe au centre de l’écran.</span>
            </div>
            <div class="locate-demo-step">
              <strong>2</strong>
              <span>Déplacez la carte jusqu’à voir votre toiture sous la punaise.</span>
            </div>
            <div class="locate-demo-step">
              <strong>3</strong>
              <span>Quand la toiture est bien calée, validez l’emplacement.</span>
            </div>
          </div>
        </div>
        <div class="locate-demo-stage" aria-hidden="true">
          <svg class="locate-demo-svg" viewBox="0 0 280 420" xmlns="http://www.w3.org/2000/svg">
            <rect width="280" height="420" fill="#eef6fe"/>
            <circle class="loc-stage-glow" cx="224" cy="80" r="108"/>
            <rect class="loc-stage-band" x="-28" y="40" width="344" height="34" rx="6" transform="rotate(24 140 210)"/>
            <rect class="loc-stage-band" x="136" y="286" width="170" height="26" rx="6" transform="rotate(-18 220 300)"/>
            <line class="loc-stage-guide" x1="48" y1="184" x2="24" y2="284"/>
            <line class="loc-stage-guide" x1="236" y1="224" x2="218" y2="314"/>
            <g class="loc-roof-group">
              <polygon class="loc-roof-shadow" points="64,214 116,226 104,286 52,272"/>
              <polygon class="loc-roof-wall" points="118,206 166,220 154,278 104,286"/>
              <polygon class="loc-roof-plane alt" points="68,198 122,212 108,270 56,254"/>
              <polygon class="loc-roof-plane" points="122,212 170,226 156,282 108,270"/>
              <polyline class="loc-roof-outline" points="56,254 108,270 156,282"/>
              <line class="loc-roof-ridge" x1="122" y1="212" x2="108" y2="270"/>
              <line class="loc-roof-tile" x1="82" y1="210" x2="116" y2="218"/>
              <line class="loc-roof-tile" x1="76" y1="228" x2="112" y2="238"/>
              <line class="loc-roof-tile" x1="70" y1="246" x2="106" y2="256"/>
              <line class="loc-roof-tile" x1="132" y1="224" x2="162" y2="232"/>
              <line class="loc-roof-tile" x1="126" y1="242" x2="156" y2="250"/>
              <line class="loc-roof-tile" x1="120" y1="260" x2="150" y2="268"/>
            </g>
            <circle class="loc-pin-ring" cx="144" cy="154" r="16"/>
            <ellipse class="loc-pin-shadow" cx="144" cy="206" rx="18" ry="10"/>
            <path class="loc-pin-body" d="M144 118C128 118 115 131 115 147c0 20.5 29 54 29 54s29-33.5 29-54c0-16-13-29-29-29Z"/>
            <circle class="loc-pin-core" cx="144" cy="148" r="11"/>
            <path class="loc-cursor" d="M214 220L196 238L202 238L196 258L222 232L212 232L214 220Z" fill="#1FA8FF"/>
          </svg>
          <div class="locate-tutorial-caption">Glissez votre maison<br>sous la punaise rouge</div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ── Popup démo ── --}}
<div class="demo-backdrop" id="demoPopup" style="display:none" role="dialog" aria-modal="true" aria-label="Comment tracer votre zone">
  <div class="demo-box">
    <div class="demo-head">
      <div>
        <h3 id="demoTitle">Comment tracer votre zone de toiture</h3>
        <p id="demoIntro">Regardez l'exemple ci-dessous, puis fermez pour commencer à tracer sur votre toiture.</p>
      </div>
      <button class="demo-close" id="demoCloseBtn" aria-label="Fermer">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>

    {{-- Démo SVG --}}
    <div class="demo-img-wrap" id="demoImgWrap">
      <div class="demo-type-badge" id="demoTypeBadge">Toiture</div>

      <svg class="demo-svg" id="demoSvg" viewBox="0 0 720 540" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
        <defs>
          <linearGradient id="demoShapeFill" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#ffffff"/>
            <stop offset="100%" stop-color="#e8eef1"/>
          </linearGradient>
          <linearGradient id="demoSceneSky" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" stop-color="#f2f8fe"/>
            <stop offset="100%" stop-color="#e6f1fb"/>
          </linearGradient>
        </defs>

        <g id="demoRoofDecor">
          <rect width="720" height="540" fill="url(#demoSceneSky)"/>
          <circle class="dp-scene-sky-glow" cx="576" cy="86" r="150"/>
          <rect class="dp-scene-band" x="-88" y="66" width="900" height="66" rx="8" transform="rotate(22 360 270)"/>
          <rect class="dp-scene-band alt" x="462" y="318" width="250" height="38" rx="8" transform="rotate(-18 586 338)"/>
          <line class="dp-scene-guide" x1="124" y1="156" x2="54" y2="432"/>
          <line class="dp-scene-guide" x1="604" y1="220" x2="560" y2="458"/>
          <g id="demoRoofBase">
            <polygon class="dp-roof-shadow" points="148,198 466,286 410,454 120,376"/>
            <polygon class="dp-roof-wall" points="466,286 544,246 486,414 410,454"/>
            <polygon class="dp-roof-plane alt" points="152,182 328,232 272,404 96,354"/>
            <polygon class="dp-roof-plane" points="328,232 506,282 446,450 272,404"/>
            <polygon class="dp-roof-highlight" points="196,202 286,226 256,320 166,294"/>
            <polyline class="dp-roof-outline" points="96,354 272,404 446,450 486,414"/>
            <line class="dp-roof-ridge" x1="328" y1="232" x2="272" y2="404"/>
            <line class="dp-roof-tile" x1="188" y1="214" x2="302" y2="246"/>
            <line class="dp-roof-tile" x1="172" y1="252" x2="286" y2="284"/>
            <line class="dp-roof-tile" x1="158" y1="290" x2="272" y2="322"/>
            <line class="dp-roof-tile" x1="144" y1="328" x2="258" y2="360"/>
            <line class="dp-roof-tile" x1="356" y1="244" x2="468" y2="276"/>
            <line class="dp-roof-tile" x1="342" y1="282" x2="454" y2="314"/>
            <line class="dp-roof-tile" x1="328" y1="320" x2="440" y2="352"/>
            <line class="dp-roof-tile" x1="314" y1="358" x2="426" y2="390"/>
          </g>
        </g>

        <g id="demoGardenDecor" style="display:none">
          <rect class="dp-scene-lawn" x="0" y="0" width="720" height="540"/>
          <rect class="dp-scene-lawn-patch" x="34" y="38" width="300" height="190" rx="28"/>
          <rect class="dp-scene-lawn-patch" x="396" y="92" width="248" height="156" rx="24"/>
          <rect class="dp-scene-lawn-patch" x="154" y="308" width="412" height="140" rx="30"/>
          <path class="dp-scene-grid" d="M0 210 H720 M0 320 H720 M150 0 V540 M310 0 V540 M490 0 V540"/>
        </g>

        <g id="demoSceneShape">
          <polygon class="dp-ghost-zone" id="dpGhostZone" points="0,0 0,0 0,0 0,0"/>
          <polygon class="dp-scene-zone shadow" id="dpShadow" points="0,0 0,0 0,0 0,0"/>
          <polygon class="dp-fill dp-scene-zone" id="dpFill" points="0,0 0,0 0,0 0,0"/>
          <polyline class="dp-line" id="dpLine" points="0,0 0,0 0,0 0,0 0,0"/>
          <polyline class="dp-selected-edge" id="dpSelectedEdge" points="0,0 0,0"/>
          <circle class="dp-dot" id="dp1" cx="0" cy="0" r="12"/>
          <circle class="dp-dot" id="dp2" cx="0" cy="0" r="12"/>
          <circle class="dp-dot" id="dp3" cx="0" cy="0" r="12"/>
          <circle class="dp-dot" id="dp4" cx="0" cy="0" r="12"/>
        </g>

        <g class="dp-cursor" id="dpCursorGroup" transform="translate(184 214)">
          <circle class="dp-cursor-pulse" cx="0" cy="0" r="18"/>
          <ellipse class="dp-cursor-shadow" cx="18" cy="28" rx="14" ry="8"/>
          <path class="dp-cursor-shape" d="M0 0L0 42L12 31L20 52L28 48L20 28L40 28L0 0Z"/>
          <circle class="dp-cursor-tip" cx="0" cy="0" r="4"/>
        </g>

        <g class="dp-badge" id="dpBadge">
          <rect id="dpBadgeRect" x="270" y="106" width="180" height="48" rx="14"/>
          <text id="dpBadgeText" x="360" y="136">4 coins à placer</text>
        </g>

        <g class="dp-caption" id="dpCaption">
          <text class="main" id="dpCaptionLine1" x="360" y="420">Cliquez sur les 4 coins</text>
          <text class="sub" id="dpCaptionLine2" x="360" y="462">du pan de toiture</text>
        </g>
      </svg>
    </div>

    {{-- Étapes --}}
    <div class="demo-steps">
      <div class="demo-step">
        <div class="ds-num">1</div>
        <div class="ds-label" id="demoStep1Label">Placez 4 points</div>
        <div class="ds-sub" id="demoStep1Sub">sur les coins du pan</div>
      </div>
      <div class="demo-step">
        <div class="ds-num">2</div>
        <div class="ds-label" id="demoStep2Label">Fermez le contour</div>
        <div class="ds-sub" id="demoStep2Sub">la zone se dessine automatiquement</div>
      </div>
      <div class="demo-step">
        <div class="ds-num">3</div>
        <div class="ds-label" id="demoStep3Label">Validez la surface</div>
        <div class="ds-sub" id="demoStep3Sub">puis passez à l’orientation</div>
      </div>
    </div>

    <div class="demo-foot">
      <p id="demoFootText">Tracez uniquement la surface utile du pan de toiture. Une fois la zone validée, vous pourrez choisir le côté le plus haut.</p>
      <button class="demo-start-btn" id="demoStartBtn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        <span id="demoStartText">Fermer et commencer</span>
      </button>
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
window.__geocodeUrl      = @json(route('api.solar.geocode'));
window.__autocompleteUrl = @json(route('api.solar.autocomplete'));
window.__step4Url = @json($step4Url);
window.__solarStep4StorageKey = 'solarSimulatorStep4';
window.__pricingSettings = @json($pricing);

// Doit être global ET défini AVANT le chargement du script Maps
window.gm_authFailure = function(){
  var msg = [
    '❌ gm_authFailure — causes possibles :',
    '1. La clé n\'autorise pas le domaine "' + location.hostname + '" (restrictions HTTP referrer)',
    '2. La Maps JavaScript API ou Places API n\'est pas activée dans Google Cloud Console',
    '3. Pas de compte de facturation lié au projet Google Cloud',
    '4. Quota dépassé',
    '',
    'URL actuelle : ' + location.href,
    'Clé utilisée : ' + (window.__mapsKey||'').slice(0,12) + '…',
  ].join('\n');
  console.error(msg);
  // Affiche dans le panneau de debug
  var p = document.getElementById('debugPanel');
  if(p){
    p.innerHTML += '<div style="background:#fdecec;border:1px solid #e23a3a;border-radius:8px;padding:10px;margin-top:6px;font-size:12px;white-space:pre-wrap;color:#c00">' + msg + '</div>';
    document.getElementById('debugContainer') && (document.getElementById('debugContainer').style.maxHeight='320px');
  }
  // Banner dans la carte
  var ml = document.getElementById('mapLoading');
  if(ml){
    ml.innerHTML = '<div style="background:rgba(226,58,58,.15);border:1px solid #e23a3a;border-radius:12px;padding:24px;max-width:440px;text-align:left">'
      + '<p style="color:#fff;font-size:18px;font-weight:800;margin-bottom:10px">⚠️ Clé API refusée</p>'
      + '<p style="color:rgba(255,255,255,.9);font-size:13px;line-height:1.6;margin-bottom:8px"><b>gm_authFailure</b> déclenché par Google Maps.</p>'
      + '<p style="color:rgba(255,255,255,.8);font-size:12.5px;line-height:1.6">Domaine testé : <b style="color:#fff">' + location.hostname + '</b><br>'
      + 'Dans Google Cloud Console → Identifiants → votre clé → ajouter :<br>'
      + '<code style="background:rgba(255,255,255,.15);padding:2px 6px;border-radius:4px">*.normesrenovation.fr/*</code><br>'
      + '<code style="background:rgba(255,255,255,.15);padding:2px 6px;border-radius:4px">http://localhost/*</code></p>'
      + '</div>';
    ml.classList.remove('hidden');
  }
};
</script>
<script>
(function(){
'use strict';

// ── State ──────────────────────────────────────────────────────────
const state = {
  lat: null, lng: null,
  address: '',
  baseResults: null,
  results: null,
  drawResults: null,
  panelLayout: null,
  roofStage: 'address',
  selectedPitch: 30,
};
const initialSolarParams = new URLSearchParams(window.location.search);
const initialSolarAddress = (initialSolarParams.get('address') || '').trim();
const initialSolarLabel = (initialSolarParams.get('label') || initialSolarAddress).trim();
const initialSolarLat = Number(initialSolarParams.get('lat'));
const initialSolarLng = Number(initialSolarParams.get('lng'));
const initialSolarKitKwc = Number(initialSolarParams.get('kit') || 0);
let preferredInitialPanelCount = initialSolarKitKwc > 0 ? panelCountFromKwc(initialSolarKitKwc) : 0;
let initialHeroSelection = null;
try {
  initialHeroSelection = JSON.parse(window.sessionStorage.getItem('solarHeroSelection') || 'null');
} catch(_error) {
  initialHeroSelection = null;
}

// ── DOM refs ────────────────────────────────────────────────────────
const $ = id => document.getElementById(id);
const addressInput = $('addressInput');
const analyzeBtn   = $('analyzeBtn');
const addrPill     = $('addrPill');
const addrPillText = $('addrPillText');
const changeAddrBtn= $('changeAddrBtn');
const addrSearchWrap = $('addrSearchWrap');
const cardAddr     = $('cardAddr');
const cardDraw     = $('cardDraw');
const cardRoof     = $('cardRoof');
const rightCol     = $('rightCol');
const mapLoading   = $('mapLoading');
const mapLoadingText = $('mapLoadingText');
const mapInfoText  = $('mapInfoText');
const centerLocator = $('centerLocator');
const locateTutorialOverlay = $('locateTutorialOverlay');
const drawCardTitle = $('drawCardTitle');
const drawCardLead = $('drawCardLead');
const drawCardNote = $('drawCardNote');
const locateStageDemo = $('locateStageDemo');
const surfaceMetaLabel = $('surfaceMetaLabel');
const clearZoneBtnLabel = $('clearZoneBtnLabel');
const ridgeHelper = $('ridgeHelper');
const ridgeHelperTitle = $('ridgeHelperTitle');
const ridgeHelperText = $('ridgeHelperText');
const validateZoneBtnText = $('validateZoneBtnText');
const drawResultBox = $('drawResultBox');
const drawResultLabel = $('drawResultLabel');
const drawResultValue = $('drawResultValue');
const drawBackLink = $('drawBackLink');
const roofStageTitle = $('roofStageTitle');
const roofStageLead = $('roofStageLead');
const roofBackBtn = $('roofBackBtn');
const pitchGrid = $('pitchGrid');
const roofInfoRows = $('roofInfoRows');
const panelAdjustWrap = $('panelAdjustWrap');
const panelMinusBtn = $('panelMinusBtn');
const panelPlusBtn = $('panelPlusBtn');
const panelCountVal = $('panelCountVal');
const panelMaxVal = $('panelMaxVal');
const panelQuickPicks = $('panelQuickPicks');
const panelAdjustSub = $('panelAdjustSub');
const addZoneBtn = $('addZoneBtn');
const quoteBtn     = $('quoteBtn');
let map, marker;
let satelliteRecoveryAttempts = 0;
let satelliteRecoveryTimer = null;

function updateBodyScrollLock(){
  const locateOpen = locateTutorialOverlay?.style.display === 'flex';
  const demoOpen = demoPopup?.style.display === 'flex';
  document.body.style.overflow = (locateOpen || demoOpen) ? 'hidden' : '';
}

function openLocateTutorial(){
  if(!locateTutorialOverlay) return;
  locateTutorialOverlay.style.display = 'flex';
  locateTutorialOverlay.setAttribute('aria-hidden', 'false');
  updateBodyScrollLock();
}

function closeLocateTutorial(){
  if(!locateTutorialOverlay) return;
  locateTutorialOverlay.style.display = 'none';
  locateTutorialOverlay.setAttribute('aria-hidden', 'true');
  updateBodyScrollLock();
}

function syncLayerSwitch(activeType){
  document.querySelectorAll('.layer-switch button').forEach(btn => {
    btn.classList.toggle('active', btn.dataset.type === activeType);
  });
}

function scheduleSatelliteRecovery(reset = false){
  if(!map) return;
  if(reset) satelliteRecoveryAttempts = 0;
  window.clearTimeout(satelliteRecoveryTimer);
  satelliteRecoveryTimer = window.setTimeout(() => {
    if(!map || state.roofStage !== 'locate' || map.getMapTypeId() !== 'satellite') return;
    const mapText = map.getDiv()?.innerText || '';
    if(!/aucune image n'est disponible/i.test(mapText)) return;

    const currentZoom = Number(map.getZoom()) || 19;
    if(currentZoom > 18 && satelliteRecoveryAttempts < 4){
      satelliteRecoveryAttempts += 1;
      map.setZoom(currentZoom - 1);
      return;
    }

    if(map.getMapTypeId() !== 'roadmap'){
      map.setMapTypeId('roadmap');
      syncLayerSwitch('roadmap');
      showToast('Imagerie satellite indisponible ici — affichage du plan pour vous repérer.', true);
    }
  }, 1400);
}

// ── Journey + roof stages ───────────────────────────────────────────
function setJourneyStep(n){
  [1,2,3].forEach(i => {
    const stepEl = $('journeyStep' + i);
    if(!stepEl) return;
    stepEl.className = 'step' + (i < n ? ' done' : i === n ? ' active' : '');
    const numEl = stepEl.querySelector('.num');
    if(numEl) numEl.textContent = i < n ? '✓' : String(i);
    if(i < 3){
      const sep = $('journeySep' + i);
      if(sep) sep.className = 'step-sep' + (i < n ? ' done' : '');
    }
  });
}

function setPitchSelection(value){
  const safeValue = Number(value) || 30;
  state.selectedPitch = safeValue;
  pitchGrid?.querySelectorAll('.pitch-btn').forEach(btn => {
    btn.classList.toggle('active', Number(btn.dataset.pitch) === safeValue);
  });
}

function setRoofStage(stage){
  state.roofStage = stage;
  if(cardDraw){
    cardDraw.classList.remove('stage-address','stage-locate','stage-surface','stage-orientation','stage-inclination');
    cardDraw.classList.add(`stage-${stage}`);
  }
  if(cardAddr) cardAddr.style.display = stage === 'address' ? 'block' : 'none';
  if(cardDraw) cardDraw.style.display = stage === 'address' || stage === 'inclination' ? 'none' : 'block';
  if(cardRoof) cardRoof.style.display = stage === 'inclination' ? 'block' : 'none';
  if(rightCol) rightCol.style.display = 'none';
  if(centerLocator) centerLocator.classList.toggle('visible', stage === 'locate');
  if(drawBackLink) drawBackLink.style.display = stage !== 'address' ? 'block' : 'none';
  if(stage !== 'locate') closeLocateTutorial();
  if(stage !== 'locate') window.clearTimeout(satelliteRecoveryTimer);

  if(drawCardNote){
    drawCardNote.classList.add('wizard-hidden');
    drawCardNote.style.display = 'none';
  }
  if(locateStageDemo) locateStageDemo.style.display = 'none';
  if(drawResultBox) drawResultBox.style.display = 'none';
  if(ridgeHelper) ridgeHelper.style.display = 'none';
  if(panelAdjustWrap) panelAdjustWrap.style.display = 'none';

  switch(stage){
    case 'address':
      if(mapInfoText) mapInfoText.innerHTML = 'Saisissez votre adresse pour afficher votre toiture et analyser son potentiel solaire.';
      break;
    case 'locate':
      if(drawCardTitle) drawCardTitle.textContent = 'Repérons votre toiture';
      if(drawCardLead) drawCardLead.textContent = 'Faites glisser la carte pour placer le repère rouge sur votre toiture.';
      if(surfaceMetaLabel) surfaceMetaLabel.textContent = 'Emplacement';
      $('surfaceVal').textContent = '1';
      $('surfaceSub').textContent = 'Placez le repère rouge sur votre toiture avant de valider.';
      if(validateZoneBtnText) validateZoneBtnText.textContent = 'Valider mon emplacement';
      if($('validateZoneBtn')) $('validateZoneBtn').disabled = false;
      if($('clearZoneBtn')) $('clearZoneBtn').style.display = 'none';
      if(clearZoneBtnLabel) clearZoneBtnLabel.textContent = 'Recommencer la simulation';
      if(mapInfoText) mapInfoText.innerHTML = '<b>Faites glisser la carte</b> pour placer le repère rouge sur votre toiture.';
      if(locateStageDemo) locateStageDemo.style.display = 'block';
      if(map) syncLayerSwitch(map.getMapTypeId() || 'satellite');
      break;
    case 'surface':
      if(drawCardTitle) drawCardTitle.textContent = 'Calculons la surface de votre toiture';
      if(drawCardLead) drawCardLead.textContent = 'Sélectionnez les 4 coins du pan de votre toiture pouvant accueillir des panneaux photovoltaïques.';
      if(drawCardNote){
        drawCardNote.classList.remove('wizard-hidden');
        drawCardNote.style.display = 'block';
        drawCardNote.innerHTML = '<strong>Astuce</strong> Vous souhaitez une installation sur plusieurs pans ? Faites une simulation par pan de toiture.';
      }
      if(surfaceMetaLabel) surfaceMetaLabel.textContent = 'Surface estimée';
      if(validateZoneBtnText) validateZoneBtnText.textContent = 'Valider la surface de ma toiture';
      if($('clearZoneBtn')) $('clearZoneBtn').style.display = '';
      if(clearZoneBtnLabel) clearZoneBtnLabel.textContent = 'Effacer et recommencer';
      if(mapInfoText) mapInfoText.innerHTML = '<b>Cliquez sur les 4 coins</b> du pan de toiture à équiper.';
      break;
    case 'orientation':
      if(drawCardTitle) drawCardTitle.textContent = 'Déterminons l\'orientation de votre toiture';
      if(drawCardLead) drawCardLead.textContent = 'Cliquez sur le côté le plus haut de votre toiture';
      if(surfaceMetaLabel) surfaceMetaLabel.textContent = 'Orientation';
      if(validateZoneBtnText) validateZoneBtnText.textContent = 'Valider l\'orientation de ma toiture';
      if($('clearZoneBtn')) $('clearZoneBtn').style.display = 'none';
      break;
    case 'inclination':
      if(roofStageTitle) roofStageTitle.textContent = 'Quelle est l\'inclinaison de votre toiture ?';
      if(roofStageLead) roofStageLead.textContent = 'Si vous ne connaissez pas l\'inclinaison exacte, choisissez 30°. C\'est la configuration la plus courante.';
      if(quoteBtn) quoteBtn.disabled = false;
      break;
  }
}

function beginLocateStage(options = {}){
  setJourneyStep(1);
  setRoofStage('locate');
  if(mapLoading) mapLoading.classList.add('hidden');
  if(cardDraw && window.innerWidth < 960){
    cardDraw.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
  if(options.showDemo === false) return;
  window.clearTimeout(beginLocateStage._demoTimer);
  beginLocateStage._demoTimer = window.setTimeout(() => {
    openLocateTutorial();
  }, Number.isFinite(options.demoDelay) ? options.demoDelay : 180);
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
const fmt1 = n => Number(n || 0).toLocaleString('fr-FR', {minimumFractionDigits:1, maximumFractionDigits:1});
const PANEL_POWER_KWC = 0.425;
const KIT_POWER_KWC = 3;
const PANELS_PER_KIT = Math.max(1, Math.round(KIT_POWER_KWC / PANEL_POWER_KWC));
const PANEL_GAP_METERS = 0.02;
const SAFETY_SETBACK_METERS = 0.5;
const PANEL_INNER_CLEARANCE_METERS = 0.08;
const PRICING = {
  roofMinPerKwc: Number(window.__pricingSettings?.roof_min_per_kwc || 2000),
  roofMaxPerKwc: Number(window.__pricingSettings?.roof_max_per_kwc || 2800),
  gardenMinPerKwc: Number(window.__pricingSettings?.garden_min_per_kwc || 1800),
  gardenMaxPerKwc: Number(window.__pricingSettings?.garden_max_per_kwc || 2400),
};

// ── Update metrics in right panel ────────────────────────────────
const azimuthToLabel = az => {
  if(az >= 337.5 || az < 22.5) return 'Nord';
  if(az < 67.5) return 'Nord-Est'; if(az < 112.5) return 'Est';
  if(az < 157.5) return 'Sud-Est'; if(az < 202.5) return 'Sud';
  if(az < 247.5) return 'Sud-Ouest'; if(az < 292.5) return 'Ouest';
  return 'Nord-Ouest';
};

function getAutoRoofSettings(){
  if(draw.zoneType === 'garden'){
    return { orientation: 'Sud', hasPitch: true, pitchDeg: 30, pitchBucket: 30 };
  }

  const manualPitch = Number.isFinite(state.selectedPitch) ? Number(state.selectedPitch) : null;

  if(state.panelLayout?.orientationLabel){
    return {
      orientation: state.panelLayout.orientationLabel,
      hasPitch: true,
      pitchDeg: manualPitch ?? 30,
      pitchBucket: manualPitch ?? 30,
    };
  }

  const seg = state.baseResults?.roofSegments?.[0] || null;
  const orientation = seg ? azimuthToLabel(seg.azimuthDeg) : 'Sud';
  const hasPitch = Number.isFinite(seg?.pitchDeg);
  const pitchSource = hasPitch ? seg.pitchDeg : null;
  const nearestPitch = [0, 15, 30, 45, 60].reduce((best, value) => {
    return Math.abs(value - (pitchSource ?? 30)) < Math.abs(best - (pitchSource ?? 30)) ? value : best;
  }, 30);

  return {
    orientation,
    hasPitch: true,
    pitchDeg: manualPitch ?? pitchSource ?? 30,
    pitchBucket: manualPitch ?? (hasPitch ? nearestPitch : 30),
  };
}

function getKitAlignedPanelCount(rawCount, maxPanels = rawCount, mode = 'floor'){
  const safeMax = Math.max(0, Number(maxPanels) || 0);
  const safeCount = Math.max(0, Math.min(Number(rawCount) || 0, safeMax));
  if(safeMax === 0) return 0;
  if(safeMax < PANELS_PER_KIT) return safeCount;
  const kitRatio = safeCount / PANELS_PER_KIT;
  if(mode === 'ceil') return Math.min(safeMax, Math.ceil(kitRatio) * PANELS_PER_KIT);
  if(mode === 'nearest') return Math.min(safeMax, Math.max(PANELS_PER_KIT, Math.round(kitRatio) * PANELS_PER_KIT));
  const floored = Math.floor(kitRatio) * PANELS_PER_KIT;
  return floored >= PANELS_PER_KIT ? floored : 0;
}

function formatPanelCountLabel(panelCount){
  const safeCount = Math.max(0, Number(panelCount) || 0);
  return `${fmt(safeCount)} panneau${safeCount > 1 ? 'x' : ''}`;
}

function formatRoofKitLabel(panelCount){
  const safeCount = Math.max(0, Number(panelCount) || 0);
  const kitCount = safeCount >= PANELS_PER_KIT ? Math.round(safeCount / PANELS_PER_KIT) : 0;
  if(kitCount > 0 && safeCount % PANELS_PER_KIT === 0){
    return `${kitCount} kit${kitCount > 1 ? 's' : ''} de ${KIT_POWER_KWC} kWc`;
  }
  return formatPanelCountLabel(safeCount);
}

function panelCountFromKwc(targetKwc){
  const safeKwc = Number(targetKwc) || 0;
  if(safeKwc === 3) return 8;
  const rawPanels = Math.round(safeKwc / PANEL_POWER_KWC);
  return Math.max(1, rawPanels);
}

function getRoofDefaultPanelCount(maxPanels){
  const maxSelectable = getKitAlignedPanelCount(maxPanels, maxPanels, 'floor');
  if(maxSelectable >= PANELS_PER_KIT * 3) return PANELS_PER_KIT * 3;
  if(maxSelectable >= PANELS_PER_KIT * 2) return PANELS_PER_KIT * 2;
  if(maxSelectable >= PANELS_PER_KIT) return PANELS_PER_KIT;
  return maxPanels;
}

// ── Panneaux solaires en grille dans le polygone dessiné ──────────
let solarPanelOverlays = [];
let solarSafetyBandOverlay = null;
let solarSafetyOutline = null;
let solarUsableAreaOverlay = null;
let solarUsableAreaOutline = null;
let ridgeSelectionOverlays = [];

function clearSolarPanels(){
  solarPanelOverlays.forEach(p => p.setMap(null));
  solarPanelOverlays = [];
}

function clearRidgeSelection(){
  ridgeSelectionOverlays.forEach(overlay => overlay.setMap(null));
  ridgeSelectionOverlays = [];
}

function clearOverlayEntry(entry){
  if(Array.isArray(entry)){
    entry.forEach(clearOverlayEntry);
    return;
  }
  entry?.setMap?.(null);
}

function clearSafetyZone(){
  [solarSafetyBandOverlay, solarSafetyOutline, solarUsableAreaOverlay, solarUsableAreaOutline].forEach(clearOverlayEntry);
  solarSafetyBandOverlay = null;
  solarSafetyOutline = null;
  solarUsableAreaOverlay = null;
  solarUsableAreaOutline = null;
}

function clearPanelLayout(){
  clearSolarPanels();
  clearSafetyZone();
  state.panelLayout = null;
}

function hidePanelSlider(){
  const wrap = $('panelSliderWrap');
  if(wrap) wrap.style.display = 'none';
  if(panelAdjustWrap) panelAdjustWrap.style.display = 'none';
  if(panelCountVal) panelCountVal.textContent = '0';
  if(panelMaxVal) panelMaxVal.textContent = '0 max';
  if(panelAdjustSub) panelAdjustSub.textContent = 'Les panneaux restent bien disposés dans la zone utile.';
  if(panelMinusBtn) panelMinusBtn.disabled = true;
  if(panelPlusBtn) panelPlusBtn.disabled = true;
  panelQuickPicks?.querySelectorAll('.panel-quick-btn').forEach(btn => {
    btn.disabled = true;
    btn.classList.remove('active');
  });
}

function updatePanelAdjustUi(){
  const layout = state.panelLayout;
  if(!layout || layout.maxPanels < 1){
    hidePanelSlider();
    return;
  }

  const maxSelectable = layout.selectableMaxPanels ?? layout.maxPanels;
  const count = Math.max(0, Math.min(layout.activeCount ?? maxSelectable, maxSelectable));
  if(panelAdjustWrap) panelAdjustWrap.style.display = 'block';
  if(panelCountVal) panelCountVal.textContent = fmt(count);
  if(panelMaxVal) panelMaxVal.textContent = `${fmt(maxSelectable)} max`;
  if(panelAdjustSub){
    panelAdjustSub.textContent = `Choisissez le nombre de panneaux. La ligne jaune garde un espace libre tout autour.`;
  }
  if(panelMinusBtn) panelMinusBtn.disabled = count <= 0;
  if(panelPlusBtn) panelPlusBtn.disabled = count >= maxSelectable;
  panelQuickPicks?.querySelectorAll('.panel-quick-btn').forEach(btn => {
    const targetPanels = panelCountFromKwc(btn.dataset.kwc);
    const available = targetPanels <= maxSelectable;
    btn.disabled = !available;
    btn.classList.toggle('active', available && count === targetPanels);
  });
}

function stepPanelCount(delta){
  const layout = state.panelLayout;
  if(!layout) return;
  applyValidatedLayout((layout.activeCount ?? 0) + delta);
}

function bindPanelAdjustPress(el, handler){
  if(!el) return;
  const onPress = (event) => {
    event.preventDefault();
    event.stopPropagation();
    handler();
  };
  el.addEventListener('click', onPress);
  el.addEventListener('touchend', onPress, { passive: false });
}

function closePolylinePath(points){
  if(!points?.length) return [];
  return [...points, points[0]];
}

function pointInsideOrOnEdge(point, polygon){
  return google.maps.geometry.poly.containsLocation(point, polygon)
    || google.maps.geometry.poly.isLocationOnEdge(point, polygon, 1e-9);
}

function normalizeAngleRad(angle){
  let next = angle;
  while(next <= -Math.PI) next += Math.PI * 2;
  while(next > Math.PI) next -= Math.PI * 2;
  return next;
}

function angleDiffRad(a, b){
  return Math.abs(normalizeAngleRad(a - b));
}

function orientationLabelFromAzimuth(azimuth){
  return azimuthToLabel((azimuth + 360) % 360);
}

function ridgeOrientationFromEdge(edgePoints, polygonPoints){
  if(!edgePoints?.length || edgePoints.length < 2 || !polygonPoints?.length) return 'Sud';
  const p1 = edgePoints[0];
  const p2 = edgePoints[1];
  const center = polygonPoints.reduce((acc, point) => ({
    lat: acc.lat + point.lat(),
    lng: acc.lng + point.lng(),
  }), { lat: 0, lng: 0 });
  center.lat /= polygonPoints.length;
  center.lng /= polygonPoints.length;

  const midLat = (p1.lat() + p2.lat()) / 2;
  const midLng = (p1.lng() + p2.lng()) / 2;
  const latDiff = center.lat - midLat;
  const lngDiff = center.lng - midLng;
  const azimuth = (Math.atan2(lngDiff, latDiff) * 180 / Math.PI + 360) % 360;
  return orientationLabelFromAzimuth(azimuth);
}

function getRidgeEdgePoints(points, ridgeEdgeIndex){
  if(!Array.isArray(points) || points.length < 2 || !Number.isInteger(ridgeEdgeIndex)) return null;
  const safeIndex = ((ridgeEdgeIndex % points.length) + points.length) % points.length;
  return [points[safeIndex], points[(safeIndex + 1) % points.length]];
}

function getDefaultRidgeEdgeIndex(points){
  if(!Array.isArray(points) || points.length < 2) return null;
  let bestIndex = 0;
  let bestLat = -Infinity;
  points.forEach((point, index) => {
    const nextPoint = points[(index + 1) % points.length];
    const avgLat = (point.lat() + nextPoint.lat()) / 2;
    if(avgLat > bestLat){
      bestLat = avgLat;
      bestIndex = index;
    }
  });
  return bestIndex;
}

// ── Intersection de deux droites (en mètres) ─────────────────────
function lineIntersectM(p1, p2, p3, p4){
  const d1x = p2.x-p1.x, d1y = p2.y-p1.y;
  const d2x = p4.x-p3.x, d2y = p4.y-p3.y;
  const den = d1x*d2y - d1y*d2x;
  if(Math.abs(den) < 1e-10) return {x:(p1.x+p3.x)/2, y:(p1.y+p3.y)/2};
  const t = ((p3.x-p1.x)*d2y - (p3.y-p1.y)*d2x) / den;
  return {x: p1.x + t*d1x, y: p1.y + t*d1y};
}

/**
 * Applique un retrait (inset) de `insetM` mètres à l'intérieur du polygone.
 * Chaque arête est décalée vers l'intérieur, puis les nouvelles arêtes sont intersectées.
 */
function insetPolygonM(polyPoints, insetM){
  const n = polyPoints.length;
  if(n < 3) return polyPoints;
  const centLat = polyPoints.reduce((s,p) => s+p.lat(),0)/n;
  const centLng = polyPoints.reduce((s,p) => s+p.lng(),0)/n;
  const mPerLat = 111320;
  const mPerLng = 111320 * Math.cos(centLat * Math.PI/180);

  // Convertir en mètres
  const pts = polyPoints.map(p => ({
    x: (p.lng()-centLng)*mPerLng,
    y: (p.lat()-centLat)*mPerLat
  }));

  // Orientation du polygone (aire signée)
  let area = 0;
  for(let i=0;i<n;i++){ const j=(i+1)%n; area += pts[i].x*pts[j].y - pts[j].x*pts[i].y; }
  const isCCW = area > 0;

  // Décaler chaque arête vers l'intérieur
  const offEdges = pts.map((p, i) => {
    const q = pts[(i+1)%n];
    const dx = q.x-p.x, dy = q.y-p.y;
    const len = Math.sqrt(dx*dx+dy*dy) || 1;
    const nx = isCCW ?  dy/len : -dy/len;
    const ny = isCCW ? -dx/len :  dx/len;
    return {
      p1: {x: p.x+nx*insetM, y: p.y+ny*insetM},
      p2: {x: q.x+nx*insetM, y: q.y+ny*insetM},
    };
  });

  // Intersections des arêtes décalées consécutives
  return offEdges.map((e, i) => {
    const prev = offEdges[(i+n-1)%n];
    const pt   = lineIntersectM(prev.p1, prev.p2, e.p1, e.p2);
    return new google.maps.LatLng(
      centLat + pt.y/mPerLat,
      centLng + pt.x/mPerLng
    );
  });
}

/**
 * Génère une grille de panneaux à l'intérieur du polygone dessiné.
 * - Retrait de sécurité de 0.5 m sur tous les bords
 * - Alignement sur la ligne de faîtage sélectionnée si disponible
 * - Taille réelle des panneaux (panelH × panelW en mètres)
 */
function computePanelLayoutVariant(insetPts, panelH, panelW, gap, orientationMode, outerPts, preferredAngle = null){
  const centLat = insetPts.reduce((s,p) => s+p.lat(),0)/insetPts.length;
  const centLng = insetPts.reduce((s,p) => s+p.lng(),0)/insetPts.length;
  const mPerLat = 111320;
  const mPerLng = 111320 * Math.cos(centLat * Math.PI/180);
  const insetPoly = new google.maps.Polygon({ paths: insetPts });
  const outerPoly = outerPts?.length >= 3 ? new google.maps.Polygon({ paths: outerPts }) : null;

  let angle = preferredAngle;
  if(angle === null){
    let maxLen = 0;
    angle = 0;
    for(let i=0;i<insetPts.length;i++){
      const p1 = insetPts[i], p2 = insetPts[(i+1)%insetPts.length];
      const dlat = (p2.lat()-p1.lat())*mPerLat;
      const dlng = (p2.lng()-p1.lng())*mPerLng;
      const len  = Math.sqrt(dlat*dlat+dlng*dlng);
      if(len > maxLen){ maxLen = len; angle = Math.atan2(dlng, dlat); }
    }
  }

  // Rotation locale autour du centroïde
  const rot = (lat, lng, a) => {
    const dy = (lat-centLat)*mPerLat, dx = (lng-centLng)*mPerLng;
    const cos = Math.cos(a), sin = Math.sin(a);
    return { lat: centLat+(dy*cos-dx*sin)/mPerLat, lng: centLng+(dy*sin+dx*cos)/mPerLng };
  };

  // 3. Pivoter le polygone inset pour aligner sur l'axe
  const rotPoly = insetPts.map(p => rot(p.lat(), p.lng(), -angle));
  const minLat  = Math.min(...rotPoly.map(p=>p.lat));
  const maxLat  = Math.max(...rotPoly.map(p=>p.lat));
  const minLng  = Math.min(...rotPoly.map(p=>p.lng));
  const maxLng  = Math.max(...rotPoly.map(p=>p.lng));

  const hDeg   = panelH/mPerLat,  wDeg  = panelW/mPerLng;
  const gapLat = gap/mPerLat,     gapLng = gap/mPerLng;
  const stepH  = hDeg+gapLat,     stepW  = wDeg+gapLng;
  const boxHeight = maxLat - minLat;
  const boxWidth  = maxLng - minLng;
  const rowCount  = Math.max(1, Math.floor((boxHeight - hDeg) / stepH) + 1);
  const colCount  = Math.max(1, Math.floor((boxWidth - wDeg) / stepW) + 1);
  const gridHeight = hDeg + ((rowCount - 1) * stepH);
  const gridWidth  = wDeg + ((colCount - 1) * stepW);
  const startLat = ((minLat + maxLat) / 2) - (gridHeight / 2) + (hDeg / 2);
  const startLng = ((minLng + maxLng) / 2) - (gridWidth / 2) + (wDeg / 2);
  const centerLat = (minLat + maxLat) / 2;
  const centerLng = (minLng + maxLng) / 2;

  // Générer la grille et s'assurer que chaque panneau rentre entièrement dans la zone utile
  const panels = [];
  for(let row=0; row<rowCount; row++){
    const lat = startLat + (row * stepH);
    for(let col=0; col<colCount; col++){
      const lng = startLng + (col * stepW);
      const corners = [
        rot(lat-hDeg/2, lng-wDeg/2, angle),
        rot(lat-hDeg/2, lng+wDeg/2, angle),
        rot(lat+hDeg/2, lng+wDeg/2, angle),
        rot(lat+hDeg/2, lng-wDeg/2, angle),
      ];
      const cornerPoints = corners.map(c => new google.maps.LatLng(c.lat, c.lng));
      if(!cornerPoints.every(point => pointInsideOrOnEdge(point, insetPoly))) continue;
      if(outerPoly && !cornerPoints.every(point => pointInsideOrOnEdge(point, outerPoly))) continue;
      panels.push({
        corners,
        centerDist: Math.hypot(lat - centerLat, lng - centerLng),
        rowOffset: Math.abs(row - ((rowCount - 1) / 2)),
        colOffset: Math.abs(col - ((colCount - 1) / 2)),
      });
    }
  }

  return {
    panels: panels
      .sort((a, b) => (
        a.centerDist - b.centerDist
        || a.rowOffset - b.rowOffset
        || a.colOffset - b.colOffset
      ))
      .map(panel => panel.corners),
    panelHeightMeters: panelH,
    panelWidthMeters: panelW,
    orientationMode,
  };
}

function generatePanelsInPolygon(polyPoints, panelH, panelW, gap = PANEL_GAP_METERS, setbackM = SAFETY_SETBACK_METERS, ridgeEdgeIndex = null){
  if(!polyPoints || polyPoints.length < 3) return { panels: [], insetPoints: [] };

  const insetPts = insetPolygonM(polyPoints, setbackM);
  if(!insetPts || insetPts.length < 3) return { panels: [], insetPoints: [] };
  const panelPlacementPts = insetPolygonM(polyPoints, setbackM + PANEL_INNER_CLEARANCE_METERS);
  const panelAreaPts = panelPlacementPts?.length >= 3 ? panelPlacementPts : insetPts;

  const ridgeEdgePoints = getRidgeEdgePoints(polyPoints, ridgeEdgeIndex);
  const preferredAngle = ridgeEdgePoints
    ? Math.atan2(
        (ridgeEdgePoints[1].lng() - ridgeEdgePoints[0].lng()) * Math.cos(((ridgeEdgePoints[1].lat() + ridgeEdgePoints[0].lat()) / 2) * Math.PI / 180),
        ridgeEdgePoints[1].lat() - ridgeEdgePoints[0].lat()
      )
    : null;
  const variants = [
    computePanelLayoutVariant(panelAreaPts, panelW, panelH, gap, 'landscape', polyPoints, preferredAngle),
    computePanelLayoutVariant(panelAreaPts, panelH, panelW, gap, 'portrait', polyPoints, preferredAngle),
  ];
  const bestVariant = variants.find(variant => variant.panels.length > 0) || variants[0];

  return {
    ...(bestVariant || {
      panels: [],
      panelHeightMeters: panelH,
      panelWidthMeters: panelW,
      orientationMode: 'landscape',
    }),
    insetPoints: insetPts,
    panelPlacementPoints: panelAreaPts,
    safetyInsetMeters: setbackM,
    panelInnerClearanceMeters: PANEL_INNER_CLEARANCE_METERS,
    ridgeEdgeIndex,
    ridgeEdgePoints,
    orientationLabel: ridgeOrientationFromEdge(ridgeEdgePoints, polyPoints),
  };
}

function buildLayoutForZone(zoneDefinition, panelHeightMeters, panelWidthMeters){
  const zonePoints = Array.isArray(zoneDefinition) ? zoneDefinition : zoneDefinition?.points;
  const ridgeEdgeIndex = Array.isArray(zoneDefinition) ? null : zoneDefinition?.ridgeEdgeIndex ?? null;
  const zoneLayout = generatePanelsInPolygon(zonePoints, panelHeightMeters, panelWidthMeters, PANEL_GAP_METERS, SAFETY_SETBACK_METERS, ridgeEdgeIndex);
  return {
    ...zoneLayout,
    originalPoints: zonePoints,
    totalAreaM2: computeAreaM2(zonePoints),
    usableAreaM2: zoneLayout.insetPoints?.length >= 3 ? computeAreaM2(zoneLayout.insetPoints) : computeAreaM2(zonePoints),
  };
}

function buildCombinedPanelLayout(zoneDefinitions, panelHeightMeters, panelWidthMeters){
  const zoneLayouts = zoneDefinitions
    .filter(zone => {
      const points = Array.isArray(zone) ? zone : zone?.points;
      return Array.isArray(points) && points.length >= 3;
    })
    .map(zone => buildLayoutForZone(zone, panelHeightMeters, panelWidthMeters));
  const orientationCounts = zoneLayouts.reduce((acc, zone) => {
    const key = zone.orientationLabel || '';
    if(!key) return acc;
    acc[key] = (acc[key] || 0) + 1;
    return acc;
  }, {});
  const orientationLabel = Object.entries(orientationCounts)
    .sort((a, b) => b[1] - a[1])[0]?.[0] || null;

  return {
    zoneLayouts,
    panels: zoneLayouts.flatMap(zone => zone.panels || []),
    totalAreaM2: zoneLayouts.reduce((sum, zone) => sum + (zone.totalAreaM2 || 0), 0),
    usableAreaM2: zoneLayouts.reduce((sum, zone) => sum + (zone.usableAreaM2 || 0), 0),
    safetyInsetMeters: SAFETY_SETBACK_METERS,
    panelInnerClearanceMeters: PANEL_INNER_CLEARANCE_METERS,
    orientationLabel,
  };
}

function drawSafetyZone(layout){
  clearSafetyZone();
  if(!map) return;
  const zoneLayouts = layout?.zoneLayouts?.length ? layout.zoneLayouts : [];
  if(!zoneLayouts.length) return;

  const overlays = [];
  zoneLayouts.forEach(zone => {
    if(!zone.insetPoints?.length || !zone.originalPoints?.length) return;
    overlays.push(
      new google.maps.Polygon({
        paths: [zone.originalPoints, [...zone.insetPoints].reverse()],
        strokeOpacity: 0,
        fillColor: '#f5c400',
        fillOpacity: 0.22,
        map,
        clickable: false,
        zIndex: 2,
      }),
      new google.maps.Polygon({
        paths: zone.insetPoints,
        strokeOpacity: 0,
        fillColor: '#ff3b30',
        fillOpacity: 0.06,
        map,
        clickable: false,
        zIndex: 2,
      }),
      new google.maps.Polyline({
        path: closePolylinePath(zone.insetPoints),
        strokeColor: '#f5c400',
        strokeOpacity: 0,
        strokeWeight: 3,
        icons: [{
          icon: {
            path: 'M 0,-1 0,1',
            strokeColor: '#f5c400',
            strokeOpacity: 1,
            scale: 4,
          },
          offset: '0',
          repeat: '12px',
        }],
        map,
        clickable: false,
        zIndex: 4,
      }),
      new google.maps.Polyline({
        path: closePolylinePath(zone.insetPoints),
        strokeColor: '#ff3b30',
        strokeOpacity: 1,
        strokeWeight: 4,
        map,
        clickable: false,
        zIndex: 4,
      })
    );
  });

  [solarSafetyBandOverlay, solarUsableAreaOverlay, solarSafetyOutline, solarUsableAreaOutline] = overlays;
}

function drawSolarPanelsOnMap(layout, limitCount = layout?.panels?.length ?? 0){
  clearSolarPanels();
  drawSafetyZone(layout);
  if(!map || !layout?.panels?.length) return 0;

  const visibleCount = Math.max(0, Math.min(limitCount, layout.panels.length));
  layout.panels.slice(0, visibleCount).forEach(corners => {
    const poly = new google.maps.Polygon({
      paths: corners,
      strokeColor:   '#0d2b52',
      strokeOpacity: 1,
      strokeWeight:  1,
      fillColor:     '#1a4f8c',
      fillOpacity:   0.82,
      map, clickable: false, zIndex: 4,
    });
    solarPanelOverlays.push(poly);
  });

  return visibleCount;
}

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

  const seg = draw.zoneType === 'garden'
    ? null
    : (r.roofSegments?.[0] || state.baseResults?.roofSegments?.[0] || null);
  const autoRoof = getAutoRoofSettings();
  const orientationText = state.panelLayout?.orientationLabel
    ? state.panelLayout.orientationLabel
    : (seg ? azimuthToLabel(seg.azimuthDeg) : null);
  const surfaceLabel = Number.isFinite(r.usableAreaM2) ? 'Surface disponible' : 'Surface sélectionnée';
  const surfaceValue = Number.isFinite(r.usableAreaM2)
    ? `${fmt(r.usableAreaM2)} m²`
    : `${fmt(r.areaM2 || 0)} m²`;

  roofInfoRows.innerHTML = `
    <div class="roof-info-row">
      <div class="ri-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 11 12 2 21 11"/><path d="M3 11v10h5v-7h8v7h5V11"/></svg></div>
      <div><div class="ri-label">${surfaceLabel}</div><div class="ri-val">${surfaceValue}</div></div>
    </div>
    <div class="roof-info-row">
      <div class="ri-icon">🔷</div>
      <div><div class="ri-label">Calepinage</div><div class="ri-val">${draw.zoneType === 'roof' ? formatRoofKitLabel(r.panelCount || 0) : formatPanelCountLabel(r.panelCount || 0)} disposés dans la zone utile</div></div>
    </div>
    ${orientationText ? `
    <div class="roof-info-row">
      <div class="ri-icon">🧭</div>
      <div><div class="ri-label">Orientation détectée</div><div class="ri-val">${orientationText}${seg?.sunshineAvg ? ` · ${seg.sunshineAvg} h/an` : ''}</div></div>
    </div>` : ''}
    ${r.sunshineHoursPerYear ? `
    <div class="roof-info-row">
      <div class="ri-icon">☀️</div>
      <div><div class="ri-label">Ensoleillement</div><div class="ri-val">${fmt(r.sunshineHoursPerYear)} h/an</div></div>
    </div>` : ''}
    ${r.co2SavingsMwh ? `
    <div class="roof-info-row">
      <div class="ri-icon">🌿</div>
      <div><div class="ri-label">CO₂ évité/an</div><div class="ri-val">${r.co2SavingsMwh} MWh</div></div>
    </div>` : ''}`;

  // Panneaux solaires stockés — affichés après validation de la zone
  // (voir validateZone())

  if(!state.panelLayout) hidePanelSlider();
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
async function fetchSolarData(options = {}){
  const background = !!options.background;
  const skipLocateStage = !!options.skipLocateStage;
  const requestTimeoutMs = Number(options.timeoutMs || 8000);
  if(!background){
    mapLoading.classList.remove('hidden');
    mapLoadingText.textContent = 'Analyse du potentiel solaire…';
  }

  const controller = typeof AbortController !== 'undefined' ? new AbortController() : null;
  const timeoutId = controller ? window.setTimeout(() => controller.abort(), requestTimeoutMs) : null;

  try {
    const resp = await fetch(window.__estimateUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': window.__csrfToken,
        'Accept': 'application/json',
      },
      signal: controller?.signal,
      body: JSON.stringify({ lat: state.lat, lng: state.lng }),
    });

    const data = await resp.json();

    if(!resp.ok || data.error){
      throw new Error(data.error || 'Erreur serveur');
    }

    state.baseResults = data;
    state.results = data;
    state.drawResults = null;
    state.panelLayout = null;
    displayResults(data);

    if(!background){
      showToast('Adresse analysée — positionnez votre toiture sous le repère rouge.');
    }
    if(!skipLocateStage){
      beginLocateStage({ forceDemo: true, demoDelay: 250 });
    }

  } catch(e){
    const message = e?.name === 'AbortError'
      ? 'Temps de réponse dépassé — mode dessin direct'
      : e.message;
    dbg('WARN', 'Solar API indisponible — mode estimation locale', message);
    if(!background){
      showToast('Adresse chargée — positionnez votre toiture sur la carte', false);
    }
    if(!skipLocateStage){
      beginLocateStage({ forceDemo: true, demoDelay: 250 });
    }
  } finally {
    if(timeoutId){
      window.clearTimeout(timeoutId);
    }
    if(!background){
      mapLoading.classList.add('hidden');
    }
  }
}

// ── Drawing state ─────────────────────────────────────────────────
const draw = {
  active: false,       // mode dessin actif
  validated: false,    // zone validée
  zoneType: 'roof',   // 'roof' | 'garden'
  points: [],          // google.maps.LatLng[]
  ridgeEdgeIndex: null,
  polygon: null,       // google.maps.Polygon
  markers: [],         // vertex markers
  zones: [],           // zones validées [{ points, polygon, markers }]
  clickListener: null,
};

// Surface au sol en m² via Shoelace + conversion lat/lng
function computeAreaM2(latLngs){
  const n = latLngs.length;
  if(n < 3) return 0;
  const R = 6371000;
  let area = 0;
  for(let i = 0; i < n; i++){
    const p1 = latLngs[i], p2 = latLngs[(i+1) % n];
    const φ1 = p1.lat() * Math.PI/180, φ2 = p2.lat() * Math.PI/180;
    const λ1 = p1.lng() * Math.PI/180, λ2 = p2.lng() * Math.PI/180;
    area += (λ2 - λ1) * (2 + Math.sin(φ1) + Math.sin(φ2));
  }
  return Math.abs(area * R * R / 2);
}

function getValidatedZonesAreaM2(){
  return draw.zones.reduce((sum, zone) => sum + computeAreaM2(zone.points), 0);
}

function getAllZonePoints(){
  return draw.zones.map(zone => ({
    points: zone.points,
    ridgeEdgeIndex: zone.ridgeEdgeIndex ?? null,
    zoneType: zone.zoneType ?? draw.zoneType,
  }));
}

function requiresRidgeSelection(){
  return state.roofStage === 'orientation' && draw.zoneType === 'roof' && draw.points.length >= 3;
}

// Calcul panneaux depuis surface tracée
function panelsFromArea(m2, zoneType){
  // Roof: 1.7m² / panneau (1.722m × 1.013m standard)
  // Garden: 2.5m² / panneau (inter-rangs inclus)
  const m2PerPanel = zoneType === 'garden' ? 2.5 : 1.7;
  return Math.max(1, Math.floor(m2 / m2PerPanel));
}

function updateDrawUI(){
  if(state.roofStage === 'locate'){
    $('surfaceVal').textContent = '1';
    $('surfaceSub').textContent = 'Validez la position avant de tracer votre pan de toiture.';
    $('validateZoneBtn').disabled = false;
    if(validateZoneBtnText) validateZoneBtnText.textContent = 'Valider mon emplacement';
    $('drawToolbar')?.classList.add('hidden');
    $('drawHint')?.classList.add('hidden');
    if(ridgeHelper){
      ridgeHelper.style.display = 'none';
      ridgeHelper.classList.remove('is-selected');
    }
    return;
  }

  if(draw.points.length < 3){
    draw.ridgeEdgeIndex = null;
  } else if(Number.isInteger(draw.ridgeEdgeIndex) && draw.ridgeEdgeIndex >= draw.points.length){
    draw.ridgeEdgeIndex = null;
  }

  const currentAreaM2 = computeAreaM2(draw.points);
  const totalAreaM2 = getValidatedZonesAreaM2() + currentAreaM2;
  const rounded = Math.round(totalAreaM2);
  $('surfaceVal').textContent = rounded;
  const needsRidgeSelection = requiresRidgeSelection();
  const ridgeSelected = Number.isInteger(draw.ridgeEdgeIndex);
  const requiresFourCorners = state.roofStage === 'surface';
  const enoughCorners = requiresFourCorners ? draw.points.length >= 4 : draw.points.length >= 3;
  const selectedOrientation = ridgeSelected
    ? ridgeOrientationFromEdge(getRidgeEdgePoints(draw.points, draw.ridgeEdgeIndex), draw.points)
    : null;

  if(!enoughCorners){
    $('surfaceSub').textContent = draw.points.length === 0
      ? 'Tracez votre zone sur la carte satellite'
      : draw.points.length === 1
      ? 'Cliquez sur un deuxième coin de toiture…'
      : draw.points.length === 2
      ? 'Encore deux coins pour dessiner la surface…'
      : 'Encore un coin pour terminer la surface…';
    $('validateZoneBtn').disabled = true;
    if(validateZoneBtnText) validateZoneBtnText.textContent = state.roofStage === 'orientation'
      ? 'Valider l\'orientation de ma toiture'
      : 'Valider la surface de ma toiture';
  } else if(needsRidgeSelection && !ridgeSelected){
    $('surfaceSub').textContent = 'Cliquez sur le côté le plus haut pour orienter la toiture et placer les panneaux dans le meilleur sens.';
    $('validateZoneBtn').disabled = true;
    if(validateZoneBtnText) validateZoneBtnText.textContent = 'Sélectionnez le côté le plus haut';
  } else {
    if(state.roofStage === 'orientation'){
      $('surfaceSub').textContent = 'Le côté haut est sélectionné. Vous pouvez confirmer l’orientation.';
    } else {
      const panels = panelsFromArea(totalAreaM2, draw.zoneType);
      const kwc    = (panels * 0.425).toFixed(2);
      $('surfaceSub').textContent = `≈ ${formatPanelCountLabel(panels)} · ${kwc} kWc`;
    }
    $('validateZoneBtn').disabled = false;
    if(validateZoneBtnText) validateZoneBtnText.textContent = state.roofStage === 'orientation'
      ? 'Valider l\'orientation de ma toiture'
      : 'Valider la surface de ma toiture';
  }

  // Toolbar visibility
  const toolbar = $('drawToolbar');
  if(draw.points.length > 0 && !draw.validated) toolbar.classList.remove('hidden');
  else toolbar.classList.add('hidden');

  // Draw hint
  const hint = $('drawHint');
  hint.classList.remove('attention', 'success');
  if(state.roofStage === 'surface' && !draw.validated && draw.points.length === 0){
    hint.classList.remove('hidden');
    $('drawHintText').textContent = 'Cliquez sur les 4 coins du pan de toiture';
  } else if(!draw.validated && needsRidgeSelection && !ridgeSelected){
    hint.classList.remove('hidden');
    hint.classList.add('attention');
    $('drawHintText').textContent = 'Cliquez sur le côté le plus haut pour bien orienter les panneaux';
  } else if(!draw.validated && needsRidgeSelection && ridgeSelected){
    hint.classList.remove('hidden');
    hint.classList.add('success');
    $('drawHintText').textContent = 'Côté haut sélectionné — vous pouvez valider';
  } else {
    hint.classList.add('hidden');
  }

  if(mapInfoText && !draw.validated){
    if(state.roofStage === 'surface' && draw.points.length === 0){
      mapInfoText.innerHTML = '<b>Cliquez sur les 4 coins</b> du pan de toiture à équiper.';
    } else if(needsRidgeSelection && !ridgeSelected){
      mapInfoText.innerHTML = '<b>Cliquez sur le côté le plus haut</b> pour définir l’orientation de la toiture et positionner vos panneaux au mieux.';
    } else if(needsRidgeSelection && ridgeSelected){
      mapInfoText.innerHTML = '<b>Côté haut sélectionné</b> — validez l’orientation de votre toiture.';
    } else if(!enoughCorners){
      mapInfoText.innerHTML = '<b>Continuez le tracé</b> en cliquant point par point sur la zone utile.';
    } else {
      mapInfoText.innerHTML = state.roofStage === 'orientation'
        ? '<b>Choisissez le côté haut</b> pour calculer l’exposition et placer les panneaux.'
        : '<b>Vérifiez votre contour</b> puis validez la surface de toiture.';
    }
  }

  if(ridgeHelper){
    if(needsRidgeSelection && !draw.validated){
      ridgeHelper.style.display = 'flex';
      ridgeHelper.classList.toggle('is-selected', ridgeSelected);
      if(ridgeHelperTitle){
        ridgeHelperTitle.textContent = ridgeSelected ? 'Orientation de toiture définie' : 'Déterminons l\'orientation de votre toiture';
      }
      if(ridgeHelperText){
        ridgeHelperText.textContent = ridgeSelected
          ? 'L’orientation de la toiture est prise en compte. Les panneaux seront positionnés automatiquement dans le meilleur sens.'
          : 'Après le tracé, cliquez sur le côté le plus haut pour orienter la toiture et placer automatiquement les panneaux dans la meilleure position.';
      }
    } else {
      ridgeHelper.style.display = 'none';
      ridgeHelper.classList.remove('is-selected');
    }
  }

  if(addZoneBtn){
    addZoneBtn.style.display = draw.validated && draw.zones.length > 0 ? '' : 'none';
  }

  if(drawResultBox){
    if(state.roofStage === 'surface' && draw.points.length >= 4){
      drawResultBox.style.display = 'block';
      if(drawResultLabel) drawResultLabel.textContent = 'Nous estimons que la surface de votre toiture est de :';
      if(drawResultValue) drawResultValue.textContent = `${rounded} m2`;
    } else if(state.roofStage === 'orientation' && selectedOrientation){
      drawResultBox.style.display = 'block';
      if(drawResultLabel) drawResultLabel.textContent = 'Votre toiture est exposée :';
      if(drawResultValue) drawResultValue.textContent = selectedOrientation;
    } else {
      drawResultBox.style.display = 'none';
    }
  }
}

function drawPolygon(){
  if(draw.polygon){ draw.polygon.setMap(null); draw.polygon = null; }
  clearRidgeSelection();

  if(draw.points.length >= 2){
    draw.polygon = new google.maps.Polygon({
      paths: draw.points,
      strokeColor: '#13a6e8',
      strokeOpacity: 1,
      strokeWeight: 2.5,
      fillColor: '#13a6e8',
      fillOpacity: draw.validated ? 0.35 : 0.20,
      map,
      clickable: false,
      zIndex: 1,
    });
    if(draw.validated){
      draw.polygon.setOptions({
        strokeColor:'#13a6e8',
        strokeOpacity: 0.9,
        strokeWeight: 2,
        fillOpacity: 0,
      });
    }
  }

  if(draw.zoneType === 'roof' && !draw.validated && draw.points.length >= 3){
    const canSelectEdge = state.roofStage === 'orientation';
    draw.points.forEach((point, index) => {
      const nextPoint = draw.points[(index + 1) % draw.points.length];
      const isSelected = draw.ridgeEdgeIndex === index;
      const selectEdge = () => {
        if(!canSelectEdge) return;
        draw.ridgeEdgeIndex = index;
        drawPolygon();
        updateDrawUI();
      };
      const target = new google.maps.Polyline({
        path: [point, nextPoint],
        strokeColor: '#000000',
        strokeOpacity: canSelectEdge ? 0.01 : 0,
        strokeWeight: canSelectEdge ? 18 : 0,
        zIndex: 11,
        clickable: canSelectEdge,
        map,
      });
      const edge = new google.maps.Polyline({
        path: [point, nextPoint],
        strokeColor: isSelected ? '#ff3b30' : '#52e33f',
        strokeOpacity: isSelected ? 1 : 0.96,
        strokeWeight: isSelected ? 7 : 5,
        zIndex: 12,
        clickable: canSelectEdge,
        map,
      });
      if(canSelectEdge){
        edge.addListener('click', selectEdge);
        target.addListener('click', selectEdge);
      }
      ridgeSelectionOverlays.push(target);
      ridgeSelectionOverlays.push(edge);
    });
  }
}

function addVertexMarker(latlng, idx){
  const m = new google.maps.Marker({
    position: latlng,
    map,
    icon: {
      path: google.maps.SymbolPath.CIRCLE,
      scale: idx === 0 ? 9 : 7,
      fillColor: '#ffffff',
      fillOpacity: 1,
      strokeColor: draw.zoneType === 'roof' ? '#52e33f' : '#13a6e8',
      strokeWeight: draw.zoneType === 'roof' ? 3 : 2.5,
    },
    title: `Point ${idx+1}`,
    clickable: !draw.validated,
    zIndex: 10 + idx,
  });
  draw.markers.push(m);
}

function clearCurrentDrawing(){
  clearRidgeSelection();
  if(draw.polygon){ draw.polygon.setMap(null); draw.polygon = null; }
  draw.markers.forEach(m => m.setMap(null));
  draw.markers = [];
  draw.points  = [];
  draw.ridgeEdgeIndex = null;
}

function clearValidatedZones(){
  draw.zones.forEach(zone => {
    zone.polygon?.setMap(null);
    zone.markers?.forEach(marker => marker.setMap(null));
  });
  draw.zones = [];
}

function clearDrawing(keepValidated = false){
  clearCurrentDrawing();
  clearSafetyZone();
  if(!keepValidated){
    clearValidatedZones();
    draw.validated = false;
    state.panelLayout = null;
  }
  updateDrawUI();
}

// ── Popup démo ───────────────────────────────────────────────────
const demoPopup  = $('demoPopup');
const demoSeenSessionPrefix = 'solarSimulatorDemoSeen';

function setDemoPolygon(points){
  if(!Array.isArray(points) || points.length < 4) return;
  const polygonPoints = points.map(([x, y]) => `${x},${y}`).join(' ');
  $('dpGhostZone')?.setAttribute('points', polygonPoints);
  $('dpFill')?.setAttribute('points', polygonPoints);
  $('dpLine')?.setAttribute('points', `${polygonPoints} ${points[0][0]},${points[0][1]}`);

  const shadowPoints = points.map(([x, y]) => `${x + 14},${y + 12}`).join(' ');
  $('dpShadow')?.setAttribute('points', shadowPoints);

  [$('dp1'), $('dp2'), $('dp3'), $('dp4')].forEach((node, index) => {
    if(!node || !points[index]) return;
    node.setAttribute('cx', points[index][0]);
    node.setAttribute('cy', points[index][1]);
  });
}

function setDemoSelectedEdge(points, isVisible = true){
  const edge = $('dpSelectedEdge');
  if(!edge) return;
  if(!Array.isArray(points) || points.length < 2 || !isVisible){
    edge.style.display = 'none';
    edge.setAttribute('points', '0,0 0,0');
    return;
  }
  edge.style.display = '';
  edge.setAttribute('points', points.map(([x, y]) => `${x},${y}`).join(' '));
}

function setDemoBadge({ text, x = 360, y = 136, width = 180, height = 48 } = {}){
  const rect = $('dpBadgeRect');
  const label = $('dpBadgeText');
  if(rect){
    rect.setAttribute('x', x - (width / 2));
    rect.setAttribute('y', y - 30);
    rect.setAttribute('width', width);
    rect.setAttribute('height', height);
  }
  if(label){
    label.setAttribute('x', x);
    label.setAttribute('y', y);
    label.textContent = text || '';
  }
}

function setDemoCaption(line1, line2){
  const caption1 = $('dpCaptionLine1');
  const caption2 = $('dpCaptionLine2');
  if(caption1) caption1.textContent = line1 || '';
  if(caption2) caption2.textContent = line2 || '';
}

function setDemoStartText(text){
  const label = $('demoStartText');
  if(label) label.textContent = text || 'Fermer le tutoriel';
}

function setDemoCursorVisibility(isVisible = false){
  const cursor = $('dpCursorGroup');
  if(!cursor) return;
  cursor.style.display = isVisible ? '' : 'none';
}

function configureRoofTraceDemo(){
  $('demoRoofDecor').style.display = '';
  $('demoGardenDecor').style.display = 'none';
  $('demoTypeBadge').textContent = 'Toiture';
  $('demoTitle').textContent = 'Comment tracer votre zone de toiture';
  $('demoIntro').textContent = 'Regardez l\'exemple ci-dessous, puis fermez pour commencer à tracer sur votre toiture.';
  $('demoStep1Label').textContent = 'Placez 4 points';
  $('demoStep1Sub').textContent = 'sur les coins du pan';
  $('demoStep2Label').textContent = 'Fermez le contour';
  $('demoStep2Sub').textContent = 'la zone se dessine automatiquement';
  $('demoStep3Label').textContent = 'Validez la surface';
  $('demoStep3Sub').textContent = 'puis passez à l’orientation';
  $('demoFootText').textContent = 'Tracez uniquement la surface utile du pan de toiture. Une fois la zone validée, vous pourrez choisir le côté le plus haut.';
  setDemoStartText('Fermer et commencer');

  const roofPoints = [
    [182, 222],
    [380, 276],
    [334, 408],
    [138, 354],
  ];
  setDemoPolygon(roofPoints);
  setDemoSelectedEdge(null, false);
  setDemoBadge({ text: '4 coins à placer', x: 360, y: 144, width: 204, height: 46 });
  setDemoCaption('Cliquez sur les 4 coins', 'du pan de toiture');
  setDemoCursorVisibility(true);
}

function configureOrientationDemo(){
  $('demoRoofDecor').style.display = '';
  $('demoGardenDecor').style.display = 'none';
  $('demoTypeBadge').textContent = 'Orientation';
  $('demoTitle').textContent = 'Déterminons l\'orientation de votre toiture';
  $('demoIntro').textContent = 'Cliquez sur le côté le plus haut pour définir l’orientation du toit et positionner les panneaux dans le meilleur sens.';
  $('demoStep1Label').textContent = 'Surface tracée';
  $('demoStep1Sub').textContent = 'le contour est déjà validé';
  $('demoStep2Label').textContent = 'Cliquez sur le côté le plus haut';
  $('demoStep2Sub').textContent = 'il devient rouge';
  $('demoStep3Label').textContent = 'Validez l’orientation';
  $('demoStep3Sub').textContent = 'les panneaux seront placés au mieux';
  $('demoFootText').textContent = 'Le côté haut permet de déterminer l’orientation de la toiture et d’optimiser automatiquement le sens de pose des panneaux.';
  setDemoStartText('Fermer le tutoriel');

  const roofPoints = [
    [182, 222],
    [380, 276],
    [334, 408],
    [138, 354],
  ];
  setDemoPolygon(roofPoints);
  setDemoSelectedEdge([roofPoints[0], roofPoints[1]], true);
  setDemoBadge({ text: '≈ 35 m²', x: 360, y: 144, width: 170, height: 46 });
  setDemoCaption('Cliquez sur le côté', 'le plus haut');
  setDemoCursorVisibility(false);
}

function configureLocateDemo(){
  $('demoRoofDecor').style.display = '';
  $('demoGardenDecor').style.display = 'none';
  $('demoTypeBadge').textContent = 'Repérage';
  $('demoTitle').textContent = 'Repérons votre toiture';
  $('demoIntro').textContent = 'Faites glisser la carte pour placer la punaise rouge sur votre toiture avant de valider.';
  $('demoStep1Label').textContent = 'Affichez votre maison';
  $('demoStep1Sub').textContent = 'à l’écran';
  $('demoStep2Label').textContent = 'Glissez la carte';
  $('demoStep2Sub').textContent = 'jusqu’à la punaise rouge';
  $('demoStep3Label').textContent = 'Validez l’emplacement';
  $('demoStep3Sub').textContent = 'puis passez au tracé';
  $('demoFootText').textContent = 'La punaise rouge vous aide à placer précisément votre toiture avant de sélectionner sa surface utile.';
  setDemoStartText('Fermer le tutoriel');

  const locatePoints = [
    [232, 240],
    [382, 278],
    [334, 394],
    [186, 356],
  ];
  setDemoPolygon(locatePoints);
  setDemoSelectedEdge(null, false);
  setDemoBadge({ text: 'Repère rouge', x: 360, y: 126, width: 184, height: 46 });
  setDemoCaption('Glissez votre maison', 'sous la punaise rouge');
  setDemoCursorVisibility(false);
}

function configureGardenDemo(){
  $('demoRoofDecor').style.display = 'none';
  $('demoGardenDecor').style.display = '';
  $('demoTypeBadge').textContent = 'Sol / jardin';
  $('demoTitle').textContent = 'Comment tracer votre zone au sol';
  $('demoIntro').textContent = 'Délimitez la surface utile au sol en posant simplement vos points tout autour de la zone.';
  $('demoStep1Label').textContent = 'Placez vos points';
  $('demoStep1Sub').textContent = 'sur le terrain à équiper';
  $('demoStep2Label').textContent = 'Fermez le contour';
  $('demoStep2Sub').textContent = 'point par point';
  $('demoStep3Label').textContent = 'Validez la zone';
  $('demoStep3Sub').textContent = 'surface prête pour l’estimation';
  $('demoFootText').textContent = 'Gardez un contour simple et propre. Vous pouvez effacer et recommencer à tout moment.';
  setDemoStartText('Fermer et commencer');

  const gardenPoints = [
    [168, 182],
    [516, 182],
    [548, 362],
    [196, 392],
  ];
  setDemoPolygon(gardenPoints);
  setDemoSelectedEdge(null, false);
  setDemoBadge({ text: '≈ 48 m²', x: 360, y: 122, width: 170, height: 46 });
  setDemoCaption('Tracez la zone utile', 'sur le sol ou le jardin');
  setDemoCursorVisibility(false);
}

function openDemoPopup(mode = 'auto', options = {}){
  if(!demoPopup) return;
  let resolvedMode = mode;
  if(mode === 'auto'){
    if(state.roofStage === 'locate') resolvedMode = 'locate';
    else if(draw.zoneType === 'garden') resolvedMode = 'garden';
    else if(state.roofStage === 'orientation') resolvedMode = 'orientation';
    else resolvedMode = 'surface';
  }
  const force = !!options.force;
  const seenKey = `${demoSeenSessionPrefix}:${resolvedMode}`;
  try {
    if(!force && window.sessionStorage.getItem(seenKey) === '1') return;
    window.sessionStorage.setItem(seenKey, '1');
  } catch(_error) {}

  if(resolvedMode === 'locate') configureLocateDemo();
  else if(resolvedMode === 'garden') configureGardenDemo();
  else if(resolvedMode === 'orientation') configureOrientationDemo();
  else configureRoofTraceDemo();

  window.clearTimeout(closeDemoPopup._timer);
  demoPopup.classList.remove('closing');
  demoPopup.style.display = 'flex';
  updateBodyScrollLock();

  const svgEl = $('demoSvg');
  if(svgEl){
    svgEl.classList.remove('demo-anim-running');
    void svgEl.offsetWidth;
    svgEl.classList.add('demo-anim-running');
  }
}

function closeDemoPopup(){
  const svgEl = $("demoSvg");
  if(svgEl) svgEl.classList.remove("demo-anim-running");
  demoPopup.classList.add('closing');
  window.clearTimeout(closeDemoPopup._timer);
  closeDemoPopup._timer = setTimeout(() => {
    demoPopup.style.display = 'none';
    demoPopup.classList.remove('closing');
    updateBodyScrollLock();
  }, 240);
}

$('locateTutorialClose')?.addEventListener('click', closeLocateTutorial);
$('demoCloseBtn')?.addEventListener('click', closeDemoPopup);
$('demoStartBtn')?.addEventListener('click', closeDemoPopup);
demoPopup?.addEventListener('click', e => { if(e.target === demoPopup) closeDemoPopup(); });

function startDrawMode(options = {}){
  const { preserveZones = false, skipDemoPopup = true, demoMode = 'auto', forceDemo = false } = options;
  draw.active    = true;
  draw.validated = false;
  clearDrawing(preserveZones);
  document.querySelector('.map-wrap').classList.add('drawing');
  if(marker){
    marker.setVisible(true);
    marker.setOpacity(0.92);
    marker.setZIndex(6);
  }

  if(draw.clickListener) google.maps.event.removeListener(draw.clickListener);
  draw.clickListener = map.addListener('click', e => {
    if(draw.validated) return;
    if(state.roofStage === 'surface' && draw.points.length >= 4){
      showToast('Le contour de toiture se fait en 4 points sur ce parcours.', true);
      return;
    }
    draw.points.push(e.latLng);
    addVertexMarker(e.latLng, draw.points.length - 1);
    drawPolygon();
    updateDrawUI();
  });

  updateDrawUI();
  // Ouvrir le popup démo
  if(!skipDemoPopup) setTimeout(() => openDemoPopup(demoMode, { force: forceDemo }), 500);
}

function stopDrawMode(){
  draw.active = false;
  document.querySelector('.map-wrap').classList.remove('drawing');
  if(draw.clickListener){ google.maps.event.removeListener(draw.clickListener); draw.clickListener = null; }
  if(marker){
    marker.setVisible(true);
    marker.setOpacity(1);
  }
}

function computeMonthlyKwhBreakdown(yearlyKwh){
  return [.045,.06,.085,.10,.115,.125,.13,.12,.095,.07,.045,.035].map(weight => Math.round(yearlyKwh * weight));
}

function serializeMapPoint(point){
  if(!point) return null;
  if(typeof point.lat === 'function' && typeof point.lng === 'function'){
    return { lat: point.lat(), lng: point.lng() };
  }
  if(Number.isFinite(point.lat) && Number.isFinite(point.lng)){
    return { lat: point.lat, lng: point.lng };
  }
  return null;
}

function serializeMapPath(points){
  return (points || []).map(serializeMapPoint).filter(Boolean);
}

function buildSnapshotPayload(){
  const layout = state.panelLayout;
  if(!layout?.zoneLayouts?.length) return null;

  return {
    zones: layout.zoneLayouts.map(zone => ({
      originalPoints: serializeMapPath(zone.originalPoints),
      insetPoints: serializeMapPath(zone.insetPoints),
      panelPlacementPoints: serializeMapPath(zone.panelPlacementPoints),
    })),
    panelPolygons: (layout.panels || [])
      .slice(0, layout.activeCount || 0)
      .map(panel => serializeMapPath(panel)),
  };
}

function computeSimulationResults(panelCount, areaM2, usableAreaM2){
  const base = state.baseResults || state.results;
  const baseRatio = base ? base.yearlyKwh / Math.max(base.kwc, 0.1) : 1180;
  const orientCoeff = {Sud:1.0,'Sud-Est':.95,'Sud-Ouest':.95,'Est':.85,'Ouest':.85,'Nord-Est':.72,'Nord-Ouest':.72,'Nord':.65};
  const inclCoeff   = {0:.85,15:.92,30:1.0,45:.97,60:.90};
  const autoRoof = getAutoRoofSettings();
  const orient = autoRoof.orientation;
  const inclCoeffValue = autoRoof.hasPitch ? (inclCoeff[autoRoof.pitchBucket] || 1) : 1;
  const gardenBonus = draw.zoneType === 'garden' ? 1.05 : 1;
  const kwc = +(panelCount * PANEL_POWER_KWC).toFixed(2);
  const yearlyKwh = panelCount > 0
    ? Math.round(kwc * baseRatio * (orientCoeff[orient] || 1) * inclCoeffValue * gardenBonus)
    : 0;
  const annualSavings = Math.round(yearlyKwh * 0.35 * 0.2276 + yearlyKwh * 0.65 * 0.1269);
  const budgetFactorMin = draw.zoneType === 'garden' ? PRICING.gardenMinPerKwc : PRICING.roofMinPerKwc;
  const budgetFactorMax = draw.zoneType === 'garden' ? PRICING.gardenMaxPerKwc : PRICING.roofMaxPerKwc;

  return {
    panelCount,
    kwc,
    yearlyKwh,
    annualSavings,
    budgetMin: panelCount > 0 ? Math.round(kwc * budgetFactorMin / 100) * 100 : 0,
    budgetMax: panelCount > 0 ? Math.round(kwc * budgetFactorMax / 100) * 100 : 0,
    monthlyKwh: computeMonthlyKwhBreakdown(yearlyKwh),
    areaM2: Math.round(areaM2),
    usableAreaM2: Math.round(usableAreaM2),
    panelSetbackMeters: state.panelLayout?.safetyInsetMeters || SAFETY_SETBACK_METERS,
  };
}

function refreshValidatedZoneUi(results){
  const layout = state.panelLayout;
  const currentCount = layout?.activeCount ?? results.panelCount ?? 0;
  $('surfaceVal').textContent = Math.round(layout?.totalAreaM2 || results.areaM2 || 0);
  $('zoneValidatedArea').textContent = Math.round(layout?.totalAreaM2 || results.areaM2 || 0);

  if(currentCount > 0){
    $('surfaceSub').textContent = `${currentCount} panneaux prévus`;
    mapInfoText.innerHTML = `<b>${fmt(layout?.usableAreaM2 || results.usableAreaM2 || 0)} m² disponibles</b> pour placer vos panneaux.`;
  } else {
    $('surfaceSub').textContent = `Cette zone est trop petite pour accueillir des panneaux`;
    mapInfoText.innerHTML = `Cette zone ne permet pas de poser des panneaux.`;
  }
}

function applyValidatedLayout(panelCount = state.panelLayout?.activeCount ?? 0){
  const layout = state.panelLayout;
  if(!layout) return;

  const maxSelectable = layout.selectableMaxPanels ?? layout.maxPanels;
  const boundedCount = Math.max(0, Math.min(panelCount, maxSelectable));
  const safeCount = boundedCount;
  layout.activeCount = safeCount;

  const nextResults = {
    ...(state.baseResults || state.results || {}),
    ...computeSimulationResults(safeCount, layout.totalAreaM2, layout.usableAreaM2),
  };

  state.results = nextResults;
  state.drawResults = nextResults;

  displayResults(nextResults);
  drawSolarPanelsOnMap(layout, safeCount);
  refreshValidatedZoneUi(nextResults);
  updatePanelAdjustUi();
}

function setupPanelSlider(){
  updatePanelAdjustUi();
}

function resetZoneSelection(startFresh = true){
  draw.validated = false;
  clearPanelLayout();
  hidePanelSlider();
  clearDrawing();
  state.results = state.baseResults;
  state.drawResults = null;
  state.selectedPitch = 30;
  setPitchSelection(30);
  $('zoneValidatedRow').style.display = 'none';
  $('validateZoneBtn').style.display  = '';
  $('clearZoneBtn').style.display     = '';
  if(addZoneBtn) addZoneBtn.style.display = 'none';
  if(drawResultBox) drawResultBox.style.display = 'none';
  setRoofStage('surface');
  if(mapInfoText) mapInfoText.innerHTML = `<b>Cliquez sur les 4 coins</b> du pan de toiture à équiper.`;
  if(startFresh) startDrawMode({ skipDemoPopup: false, demoMode: draw.zoneType === 'garden' ? 'garden' : 'surface', forceDemo: true });
}

function validatePlacementStage(){
  if(!map) return;
  const center = map.getCenter();
  if(!center) return;
  state.lat = center.lat();
  state.lng = center.lng();
  closeLocateTutorial();
  clearCurrentDrawing();
  setRoofStage('surface');
  startDrawMode({ skipDemoPopup: false, demoMode: draw.zoneType === 'garden' ? 'garden' : 'surface', forceDemo: true });
  showToast('Emplacement validé — sélectionnez maintenant la surface utile.');
}

function validateSurfaceStage(){
  if(draw.points.length < 4){
    showToast('Sélectionnez les 4 coins du pan de toiture.', true);
    return;
  }
  stopDrawMode();
  draw.validated = false;
  draw.ridgeEdgeIndex = null;
  drawPolygon();
  setRoofStage('orientation');
  if(drawResultBox) drawResultBox.style.display = 'none';
  updateDrawUI();
  setTimeout(() => openDemoPopup('orientation', { force: true }), 250);
  showToast('Surface validée — choisissez maintenant le côté le plus haut.');
}

function validateOrientationStage(){
  if(!Number.isInteger(draw.ridgeEdgeIndex)){
    showToast('Cliquez d’abord sur le côté le plus haut de la toiture.', true);
    return;
  }
  const zonePoints = [...draw.points];
  const ridgeEdgeIndex = draw.ridgeEdgeIndex;
  const base = state.baseResults || state.results;
  const panelHeightMeters = base?.panelHeightMeters || 1.722;
  const panelWidthMeters  = base?.panelWidthMeters  || 1.134;
  const combinedLayout = buildCombinedPanelLayout([{
    points: zonePoints,
    ridgeEdgeIndex,
    zoneType: draw.zoneType,
  }], panelHeightMeters, panelWidthMeters);
  const solarApiMax = base?.maxPanels || 0;
  const maxPanels = combinedLayout.panels.length;
  const selectableMaxPanels = maxPanels;
  const defaultPanelCount = draw.zoneType === 'roof'
    ? getRoofDefaultPanelCount(maxPanels)
    : selectableMaxPanels;
  const requestedPanelCount = preferredInitialPanelCount > 0
    ? Math.min(selectableMaxPanels, preferredInitialPanelCount)
    : 0;
  const initialPanelCount = requestedPanelCount > 0 ? requestedPanelCount : defaultPanelCount;

  state.panelLayout = {
    ...combinedLayout,
    maxPanels,
    selectableMaxPanels,
    activeCount: initialPanelCount,
    fullPanelCount: combinedLayout.panels.length,
    solarApiSuggestedPanels: solarApiMax,
  };

  draw.validated = true;
  clearRidgeSelection();
  drawPolygon();
  setPitchSelection(getAutoRoofSettings().pitchBucket || 30);
  applyValidatedLayout(initialPanelCount);
  preferredInitialPanelCount = 0;
  setupPanelSlider();

  if(drawResultValue) drawResultValue.textContent = state.panelLayout?.orientationLabel || 'Sud';
  if(drawResultBox) drawResultBox.style.display = 'block';
  setRoofStage('inclination');
  $('cardRoof').scrollIntoView({behavior:'smooth', block:'nearest'});
  showToast('Orientation validée — choisissez maintenant l’inclinaison.');
}

function validateZone(){
  if(state.roofStage === 'locate'){
    validatePlacementStage();
    return;
  }
  if(state.roofStage === 'surface'){
    validateSurfaceStage();
    return;
  }
  if(state.roofStage === 'orientation'){
    validateOrientationStage();
  }
}

// ── Zone type toggle ──────────────────────────────────────────────
[$('zoneBtnRoof'), $('zoneBtnGarden')].forEach(btn => {
  btn?.addEventListener('click', () => {
    [$('zoneBtnRoof'), $('zoneBtnGarden')].forEach(b => b?.classList.remove('active'));
    btn.classList.add('active');
    draw.zoneType = btn.dataset.zone;
    if(draw.zoneType !== 'roof'){
      draw.ridgeEdgeIndex = null;
    }
    $('drawModeBadge').textContent = draw.zoneType === 'garden' ? 'SOL/JARDIN' : 'TOITURE';
    if(draw.points.length >= 2) drawPolygon();
    updateDrawUI();
    // Rouvrir le popup démo si aucun point tracé
    if(draw.points.length === 0 && draw.active && typeof openDemoPopup === 'function') openDemoPopup();
    else if(draw.points.length >= 3) updateDrawUI();
  });
});

// ── Validate / Clear / Edit buttons ─────────────────────────────
$('validateZoneBtn')?.addEventListener('click', validateZone);
bindPanelAdjustPress(panelMinusBtn, () => stepPanelCount(-1));
bindPanelAdjustPress(panelPlusBtn, () => stepPanelCount(1));
panelQuickPicks?.querySelectorAll('.panel-quick-btn').forEach(btn => {
  bindPanelAdjustPress(btn, () => {
    if(btn.disabled) return;
    applyValidatedLayout(panelCountFromKwc(btn.dataset.kwc));
  });
});
$('clearZoneBtn')?.addEventListener('click', () => {
  if(state.roofStage === 'locate'){
    changeAddrBtn?.click();
    return;
  }
  resetZoneSelection(true);
});
$('editZoneBtn')?.addEventListener('click', () => {
  resetZoneSelection(true);
});
$('addZoneBtn')?.addEventListener('click', () => {
  setRoofStage('surface');
  startDrawMode({ preserveZones: true, skipDemoPopup: true });
});
$('undoPointBtn')?.addEventListener('click', () => {
  if(!draw.points.length) return;
  draw.points.pop();
  const last = draw.markers.pop();
  if(last) last.setMap(null);
  drawPolygon();
  updateDrawUI();
});
$('clearDrawBtn')?.addEventListener('click', () => {
  resetZoneSelection(true);
});
roofBackBtn?.addEventListener('click', event => {
  event.preventDefault();
  draw.validated = false;
  clearPanelLayout();
  setRoofStage('orientation');
  drawPolygon();
  updateDrawUI();
});
pitchGrid?.querySelectorAll('.pitch-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    setPitchSelection(Number(btn.dataset.pitch) || 30);
    if(state.panelLayout){
      applyValidatedLayout(state.panelLayout.activeCount ?? state.results?.panelCount ?? 0);
    }
  });
});

// ── Autocomplétion custom via Nominatim (backend) ────────────────
const autocompleteList = $('autocompleteList');
let acItems = [], acFocused = -1, acDebounce;

function openAddress(item, options = {}){
  state.lat     = item.lat;
  state.lng     = item.lng;
  state.address = item.label;
  state.baseResults = null;
  state.results = null;
  state.drawResults = null;
  draw.validated = false;
  clearPanelLayout();
  hidePanelSlider();
  clearDrawing();
  stopDrawMode();
  $('zoneValidatedRow').style.display = 'none';
  $('validateZoneBtn').style.display  = '';
  $('clearZoneBtn').style.display     = '';
  closeAutocomplete();
  addressInput.value = item.label;
  addrPillText.textContent = item.label;
  addrPill.style.display   = 'flex';
  addrSearchWrap.style.display = 'none';
  if(mapLoading) mapLoading.classList.add('hidden');
  if(map){
    map.setMapTypeId('satellite');
    syncLayerSwitch('satellite');
    map.setTilt(0);
    map.setCenter({lat: item.lat, lng: item.lng});

    map.setZoom(19);
    const _mzs = new google.maps.MaxZoomService();
    _mzs.getMaxZoomAtLatLng({lat: item.lat, lng: item.lng}, function(r){
      const maxZoom = (r.status === google.maps.MaxZoomStatus.OK ? r.zoom : 20);
      const safeZoom = Math.max(18, Math.min(20, maxZoom - 1));
      map.setZoom(safeZoom);
      map.setTilt(0);
      scheduleSatelliteRecovery(true);
    });

    if(marker){
      marker.setPosition({lat: item.lat, lng: item.lng});
      marker.setVisible(false);
      marker.setOpacity(0);
      marker.setZIndex(6);
    }
    scheduleSatelliteRecovery(true);
  }
  beginLocateStage({ forceDemo: true });
  fetchSolarData({
    background: true,
    timeoutMs: 8000,
    skipLocateStage: true,
    ...(options.fetchOptions || {}),
  });
}

function renderAutocomplete(items){
  acItems = items;
  acFocused = -1;
  if(!items.length){ closeAutocomplete(); return; }
  autocompleteList.innerHTML = items.map((it, i) => {
    // le backend renvoie maintenant {label, full, lat, lng}
    const main = it.label || it.full || '';
    const sub  = it.full && it.full !== main ? it.full.split(',').slice(1,3).join(',').trim() : '';
    return `<div class="autocomplete-item" data-i="${i}" role="option">
      <span class="ai-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
      <div><div class="ai-label">${main}</div>${sub ? `<div class="ai-sub">${sub}</div>` : ''}</div>
    </div>`;
  }).join('');
  autocompleteList.classList.add('open');
  addressInput.setAttribute('aria-expanded', 'true');
  autocompleteList.querySelectorAll('.autocomplete-item').forEach(el => {
    el.addEventListener('mousedown', e => { e.preventDefault(); openAddress(acItems[+el.dataset.i]); });
  });
}

function closeAutocomplete(){
  autocompleteList.classList.remove('open');
  autocompleteList.innerHTML = '';
  addressInput.setAttribute('aria-expanded', 'false');
  acFocused = -1; acItems = [];
}

function focusItem(idx){
  const els = autocompleteList.querySelectorAll('.autocomplete-item');
  els.forEach(e => e.classList.remove('focused'));
  if(idx >= 0 && idx < els.length){ els[idx].classList.add('focused'); acFocused = idx; }
}

async function queryAutocomplete(q){
  if(q.length < 3){ closeAutocomplete(); return; }
  try {
    const url = `${window.__autocompleteUrl}?q=${encodeURIComponent(q)}`;
    const r = await fetch(url, { headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': window.__csrfToken } });
    const data = await r.json();
    renderAutocomplete(Array.isArray(data) ? data : []);
  } catch(e){ closeAutocomplete(); }
}

// ── Geocode via backend (fallback si selection directe non faite) ──
async function geocodeAddress(addr){
  mapLoading.classList.remove('hidden');
  mapLoadingText.textContent = 'Recherche de l\'adresse…';
  analyzeBtn.disabled = true;
  closeAutocomplete();

  try {
    const resp = await fetch(window.__geocodeUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': window.__csrfToken, 'Accept': 'application/json' },
      body: JSON.stringify({ address: addr }),
    });
    const data = await resp.json();
    if(!resp.ok || data.error) throw new Error(data.error || 'Adresse introuvable');

    openAddress({ lat: data.lat, lng: data.lng, label: data.formatted_address });
  } catch(e){
    showToast(e.message || 'Adresse introuvable', true);
    mapLoading.classList.add('hidden');
    analyzeBtn.disabled = false;
  }
}

// ── Init Google Maps (sans Places Autocomplete) ───────────────────
function initMap(){
  map = new google.maps.Map($('mapDiv'), {
    center: {lat: 46.603354, lng: 1.888334},
    zoom: 5,
    mapTypeId: 'satellite',
    tilt: 0,
    backgroundColor: '#eef4f9',
    disableDefaultUI: true,
    zoomControl: true,
    zoomControlOptions: {position: google.maps.ControlPosition.RIGHT_CENTER},
    streetViewControl: false,
    fullscreenControl: false,
    mapTypeControl: false,
  });

  // Icône pin localisation SVG (forme épingle / goutte)
  // Pin rouge avec point accent au-dessus
  const pinSvg = encodeURIComponent(
    '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="42" viewBox="0 0 30 42">' +
    '<path d="M15 0C6.716 0 0 6.716 0 15c0 10.5 15 27 15 27s15-16.5 15-27C30 6.716 23.284 0 15 0z" fill="#e23a3a"/>' +
    '<circle cx="15" cy="15" r="6" fill="white" fill-opacity="0.9"/>' +
    '</svg>'
  );
  marker = new google.maps.Marker({
    map,
    icon: {
      url: 'data:image/svg+xml;charset=UTF-8,' + pinSvg,
      scaledSize: new google.maps.Size(30, 42),
      anchor: new google.maps.Point(15, 42),
    },
    visible: false,
  });

  map.addListener('click', e => {
    if(!draw.active) return;
  });

  // Layer switch
  const lsBtns = document.querySelectorAll('.layer-switch button');
  lsBtns.forEach(b => b.addEventListener('click', () => {
    map.setMapTypeId(b.dataset.type);
    syncLayerSwitch(b.dataset.type);
    if(b.dataset.type === 'satellite') scheduleSatelliteRecovery(true);
  }));
  syncLayerSwitch('satellite');

  map.addListener('tilesloaded', () => {
    if(state.roofStage === 'locate' && map.getMapTypeId() === 'satellite'){
      scheduleSatelliteRecovery(false);
    }
  });

  // Input listeners avec autocomplétion
  addressInput.addEventListener('input', () => {
    const v = addressInput.value.trim();
    analyzeBtn.disabled = v.length < 5;
    clearTimeout(acDebounce);
    acDebounce = setTimeout(() => queryAutocomplete(v), 280);
  });
  addressInput.addEventListener('keydown', e => {
    if(e.key === 'ArrowDown'){ e.preventDefault(); focusItem(Math.min(acFocused + 1, acItems.length - 1)); return; }
    if(e.key === 'ArrowUp'){   e.preventDefault(); focusItem(Math.max(acFocused - 1, 0)); return; }
    if(e.key === 'Enter'){
      e.preventDefault();
      if(acFocused >= 0 && acItems[acFocused]){ openAddress(acItems[acFocused]); return; }
      const v = addressInput.value.trim();
      if(v.length >= 5) geocodeAddress(v);
      return;
    }
    if(e.key === 'Escape'){ closeAutocomplete(); }
  });
  addressInput.addEventListener('blur', () => setTimeout(closeAutocomplete, 150));
  analyzeBtn.addEventListener('click', () => {
    const v = addressInput.value.trim();
    if(v.length >= 5) geocodeAddress(v);
  });

  dbg('INFO', 'Carte initialisée ✓');
  mapLoading.classList.add('hidden');

  const heroSelection = initialHeroSelection
    && String(initialHeroSelection.address || '').trim() !== ''
    ? initialHeroSelection
    : null;
  const bootAddress = heroSelection?.address || initialSolarAddress;
  const bootLabel = heroSelection?.label || initialSolarLabel || bootAddress;
  const bootLat = Number(heroSelection?.lat || initialSolarLat);
  const bootLng = Number(heroSelection?.lng || initialSolarLng);

  if(bootAddress){
    addressInput.value = bootAddress;
    analyzeBtn.disabled = bootAddress.length < 5;
    if(Number.isFinite(bootLat) && Number.isFinite(bootLng) && bootAddress.length >= 5){
      preferredInitialPanelCount = Number(heroSelection?.kit || initialSolarKitKwc || 0) > 0
        ? panelCountFromKwc(Number(heroSelection?.kit || initialSolarKitKwc || 0))
        : preferredInitialPanelCount;
      openAddress(
        { lat: bootLat, lng: bootLng, label: bootLabel || bootAddress },
        { fetchOptions: { background: true, timeoutMs: 8000 } }
      );
      try { window.sessionStorage.removeItem('solarHeroSelection'); } catch(_error) {}
    } else if(bootAddress.length >= 5){
      geocodeAddress(bootAddress);
    }
  }
}

// ── Change address ────────────────────────────────────────────────
changeAddrBtn.addEventListener('click', () => {
  addrPill.style.display = 'none';
  addrSearchWrap.style.display = 'block';
  addressInput.value = '';
  addressInput.focus();
  analyzeBtn.disabled = true;
  // Reset dessin
  if(typeof clearDrawing === 'function'){ clearPanelLayout(); hidePanelSlider(); clearDrawing(); stopDrawMode(); }
  // Reset métriques
  ['metricPanels','metricKwc','metricKwh','metricSavings','budgetCard'].forEach(id => {
    const el = $(id); if(el) el.classList.add('skeleton');
  });
  $('valPanels').innerHTML = '— <small>panneaux</small>';
  $('valKwc').innerHTML    = '— <small>kWc</small>';
  $('valKwh').innerHTML    = '— <small>kWh/an</small>';
  $('valSavings').innerHTML= '— <small>€/an</small>';
  $('valBudget').innerHTML = '— <small>€</small>';
  state.baseResults = null;
  state.results = null;
  state.drawResults = null;
  state.lat = null;
  state.lng = null;
  setJourneyStep(1);
  setRoofStage('address');
});

// ── Step 4 page ───────────────────────────────────────────────────
quoteBtn.addEventListener('click', () => {
  if(!state.results || state.roofStage !== 'inclination'){
    showToast('Validez d’abord l’orientation et l’inclinaison de votre toiture.', true);
    return;
  }

  const payload = {
    address: state.address || '',
    lat: state.lat,
    lng: state.lng,
    zoneType: draw.zoneType,
    panels: state.results.panelCount || 0,
    kwc: state.results.kwc || 0,
    yearlyKwh: state.results.yearlyKwh || 0,
    annualSavings: state.results.annualSavings || 0,
    budgetMin: state.results.budgetMin || 0,
    budgetMax: state.results.budgetMax || 0,
    surfaceM2: state.results.usableAreaM2 || state.results.areaM2 || 0,
    orientation: state.panelLayout?.orientationLabel || getAutoRoofSettings().orientation || 'Sud',
    inclination: state.selectedPitch || 30,
    snapshotPayload: buildSnapshotPayload(),
    selectedAt: new Date().toISOString(),
  };

  try {
    window.sessionStorage.setItem(window.__solarStep4StorageKey, JSON.stringify(payload));
  } catch (e) {
    console.warn('Impossible de stocker les données étape 4', e);
  }

  window.location.href = window.__step4Url;
});

// ── Debug logger ─────────────────────────────────────────────────
const debugLogs = [];
function dbg(level, msg, data){
  const entry = { t: new Date().toISOString(), level, msg, data: data ?? null };
  debugLogs.push(entry);
  const icon = level === 'ERROR' ? '🔴' : level === 'WARN' ? '🟡' : '🟢';
  console[level === 'ERROR' ? 'error' : level === 'WARN' ? 'warn' : 'log'](
    `[Solar ${level}] ${msg}`, data ?? ''
  );
  // Write to visible debug panel
  const panel = $('debugPanel');
  if(panel){
    const row = document.createElement('div');
    row.style.cssText = 'font-size:12px;padding:4px 0;border-bottom:1px solid #eee;word-break:break-all';
    row.innerHTML = `<span style="color:${level==='ERROR'?'#c00':level==='WARN'?'#a60':'#080'}">${icon} ${level}</span> <b>${msg}</b>` +
      (data ? `<br><span style="color:#555;font-size:11px">${typeof data==='object'?JSON.stringify(data,null,0):data}</span>` : '');
    panel.appendChild(row);
    panel.scrollTop = panel.scrollHeight;
  }
}

// ── Load Google Maps ──────────────────────────────────────────────
function loadMaps(){
  const key = window.__mapsKey;
  dbg('INFO', 'Clé Maps reçue', key ? `${key.slice(0,10)}…` : 'VIDE ❌');

  if(!key || key.length < 20){
    dbg('ERROR', 'Clé API Maps absente ou trop courte — vérifiez GOOGLE_MAPS_BROWSER_KEY dans .env');
    showMapError('Clé API Google Maps manquante. Vérifiez la configuration serveur.');
    return;
  }

  // gm_authFailure est déjà défini globalement avant ce script

  window.initMapCallback = function(){
    dbg('INFO', 'initMapCallback appelé — Google Maps chargé avec succès');
    try {
      initMap();
      dbg('INFO', 'Carte initialisée ✓');
    } catch(e){
      dbg('ERROR', 'Erreur initMap()', e.message);
      showMapError('Erreur lors de l\'initialisation de la carte : ' + e.message);
    }
  };

  // v=weekly + sans loading=async dans l'URL, sans async/defer sur le tag
  // Le callback gère l'ordre d'exécution — c'est le mode le plus stable
  // Plus besoin de "places" — le géocodage passe par le backend
  const src = `https://maps.googleapis.com/maps/api/js?key=${key}&libraries=geometry&callback=initMapCallback&language=fr&region=FR&v=weekly`;
  dbg('INFO', 'Chargement script Maps', src.replace(key, key.slice(0,10)+'…'));

  const mapsScript = document.createElement('script');
  mapsScript.src = src;
  // PAS de async/defer ici : le paramètre callback= suffit
  mapsScript.onload = function(){
    dbg('INFO', 'Script Google Maps chargé (onload)');
    if(!map && window.google?.maps && typeof window.initMapCallback === 'function'){
      dbg('WARN', 'Callback Maps non déclenché automatiquement — tentative manuelle');
      window.initMapCallback();
    }
  };
  mapsScript.onerror = function(e){
    dbg('ERROR', 'Échec chargement script Maps (onerror)', 'API Maps JavaScript non activée ou réseau indisponible.');
    showMapError('Impossible de charger le script Google Maps. Vérifiez la connexion.');
  };
  document.head.appendChild(mapsScript);

  // Watchdog : si après 10 s la carte n'est toujours pas chargée
  setTimeout(() => {
    if(!map){
      if(window.google?.maps && typeof initMap === 'function'){
        dbg('WARN', 'Timeout 10s — callback absent mais API présente, tentative initMap() manuelle');
        try {
          initMap();
          dbg('INFO', 'Carte initialisée via watchdog ✓');
          return;
        } catch(e){
          dbg('ERROR', 'Échec initMap() via watchdog', e.message);
        }
      } else {
        dbg('WARN', 'Timeout 10s — Maps n\'a pas appelé le callback. Probablement gm_authFailure silencieux.');
      }
      showMapError('La carte met trop de temps à se charger. Rechargez la page ou revenez depuis l’accueil.');
    }
  }, 10000);
}

function showMapError(msg){
  const ml = $('mapLoading');
  if(ml) {
    ml.innerHTML = `<div style="background:rgba(226,58,58,.15);border:1px solid #e23a3a;border-radius:12px;padding:20px 24px;max-width:400px;text-align:center">
      <div style="font-size:32px;margin-bottom:8px">⚠️</div>
      <p style="color:#fff;font-weight:700;font-size:15px;margin-bottom:6px">Erreur Google Maps</p>
      <p style="color:rgba(255,255,255,.8);font-size:13px;line-height:1.5">${msg}</p>
      <p style="color:rgba(255,255,255,.6);font-size:12px;margin-top:8px">Voir le panneau de debug en bas de page</p>
    </div>`;
    ml.classList.remove('hidden');
  }
}

// Lancer le chargement
dbg('INFO', 'Page chargée — démarrage');
dbg('INFO', 'URL de la page', window.location.href);
dbg('INFO', 'User-Agent', navigator.userAgent.slice(0,80));
setJourneyStep(1);
setPitchSelection(30);
setRoofStage('address');
loadMaps();

})();
</script>

<script>
// Layer switch inside map
document.addEventListener('DOMContentLoaded', function(){
  const mapWrap = document.querySelector('.map-wrap');
  if(!mapWrap) return;
  const ls = document.createElement('div');
  ls.className = 'layer-switch';
  ls.innerHTML = `<button data-type="satellite" class="active">Satellite</button><button data-type="roadmap">Plan</button>`;
  mapWrap.appendChild(ls);
});
</script>
</body>
</html>
