<?php

namespace Fuelviews\Sitemap\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Spatie\Crawler\Crawler;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

class SitemapGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * This signature allows the command to be called using the console.
     * It defines the command's name that will be used when running it from the command line.
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * This description provides a brief overview of what the command does
     * when listed in the console. It's shown when you run `php artisan list`
     * or when you specifically view help for this command.
     */
    protected $description = 'Sitemap Generation';

    /**
     * TODO
     */
    protected $diskName;

    /**
     * Execute the console command.
     *
     * This method handles the logic after the command is called. It decides
     * whether to include an index in the sitemap based on configuration settings.
     * Depending on those settings, it may generate individual sitemaps for pages
     * and posts and then either create a sitemap index to include them or
     * directly generate a single sitemap.
     */
    public function handle()
    {
        $this->diskName = Config::get('fv-sitemap.disk', 'public');

        try {
            $SitemapIndex = ! Config::get('fv-sitemap.exclude_index');

            if ($SitemapIndex) {
                $this->generatePagesSitemap();
                $this->generatePostsSitemap();

                $sitemapIndex = SitemapIndex::create()
                    ->add('/sitemap/pages_sitemap.xml')
                    ->add('/sitemap/posts_sitemap.xml');

                $sitemapIndex->writeToDisk($this->diskName, '/sitemap/sitemap.xml', true);
            } else {
                $this->generatePagesSitemap('/sitemap/sitemap.xml');
            }

            $this->info('Sitemap generated successfully.');
        } catch (\Exception $e) {
            Log::error('Sitemap generation failed: '.$e->getMessage());

            $this->error('Sitemap generation failed: '.$e->getMessage());

            return 1;
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
    protected function generatePagesSitemap($filename = 'pages_sitemap.xml')
    {
        $filename = 'sitemap/'.$filename;

        $excludedRouteNameUrls = $this->mapExcludedRouteNamesToUrls();
        $excludedPaths = $this->getExcludedPaths();
        $excludedUrls = $this->getExcludedUrls();

        SitemapGenerator::create(config('app.url'))
            ->configureCrawler(function (Crawler $crawler) {
                $crawler->ignoreRobots();
            })
            ->hasCrawled(function (Url $url) use ($excludedRouteNameUrls, $excludedPaths, $excludedUrls) {
                $path = parse_url($url->url, PHP_URL_PATH);

                if ($this->isRedirect($url->url)) {
                    return;
                }

                if (in_array($path, $excludedRouteNameUrls) || $this->isPathExcluded($path, $excludedPaths) || in_array($path, $excludedUrls)) {
                    return null;
                }

                $baseUrlWithoutSlash = rtrim(config('app.url'), '/');

                $normalizedUrl = rtrim($url->url, '/');
                if ($normalizedUrl !== $baseUrlWithoutSlash) {
                    $url->setUrl($normalizedUrl);
                } elseif ($url->url === $baseUrlWithoutSlash.'/') {
                    return null;
                }

                return $url;
            })->getSitemap()->writeToDisk($this->diskName, $filename, true);
    }

    /**
     * Generates a sitemap for posts.
     *
     * This function is intended to create a sitemap specifically for blog posts or articles.
     * It should define logic similar to generatePagesSitemap, tailored to the data structure and
     * requirements of the posts being included. The generated sitemap could exclude certain posts
     * based on criteria like publication status, visibility settings, or other custom logic.
     */
    protected function generatePostsSitemap()
    {
        //
    }

    /**
     * Determine if a path matches any of the excluded patterns.
     *
     * @param  string  $path
     * @param  array  $excludedPatterns
     * @return bool
     */
    protected function isPathExcluded($path, $excludedPatterns)
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
     *
     * @param  string  $url
     * @return bool
     */
    protected function isRedirect($url)
    {
        $excludeRedirects = Config::get('fv-sitemap.exclude_redirects');

        if (! $excludeRedirects) {
            return false;
        }

        $client = new Client();
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
     *
     * @return array
     */
    protected function mapExcludedRouteNamesToUrls()
    {
        $excludedRouteNames = $this->getExcludedRouteNames();

        return collect($excludedRouteNames)->map(function ($routeName) {
            try {
                return route($routeName, [], false);
            } catch (\InvalidArgumentException $e) {
                return null;
            }
        })->filter()->values()->all();
    }

    /**
     * Get route names to exclude from the sitemap.
     *
     * @return array
     */
    protected function getExcludedRouteNames()
    {
        return Config::get('fv-sitemap.exclude_route_names', []);

    }

    /**
     * Get paths to exclude from the sitemap.
     *
     * @return array
     */
    protected function getExcludedPaths()
    {
        return Config::get('fv-sitemap.exclude_paths', []);
    }

    /**
     * Get URLs to exclude from the sitemap.
     *
     * @return array
     */
    protected function getExcludedUrls()
    {
        return Config::get('fv-sitemap.exclude_urls', []);
    }
}
