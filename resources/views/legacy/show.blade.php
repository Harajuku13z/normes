@php
    $h = $home ?? app(\App\Services\HomePageService::class)->merged();
    $pageTitle = trim((string) $page->meta_title) !== '' ? $page->meta_title : $page->title;
    $metaDescription = trim((string) $page->meta_description) !== '' ? $page->meta_description : (trim((string) $page->excerpt) !== '' ? $page->excerpt : data_get($h, 'meta.description'));
    $canonicalUrl = trim((string) $page->canonical_url) !== '' ? $page->canonical_url : url('/'.$requestedPath);
@endphp
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
@include('home.head', [
    'home' => $h,
    'title' => $pageTitle,
    'description' => $metaDescription,
    'canonicalUrl' => $canonicalUrl,
    'ogImage' => $page->og_image,
])
<body class="overflow-x-hidden bg-white font-sans text-brand-dark antialiased">
@include('home.header', ['home' => $h])

<main class="bg-slate-50/40 py-10 sm:py-14">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-soft">
            <header class="border-b border-slate-100 px-6 py-8 sm:px-10">
                <h1 class="text-3xl font-black leading-tight text-brand-dark sm:text-4xl lg:text-5xl">
                    {{ trim((string) $page->h1) !== '' ? $page->h1 : $page->title }}
                </h1>
                @if (trim((string) $page->excerpt) !== '')
                    <p class="mt-4 max-w-3xl text-base text-slate-600 sm:text-lg">{{ $page->excerpt }}</p>
                @endif
            </header>
            <div class="px-6 py-8 sm:px-10">
                <div class="prose prose-slate max-w-none prose-headings:text-brand-dark prose-a:text-brand-blue">
                    {!! $page->content_html !!}
                </div>
            </div>
        </article>
    </div>
</main>

@include('home.footer', ['home' => $h])
@include('home.scripts', ['home' => $h])
</body>
</html>

