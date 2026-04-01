@extends('admin.layout')

@section('title', 'Header — Admin')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Header Builder</h1>
            <p class="mt-1 max-w-2xl text-sm text-slate-600">
                Gestion du menu principal avec sous-menus (style WordPress), routes associées et aperçu de la structure.
            </p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-extrabold text-slate-700 hover:bg-slate-50">
            ← Retour
        </a>
    </div>

    <form method="post" action="{{ route('admin.header_settings.update') }}" class="space-y-5">
        @csrf

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <h2 class="text-sm font-extrabold text-slate-900">Logo header</h2>
            <div class="mt-3 grid gap-4 lg:grid-cols-2">
                <div>
                    <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Logo (URL)</label>
                    <input id="headerLogoUrl" type="text" name="header[logo]" value="{{ data_get($header, 'logo') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                    <input id="headerLogoUpload" type="file" accept="image/*" class="mt-2 w-full text-sm">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-extrabold uppercase tracking-wide text-slate-500">Texte alternatif</label>
                    <input type="text" name="header[logo_alt]" value="{{ data_get($header, 'logo_alt') }}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="text-sm font-extrabold text-slate-900">Menu principal</h2>
                    <p class="mt-1 text-xs text-slate-600">Ajoute des entrées, puis des sous-menus si besoin. Tu peux mélanger route interne + URL personnalisée.</p>
                </div>
                <button type="button" id="addMenuItemBtn" class="inline-flex items-center rounded-lg bg-sky-600 px-3 py-2 text-xs font-extrabold text-white hover:bg-sky-700">
                    + Ajouter un menu
                </button>
            </div>

            <div id="menuBuilder" class="mt-4 space-y-4"></div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
            <h2 class="text-sm font-extrabold text-slate-900">Aperçu structure</h2>
            <p class="mt-1 text-xs text-slate-600">Vue rapide de la hiérarchie menus / sous-menus avant enregistrement.</p>
            <div id="menuPreview" class="mt-3 rounded-xl border border-slate-200 bg-white p-4 text-sm text-slate-700"></div>
        </div>

        <div class="pt-2">
            <button type="submit" class="rounded-xl bg-sky-600 px-6 py-3 text-sm font-extrabold text-white hover:bg-sky-700">
                Enregistrer le header
            </button>
        </div>
    </form>

    <template id="menuItemTemplate">
        <div class="menu-item rounded-xl border border-slate-200 bg-slate-50 p-4">
            <div class="mb-3 flex flex-wrap items-center justify-between gap-2">
                <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">Menu principal</p>
                <div class="flex items-center gap-2">
                    <button type="button" class="add-child-btn rounded-lg border border-slate-300 bg-white px-2.5 py-1.5 text-xs font-extrabold text-slate-700 hover:bg-slate-100">+ Sous-menu</button>
                    <button type="button" class="remove-item-btn rounded-lg border border-red-200 bg-red-50 px-2.5 py-1.5 text-xs font-extrabold text-red-700 hover:bg-red-100">Supprimer</button>
                </div>
            </div>
            <div class="grid gap-2 lg:grid-cols-[1.4fr_1.1fr_1fr_1.2fr_0.8fr]">
                <input data-field="label" type="text" placeholder="Libellé" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                <select data-field="route" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                    <option value="">Route</option>
                    @foreach ($routeOptions as $opt)
                        <option value="{{ $opt['value'] }}">{{ $opt['label'] }}</option>
                    @endforeach
                </select>
                <input data-field="anchor" type="text" placeholder="ancre" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                <input data-field="custom_url" type="text" placeholder="URL personnalisée" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                <select data-field="style" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                    <option value="">Normal</option>
                    <option value="cta">CTA</option>
                </select>
            </div>
            <div class="children-container mt-3 space-y-2"></div>
        </div>
    </template>

    <template id="childItemTemplate">
        <div class="child-item rounded-lg border border-slate-200 bg-white p-3">
            <div class="mb-2 flex flex-wrap items-center justify-between gap-2">
                <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">Sous-menu</p>
                <button type="button" class="remove-child-btn rounded-lg border border-red-200 bg-red-50 px-2.5 py-1 text-xs font-extrabold text-red-700 hover:bg-red-100">Supprimer</button>
            </div>
            <div class="grid gap-2 lg:grid-cols-4">
                <input data-field="label" type="text" placeholder="Libellé" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                <select data-field="route" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                    <option value="">Route</option>
                    @foreach ($routeOptions as $opt)
                        <option value="{{ $opt['value'] }}">{{ $opt['label'] }}</option>
                    @endforeach
                </select>
                <input data-field="anchor" type="text" placeholder="ancre" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
                <input data-field="custom_url" type="text" placeholder="URL personnalisée" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">
            </div>
        </div>
    </template>

    @push('scripts')
    <script>
        (function () {
            const initialItems = @json($menuItems ?? []);
            const menuBuilder = document.getElementById('menuBuilder');
            const previewBox = document.getElementById('menuPreview');
            const addMenuItemBtn = document.getElementById('addMenuItemBtn');
            const menuTpl = document.getElementById('menuItemTemplate');
            const childTpl = document.getElementById('childItemTemplate');

            function addChildItem(parentNode, values = {}) {
                const childNode = childTpl.content.firstElementChild.cloneNode(true);
                childNode.querySelector('[data-field="label"]').value = values.label || '';
                childNode.querySelector('[data-field="route"]').value = values.route || '';
                childNode.querySelector('[data-field="anchor"]').value = values.anchor || '';
                childNode.querySelector('[data-field="custom_url"]').value = values.custom_url || '';
                childNode.querySelector('.remove-child-btn').addEventListener('click', function () {
                    childNode.remove();
                    syncNamesAndPreview();
                });
                childNode.querySelectorAll('input,select').forEach((el) => {
                    el.addEventListener('input', syncNamesAndPreview);
                    el.addEventListener('change', syncNamesAndPreview);
                });
                parentNode.querySelector('.children-container').appendChild(childNode);
            }

            function addMenuItem(values = {}) {
                const menuNode = menuTpl.content.firstElementChild.cloneNode(true);
                menuNode.querySelector('[data-field="label"]').value = values.label || '';
                menuNode.querySelector('[data-field="route"]').value = values.route || '';
                menuNode.querySelector('[data-field="anchor"]').value = values.anchor || '';
                menuNode.querySelector('[data-field="custom_url"]').value = values.custom_url || '';
                menuNode.querySelector('[data-field="style"]').value = values.style || '';

                menuNode.querySelector('.remove-item-btn').addEventListener('click', function () {
                    menuNode.remove();
                    syncNamesAndPreview();
                });
                menuNode.querySelector('.add-child-btn').addEventListener('click', function () {
                    addChildItem(menuNode, {});
                    syncNamesAndPreview();
                });
                menuNode.querySelectorAll('input,select').forEach((el) => {
                    el.addEventListener('input', syncNamesAndPreview);
                    el.addEventListener('change', syncNamesAndPreview);
                });

                (Array.isArray(values.children) ? values.children : []).forEach((child) => addChildItem(menuNode, child || {}));
                menuBuilder.appendChild(menuNode);
            }

            function syncNamesAndPreview() {
                const lines = [];
                const menuNodes = Array.from(menuBuilder.querySelectorAll(':scope > .menu-item'));
                menuNodes.forEach((menuNode, i) => {
                    const label = menuNode.querySelector('[data-field="label"]').value || '';
                    const route = menuNode.querySelector('[data-field="route"]').value || '';
                    const anchor = menuNode.querySelector('[data-field="anchor"]').value || '';
                    const customUrl = menuNode.querySelector('[data-field="custom_url"]').value || '';
                    const style = menuNode.querySelector('[data-field="style"]').value || '';

                    menuNode.querySelector('[data-field="label"]').name = `header[menu_items][${i}][label]`;
                    menuNode.querySelector('[data-field="route"]').name = `header[menu_items][${i}][route]`;
                    menuNode.querySelector('[data-field="anchor"]').name = `header[menu_items][${i}][anchor]`;
                    menuNode.querySelector('[data-field="custom_url"]').name = `header[menu_items][${i}][custom_url]`;
                    menuNode.querySelector('[data-field="style"]').name = `header[menu_items][${i}][style]`;

                    lines.push(`• ${label || '(sans titre)'} ${style === 'cta' ? '[CTA]' : ''} ${route ? `→ ${route}` : ''} ${customUrl ? `→ ${customUrl}` : ''} ${anchor ? `#${anchor}` : ''}`.trim());

                    const childNodes = Array.from(menuNode.querySelectorAll(':scope .children-container > .child-item'));
                    childNodes.forEach((childNode, j) => {
                        const cLabel = childNode.querySelector('[data-field="label"]').value || '';
                        const cRoute = childNode.querySelector('[data-field="route"]').value || '';
                        const cAnchor = childNode.querySelector('[data-field="anchor"]').value || '';
                        const cCustom = childNode.querySelector('[data-field="custom_url"]').value || '';

                        childNode.querySelector('[data-field="label"]').name = `header[menu_items][${i}][children][${j}][label]`;
                        childNode.querySelector('[data-field="route"]').name = `header[menu_items][${i}][children][${j}][route]`;
                        childNode.querySelector('[data-field="anchor"]').name = `header[menu_items][${i}][children][${j}][anchor]`;
                        childNode.querySelector('[data-field="custom_url"]').name = `header[menu_items][${i}][children][${j}][custom_url]`;

                        lines.push(`    - ${cLabel || '(sans titre)'} ${cRoute ? `→ ${cRoute}` : ''} ${cCustom ? `→ ${cCustom}` : ''} ${cAnchor ? `#${cAnchor}` : ''}`.trim());
                    });
                });

                previewBox.innerHTML = lines.length ? `<pre class="whitespace-pre-wrap text-xs leading-6 text-slate-700">${lines.join('\n')}</pre>` : '<p class="text-xs text-slate-500">Aucun menu pour le moment.</p>';
            }

            if (addMenuItemBtn) {
                addMenuItemBtn.addEventListener('click', function () {
                    addMenuItem({});
                    syncNamesAndPreview();
                });
            }

            if (Array.isArray(initialItems) && initialItems.length > 0) {
                initialItems.forEach((it) => addMenuItem(it || {}));
            } else {
                addMenuItem({ label: 'Accueil', route: 'home', style: '' });
            }
            syncNamesAndPreview();

            const fileInput = document.getElementById('headerLogoUpload');
            const targetInput = document.getElementById('headerLogoUrl');
            if (fileInput && targetInput) {
                fileInput.addEventListener('change', async function () {
                    if (!fileInput.files || !fileInput.files[0]) return;
                    const fd = new FormData();
                    fd.append('file', fileInput.files[0]);
                    try {
                        const res = await fetch(@json(route('admin.upload')), {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': @json(csrf_token()), 'Accept': 'application/json' },
                            body: fd,
                            credentials: 'same-origin',
                        });
                        const data = await res.json().catch(() => ({}));
                        if (!res.ok || !data.url) throw new Error(data.message || 'Erreur upload');
                        targetInput.value = data.url;
                    } catch (err) {
                        alert(String(err));
                    } finally {
                        fileInput.value = '';
                    }
                });
            }
        })();
    </script>
    @endpush
@endsection

