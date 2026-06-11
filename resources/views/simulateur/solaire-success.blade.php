@php
    use App\Support\HomeView;
    $h = $home ?? [];
    $logo = HomeView::url((string) data_get($h, 'header.logo', '/logo.png'));
    $siteName = (string) data_get($h, 'meta.site_name', 'Normes Renovation');
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Demande envoyee - {{ $siteName }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{
  --ink:#0f2231;
  --slate:#5a6b78;
  --line:#e6ebef;
  --card:#ffffff;
  --bg:#f4f6f8;
  --accent:#13a6e8;
  --accent-soft:#e7f6fd;
  --ok:#1f8a5b;
  --ok-soft:#eaf7ef;
  --yellow:#f5c400;
  --shadow:0 1px 2px rgba(15,34,49,.04),0 8px 24px rgba(15,34,49,.06);
}
*{box-sizing:border-box}
html,body{
  margin:0;min-height:100vh;font-family:'Inter',system-ui,-apple-system,Segoe UI,sans-serif;
  background:
    radial-gradient(1200px 600px at 80% -10%,#eaf4fb 0%,transparent 60%),
    radial-gradient(900px 500px at -10% 110%,#eef4f8 0%,transparent 60%),
    var(--bg);
  color:var(--ink);
}
.page{max-width:860px;margin:0 auto;padding:28px 20px 40px}
.card{
  background:var(--card);border:1px solid var(--line);border-radius:24px;padding:34px 30px;
  box-shadow:var(--shadow);text-align:center;
}
.logo{height:52px;width:auto;display:block;margin:0 auto 18px}
.check{
  width:76px;height:76px;border-radius:50%;background:var(--ok-soft);color:var(--ok);
  display:grid;place-items:center;font-size:36px;font-weight:800;margin:0 auto 18px;
}
h1{margin:0 0 10px;font-size:34px;letter-spacing:-.03em}
p{margin:0 auto;color:var(--slate);font-size:16px;line-height:1.7;max-width:620px}
.actions{display:flex;justify-content:center;gap:12px;flex-wrap:wrap;margin-top:28px}
.btn{
  display:inline-flex;align-items:center;justify-content:center;padding:15px 20px;border-radius:14px;
  font:800 14px/1 'Inter',sans-serif;text-decoration:none;
}
.btn-primary{background:var(--yellow);color:var(--ink)}
.btn-secondary{background:#fff;border:1.5px solid var(--line);color:var(--ink)}
.info{
  margin-top:20px;padding:14px 16px;border-radius:14px;background:var(--accent-soft);
  color:#28526d;font-size:14px;line-height:1.6;
}
</style>
</head>
<body>
<div class="page">
  <div class="card">
    <img class="logo" src="{{ $logo }}" alt="{{ $siteName }}">
    <div class="check">✓</div>
    <h1>Votre demande est envoyee</h1>
    <p>Votre projet solaire a bien ete confirme. Un e-mail de confirmation part au client et une copie est envoyee a l'equipe pour reprise rapide.</p>

    <div class="info">
      Un conseiller peut maintenant reprendre votre dossier et revenir vers vous avec une proposition plus precise.
    </div>

    <div class="actions">
      <a class="btn btn-primary" href="{{ route('simulateur.solaire') }}">Refaire une simulation</a>
      <a class="btn btn-secondary" href="{{ route('contact.page') }}">Contacter l'equipe</a>
    </div>
  </div>
</div>
</body>
</html>
