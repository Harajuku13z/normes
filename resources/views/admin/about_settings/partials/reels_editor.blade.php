@php
    use App\Support\HomeView;

    /** @var array<int, mixed> $reels */
    $reelsList = is_array($reels ?? null) ? array_values($reels) : [];
    $prefix = $namePrefix ?? 'sections[about_page][reels]';
@endphp

<div class="mb-8 rounded-2xl border-2 border-sky-300 bg-gradient-to-b from-sky-50 to-white p-6 shadow-sm">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h2 class="text-lg font-extrabold text-slate-900">Reels — bannières verticales (page À propos)</h2>
            <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-600">
                Jusqu’à <strong>4 emplacements</strong>. Pour chaque emplacement, choisis une <strong>vidéo</strong> (MP4 ou MOV, idéalement sans piste audio — la lecture est <strong>muette</strong> sur le site) <strong>ou</strong> une <strong>photo</strong> à la place. Tu peux coller une URL ou envoyer un fichier.
            </p>
        </div>
        <a href="{{ route('about.page') }}#contenu" target="_blank" rel="noopener noreferrer" class="shrink-0 rounded-lg bg-sky-600 px-4 py-2 text-sm font-extrabold text-white hover:bg-sky-700">
            Prévisualiser la page
        </a>
    </div>

    <div class="mt-6 space-y-8">
        @for ($slot = 0; $slot < 4; $slot++)
            @php
                $r = isset($reelsList[$slot]) && is_array($reelsList[$slot]) ? $reelsList[$slot] : [];
                $videoVal = trim((string) data_get($r, 'video', ''));
                $imageVal = trim((string) data_get($r, 'image', ''));
                $captionVal = trim((string) data_get($r, 'caption', ''));

                $baseName = $prefix.'['.$slot.']';
                $fieldIdVideo = 'reel_video_'.$slot;
                $fieldIdImage = 'reel_image_'.$slot;
                $previewIdImage = 'reel_img_preview_'.$slot;
                $previewIdVideo = 'reel_vid_preview_'.$slot;

                $imagePreviewUrl = $imageVal !== '' ? HomeView::url($imageVal) : '';
                $videoPreviewUrl = $videoVal !== '' ? HomeView::url($videoVal) : '';
            @endphp

            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm ring-1 ring-slate-100">
                <p class="text-sm font-extrabold text-slate-800">
                    Emplacement {{ $slot + 1 }} <span class="font-normal text-slate-500">— priorité à la vidéo si les deux sont remplis</span>
                </p>

                <div class="mt-4 grid gap-6 lg:grid-cols-2">
                    {{-- Vidéo --}}
                    <div>
                        <label class="text-xs font-extrabold uppercase tracking-wide text-slate-500">Vidéo (MP4 / MOV)</label>
                        <div class="mt-2 flex flex-wrap items-start gap-4">
                            <div class="w-full min-w-0 flex-1 sm:w-auto sm:min-w-[200px]">
                                @if ($videoPreviewUrl !== '')
                                    <video
                                        id="{{ $previewIdVideo }}"
                                        src="{{ $videoPreviewUrl }}"
                                        class="h-40 w-full max-w-[200px] rounded-lg border border-slate-200 bg-slate-900 object-cover"
                                        muted
                                        loop
                                        playsinline
                                        controls
                                    ></video>
                                @else
                                    <video
                                        id="{{ $previewIdVideo }}"
                                        class="hidden h-40 w-full max-w-[200px] rounded-lg border border-slate-200 bg-slate-900 object-cover"
                                        muted
                                        loop
                                        playsinline
                                        controls
                                    ></video>
                                    <p id="{{ $previewIdVideo }}_placeholder" class="flex h-40 max-w-[200px] items-center justify-center rounded-lg border border-dashed border-slate-300 bg-slate-50 text-center text-xs text-slate-500">
                                        Aperçu vidéo après upload ou URL
                                    </p>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <input
                                    id="{{ $fieldIdVideo }}"
                                    type="text"
                                    name="{{ $baseName }}[video]"
                                    value="{{ $videoVal }}"
                                    placeholder="/uploads/….mp4 ou https://…"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                >
                                <input
                                    type="file"
                                    class="js-admin-media-upload mt-2 w-full text-sm"
                                    accept="video/mp4,video/quicktime,video/webm,.mp4,.mov"
                                    data-upload-target-input-id="{{ $fieldIdVideo }}"
                                    data-upload-target-preview-video-id="{{ $previewIdVideo }}"
                                >
                                <p class="mt-1 text-xs text-slate-500">Fichiers : MP4, MOV (max. ~100 Mo selon serveur).</p>
                            </div>
                        </div>
                    </div>

                    {{-- Image de remplacement --}}
                    <div>
                        <label class="text-xs font-extrabold uppercase tracking-wide text-slate-500">Photo (si pas de vidéo)</label>
                        <div class="mt-2 flex flex-wrap items-start gap-4">
                            <div class="w-28 shrink-0">
                                @if ($imagePreviewUrl !== '')
                                    <img
                                        id="{{ $previewIdImage }}"
                                        src="{{ $imagePreviewUrl }}"
                                        alt=""
                                        class="h-40 w-28 rounded-lg border border-slate-200 bg-white object-cover"
                                    >
                                @else
                                    <img
                                        id="{{ $previewIdImage }}"
                                        src=""
                                        alt=""
                                        class="hidden h-40 w-28 rounded-lg border border-slate-200 bg-white object-cover"
                                    >
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <input
                                    id="{{ $fieldIdImage }}"
                                    type="text"
                                    name="{{ $baseName }}[image]"
                                    value="{{ $imageVal }}"
                                    placeholder="/uploads/….jpg ou chemin image"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                >
                                <input
                                    type="file"
                                    class="js-admin-media-upload mt-2 w-full text-sm"
                                    accept="image/*"
                                    data-upload-target-input-id="{{ $fieldIdImage }}"
                                    data-upload-target-preview-id="{{ $previewIdImage }}"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="text-xs font-extrabold uppercase tracking-wide text-slate-500">Légende (caption)</label>
                    <textarea
                        name="{{ $baseName }}[caption]"
                        rows="2"
                        class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        placeholder="Texte affiché sur le média (optionnel)"
                    >{{ $captionVal }}</textarea>
                </div>
            </div>
        @endfor
    </div>
</div>
