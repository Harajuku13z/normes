@php
    use App\Support\HomeView;
    $h = $home ?? [];
    $logo = HomeView::url((string) data_get($h, 'header.logo', '/logo.png'));
    $siteName = (string) data_get($h, 'meta.site_name', 'Normes Renovation');
    $defaultProjectType = old('type_projet', 'autoconsommation');
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Confirmation du projet solaire - {{ $siteName }}</title>
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
  --yellow:#f5c400;
  --danger:#e23a3a;
  --danger-soft:#fdecec;
  --shadow:0 1px 2px rgba(15,34,49,.04),0 8px 24px rgba(15,34,49,.06);
  --radius:16px;
}
*{box-sizing:border-box}
html,body{
  margin:0;
  min-height:100vh;
  background:
    radial-gradient(1200px 600px at 80% -10%,#eaf4fb 0%,transparent 60%),
    radial-gradient(900px 500px at -10% 110%,#eef4f8 0%,transparent 60%),
    var(--bg);
  color:var(--ink);
  font-family:'Inter',system-ui,-apple-system,Segoe UI,sans-serif;
  -webkit-font-smoothing:antialiased;
}
.page{max-width:1240px;margin:0 auto;padding:20px 24px 40px}
.topbar{
  background:var(--card);border:1px solid var(--line);border-radius:18px;padding:14px 22px;
  display:flex;align-items:center;gap:20px;box-shadow:var(--shadow);
}
.brand img{height:44px;width:auto;display:block}
.stepper{flex:1;display:flex;align-items:center;justify-content:center;gap:10px}
.step{display:flex;align-items:center;gap:9px;color:var(--muted);font-weight:500;font-size:14px}
.step .num{
  width:28px;height:28px;border-radius:50%;background:#eef2f5;color:#8a96a0;
  display:grid;place-items:center;font-weight:700;font-size:12px;flex-shrink:0;
}
.step.done .num{background:#1f8a5b;color:#fff}
.step.done{color:var(--ink-2)}
.step.active .num{background:var(--ink);color:#fff}
.step.active{color:var(--ink);font-weight:700}
.step-sep{width:40px;height:2px;background:linear-gradient(90deg,#dfe5ea,#eef2f5);border-radius:999px}
.step-sep.done{background:#1f8a5b;opacity:.45}
.help-link{
  border:1px solid var(--line);background:#fff;border-radius:12px;padding:10px 14px;
  color:var(--ink);font-size:13px;font-weight:700;text-decoration:none;
}
.shell{display:grid;grid-template-columns:1.05fr .95fr;gap:20px;margin-top:20px}
.card{
  background:var(--card);border:1px solid var(--line);border-radius:var(--radius);
  padding:24px;box-shadow:var(--shadow);
}
.eyebrow{
  display:inline-flex;align-items:center;gap:8px;padding:6px 10px;border-radius:999px;
  background:var(--accent-soft);color:var(--accent-deep);font-size:11px;font-weight:800;
  letter-spacing:.08em;text-transform:uppercase;
}
h1{margin:14px 0 8px;font-size:34px;line-height:1.05;letter-spacing:-.03em}
.lede{margin:0 0 22px;color:var(--slate);font-size:15px;line-height:1.6}
.summary-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}
.summary-card{
  border:1px solid var(--line);border-radius:14px;padding:16px;background:#fbfdff;
}
.summary-label{font-size:11px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-bottom:8px}
.summary-value{font-size:28px;font-weight:800;letter-spacing:-.03em}
.summary-sub{font-size:13px;color:var(--slate);margin-top:6px}
.notice{
  margin-top:16px;border:1px solid #d9edf8;background:#f4fbff;color:#28526d;
  border-radius:14px;padding:14px 16px;font-size:14px;line-height:1.5;
}
.warning{
  margin-top:16px;border:1px solid #f0c4c4;background:var(--danger-soft);color:#8d1f1f;
  border-radius:14px;padding:14px 16px;font-size:14px;line-height:1.5;
}
.field{margin-bottom:16px}
.field label{display:block;margin-bottom:7px;font-size:13px;font-weight:700;color:var(--ink)}
.field input{
  width:100%;border:1.5px solid var(--line);border-radius:12px;padding:13px 14px;
  font:500 14px 'Inter',sans-serif;color:var(--ink);outline:none;background:#fff;
}
.field input:focus{border-color:var(--accent);box-shadow:0 0 0 3px var(--accent-soft)}
.field input.error{border-color:var(--danger);background:#fff7f7}
.row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.project-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;margin-top:8px}
.project-btn{
  border:1.5px solid var(--line);background:#fff;border-radius:12px;padding:14px 12px;cursor:pointer;
  text-align:left;transition:.15s ease;color:var(--ink);
}
.project-btn strong{display:block;font-size:14px;margin-bottom:3px}
.project-btn span{font-size:12px;color:var(--slate)}
.project-btn.active{border-color:var(--accent);background:var(--accent-soft);box-shadow:inset 0 0 0 1px rgba(19,166,232,.08)}
.actions{display:flex;align-items:center;gap:12px;margin-top:22px}
.btn{
  appearance:none;border:none;border-radius:14px;padding:15px 18px;cursor:pointer;
  font:800 14px/1 'Inter',sans-serif;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;gap:10px;
}
.btn-primary{background:var(--yellow);color:#0f2231;box-shadow:0 10px 22px rgba(245,196,0,.24)}
.btn-secondary{background:#fff;border:1.5px solid var(--line);color:var(--ink)}
.btn:disabled{opacity:.55;cursor:not-allowed}
.fine{margin-top:14px;font-size:12px;color:var(--muted);line-height:1.55}
.error-box{
  margin-bottom:16px;border:1px solid #f0c4c4;background:var(--danger-soft);color:#8d1f1f;
  border-radius:12px;padding:12px 14px;font-size:14px;
}
.list-errors{margin:0;padding-left:18px}
@media (max-width: 980px){
  .shell{grid-template-columns:1fr}
}
@media (max-width: 720px){
  .page{padding:14px 14px 32px}
  .topbar{padding:14px;gap:12px;flex-wrap:wrap}
  .stepper{order:3;width:100%;justify-content:flex-start;overflow:auto;padding-bottom:2px}
  h1{font-size:28px}
  .summary-grid,.row,.project-grid{grid-template-columns:1fr}
  .actions{flex-direction:column;align-items:stretch}
}
</style>
</head>
<body>
<div class="page">
  <div class="topbar">
    <a class="brand" href="{{ route('home') }}" aria-label="{{ $siteName }}">
      <img src="{{ $logo }}" alt="{{ $siteName }}">
    </a>
    <div class="stepper" aria-label="Progression">
      <div class="step done"><span class="num">✓</span><span>Adresse</span></div>
      <div class="step-sep done"></div>
      <div class="step done"><span class="num">✓</span><span>Zone</span></div>
      <div class="step-sep done"></div>
      <div class="step done"><span class="num">✓</span><span>Simulation</span></div>
      <div class="step-sep"></div>
      <div class="step active"><span class="num">4</span><span>Confirmation</span></div>
    </div>
    <a class="help-link" href="{{ route('simulateur.solaire') }}">Retour au simulateur</a>
  </div>

  <div class="shell">
    <section class="card">
      <span class="eyebrow">Etape 4</span>
      <h1>Confirmez votre projet solaire</h1>
      <p class="lede">Vérifiez vos informations, choisissez votre besoin et validez votre demande. Dès confirmation, un e-mail part au client et un e-mail part à l'équipe.</p>

      @if ($errors->any())
        <div class="error-box">
          <ul class="list-errors">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="post" action="{{ route('simulateur.solaire.confirmation.store') }}" id="solarLeadForm" novalidate>
        @csrf
        <input type="hidden" name="type_projet" id="typeProjetInput" value="{{ $defaultProjectType }}">
        <input type="hidden" name="kwc" id="kwcInput" value="{{ old('kwc') }}">
        <input type="hidden" name="budget_min" id="budgetMinInput" value="{{ old('budget_min') }}">
        <input type="hidden" name="budget_max" id="budgetMaxInput" value="{{ old('budget_max') }}">
        <input type="hidden" name="yearly_kwh" id="yearlyKwhInput" value="{{ old('yearly_kwh') }}">
        <input type="hidden" name="panel_count" id="panelCountInput" value="{{ old('panel_count') }}">
        <input type="hidden" name="annual_savings" id="annualSavingsInput" value="{{ old('annual_savings') }}">
        <input type="hidden" name="surface_m2" id="surfaceM2Input" value="{{ old('surface_m2') }}">

        <div class="row">
          <div class="field">
            <label for="prenom">Prenom *</label>
            <input type="text" id="prenom" name="prenom" value="{{ old('prenom') }}" autocomplete="given-name" required>
          </div>
          <div class="field">
            <label for="nom">Nom *</label>
            <input type="text" id="nom" name="nom" value="{{ old('nom') }}" autocomplete="family-name" required>
          </div>
        </div>

        <div class="row">
          <div class="field">
            <label for="telephone">Telephone *</label>
            <input type="tel" id="telephone" name="telephone" value="{{ old('telephone') }}" autocomplete="tel" required>
          </div>
          <div class="field">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
          </div>
        </div>

        <div class="field">
          <label for="adresse">Adresse du projet *</label>
          <input type="text" id="adresse" name="adresse" value="{{ old('adresse') }}" autocomplete="street-address" required>
        </div>

        <div class="field">
          <label>Type de projet *</label>
          <div class="project-grid" id="projectTypeGrid">
            <button type="button" class="project-btn" data-type="autoconsommation">
              <strong>Autoconsommation</strong>
              <span>Je consomme l'electricite produite chez moi.</span>
            </button>
            <button type="button" class="project-btn" data-type="revente">
              <strong>Revente totale</strong>
              <span>Je souhaite surtout revendre ma production.</span>
            </button>
            <button type="button" class="project-btn" data-type="batterie">
              <strong>Avec batterie</strong>
              <span>Je veux ajouter du stockage a mon installation.</span>
            </button>
            <button type="button" class="project-btn" data-type="je-ne-sais-pas">
              <strong>Je ne sais pas</strong>
              <span>J'ai besoin d'etre conseille avant de choisir.</span>
            </button>
          </div>
        </div>

        <div class="actions">
          <button class="btn btn-primary" type="submit" id="submitBtn">Confirmer ma demande</button>
          <a class="btn btn-secondary" href="{{ route('simulateur.solaire') }}">Modifier ma simulation</a>
        </div>
        <p class="fine">Vos informations restent confidentielles. Une fois validée, votre demande est envoyée au client et a l'equipe.</p>
      </form>
    </section>

    <aside class="card">
      <span class="eyebrow">Resume</span>
      <h2 style="margin:14px 0 8px;font-size:28px;letter-spacing:-.03em">Votre installation estimee</h2>
      <p class="lede" style="margin-bottom:18px">Nous reprenons automatiquement les informations choisies sur l'etape precedente.</p>

      <div class="summary-grid">
        <div class="summary-card">
          <div class="summary-label">Panneaux</div>
          <div class="summary-value" id="summaryPanels">-</div>
          <div class="summary-sub">panneaux affiches</div>
        </div>
        <div class="summary-card">
          <div class="summary-label">Puissance</div>
          <div class="summary-value" id="summaryKwc">-</div>
          <div class="summary-sub">kWc</div>
        </div>
        <div class="summary-card">
          <div class="summary-label">Production annuelle</div>
          <div class="summary-value" id="summaryKwh">-</div>
          <div class="summary-sub">kWh / an</div>
        </div>
        <div class="summary-card">
          <div class="summary-label">Economies annuelles</div>
          <div class="summary-value" id="summarySavings">-</div>
          <div class="summary-sub">euros / an</div>
        </div>
      </div>

      <div class="notice">
        <strong id="summaryBudget">Budget estime : -</strong><br>
        <span id="summaryAddress">Adresse du projet a confirmer.</span><br>
        <span id="summarySurface">Surface disponible : -</span>
      </div>

      <div class="warning" id="missingDataNotice" style="display:none">
        Impossible de retrouver la simulation de l'etape precedente. Revenez au simulateur pour refaire votre selection avant de confirmer.
      </div>
    </aside>
  </div>
</div>

<script>
window.__solarStep4StorageKey = 'solarSimulatorStep4';

const projectTypeInput = document.getElementById('typeProjetInput');
const submitBtn = document.getElementById('submitBtn');
const form = document.getElementById('solarLeadForm');
const missingDataNotice = document.getElementById('missingDataNotice');
const fieldIds = ['prenom', 'nom', 'telephone', 'email', 'adresse'];

function fmtInt(value){
  return new Intl.NumberFormat('fr-FR', { maximumFractionDigits: 0 }).format(Number(value || 0));
}

function fmtDecimal(value){
  return new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(Number(value || 0));
}

function selectProjectType(type){
  projectTypeInput.value = type;
  document.querySelectorAll('#projectTypeGrid .project-btn').forEach(btn => {
    btn.classList.toggle('active', btn.dataset.type === type);
  });
}

document.querySelectorAll('#projectTypeGrid .project-btn').forEach(btn => {
  btn.addEventListener('click', () => selectProjectType(btn.dataset.type));
});
selectProjectType(projectTypeInput.value || 'autoconsommation');

function setValueIfEmpty(id, value){
  const input = document.getElementById(id);
  if(input && !input.value && value !== undefined && value !== null){
    input.value = value;
  }
}

function loadSimulation(){
  try {
    const raw = window.sessionStorage.getItem(window.__solarStep4StorageKey);
    if(!raw) return null;
    return JSON.parse(raw);
  } catch (e) {
    return null;
  }
}

const simulation = loadSimulation();
if(simulation){
  document.getElementById('summaryPanels').textContent = fmtInt(simulation.panels);
  document.getElementById('summaryKwc').textContent = fmtDecimal(simulation.kwc);
  document.getElementById('summaryKwh').textContent = fmtInt(simulation.yearlyKwh);
  document.getElementById('summarySavings').textContent = fmtInt(simulation.annualSavings);
  document.getElementById('summaryBudget').textContent = `Budget estime : ${fmtInt(simulation.budgetMin)} € a ${fmtInt(simulation.budgetMax)} €`;
  document.getElementById('summaryAddress').textContent = simulation.address || 'Adresse du projet a confirmer.';
  document.getElementById('summarySurface').textContent = `Surface disponible : ${fmtInt(simulation.surfaceM2)} m²`;

  setValueIfEmpty('adresse', simulation.address || '');
  setValueIfEmpty('kwcInput', simulation.kwc || '');
  setValueIfEmpty('budgetMinInput', simulation.budgetMin || '');
  setValueIfEmpty('budgetMaxInput', simulation.budgetMax || '');
  setValueIfEmpty('yearlyKwhInput', simulation.yearlyKwh || '');
  setValueIfEmpty('panelCountInput', simulation.panels || '');
  setValueIfEmpty('annualSavingsInput', simulation.annualSavings || '');
  setValueIfEmpty('surfaceM2Input', simulation.surfaceM2 || '');
} else {
  missingDataNotice.style.display = 'block';
  submitBtn.disabled = true;
}

form.addEventListener('submit', event => {
  let valid = true;
  fieldIds.forEach(id => {
    const input = document.getElementById(id);
    input.classList.remove('error');
    if(!input.value.trim()){
      input.classList.add('error');
      valid = false;
    }
  });

  const email = document.getElementById('email');
  if(email.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())){
    email.classList.add('error');
    valid = false;
  }

  if(!valid){
    event.preventDefault();
    return;
  }

  submitBtn.disabled = true;
  submitBtn.textContent = 'Envoi en cours...';
});
</script>
</body>
</html>
