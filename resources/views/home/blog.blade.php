@php $h = $home ?? []; @endphp
<section id="conseils" class="bg-slate-50/70 py-16 sm:py-20 scroll-mt-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 class="mb-2 text-4xl font-extrabold leading-tight text-brand-dark sm:text-5xl"><span class="text-brand-blue">{{ data_get($h, 'blog.title_accent') }}</span>{{ data_get($h, 'blog.title_rest') }}</h2>
        <p class="mb-8 max-w-2xl text-base text-slate-600 sm:text-lg">{{ data_get($h, 'blog.intro') }}</p>
        <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @foreach (data_get($h, 'blog.posts', []) as $post)
                <article class="flex h-full flex-col rounded-2xl border border-slate-200 bg-white p-6 shadow-soft transition hover:border-brand-blue/30 {{ !empty($post['wide']) ? 'md:col-span-2 lg:col-span-1' : '' }}">
                    <p class="mb-2 text-xs font-bold uppercase tracking-wide text-brand-blue">{{ data_get($post, 'tag') }}</p>
                    <h3 class="mb-2 text-xl font-extrabold text-brand-dark">{{ data_get($post, 'title') }}</h3>
                    <p class="flex-1 text-sm leading-relaxed text-slate-600">{{ data_get($post, 'excerpt') }}</p>
                    <a href="{{ data_get($post, 'href') }}" class="mt-4 inline-flex text-sm font-bold text-brand-blue transition hover:text-brand-dark">{{ data_get($post, 'link_text') }}</a>
                </article>
            @endforeach
        </div>
    </div>
</section>
