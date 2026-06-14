@php
    use App\Support\HomeView;
    $h = $home ?? [];
    $logo = HomeView::url((string) data_get($h, 'header.logo', '/logo.png'));
    $siteName = (string) data_get($h, 'meta.site_name', 'Normes Renovation');
    $backUrl = route('simulateur.photovoltaique');
    $successUrl = route('simulateur.photovoltaique.success');
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Votre consommation - {{ $siteName }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{
  --ink:#0f2231;
  --ink-soft:#5a6b78;
  --muted:#8ca2b7;
  --line:#dbe6f0;
  --card:#ffffff;
  --bg:#f4f6f8;
  --blue:#13a6e8;
  --blue-soft:#e7f6fd;
  --navy:#0f2231;
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
body{padding:24px 18px 40px}
.shell{max-width:1240px;margin:0 auto}
.header{
  display:flex;align-items:center;justify-content:center;gap:24px;
  margin-bottom:28px;color:#fff;flex-wrap:wrap;
  padding-top:4px;
}
.brand{display:none}
.brand img{height:42px;width:auto;display:block}
.steps{display:flex;align-items:center;justify-content:center;gap:56px;flex-wrap:wrap}
.step{display:flex;flex-direction:column;align-items:center;gap:10px;color:rgba(255,255,255,.6)}
.step .num{
  width:68px;height:68px;border-radius:50%;border:2px solid rgba(255,255,255,.45);
  display:grid;place-items:center;font-size:28px;font-weight:700;
}
.step.active{color:#fff}
.step.active .num{background:#fff;color:#111;border-color:#fff}
.card{
  background:var(--card);border-radius:28px;padding:42px 44px 34px;
  box-shadow:var(--shadow);
  border:1px solid #e6ebef;
}
.eyebrow{
  display:inline-flex;align-items:center;gap:8px;padding:8px 12px;border-radius:999px;
  background:var(--blue-soft);color:var(--blue);font-size:11px;font-weight:800;
  letter-spacing:.08em;text-transform:uppercase;
}
.eyebrow{display:none}
h1{
  margin:18px 0 12px;
  font-family:'Anton','Arial Narrow',sans-serif;
  font-size:clamp(38px,5vw,62px);
  line-height:1.02;
  letter-spacing:-.02em;
  color:var(--blue);
  text-align:center;
  text-transform:uppercase;
}
.lede{
  margin:0 auto 18px;
  max-width:760px;
  text-align:center;
  font-size:16px;
  line-height:1.6;
  color:var(--ink-soft);
}
.address-pill{
  max-width:720px;
  margin:0 auto 26px;
  padding:14px 18px;
  border-radius:16px;
  background:#f7fbff;
  border:1px solid var(--line);
  text-align:center;
  font-size:14px;
  color:var(--ink-soft);
}
.address-pill strong{color:var(--ink)}
.stack{max-width:520px;margin:0 auto}
.field-block{margin-bottom:24px}
.field-title{
  margin:0 0 14px;
  text-align:center;
  font-size:16px;
  color:var(--ink);
}
.unit-row{
  display:grid;
  grid-template-columns:minmax(0,1fr) 116px 132px;
  gap:0;
  border-radius:16px;
  overflow:hidden;
  border:1.5px solid var(--line);
  background:#fff;
}
.unit-row input,
.unit-row select{
  border:0;outline:0;background:#fff;font:500 18px 'Inter',sans-serif;color:var(--ink);
  min-height:72px;
}
.unit-row input{padding:0 20px}
.unit-row select{padding:0 22px;appearance:none;color:var(--ink)}
.unit-row .unit{
  display:flex;align-items:center;justify-content:center;
  background:var(--blue);color:#fff;font-size:24px;font-weight:700;
}
.unit-row .period{
  position:relative;
  background:#d7ecfb;
  border-left:1px solid #c5e0f5;
}
.unit-row .period::after{
  content:"";
  position:absolute;right:18px;top:50%;
  width:10px;height:10px;
  border-right:2px solid #6d7d95;border-bottom:2px solid #6d7d95;
  transform:translateY(-65%) rotate(45deg);
  pointer-events:none;
}
.separator{
  margin:18px 0 24px;
  text-align:center;
  font-size:28px;
  color:var(--blue);
}
.vehicle-wrap{margin-top:28px}
.vehicle-wrap h2{
  margin:0 0 18px;
  text-align:center;
  font-family:'Anton','Arial Narrow',sans-serif;
  font-size:clamp(30px,4vw,46px);
  line-height:1.12;
  letter-spacing:-.02em;
  color:var(--blue);
  text-transform:uppercase;
}
.vehicle-choices{
  display:flex;justify-content:center;gap:18px;flex-wrap:wrap;
}
.vehicle-btn{
  width:74px;height:74px;border-radius:50%;
  border:2px solid #2c2f66;background:#fff;color:#2c2f66;
  font:800 22px/1 'Inter',sans-serif;cursor:pointer;transition:.15s ease;
}
.vehicle-btn.active{
  background:#2c2f66;color:#fff;border-color:#2c2f66;
}
.heating-wrap{margin-top:30px}
.heating-wrap h2{
  margin:0 0 18px;
  text-align:center;
  font-family:'Anton','Arial Narrow',sans-serif;
  font-size:clamp(28px,4vw,42px);
  line-height:1.12;
  letter-spacing:-.02em;
  color:var(--blue);
  text-transform:uppercase;
}
.heating-choices{
  display:grid;
  grid-template-columns:repeat(3,minmax(0,1fr));
  gap:12px;
}
.heating-btn{
  min-height:74px;
  border-radius:18px;
  border:1.5px solid var(--line);
  background:#fff;
  color:#2c2f66;
  padding:12px 10px;
  font:700 15px/1.2 'Inter',sans-serif;
  cursor:pointer;
  transition:.15s ease;
}
.heating-btn:hover{border-color:var(--blue);background:var(--blue-soft)}
.heating-btn.active{
  background:var(--navy);
  border-color:var(--navy);
  color:#fff;
}
.error{
  display:none;
  margin:18px auto 0;
  max-width:520px;
  padding:12px 14px;
  border-radius:12px;
  background:#fff1f1;
  border:1px solid #f1c1c1;
  color:#a12626;
  font-size:14px;
  line-height:1.5;
}
.notice{
  display:none;
  margin:18px auto 0;
  max-width:720px;
  padding:14px 16px;
  border-radius:14px;
  background:#fff1f1;
  border:1px solid #f1c1c1;
  color:#a12626;
  font-size:14px;
  line-height:1.6;
}
.actions{max-width:520px;margin:30px auto 0}
.btn{
  width:100%;min-height:78px;border:0;border-radius:18px;cursor:pointer;
  font:800 22px/1 'Inter',sans-serif;transition:.15s ease;
}
.btn-primary{background:var(--blue);color:#fff}
.btn-primary:hover:not(:disabled){transform:translateY(-1px);background:#1188d7}
.btn-primary:disabled{opacity:.55;cursor:not-allowed}
.back-link{
  display:block;margin-top:24px;text-align:center;
  color:var(--ink);font-size:15px;text-decoration:none;
}
.back-link:hover{text-decoration:underline}
@media (max-width: 760px){
  body{padding:18px 12px 32px}
  .card{padding:28px 18px 26px}
  .steps{gap:22px}
  .step .num{width:54px;height:54px;font-size:24px}
  .unit-row{grid-template-columns:1fr}
  .unit-row .unit,.unit-row .period{min-height:64px}
  .unit-row .period{border-left:0;border-top:1px solid #c5e0f5}
  .btn{font-size:18px;min-height:68px}
  .heating-choices{grid-template-columns:repeat(2,minmax(0,1fr))}
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
      <div class="step active"><div class="num">2</div><div>Votre consommation</div></div>
      <div class="step"><div class="num">3</div><div>Votre résultat</div></div>
    </div>
  </header>

  <main class="card">
    <span class="eyebrow">Étape 2</span>
    <h1>Quelle est votre consommation d'électricité ?</h1>
    <p class="lede">Renseignez votre consommation annuelle en kWh ou le montant de votre facture pour affiner le résultat de votre projet solaire.</p>
    <div class="address-pill" id="addressPill"><strong>Adresse du projet :</strong> <span id="addressText">Chargement…</span></div>

    <div class="stack">
      <div class="field-block">
        <p class="field-title">Je connais ma consommation en kWh</p>
        <div class="unit-row">
          <input id="consumptionKwh" type="number" min="0" step="1" inputmode="decimal" placeholder="en kWh">
          <div class="unit">kWh</div>
          <label class="period">
            <select id="consumptionKwhPeriod" aria-label="Période de consommation en kWh">
              <option value="year">An</option>
              <option value="month">Mois</option>
            </select>
          </label>
        </div>
      </div>

      <div class="separator">ou</div>

      <div class="field-block">
        <p class="field-title">Je connais le montant de ma facture</p>
        <div class="unit-row">
          <input id="billAmount" type="number" min="0" step="1" inputmode="decimal" placeholder="en €">
          <div class="unit">€</div>
          <label class="period">
            <select id="billPeriod" aria-label="Période de facture">
              <option value="year">An</option>
              <option value="month">Mois</option>
            </select>
          </label>
        </div>
      </div>

      <div class="vehicle-wrap">
        <h2>Possédez-vous un ou plusieurs véhicules électriques ?</h2>
        <div class="vehicle-choices" id="vehicleChoices">
          <button type="button" class="vehicle-btn active" data-count="0">0</button>
          <button type="button" class="vehicle-btn" data-count="1">1</button>
          <button type="button" class="vehicle-btn" data-count="2">2</button>
          <button type="button" class="vehicle-btn" data-count="3">3+</button>
        </div>
      </div>

      <div class="heating-wrap">
        <h2>Comment chauffez-vous votre logement ?</h2>
        <div class="heating-choices" id="heatingChoices">
          <button type="button" class="heating-btn active" data-heating="Gaz">Gaz</button>
          <button type="button" class="heating-btn" data-heating="Électrique">Électrique</button>
          <button type="button" class="heating-btn" data-heating="Pompe à chaleur">Pompe à chaleur</button>
          <button type="button" class="heating-btn" data-heating="Fioul">Fioul</button>
          <button type="button" class="heating-btn" data-heating="Bois">Bois</button>
        </div>
      </div>
    </div>

    <div class="error" id="errorBox"></div>
    <div class="notice" id="missingBox">Impossible de retrouver votre simulation toiture. Revenez à l’étape précédente pour repasser par le repérage de la toiture.</div>

    <div class="actions">
      <button type="button" class="btn btn-primary" id="continueBtn">Voir mon résultat</button>
      <a class="back-link" href="{{ $backUrl }}">&lt; Revenir à l'étape précédente</a>
    </div>
  </main>
</div>

<script>
window.__solarStep4StorageKey = 'solarSimulatorStep4';
window.__successUrl = @json($successUrl);

(function(){
  const storageKey = window.__solarStep4StorageKey;
  const continueBtn = document.getElementById('continueBtn');
  const missingBox = document.getElementById('missingBox');
  const errorBox = document.getElementById('errorBox');
  const addressText = document.getElementById('addressText');
  const consumptionKwh = document.getElementById('consumptionKwh');
  const consumptionKwhPeriod = document.getElementById('consumptionKwhPeriod');
  const billAmount = document.getElementById('billAmount');
  const billPeriod = document.getElementById('billPeriod');
  const vehicleChoices = document.getElementById('vehicleChoices');
  const heatingChoices = document.getElementById('heatingChoices');

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
  }

  function clearError(){
    errorBox.style.display = 'none';
    errorBox.textContent = '';
  }

  function parseNumber(value){
    if(typeof value !== 'string' && typeof value !== 'number') return 0;
    const normalized = String(value).replace(',', '.').trim();
    return Number(normalized || 0);
  }

  function annualize(value, period){
    const safeValue = Math.max(0, Number(value) || 0);
    return Math.round(safeValue * (period === 'month' ? 12 : 1));
  }

  let vehicleCount = 0;
  let heatingMode = 'Gaz';
  function setVehicleCount(nextValue){
    vehicleCount = Number(nextValue) || 0;
    vehicleChoices.querySelectorAll('.vehicle-btn').forEach(btn => {
      btn.classList.toggle('active', Number(btn.dataset.count) === vehicleCount);
    });
  }

  function setHeatingMode(nextValue){
    heatingMode = String(nextValue || 'Gaz');
    heatingChoices.querySelectorAll('.heating-btn').forEach(btn => {
      btn.classList.toggle('active', btn.dataset.heating === heatingMode);
    });
  }

  vehicleChoices.querySelectorAll('.vehicle-btn').forEach(btn => {
    btn.addEventListener('click', () => setVehicleCount(btn.dataset.count));
  });
  heatingChoices.querySelectorAll('.heating-btn').forEach(btn => {
    btn.addEventListener('click', () => setHeatingMode(btn.dataset.heating));
  });

  const simulation = loadSimulation();
  if(!simulation){
    missingBox.style.display = 'block';
    continueBtn.disabled = true;
    addressText.textContent = 'Simulation introuvable';
    return;
  }

  addressText.textContent = simulation.address || 'Adresse non renseignée';

  if(simulation.consumption){
    const saved = simulation.consumption;
    if(saved.inputKwh) consumptionKwh.value = saved.inputKwh;
    if(saved.kwhPeriod) consumptionKwhPeriod.value = saved.kwhPeriod;
    if(saved.billAmount) billAmount.value = saved.billAmount;
    if(saved.billPeriod) billPeriod.value = saved.billPeriod;
    setVehicleCount(saved.vehicleCount || 0);
    setHeatingMode(saved.heatingMode || simulation.heatingMode || 'Gaz');
  }

  continueBtn.addEventListener('click', () => {
    clearError();

    const inputKwh = parseNumber(consumptionKwh.value);
    const inputBill = parseNumber(billAmount.value);

    let annualConsumptionKwh = 0;
    let source = '';

    if(inputKwh > 0){
      annualConsumptionKwh = annualize(inputKwh, consumptionKwhPeriod.value);
      source = 'kwh';
    } else if(inputBill > 0){
      const annualBill = annualize(inputBill, billPeriod.value);
      annualConsumptionKwh = Math.round(annualBill / 0.2276);
      source = 'bill';
    }

    if(annualConsumptionKwh <= 0){
      showError('Renseignez votre consommation en kWh ou le montant de votre facture pour continuer.');
      return;
    }

    const nextState = {
      ...simulation,
      consumption: {
        source,
        inputKwh: inputKwh > 0 ? inputKwh : null,
        kwhPeriod: consumptionKwhPeriod.value,
        billAmount: inputBill > 0 ? inputBill : null,
        billPeriod: billPeriod.value,
        vehicleCount,
        annualConsumptionKwh,
        heatingMode,
      },
      heatingMode,
    };

    try {
      window.sessionStorage.setItem(storageKey, JSON.stringify(nextState));
    } catch (_error) {
      showError('Impossible de sauvegarder votre consommation pour le moment.');
      return;
    }

    window.location.href = window.__successUrl;
  });
})();
</script>
</body>
</html>
