@php
    $h = $home ?? [];
    $blogPosts = data_get($h, 'blog.posts', []);
    $blogPosts = is_array($blogPosts) ? $blogPosts : [];
@endphp
<section id="conseils" class="bg-slate-50/70 py-16 sm:py-20 scroll-mt-24">
        <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        <h2 class="mb-2 text-4xl font-extrabold leading-tight text-brand-dark sm:text-5xl"><span class="text-brand-blue">{{ data_get($h, 'blog.title_accent') }}</span>{{ filled(data_get($h, 'blog.title_rest')) ? ' ' : '' }}{{ data_get($h, 'blog.title_rest') }}</h2>
        <p class="mb-8 max-w-2xl text-base text-slate-600 sm:text-lg">{{ data_get($h, 'blog.intro') }}</p>
        @if ($blogPosts === [])
            <div class="rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-soft">
                <p class="text-base font-bold text-slate-700">Les articles du blog seront affichés ici dès publication.</p>
                <p class="mt-2 text-sm text-slate-500">En attendant, retrouvez la liste complète sur la page blog.</p>
                <a href="{{ route('blog.index') }}" class="mt-5 inline-flex rounded-xl bg-brand-blue px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:bg-sky-500">
                    Voir le blog
                </a>
            </div>
        @else
        <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($blogPosts as $post)
                @php
                    $rawImg = trim((string) data_get($post, 'image'));
                    $img = $rawImg !== '' ? \App\Support\HomeView::url($rawImg) : \App\Support\HomeView::url('/slide/toiture.png');
                    $imgClass = !empty($post['wide']) ? 'h-52' : 'h-44';
                @endphp
                <article class="flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-soft transition hover:border-brand-blue/30 {{ !empty($post['wide']) ? 'md:col-span-2 lg:col-span-1' : '' }}">
                    <img
                        src="{{ $img }}"
                        alt="{{ data_get($post, 'title') }}"
                        class="{{ $imgClass }} w-full object-cover"
                        loading="lazy"
                        decoding="async"
                    >

                    <div class="flex flex-1 flex-col p-6">
                        <p class="mb-2 text-xs font-bold uppercase tracking-wide text-brand-blue">{{ data_get($post, 'tag') }}</p>
                        <h3 class="mb-2 text-xl font-extrabold text-brand-dark">{{ data_get($post, 'title') }}</h3>
                        <p class="flex-1 text-sm leading-relaxed text-slate-600">{{ data_get($post, 'excerpt') }}</p>
                        <a href="{{ data_get($post, 'href') }}" class="mt-4 inline-flex text-sm font-bold text-brand-blue transition hover:text-brand-dark">
                            {{ data_get($post, 'link_text') }}
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
        @endif
    </div>
</section>
