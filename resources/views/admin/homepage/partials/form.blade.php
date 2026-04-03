@php
    /**
     * Génère automatiquement des champs de formulaire à partir d'une structure PHP.
     * - Les champs sont nommés en mode bracket: sections[KEY][path...]
     * - Les clés "image/logo/bg/icon" reçoivent une preview + input URL + upload
     */

    $depth = (int) ($depth ?? 0);
    $name = (string) $name;
@endphp

@if (is_array($value))
    @php
        $keys = array_keys($value);
        $isList = $keys === array_values($keys);
    @endphp

    <div class="{{ $depth > 0 ? 'mt-4 rounded-xl border border-slate-100 bg-slate-50 p-3' : '' }}">
        @foreach ($value as $k => $v)
            @php
                $childName = $name.'['.$k.']';
                $childDepth = $depth + 1;
                $lowerKey = mb_strtolower((string) $k);

                // Textes alternatifs (ex. satisfaction_image_alt, og_image_alt) contiennent
                // « image » mais ne sont pas des fichiers — ne pas utiliser l'uploader média.
                $isImageKey =
                    (str_contains($lowerKey, 'image') ||
                    str_contains($lowerKey, 'logo') ||
                    str_contains($lowerKey, 'bg') ||
                    str_contains($lowerKey, 'icon'))
                    && ! str_ends_with($lowerKey, '_alt');

                $isTextAreaKey =
                    str_contains($lowerKey, 'body') ||
                    str_contains($lowerKey, 'intro') ||
                    str_contains($lowerKey, 'description') ||
                    str_contains($lowerKey, 'text') ||
                    str_contains($lowerKey, 'subtitle') ||
                    str_contains($lowerKey, 'title') ||
                    str_contains($lowerKey, 'adresse') ||
                    str_contains($lowerKey, 'address');

                $isUrlLike = is_string($v) && (str_starts_with($v, 'http') || str_contains($v, 'storage/') || str_contains($v, 'slide/') || str_contains($v, 'nous/') || str_contains($v, 'services/'));

                $previewUrl = null;
                if ($isImageKey && is_string($v) && trim($v) !== '') {
                    $previewUrl = \App\Support\HomeView::url($v);
                } elseif ($isUrlLike && $isImageKey) {
                    $previewUrl = \App\Support\HomeView::url($v);
                }
            @endphp

            @if (is_array($v))
                <div class="mb-2">
                    <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">{{ is_numeric($k) ? 'Item '.$k : $k }}</p>
                    @include('admin.homepage.partials.form', [
                        'name' => $childName,
                        'value' => $v,
                        'depth' => $childDepth,
                    ])
                </div>
            @else
                <div class="mb-3">
                    <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">
                        {{ is_numeric($k) ? 'Champ '.$k : $k }}
                    </p>

                    @if ($isImageKey)
                        @php
                            $fieldId = 'img_' . substr(md5((string) $childName), 0, 12);
                            $previewId = $fieldId . '_preview';
                        @endphp
                        <div class="mt-2">
                            <div class="flex flex-wrap items-start gap-4">
                                <div class="w-28">
                                    @if (is_string($v) && trim($v) !== '' && $previewUrl)
                                        <img
                                            id="{{ $previewId }}"
                                            src="{{ $previewUrl }}"
                                            alt=""
                                            class="h-24 w-28 rounded-lg border border-slate-200 bg-white object-cover"
                                        >
                                    @else
                                        <img
                                            id="{{ $previewId }}"
                                            src=""
                                            alt=""
                                            class="h-24 w-28 rounded-lg border border-slate-200 bg-white object-cover"
                                            style="display:none"
                                        >
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <input
                                        id="{{ $fieldId }}"
                                        type="text"
                                        name="{{ $childName }}"
                                        value="{{ is_scalar($v) ? $v : '' }}"
                                           class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                                    <input type="file"
                                           class="mt-2 w-full text-sm"
                                           accept="image/*"
                                           data-upload-target-input-id="{{ $fieldId }}"
                                           data-upload-target-preview-id="{{ $previewId }}"
                                    >
                                </div>
                            </div>
                        </div>
                    @elseif ($isTextAreaKey)
                        <textarea name="{{ $childName }}"
                                  rows="3"
                                  class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm leading-relaxed focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">{{ is_scalar($v) ? $v : '' }}</textarea>
                    @else
                        <input type="text"
                               name="{{ $childName }}"
                               value="{{ is_scalar($v) ? $v : '' }}"
                               class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                    @endif
                </div>
            @endif
        @endforeach
    </div>
@else
    <input type="text" name="{{ $name }}" value="{{ is_scalar($value) ? $value : '' }}"
           class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
@endif

