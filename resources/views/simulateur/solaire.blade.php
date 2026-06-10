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

/* Surface display */
.surface-display{display:flex;align-items:baseline;gap:6px;margin:10px 0 4px}
.surface-display .s-val{font-size:40px;font-weight:800;color:var(--ink);letter-spacing:-.02em;font-variant-numeric:tabular-nums;line-height:1}
.surface-display .s-unit{font-size:16px;font-weight:600;color:var(--slate)}
.surface-sub{font-size:12px;color:var(--muted);font-style:italic;margin-bottom:16px}

/* Draw hint overlay on map */
.draw-hint{
  position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);
  background:rgba(15,34,49,.85);color:#fff;
  padding:14px 22px;border-radius:12px;
  font:600 13.5px 'Inter',sans-serif;
  display:flex;align-items:center;gap:12px;
  pointer-events:none;backdrop-filter:blur(6px);
  box-shadow:0 8px 24px rgba(0,0,0,.3);z-index:8;
  transition:opacity .3s ease;
}
.draw-hint.hidden{opacity:0;pointer-events:none}
.draw-hint .dot{
  width:10px;height:10px;border-radius:50%;background:var(--accent);flex-shrink:0;
  box-shadow:0 0 0 4px rgba(19,166,232,.35);animation:pulse 1.6s infinite;
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
  background:#fff;border-radius:20px;max-width:820px;width:100%;
  box-shadow:0 32px 80px rgba(15,34,49,.3);overflow:hidden;
  animation:slideUp .3s cubic-bezier(.34,1.56,.64,1);
}
@keyframes slideUp{from{transform:translateY(30px);opacity:0}to{transform:translateY(0);opacity:1}}
.demo-head{
  display:flex;align-items:center;justify-content:space-between;
  padding:18px 24px;border-bottom:1px solid var(--line);
}
.demo-head h3{font-size:17px;font-weight:800;color:var(--ink)}
.demo-head p{font-size:13px;color:var(--slate);margin-top:2px}
.demo-close{
  width:36px;height:36px;border-radius:10px;border:1.5px solid var(--line);
  background:#fff;cursor:pointer;display:grid;place-items:center;
  flex-shrink:0;transition:.15s;color:var(--ink);
}
.demo-close:hover{background:var(--line-2);border-color:#cdd6dd}
.demo-img-wrap{position:relative;overflow:hidden;background:#1a2a35;line-height:0}
.demo-img-wrap img{width:100%;height:auto;display:block;max-height:none}
.demo-svg{position:absolute;inset:0;width:100%;height:100%;pointer-events:none}
/* SVG animation */
/* ── Animation SVG en boucle ── */
/* Durée totale du cycle : 5s */
.dp-dot{
  fill:#13a6e8;stroke:#fff;stroke-width:2.5;
  vector-effect:non-scaling-stroke;
  transform-origin:center;
}
.dp-line{
  stroke:#13a6e8;stroke-width:3;fill:none;
  stroke-linecap:round;stroke-linejoin:round;
  vector-effect:non-scaling-stroke;
  stroke-dasharray:1200;stroke-dashoffset:1200;
}
.dp-fill{fill:rgba(19,166,232,.22);stroke:none;opacity:0}
.dp-badge{opacity:0}
.dp-labels{opacity:0}

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

/* Application des animations (cycle 5s en boucle) */
.demo-anim-running .dp-dot#dp1{animation:dotPop 5s ease infinite;animation-delay:0s}
.demo-anim-running .dp-dot#dp2{animation:dotPop 5s ease infinite;animation-delay:.55s}
.demo-anim-running .dp-dot#dp3{animation:dotPop 5s ease infinite;animation-delay:1.1s}
.demo-anim-running .dp-dot#dp4{animation:dotPop 5s ease infinite;animation-delay:1.65s}
.demo-anim-running .dp-line    {animation:lineTrace 5s ease infinite}
.demo-anim-running .dp-fill    {animation:fadeInOut 5s ease infinite}
.demo-anim-running .dp-badge   {animation:fadeInOut 5s ease infinite}
.demo-anim-running .dp-labels  {animation:fadeInOut 5s ease infinite}
/* type badge in demo */
.demo-type-badge{
  position:absolute;top:12px;left:12px;
  background:rgba(15,34,49,.85);color:#fff;
  padding:5px 12px;border-radius:8px;font:700 12px 'Inter',sans-serif;
  backdrop-filter:blur(4px);
}
.demo-steps{display:flex;gap:0;border-top:1px solid var(--line)}
.demo-step{flex:1;padding:14px 16px;border-right:1px solid var(--line);text-align:center}
.demo-step:last-child{border-right:0}
.demo-step .ds-num{width:26px;height:26px;border-radius:50%;background:var(--accent);color:#fff;
  font:800 12px 'Inter',sans-serif;display:grid;place-items:center;margin:0 auto 6px}
.demo-step .ds-label{font-size:12px;font-weight:600;color:var(--ink);line-height:1.4}
.demo-step .ds-sub{font-size:11px;color:var(--muted);margin-top:2px}
.demo-foot{padding:16px 24px;display:flex;gap:12px;align-items:center;border-top:1px solid var(--line);background:#f8fafc}
.demo-foot p{font-size:12.5px;color:var(--slate);flex:1}
.demo-start-btn{
  border:0;background:var(--ink);color:#fff;padding:12px 22px;
  border-radius:11px;font:700 14px 'Inter',sans-serif;cursor:pointer;
  display:flex;align-items:center;gap:8px;transition:.15s ease;white-space:nowrap;
}
.demo-start-btn:hover{background:#0a1a26;transform:translateY(-1px)}

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
      <div class="step" id="step2-nav"><div class="num">2</div><span>Zone</span></div>
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
          <h2 style="font-size:16px">Votre zone d'installation</h2>
          <span style="background:var(--accent-soft);color:var(--accent-deep);padding:3px 10px;border-radius:999px;font-weight:700;font-size:11px;letter-spacing:.04em" id="drawModeBadge">TOITURE</span>
        </div>
        <p class="lede" style="margin-bottom:12px">Choisissez le type d'installation, puis cliquez sur la carte pour tracer votre zone.</p>

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
        <div class="meta-label">Surface tracée</div>
        <div class="surface-display">
          <span class="s-val" id="surfaceVal">0</span>
          <span class="s-unit">m²</span>
        </div>
        <div class="surface-sub" id="surfaceSub">Tracez votre zone sur la carte satellite</div>

        {{-- Actions --}}
        <button class="btn btn-primary" id="validateZoneBtn" disabled>
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
          Valider cette zone
        </button>
        <button class="btn btn-outline" id="clearZoneBtn" style="margin-top:8px">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
          Effacer et recommencer
        </button>

        <div class="zone-validated" id="zoneValidatedRow" style="display:none">
          <span class="check"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
          <span>Zone validée — <span id="zoneValidatedArea">0</span> m²</span>
          <button id="editZoneBtn">Modifier</button>
        </div>
      </section>

      {{-- Roof config (appears after zone validated) --}}
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

      {{-- Draw hint --}}
      <div class="draw-hint hidden" id="drawHint">
        <span class="dot"></span>
        <span id="drawHintText">Cliquez sur la carte pour placer les premiers points</span>
      </div>

      {{-- Draw toolbar (undo / clear) --}}
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

{{-- ── Popup démo ── --}}
<div class="demo-backdrop" id="demoPopup" style="display:none" role="dialog" aria-modal="true" aria-label="Comment tracer votre zone">
  <div class="demo-box">
    <div class="demo-head">
      <div>
        <h3 id="demoTitle">Comment tracer votre zone d'installation</h3>
        <p>Regardez l'exemple ci-dessous, puis fermez pour commencer à tracer sur votre toiture.</p>
      </div>
      <button class="demo-close" id="demoCloseBtn" aria-label="Fermer">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>

    {{-- Image satellite + animation SVG --}}
    <div class="demo-img-wrap" id="demoImgWrap">
      <img id="demoImg" src="" alt="Vue satellite de la toiture" loading="lazy">
      <div class="demo-type-badge" id="demoTypeBadge">🏠 Toiture</div>

      {{-- SVG animé — viewBox dynamique calé sur l'image via JS (coords espace image 1536×1024) --}}
      <svg class="demo-svg" id="demoSvg" viewBox="0 0 720 540" preserveAspectRatio="none">
        {{-- Pan W de la toiture (triangle gauche) : P1=haut, P2=gauche, P3=bas, P4=intérieur --}}
        <polygon class="dp-fill" id="dpFill" points="241,92 518,92 518,378 241,378"/>
        <polyline class="dp-line" id="dpLine" points="241,92 518,92 518,378 241,378 241,92"/>
        <circle class="dp-dot" id="dp1" cx="241" cy="92" r="18"/>
        <circle class="dp-dot" id="dp2" cx="518" cy="92" r="18"/>
        <circle class="dp-dot" id="dp3" cx="518" cy="378" r="18"/>
        <circle class="dp-dot" id="dp4" cx="241" cy="378" r="18"/>
        <g class="dp-labels" id="dpLabels">
          <circle cx="241" cy="92" r="28" fill="rgba(19,166,232,.9)"/>
          <text x="241" y="101" fill="#fff" font-family="Inter,sans-serif" font-size="30" font-weight="800" text-anchor="middle">1</text>
          <circle cx="518" cy="92" r="28" fill="rgba(19,166,232,.9)"/>
          <text x="518" y="101" fill="#fff" font-family="Inter,sans-serif" font-size="30" font-weight="800" text-anchor="middle">2</text>
          <circle cx="518" cy="378" r="28" fill="rgba(19,166,232,.9)"/>
          <text x="518" y="387" fill="#fff" font-family="Inter,sans-serif" font-size="30" font-weight="800" text-anchor="middle">3</text>
          <circle cx="241" cy="378" r="28" fill="rgba(19,166,232,.9)"/>
          <text x="241" y="387" fill="#fff" font-family="Inter,sans-serif" font-size="30" font-weight="800" text-anchor="middle">4</text>
        </g>
        <g class="dp-badge" id="dpBadge">
          <rect x="310" y="210" width="200" height="60" rx="12" fill="rgba(15,34,49,.88)"/>
          <text x="410" y="241" fill="#fff" font-family="Inter,sans-serif" font-size="34" font-weight="800" text-anchor="middle">≈ 35 m²</text>
        </g>
      </svg>
    </div>

    {{-- Étapes --}}
    <div class="demo-steps">
      <div class="demo-step">
        <div class="ds-num">1</div>
        <div class="ds-label">Cliquez sur un coin</div>
        <div class="ds-sub">de votre toiture ou terrain</div>
      </div>
      <div class="demo-step">
        <div class="ds-num">2</div>
        <div class="ds-label">Tracez le contour</div>
        <div class="ds-sub">en cliquant point par point</div>
      </div>
      <div class="demo-step">
        <div class="ds-num">3</div>
        <div class="ds-label">Validez la zone</div>
        <div class="ds-sub">dès 3 points — surface calculée</div>
      </div>
    </div>

    <div class="demo-foot">
      <p>💡 Tracez uniquement la surface utile. Vous pouvez effacer et recommencer à tout moment.</p>
      <button class="demo-start-btn" id="demoStartBtn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        Commencer à tracer
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
window.__leadUrl     = @json(route('api.solar.lead'));

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
let map, marker;

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

    // Afficher étape dessin de zone
    $('cardDraw').style.display = 'block';
    $('cardRoof').style.display = 'none';
    mapInfoText.innerHTML = `<b>Cliquez sur votre toiture</b> pour délimiter la zone d'installation.`;
    setStep(2);
    showToast('Adresse analysée — tracez votre zone ✓');
    fAdresse.value = state.address;

    // Démarrer le mode dessin automatiquement
    if(typeof startDrawMode === 'function') startDrawMode();

  } catch(e){
    // Solar API indisponible MAIS l'adresse est valide → on affiche quand même l'étape dessin
    // avec des valeurs estimatives (sans données Solar API)
    $('cardDraw').style.display = 'block';
    $('cardRoof').style.display = 'none';
    mapInfoText.innerHTML = `<b>Cliquez sur votre toiture</b> pour délimiter la zone d'installation.`;
    setStep(2);
    fAdresse.value = state.address;
    if(typeof startDrawMode === 'function') startDrawMode();
    // Afficher une note discrète (pas une erreur bloquante)
    dbg('WARN', 'Solar API indisponible — mode estimation locale', e.message);
  } finally {
    mapLoading.classList.add('hidden');
  }
}

// ── Drawing state ─────────────────────────────────────────────────
const draw = {
  active: false,       // mode dessin actif
  validated: false,    // zone validée
  zoneType: 'roof',   // 'roof' | 'garden'
  points: [],          // google.maps.LatLng[]
  polygon: null,       // google.maps.Polygon
  markers: [],         // vertex markers
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

// Calcul panneaux depuis surface tracée
function panelsFromArea(m2, zoneType){
  // Roof: 1.7m² / panneau (1.722m × 1.013m standard)
  // Garden: 2.5m² / panneau (inter-rangs inclus)
  const m2PerPanel = zoneType === 'garden' ? 2.5 : 1.7;
  return Math.max(1, Math.floor(m2 / m2PerPanel));
}

function updateDrawUI(){
  const m2 = computeAreaM2(draw.points);
  const rounded = Math.round(m2);
  $('surfaceVal').textContent = rounded;

  if(draw.points.length < 3){
    $('surfaceSub').textContent = draw.points.length === 0
      ? 'Tracez votre zone sur la carte satellite'
      : draw.points.length === 1
      ? 'Continuez à cliquer pour former la zone…'
      : 'Encore un point pour fermer la zone…';
    $('validateZoneBtn').disabled = true;
  } else {
    const panels = panelsFromArea(m2, draw.zoneType);
    const kwc    = (panels * 0.425).toFixed(2);
    $('surfaceSub').textContent = `≈ ${panels} panneaux · ${kwc} kWc`;
    $('validateZoneBtn').disabled = false;
  }

  // Toolbar visibility
  const toolbar = $('drawToolbar');
  if(draw.points.length > 0 && !draw.validated) toolbar.classList.remove('hidden');
  else toolbar.classList.add('hidden');

  // Draw hint
  const hint = $('drawHint');
  if(!draw.validated && draw.points.length === 0){
    hint.classList.remove('hidden');
    $('drawHintText').textContent = draw.zoneType === 'garden'
      ? 'Cliquez sur votre jardin/terrain pour délimiter la zone'
      : 'Cliquez sur votre toiture pour délimiter la zone';
  } else {
    hint.classList.add('hidden');
  }
}

function drawPolygon(){
  if(draw.polygon){ draw.polygon.setMap(null); draw.polygon = null; }

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
      draw.polygon.setOptions({strokeColor:'#1f8a5b', fillColor:'#1f8a5b'});
    }
  }
}

function addVertexMarker(latlng, idx){
  const m = new google.maps.Marker({
    position: latlng,
    map,
    icon: {
      path: google.maps.SymbolPath.CIRCLE,
      scale: idx === 0 ? 9 : 7,
      fillColor: '#13a6e8',
      fillOpacity: 1,
      strokeColor: '#fff',
      strokeWeight: 2.5,
    },
    title: `Point ${idx+1}`,
    clickable: !draw.validated,
    zIndex: 10 + idx,
  });
  draw.markers.push(m);
}

function clearDrawing(keepValidated = false){
  if(draw.polygon){ draw.polygon.setMap(null); draw.polygon = null; }
  draw.markers.forEach(m => m.setMap(null));
  draw.markers = [];
  draw.points  = [];
  if(!keepValidated) draw.validated = false;
  updateDrawUI();
}

// ── Popup démo ───────────────────────────────────────────────────
const demoPopup  = $('demoPopup');
const demoImg    = $('demoImg');
let   demoSvgAnimStarted = false;

function calibrateDemoSvg(){
  // Recalcule le viewBox SVG pour coller exactement à l'image affichée.
  // L'image (1536×1024) est affichée via object-fit:cover dans le conteneur.
  // Le SVG (inset:0) doit utiliser les mêmes coordonnées image.
  const svg  = $('demoSvg');
  const img  = demoImg;
  const wrap = img.parentElement;
  if(!svg || !wrap) return;

  const W = wrap.clientWidth  || 720;
  const H = wrap.clientHeight || 360;
  const imgW = 1536, imgH = 1024;

  // object-fit:cover : scale = le plus grand des deux ratios
  const scale = Math.max(W / imgW, H / imgH);
  const rendW = imgW * scale, rendH = imgH * scale;

  // Crop (en px image originale) pour centrer
  const cropX = (rendW - W) / 2 / scale;  // px originaux rognés à gauche
  const cropY = (rendH - H) / 2 / scale;  // px originaux rognés en haut

  const visW  = W / scale;  // largeur visible en px image
  const visH  = H / scale;  // hauteur visible en px image

  // viewBox fixed — xMidYMid slice aligne automatiquement avec object-fit:cover
  // preserveAspectRatio=none → le viewBox remplit exactement le conteneur
}

function openDemoPopup(){
  if(!demoPopup) return;

  const isGarden = draw.zoneType === 'garden';
  demoImg.src = isGarden ? '/slide/demo-jardin-aerien.jpg' : '/slide/demo-toiture-crop.jpg';

  $('demoTypeBadge').textContent = isGarden ? '🌿 Sol / Jardin' : '🏠 Toiture';
  $('demoTitle').textContent = isGarden
    ? 'Comment tracer votre zone au sol / jardin'
    : 'Comment tracer votre zone de toiture';

  // Adapter les coords en espace image original selon le type
  const svg = $('demoSvg');
  if(isGarden){
    // Jardin : image 1024×820 (jardin-aerien) — grand rectangle sur la pelouse centrale
    // points en espace image 800×500
    svg.setAttribute('viewBox','0 0 800 500');
    const pts = '150,100 150,400 550,400 550,100';
    $('dpFill').setAttribute('points', pts);
    $('dpLine').setAttribute('points', pts + ' ' + pts.split(' ')[0]);
    $('dp1').setAttribute('cx','150'); $('dp1').setAttribute('cy','100');
    $('dp2').setAttribute('cx','150'); $('dp2').setAttribute('cy','400');
    $('dp3').setAttribute('cx','550'); $('dp3').setAttribute('cy','400');
    $('dp4').setAttribute('cx','550'); $('dp4').setAttribute('cy','100');
    // Labels
    const circles = $('dpLabels').querySelectorAll('circle');
    const texts   = $('dpLabels').querySelectorAll('text');
    const lc = [[150,100],[150,400],[550,400],[550,100]];
    lc.forEach(([x,y],i) => {
      if(circles[i]){ circles[i].setAttribute('cx',x); circles[i].setAttribute('cy',y); }
      if(texts[i])  { texts[i].setAttribute('x',x);   texts[i].setAttribute('y',y+9); }
    });
    // Badge
    const bg = $('dpBadge')?.querySelector('rect');
    const bt = $('dpBadge')?.querySelector('text');
    if(bg){ bg.setAttribute('x','270'); bg.setAttribute('y','228'); }
    if(bt){ bt.setAttribute('x','380'); bt.setAttribute('y','268'); bt.textContent='≈ 120 m²'; }
  } else {
    // Toiture : image aerial.png 1536×1024
    // Pan W (gauche) : P1=haut-gauche, P2=max-gauche, P3=bas-gauche, P4=intérieur
    // Coords en espace image original (1536×1024)
    const pts = '241,92 518,92 518,378 241,378';  // P1=NW P3=SW P4=centre
    $('dpFill').setAttribute('points', pts);
    $('dpLine').setAttribute('points', pts + ' ' + pts.split(' ')[0]);
    $('dp1').setAttribute('cx','241'); $('dp1').setAttribute('cy','92');
    $('dp2').setAttribute('cx','518'); $('dp2').setAttribute('cy','92'); $('dp2').setAttribute('r','18'); $('dp2').style.display='';
    $('dp3').setAttribute('cx','518'); $('dp3').setAttribute('cy','378');
    $('dp4').setAttribute('cx','241'); $('dp4').setAttribute('cy','378');
    const circles = $('dpLabels').querySelectorAll('circle');
    const texts   = $('dpLabels').querySelectorAll('text');
    const lc = [[241,92],[518,92],[518,378],[241,378]];
    lc.forEach(([x,y],i) => {
      if(circles[i]){ circles[i].setAttribute('cx',x); circles[i].setAttribute('cy',y); }
      if(texts[i])  { texts[i].setAttribute('x',x);   texts[i].setAttribute('y',y+9); }
    });
    const bg = $('dpBadge')?.querySelector('rect');
    const bt = $('dpBadge')?.querySelector('text');
    if(bg){ bg.setAttribute('x','310'); bg.setAttribute('y','210'); }
    if(bt){ bt.setAttribute('x','410'); bt.setAttribute('y','241'); bt.textContent='≈ 35 m²'; }
  }

  demoPopup.style.display = 'flex';
  document.body.style.overflow = 'hidden';

  // Calibrer le viewBox après que l'image soit chargée et affichée
  const doCalibrate = () => {
    if(!isGarden) calibrateDemoSvg(); // pour la toiture seulement (coords en espace image)
    // Lancer l'animation CSS infinie
    const svgEl = $('demoSvg');
    if(svgEl){ svgEl.classList.remove('demo-anim-running'); void svgEl.offsetWidth; svgEl.classList.add('demo-anim-running'); }
  };

  if(demoImg.complete && demoImg.naturalWidth > 0) {
    setTimeout(doCalibrate, 50);
  } else {
    demoImg.onload = () => setTimeout(doCalibrate, 50);
    setTimeout(doCalibrate, 400); // fallback
  }
}

function closeDemoPopup(){
  const svgEl = $("demoSvg");
  if(svgEl) svgEl.classList.remove("demo-anim-running");
  demoPopup.classList.add('closing');
  setTimeout(() => {
    demoPopup.style.display = 'none';
    demoPopup.classList.remove('closing');
    document.body.style.overflow = '';
  }, 240);
}

$('demoCloseBtn')?.addEventListener('click', closeDemoPopup);
$('demoStartBtn')?.addEventListener('click', closeDemoPopup);
demoPopup?.addEventListener('click', e => { if(e.target === demoPopup) closeDemoPopup(); });

function startDrawMode(){
  draw.active    = true;
  draw.validated = false;
  clearDrawing();
  document.querySelector('.map-wrap').classList.add('drawing');

  if(draw.clickListener) google.maps.event.removeListener(draw.clickListener);
  draw.clickListener = map.addListener('click', e => {
    if(draw.validated) return;
    draw.points.push(e.latLng);
    addVertexMarker(e.latLng, draw.points.length - 1);
    drawPolygon();
    updateDrawUI();
  });

  updateDrawUI();
  // Ouvrir le popup démo
  setTimeout(openDemoPopup, 500);
}

function stopDrawMode(){
  draw.active = false;
  document.querySelector('.map-wrap').classList.remove('drawing');
  if(draw.clickListener){ google.maps.event.removeListener(draw.clickListener); draw.clickListener = null; }
}

function validateZone(){
  if(draw.points.length < 3) return;
  draw.validated = true;
  stopDrawMode();
  drawPolygon();

  const m2      = computeAreaM2(draw.points);
  const panels  = panelsFromArea(m2, draw.zoneType);
  const kwc     = +(panels * 0.425).toFixed(2);

  // Production basée sur les données Solar API ou ratio standard France
  const baseRatio = state.results
    ? state.results.yearlyKwh / Math.max(state.results.kwc, 0.1)
    : 1180; // kWh/kWc/an
  const orientCoeff = {Sud:1.0,'Sud-Est':.95,'Sud-Ouest':.95,'Est':.85,'Ouest':.85,'Nord':.65};
  const inclCoeff   = {0:.85,15:.92,30:1.0,45:.97,60:.90};
  const orient = $('orientSelect')?.value || 'Sud';
  const incl   = $('inclSelect')?.value   || '30';
  const gardenBonus = draw.zoneType === 'garden' ? 1.05 : 1; // au sol légèrement + exposé
  const yearlyKwh   = Math.round(kwc * baseRatio * (orientCoeff[orient]||1) * (inclCoeff[incl]||1) * gardenBonus);

  const electricityPrice = 0.2276, selfRate = 0.35, resalePrice = 0.1269;
  const annualSavings    = Math.round(yearlyKwh * selfRate * electricityPrice + yearlyKwh * (1-selfRate) * resalePrice);

  // Calcul budget (toiture vs sol)
  const budgetFactorMin = draw.zoneType === 'garden' ? 1800 : 2000;
  const budgetFactorMax = draw.zoneType === 'garden' ? 2400 : 2800;

  // Update right panel
  const r = {
    panelCount: panels, kwc, yearlyKwh, annualSavings,
    budgetMin: Math.round(kwc * budgetFactorMin / 100) * 100,
    budgetMax: Math.round(kwc * budgetFactorMax / 100) * 100,
    monthlyKwh: [.045,.06,.085,.10,.115,.125,.13,.12,.095,.07,.045,.035].map(w => Math.round(yearlyKwh * w)),
    areaM2: Math.round(m2),
  };
  state.drawResults = r;
  displayResults(r);

  // UI updates
  $('surfaceVal').textContent = Math.round(m2);
  $('surfaceSub').textContent = `${panels} panneaux · ${kwc} kWc`;
  $('zoneValidatedArea').textContent = Math.round(m2);
  $('zoneValidatedRow').style.display = 'flex';
  $('validateZoneBtn').style.display  = 'none';
  $('clearZoneBtn').style.display     = 'none';

  // Afficher config toiture
  $('cardRoof').style.display = 'block';
  $('cardRoof').scrollIntoView({behavior:'smooth', block:'nearest'});
  setStep(3);
  showToast(`Zone validée — ${Math.round(m2)} m² · ${panels} panneaux ✓`);
  mapInfoText.innerHTML = `<b>Zone tracée :</b> ${Math.round(m2)} m² · ${panels} panneaux · ${fmt(yearlyKwh)} kWh/an estimés.`;
}

// ── Zone type toggle ──────────────────────────────────────────────
[$('zoneBtnRoof'), $('zoneBtnGarden')].forEach(btn => {
  btn?.addEventListener('click', () => {
    [$('zoneBtnRoof'), $('zoneBtnGarden')].forEach(b => b?.classList.remove('active'));
    btn.classList.add('active');
    draw.zoneType = btn.dataset.zone;
    $('drawModeBadge').textContent = draw.zoneType === 'garden' ? 'SOL/JARDIN' : 'TOITURE';
    updateDrawUI();
    // Rouvrir le popup démo si aucun point tracé
    if(draw.points.length === 0 && draw.active && typeof openDemoPopup === 'function') openDemoPopup();
    else if(draw.points.length >= 3) updateDrawUI();
  });
});

// ── Validate / Clear / Edit buttons ─────────────────────────────
$('validateZoneBtn')?.addEventListener('click', validateZone);
$('clearZoneBtn')?.addEventListener('click', () => { clearDrawing(); updateDrawUI(); });
$('editZoneBtn')?.addEventListener('click', () => {
  draw.validated = false;
  $('zoneValidatedRow').style.display = 'none';
  $('validateZoneBtn').style.display  = '';
  $('clearZoneBtn').style.display     = '';
  $('cardRoof').style.display         = 'none';
  clearDrawing();
  startDrawMode();
  setStep(2);
});
$('undoPointBtn')?.addEventListener('click', () => {
  if(!draw.points.length) return;
  draw.points.pop();
  const last = draw.markers.pop();
  if(last) last.setMap(null);
  drawPolygon();
  updateDrawUI();
});
$('clearDrawBtn')?.addEventListener('click', () => { clearDrawing(); updateDrawUI(); });

// ── Autocomplétion custom via Nominatim (backend) ────────────────
const autocompleteList = $('autocompleteList');
let acItems = [], acFocused = -1, acDebounce;

function openAddress(item){
  state.lat     = item.lat;
  state.lng     = item.lng;
  state.address = item.label;
  closeAutocomplete();
  addressInput.value = item.label;
  addrPillText.textContent = item.label;
  addrPill.style.display   = 'flex';
  addrSearchWrap.style.display = 'none';
  if(map){
    map.setTilt(0);
    map.setCenter({lat: item.lat, lng: item.lng});
    map.setZoom(20); // zoom pour voir la toiture entière avec contexte
    if(marker){ marker.setPosition({lat: item.lat, lng: item.lng}); marker.setVisible(true); }
  }
  fAdresse.value = item.label;
  fetchSolarData();
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
    disableDefaultUI: true,
    zoomControl: true,
    zoomControlOptions: {position: google.maps.ControlPosition.RIGHT_CENTER},
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
  const lsBtns = document.querySelectorAll('.layer-switch button');
  lsBtns.forEach(b => b.addEventListener('click', () => {
    map.setMapTypeId(b.dataset.type);
    lsBtns.forEach(x => x.classList.toggle('active', x === b));
  }));

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
}

// ── Change address ────────────────────────────────────────────────
changeAddrBtn.addEventListener('click', () => {
  addrPill.style.display = 'none';
  addrSearchWrap.style.display = 'block';
  addressInput.value = '';
  addressInput.focus();
  analyzeBtn.disabled = true;
  cardRoof.style.display = 'none';
  $('cardDraw').style.display = 'none';
  // Reset dessin
  if(typeof clearDrawing === 'function'){ clearDrawing(); stopDrawMode(); }
  // Reset métriques
  ['metricPanels','metricKwc','metricKwh','metricSavings','budgetCard'].forEach(id => {
    const el = $(id); if(el) el.classList.add('skeleton');
  });
  $('valPanels').innerHTML = '— <small>panneaux</small>';
  $('valKwc').innerHTML    = '— <small>kWc</small>';
  $('valKwh').innerHTML    = '— <small>kWh/an</small>';
  $('valSavings').innerHTML= '— <small>€/an</small>';
  $('valBudget').innerHTML = '— <small>€</small>';
  state.results = null; state.lat = null; state.lng = null;
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
  const src = `https://maps.googleapis.com/maps/api/js?key=${key}&callback=initMapCallback&language=fr&region=FR&v=weekly`;
  dbg('INFO', 'Chargement script Maps', src.replace(key, key.slice(0,10)+'…'));

  const mapsScript = document.createElement('script');
  mapsScript.src = src;
  // PAS de async/defer ici : le paramètre callback= suffit
  mapsScript.onerror = function(e){
    dbg('ERROR', 'Échec chargement script Maps (onerror)', 'API Maps JavaScript non activée ou réseau indisponible.');
    showMapError('Impossible de charger le script Google Maps. Vérifiez la connexion.');
  };
  document.head.appendChild(mapsScript);

  // Watchdog : si après 10 s la carte n'est toujours pas chargée
  setTimeout(() => {
    if(!map){
      dbg('WARN', 'Timeout 10s — Maps n\'a pas appelé le callback. Probablement gm_authFailure silencieux.');
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
loadMaps();

})();
</script>

{{-- ── Panneau de debug (visible, aide au diagnostic) ── --}}
<div id="debugContainer" style="
  position:fixed;bottom:0;right:0;width:420px;max-height:260px;
  background:#fff;border:2px solid #e6ebef;border-radius:16px 0 0 0;
  box-shadow:0 -4px 24px rgba(15,34,49,.12);z-index:9999;
  display:flex;flex-direction:column;font-family:'Inter',monospace;
">
  <div style="
    display:flex;align-items:center;justify-content:space-between;
    padding:8px 14px;background:#0f2231;border-radius:14px 0 0 0;cursor:pointer;
  " id="debugToggle">
    <span style="color:#fff;font-size:12px;font-weight:700;letter-spacing:.04em">🔍 DEBUG — Google Maps</span>
    <span style="color:#8a96a0;font-size:11px" id="debugToggleLabel">Masquer</span>
  </div>
  <div id="debugPanel" style="overflow-y:auto;padding:10px 14px;flex:1;font-size:11.5px"></div>
  <div style="padding:8px 14px;border-top:1px solid #eef2f5;display:flex;gap:8px">
    <button onclick="copyDebugLogs()" style="flex:1;border:1px solid #e6ebef;background:#f4f6f8;border-radius:7px;padding:5px 10px;font-size:11px;cursor:pointer;font-weight:600">📋 Copier les logs</button>
    <button onclick="document.getElementById('debugContainer').remove()" style="border:1px solid #e6ebef;background:#fff;border-radius:7px;padding:5px 10px;font-size:11px;cursor:pointer;color:#e23a3a;font-weight:600">✕ Fermer</button>
  </div>
</div>
<script>
document.getElementById('debugToggle').addEventListener('click', function(){
  const p = document.getElementById('debugPanel');
  const l = document.getElementById('debugToggleLabel');
  const c = document.getElementById('debugContainer');
  if(p.style.display === 'none'){ p.style.display=''; c.style.maxHeight='260px'; l.textContent='Masquer'; }
  else { p.style.display='none'; c.style.maxHeight='auto'; l.textContent='Afficher'; }
});
function copyDebugLogs(){
  const text = (window.debugLogs||[]).map(e=>`[${e.t}] ${e.level} — ${e.msg}${e.data?' | '+JSON.stringify(e.data):''}`).join('\n');
  navigator.clipboard.writeText(text).then(()=>alert('Logs copiés !')).catch(()=>prompt('Copiez les logs :',text));
}
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
