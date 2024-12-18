<?php

namespace Fuelviews\Sitemap\Commands;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Spatie\Crawler\Crawler;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;
use Symfony\Component\Console\Command\Command as CommandAlias;

class SitemapGenerateCommand extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Sitemap generation';

    protected string $diskName = '';

    /**
     * Execute the console command.
     *
     * This method handles the logic after the command is called. It decides
     * whether to include an index in the sitemap based on configuration settings.
     * Depending on those settings, it may generate individual sitemaps for pages
     * and posts and then either create a sitemap index to include them or
     * directly generate a single sitemap.
     */
    public function handle(): int
    {
        $this->diskName = $this->getDiskName();

        try {
            $SitemapIndex = ! $this->getExcludeSubcategorySitemapLinks();

            if ($SitemapIndex) {
                if (! $this->generatePagesSitemap()) {
                    throw new Exception('Failed to generate pages sitemap');
                }
                if (! $this->generatePostsSitemap()) {
                    throw new Exception('Failed to generate posts sitemap');
                }

                $sitemapIndex = SitemapIndex::create()
                    ->add('pages_sitemap.xml')
                    ->add('posts_sitemap.xml');

                $sitemapIndex->writeToDisk($this->diskName, 'sitemap/sitemap.xml', true);
            } else {
                if (! $this->generatePagesSitemap('sitemap.xml')) {
                    throw new Exception('Failed to generate pages sitemap');
                }
            }

            $this->info('Sitemap generated successfully.');
            return CommandAlias::SUCCESS;
        } catch (Exception $e) {
            Log::error('Sitemap generation failed: '.$e->getMessage());
            $this->error('Sitemap generation failed: '.$e->getMessage());
            return CommandAlias::FAILURE;
        }
    }

    /**
     * Generates a sitemap for pages, excluding specified routes, paths, and URLs.
     *
     * This function creates a sitemap specifically for pages by leveraging a sitemap generator.
     * It filters out URLs based on various criteria, including predefined excluded routes, paths,
     * and specific URLs. The resulting sitemap is then saved to a specified filename.
     *
     * @param  string  $filename  The filename for the generated sitemap, defaulting to 'pages_sitemap.xml'.
     */
    protected function generatePagesSitemap(string $filename = 'pages_sitemap.xml'): bool
    {
        $filename = $this->getFileName($filename);

        $excludedRouteNameUrls = $this->mapExcludedRouteNamesToUrls();
        $excludedPaths = $this->getExcludedPaths();
        $excludedUrls = $this->getExcludedUrls();

        try {
            SitemapGenerator::create(config('app.url'))
                ->configureCrawler(function (Crawler $crawler) {
                    $crawler->ignoreRobots();
                })
                ->hasCrawled(function (Url $url) use ($excludedRouteNameUrls, $excludedPaths, $excludedUrls) {
                    $parsedUrl = parse_url($url->url);
                    $path = $parsedUrl['path'] ?? '';

                    if (isset($parsedUrl['query'])) {
                        return false;
                    }

                    if ($this->isRedirect($url->url)) {
                        return false;
                    }

                    if (in_array($path, $excludedRouteNameUrls) || $this->isPathExcluded($path, $excludedPaths) || in_array($path, $excludedUrls)) {
                        return false;
                    }

                    $normalizedUrl = preg_replace('#([^:])//+#', '$1/', $url->url);
                    $baseUrlWithoutSlash = rtrim(config('app.url'), '/');

                    if ($normalizedUrl === $baseUrlWithoutSlash) {
                        $normalizedUrl = $baseUrlWithoutSlash;
                    } else {
                        $normalizedUrl = rtrim($normalizedUrl, '/');
                    }

                    $url->setUrl($normalizedUrl);

                    return $url;
                })->getSitemap()
                ->writeToDisk($this->diskName, $filename, true);

            return true;
        } catch (Exception $e) {
            Log::error('Failed to generate pages sitemap: '.$e->getMessage());

            return false;
        }
    }

    /**
     * Generates a sitemap for posts.
     *
     * This function is intended to create a sitemap specifically for blog posts or articles.
     * It should define logic similar to generatePagesSitemap, tailored to the data structure and
     * requirements of the posts being included. The generated sitemap could exclude certain posts
     * based on criteria like publication status, visibility settings, or other custom logic.
     */
    protected function generatePostsSitemap(string $filename = 'posts_sitemap.xml'): bool
    {
        $filename = $this->getFileName($filename);

        $sitemap = Sitemap::create();

        $postModelClasses = Config::get('sitemap.post_model', []);

        $postModelClasses = is_array($postModelClasses) ? $postModelClasses : [$postModelClasses];

        try {
            foreach ($postModelClasses as $postModelClass) {
                if (! class_exists($postModelClass)) {
                    throw new Exception("Configured model class '$postModelClass' does not exist.");
                }

                if (! in_array(Sitemapable::class, class_implements($postModelClass))) {
                    throw new Exception("Configured model class '$postModelClass' does not implement the Sitemapable interface.");
                }

                $posts = $postModelClass::where('status', 'published')->get();

                foreach ($posts as $post) {
                    $sitemap->add($post->toSitemapUrl());
                }
            }

            $sitemap->writeToDisk($this->diskName, $filename, true);

            return true;
        } catch (Exception $e) {
            Log::error('Failed to generate posts sitemap: '.$e->getMessage());

            return false;
        }
    }

    /**
     * Determine if a path matches any of the excluded patterns.
     */
    protected function isPathExcluded($path, array $excludedPatterns): bool
    {
        foreach ($excludedPatterns as $pattern) {
            if (preg_match('#^'.preg_quote($pattern, '#').'#', $path)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if a given URL is a redirect.
     */
    protected function isRedirect(string $url): bool
    {
        $excludeRedirects = $this->getExcludeRedirects();

        if (! $excludeRedirects) {
            return false;
        }

        $client = new Client;
        try {
            $response = $client->request('HEAD', $url, ['allow_redirects' => false]);
            $statusCode = $response->getStatusCode();

            return in_array($statusCode, [301, 302, 307, 308]);
        } catch (GuzzleException $e) {
            Log::error('Error checking URL: '.$e->getMessage());

            return false;
        }
    }

    /**
     * Map excluded route names to their URLs, excluding any that are invalid.
     */
    protected function mapExcludedRouteNamesToUrls(): array
    {
        $excludedRouteNames = $this->getExcludedRouteNames();

        return collect($excludedRouteNames)->map(function ($routeName) {
            try {
                return route($routeName, [], false);
            } catch (InvalidArgumentException $e) {
                Log::error('Error excluded route name: '.$e->getMessage());

                return false;
            }
        })->filter()->values()->all();
    }

    /**
     * Get sitemap filename variable.
     */
    protected function getFileName($filename): string
    {
        return 'sitemap/'.$filename;
    }

    /**
     * Get filesystem disk variable.
     */
    protected function getDiskName(): string
    {
        return Config::get('fv-sitemap.disk', 'public');
    }

    /**
     * Get exclude subcategory sitemap links boolean.
     */
    protected function getExcludeSubcategorySitemapLinks(): string
    {
        return Config::get('fv-sitemap.exclude_subcategory_sitemap_links', 'true');
    }

    /**
     * Get excluded redirects boolean.
     */
    protected function getExcludeRedirects(): string
    {
        return Config::get('fv-sitemap.exclude_redirects', 'true');
    }

    /**
     * Get route names to exclude from the sitemap.
     */
    protected function getExcludedRouteNames(): array
    {
        return Config::get('fv-sitemap.exclude_route_names', []);
    }

    /**
     * Get paths to exclude from the sitemap.
     */
    protected function getExcludedPaths(): array
    {
        return Config::get('fv-sitemap.exclude_paths', []);
    }

    /**
     * Get URLs to exclude from the sitemap.
     */
    protected function getExcludedUrls(): array
    {
        return Config::get('fv-sitemap.exclude_urls', []);
    }
}
