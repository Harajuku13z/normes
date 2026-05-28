<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\HomeSection;
use App\Models\LegacyPage;
use App\Models\PortfolioProject;
use App\Models\ServicePage;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        return $this->xmlResponse('sitemap.index', [
            'sitemaps' => $this->sitemaps(),
        ]);
    }

    public function pages(): Response
    {
        return $this->xmlResponse('sitemap.urlset', [
            'urls' => $this->pageUrls(),
        ]);
    }

    public function services(): Response
    {
        return $this->xmlResponse('sitemap.urlset', [
            'urls' => $this->serviceUrls(),
        ]);
    }

    public function blog(): Response
    {
        return $this->xmlResponse('sitemap.urlset', [
            'urls' => $this->blogUrls(),
        ]);
    }

    public function realisations(): Response
    {
        return $this->xmlResponse('sitemap.urlset', [
            'urls' => $this->realisationUrls(),
        ]);
    }

    public function legacy(): Response
    {
        return $this->xmlResponse('sitemap.urlset', [
            'urls' => $this->legacyUrls(),
        ]);
    }

    /**
     * @return array<int, array{loc: string, lastmod: string|null, changefreq: string|null, priority: string|null}>
     */
    private function pageUrls(): array
    {
        $lastmod = $this->formatDate(
            HomeSection::query()->max('updated_at')
        );

        return [
            $this->urlItem(route('home'), $lastmod, 'weekly', '1.0'),
            $this->urlItem(route('about.page'), $lastmod, 'monthly', '0.8'),
            $this->urlItem(route('contact.page'), $lastmod, 'monthly', '0.8'),
            $this->urlItem(route('services.index'), $lastmod, 'weekly', '0.9'),
            $this->urlItem(route('blog.index'), $this->latestBlogLastmod(), 'daily', '0.9'),
            $this->urlItem(route('franchise.page'), $lastmod, 'monthly', '0.7'),
            $this->urlItem(route('realisations.page'), $this->latestRealisationsLastmod(), 'weekly', '0.8'),
            $this->urlItem(route('simulateur.start'), $lastmod, 'weekly', '0.9'),
        ];
    }

    /**
     * @return array<int, array{loc: string, lastmod: string|null, changefreq: string|null, priority: string|null}>
     */
    private function serviceUrls(): array
    {
        return ServicePage::query()
            ->where('is_active', true)
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->orderBy('service_num')
            ->orderBy('title')
            ->get(['slug', 'updated_at'])
            ->map(fn (ServicePage $page): array => $this->urlItem(
                route('service.page', ['slug' => $page->slug]),
                $this->formatDate($page->updated_at),
                'weekly',
                '0.8'
            ))
            ->all();
    }

    /**
     * @return array<int, array{loc: string, lastmod: string|null, changefreq: string|null, priority: string|null}>
     */
    private function blogUrls(): array
    {
        return BlogPost::query()
            ->published()
            ->orderByDesc('published_at')
            ->get(['slug', 'updated_at', 'published_at'])
            ->map(fn (BlogPost $post): array => $this->urlItem(
                route('blog.show', ['slug' => $post->slug]),
                $this->formatDate($post->updated_at ?? $post->published_at),
                'monthly',
                '0.7'
            ))
            ->all();
    }

    /**
     * @return array<int, array{loc: string, lastmod: string|null, changefreq: string|null, priority: string|null}>
     */
    private function realisationUrls(): array
    {
        return PortfolioProject::query()
            ->orderBy('sort_order')
            ->orderByDesc('updated_at')
            ->get(['id', 'slug', 'updated_at'])
            ->map(function (PortfolioProject $project): array {
                $routeKey = filled($project->slug) ? $project->slug : (string) $project->getKey();

                return $this->urlItem(
                    route('realisations.show', ['portfolio_project' => $routeKey]),
                    $this->formatDate($project->updated_at),
                    'monthly',
                    '0.7'
                );
            })
            ->all();
    }

    /**
     * @return array<int, array{loc: string, lastmod: string|null, changefreq: string|null, priority: string|null}>
     */
    private function legacyUrls(): array
    {
        return LegacyPage::query()
            ->active()
            ->whereNotNull('old_path')
            ->orderBy('old_path')
            ->get(['old_path', 'updated_at', 'canonical_url'])
            ->filter(function (LegacyPage $page): bool {
                $path = LegacyPage::normalizePath((string) $page->old_path);

                return $path !== '' && ! $this->isReservedPath($path);
            })
            ->map(function (LegacyPage $page): array {
                $path = LegacyPage::normalizePath((string) $page->old_path);
                $url = $this->normalizedCanonicalUrl((string) $page->canonical_url) ?? url('/'.$path);

                return $this->urlItem(
                    $url,
                    $this->formatDate($page->updated_at),
                    'monthly',
                    '0.6'
                );
            })
            ->values()
            ->all();
    }

    /**
     * @return array<int, array{loc: string, lastmod: string|null}>
     */
    private function sitemaps(): array
    {
        $definitions = [
            [
                'loc' => route('sitemap.pages'),
                'lastmod' => $this->latestLastmod($this->pageUrls()),
                'count' => count($this->pageUrls()),
            ],
            [
                'loc' => route('sitemap.services'),
                'lastmod' => $this->latestLastmod($this->serviceUrls()),
                'count' => count($this->serviceUrls()),
            ],
            [
                'loc' => route('sitemap.blog'),
                'lastmod' => $this->latestLastmod($this->blogUrls()),
                'count' => count($this->blogUrls()),
            ],
            [
                'loc' => route('sitemap.realisations'),
                'lastmod' => $this->latestLastmod($this->realisationUrls()),
                'count' => count($this->realisationUrls()),
            ],
            [
                'loc' => route('sitemap.legacy'),
                'lastmod' => $this->latestLastmod($this->legacyUrls()),
                'count' => count($this->legacyUrls()),
            ],
        ];

        return array_values(array_filter(
            $definitions,
            static fn (array $item): bool => $item['count'] > 0
        ));
    }

    /**
     * @param  array<int, array{loc: string, lastmod: string|null, changefreq: string|null, priority: string|null}>  $items
     */
    private function latestLastmod(array $items): ?string
    {
        $dates = array_values(array_filter(array_map(
            static fn (array $item): ?string => $item['lastmod'] ?? null,
            $items
        )));

        if ($dates === []) {
            return null;
        }

        rsort($dates);

        return $dates[0];
    }

    private function latestBlogLastmod(): ?string
    {
        $latest = BlogPost::query()->published()->max('updated_at')
            ?? BlogPost::query()->published()->max('published_at');

        return $this->formatDate($latest);
    }

    private function latestRealisationsLastmod(): ?string
    {
        return $this->formatDate(
            PortfolioProject::query()->max('updated_at')
        );
    }

    private function normalizedCanonicalUrl(string $url): ?string
    {
        $url = trim($url);
        if ($url === '') {
            return null;
        }

        if (str_starts_with($url, url('/'))) {
            return $url;
        }

        return null;
    }

    private function isReservedPath(string $path): bool
    {
        $reserved = [
            'admin',
            'services',
            'contact',
            'contact/merci',
            'a-propos',
            'blog',
            'franchise',
            'franchise/merci',
            'realisations',
            'simulateur',
            'simulateur/etape-1',
            'simulateur/etape-2',
            'simulateur/etape-3',
            'simulateur/etape-4',
            'simulateur/etape-5',
            'simulateur/ok',
            'signature-mail',
            'sitemap.xml',
            'sitemap_index.xml',
            'page-sitemap.xml',
            'service-sitemap.xml',
            'blog-sitemap.xml',
            'realisation-sitemap.xml',
            'legacy-sitemap.xml',
            'robots.txt',
        ];

        foreach ($reserved as $prefix) {
            if ($path === $prefix || str_starts_with($path, $prefix.'/')) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array{loc: string, lastmod: string|null, changefreq: string|null, priority: string|null}
     */
    private function urlItem(string $loc, ?string $lastmod = null, ?string $changefreq = null, ?string $priority = null): array
    {
        return [
            'loc' => $loc,
            'lastmod' => $lastmod,
            'changefreq' => $changefreq,
            'priority' => $priority,
        ];
    }

    private function formatDate(mixed $date): ?string
    {
        if ($date instanceof CarbonInterface) {
            return $date->toAtomString();
        }

        if (is_string($date) && trim($date) !== '') {
            return Carbon::parse($date)->toAtomString();
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function xmlResponse(string $view, array $data): Response
    {
        return response()
            ->view($view, $data)
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
