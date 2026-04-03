@php
    $items = (array) data_get($value, 'items', []);
    $popularIcons = [
        'fa-solid fa-building' => 'Bâtiment',
        'fa-solid fa-star' => 'Étoile',
        'fa-solid fa-clock' => 'Horloge',
        'fa-solid fa-file-lines' => 'Document',
        'fa-solid fa-users' => 'Utilisateurs',
        'fa-solid fa-chart-line' => 'Graphique',
        'fa-solid fa-trophy' => 'Trophée',
        'fa-solid fa-shield-halved' => 'Bouclier',
        'fa-solid fa-hammer' => 'Marteau',
        'fa-solid fa-house' => 'Maison',
        'fa-solid fa-wrench' => 'Clé à molette',
        'fa-solid fa-screwdriver-wrench' => 'Outils',
        'fa-solid fa-bolt' => 'Éclair',
        'fa-solid fa-leaf' => 'Feuille',
        'fa-solid fa-solar-panel' => 'Panneau solaire',
        'fa-solid fa-fire' => 'Feu',
        'fa-solid fa-hand-holding-heart' => 'Main cœur',
        'fa-solid fa-handshake' => 'Poignée de main',
        'fa-solid fa-phone' => 'Téléphone',
        'fa-solid fa-euro-sign' => 'Euro',
        'fa-solid fa-percent' => 'Pourcentage',
        'fa-solid fa-check-circle' => 'Check',
        'fa-solid fa-map-marker-alt' => 'Localisation',
        'fa-solid fa-calendar-check' => 'Calendrier',
        'fa-solid fa-award' => 'Médaille',
        'fa-solid fa-thumbs-up' => 'Pouce en l\'air',
        'fa-solid fa-hard-hat' => 'Casque chantier',
        'fa-solid fa-ruler-combined' => 'Règle',
        'fa-solid fa-paint-roller' => 'Rouleau peinture',
        'fa-solid fa-temperature-low' => 'Température',
    ];
@endphp

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">

<p class="mb-4 text-sm text-slate-600">
    Chaque chiffre clé apparaît sur la page d'accueil avec une animation de compteur.
    L'icône utilise <a href="https://fontawesome.com/icons" target="_blank" rel="noopener noreferrer" class="font-bold text-sky-600 hover:underline">Font Awesome 6</a> — choisissez parmi les raccourcis ou saisissez une classe personnalisée (ex: <code class="rounded bg-slate-100 px-1 text-xs">fa-solid fa-rocket</code>).
</p>

<div id="statsBuilder" class="space-y-4">
    @foreach ($items as $idx => $item)
        <div class="stat-item rounded-xl border border-slate-200 bg-slate-50 p-5">
            <div class="mb-3 flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400">Chiffre {{ $idx + 1 }}</span>
                <button type="button" onclick="this.closest('.stat-item').remove()" class="text-xs font-bold text-red-500 hover:text-red-700">Supprimer</button>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-500">Valeur affichée</label>
                    <input type="text" name="{{ $name }}[items][{{ $idx }}][value]" value="{{ data_get($item, 'value') }}" placeholder="+5000" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-bold">
                    <p class="mt-1 text-[10px] text-slate-400">Préfixe/suffixe inclus (ex: +5000, 98%, 48h)</p>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-500">Label</label>
                    <input type="text" name="{{ $name }}[items][{{ $idx }}][label]" value="{{ data_get($item, 'label') }}" placeholder="Chantiers réalisés" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-xs font-bold text-slate-500">Icône Font Awesome</label>
                    <div class="flex items-center gap-3">
                        @php $currentIcon = trim((string) data_get($item, 'icon', 'fa-solid fa-chart-line')); @endphp
                        <span class="stat-icon-preview inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white ring-1 ring-slate-200">
                            <i class="{{ $currentIcon }} text-lg text-brand-blue"></i>
                        </span>
                        <div class="min-w-0 flex-1">
                            <input type="text" name="{{ $name }}[items][{{ $idx }}][icon]" value="{{ $currentIcon }}" placeholder="fa-solid fa-building" class="stat-icon-input w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-mono">
                        </div>
                    </div>
                    <div class="mt-2 flex flex-wrap gap-1.5">
                        @foreach ($popularIcons as $faClass => $faLabel)
                            <button type="button"
                                class="stat-icon-btn inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-[11px] text-slate-600 transition hover:border-brand-blue hover:text-brand-blue"
                                data-icon="{{ $faClass }}"
                                title="{{ $faLabel }}">
                                <i class="{{ $faClass }} text-xs"></i>
                                <span class="hidden sm:inline">{{ $faLabel }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<button type="button" id="addStatItem" class="mt-4 rounded-lg border border-dashed border-slate-300 px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-50">
    + Ajouter un chiffre clé
</button>

<script>
(function () {
    var popularIconsHtml = @json(collect($popularIcons)->map(fn ($label, $cls) => '<button type="button" class="stat-icon-btn inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-[11px] text-slate-600 transition hover:border-brand-blue hover:text-brand-blue" data-icon="'.$cls.'" title="'.$label.'"><i class="'.$cls.' text-xs"></i><span class="hidden sm:inline">'.$label.'</span></button>')->values()->implode(''));

    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.stat-icon-btn');
        if (!btn) return;
        e.preventDefault();
        var iconClass = btn.dataset.icon;
        var container = btn.closest('.stat-item');
        if (!container) return;
        var input = container.querySelector('.stat-icon-input');
        var preview = container.querySelector('.stat-icon-preview i');
        if (input) input.value = iconClass;
        if (preview) preview.className = iconClass + ' text-lg text-brand-blue';
    });

    document.addEventListener('input', function (e) {
        if (!e.target.classList.contains('stat-icon-input')) return;
        var container = e.target.closest('.stat-item');
        if (!container) return;
        var preview = container.querySelector('.stat-icon-preview i');
        if (preview) preview.className = e.target.value.trim() + ' text-lg text-brand-blue';
    });

    var addBtn = document.getElementById('addStatItem');
    var builder = document.getElementById('statsBuilder');
    if (addBtn && builder) {
        addBtn.addEventListener('click', function () {
            var idx = builder.querySelectorAll('.stat-item').length;
            var html = '<div class="stat-item rounded-xl border border-slate-200 bg-slate-50 p-5">'
                + '<div class="mb-3 flex items-center justify-between"><span class="text-xs font-bold text-slate-400">Chiffre ' + (idx + 1) + '</span><button type="button" onclick="this.closest(\'.stat-item\').remove()" class="text-xs font-bold text-red-500 hover:text-red-700">Supprimer</button></div>'
                + '<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">'
                + '<div><label class="mb-1 block text-xs font-bold text-slate-500">Valeur affichée</label><input type="text" name="{{ $name }}[items][' + idx + '][value]" placeholder="+5000" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-bold"><p class="mt-1 text-[10px] text-slate-400">Préfixe/suffixe inclus (ex: +5000, 98%, 48h)</p></div>'
                + '<div><label class="mb-1 block text-xs font-bold text-slate-500">Label</label><input type="text" name="{{ $name }}[items][' + idx + '][label]" placeholder="Chantiers réalisés" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm"></div>'
                + '<div class="sm:col-span-2"><label class="mb-1 block text-xs font-bold text-slate-500">Icône Font Awesome</label>'
                + '<div class="flex items-center gap-3"><span class="stat-icon-preview inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white ring-1 ring-slate-200"><i class="fa-solid fa-chart-line text-lg text-brand-blue"></i></span>'
                + '<div class="min-w-0 flex-1"><input type="text" name="{{ $name }}[items][' + idx + '][icon]" value="fa-solid fa-chart-line" placeholder="fa-solid fa-building" class="stat-icon-input w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-mono"></div></div>'
                + '<div class="mt-2 flex flex-wrap gap-1.5">' + popularIconsHtml + '</div></div>'
                + '</div></div>';
            builder.insertAdjacentHTML('beforeend', html);
        });
    }
})();
</script>
