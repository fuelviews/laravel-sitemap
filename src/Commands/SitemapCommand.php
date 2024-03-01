<?php

namespace Fuelviews\Sitemap\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;
use Spatie\Crawler\Crawler;
use Spatie\Sitemap\SitemapIndex;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
Use Illuminate\Support\Facades\Storage;

class SitemapCommand extends Command
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
    protected $description = 'Generate sitemap';

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
        $SitemapIndex = !Config::get('fv-sitemap.exclude_index');

        if ($SitemapIndex) {
            $this->generatePagesSitemap();
            $this->generatePostsSitemap();

            $sitemapIndex = SitemapIndex::create()
                ->add('/pages_sitemap.xml')
                ->add('/posts_sitemap.xml');

            $sitemapIndex->writeToFile(public_path('sitemap.xml'));
        } else {
            $this->generatePagesSitemap('sitemap.xml');
        }

        $this->info('Sitemap generated successfully.');
    }

    /**
     * Generates a sitemap for pages, excluding specified routes, paths, and URLs.
     *
     * This function creates a sitemap specifically for pages by leveraging a sitemap generator.
     * It filters out URLs based on various criteria, including predefined excluded routes, paths,
     * and specific URLs. The resulting sitemap is then saved to a specified filename.
     *
     * @param string $filename The filename for the generated sitemap, defaulting to 'pages_sitemap.xml'.
     */
    protected function generatePagesSitemap($filename = 'pages_sitemap.xml')
    {
        $diskName = Config::get('fv-sitemap.disk');
        $tempFilePath = tempnam(sys_get_temp_dir(), 'sitemap');

        $excludedRouteNameUrls = $this->mapExcludedRoutesToUrls();
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
                } else if ($url->url === $baseUrlWithoutSlash . '/') {
                    return null;
                }

                return $url;
            })->getSitemap()->writeToFile($tempFilePath);

        $sitemapContent = file_get_contents($tempFilePath);

        if ($diskName !== 'public_path') {
            Storage::disk($diskName)->put($filename, $sitemapContent);
        } else {
            file_put_contents(public_path($filename), $sitemapContent);
        }

        // Remove the temporary file after use
        @unlink($tempFilePath);
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
     * Check if a given URL is a redirect.
     *
     * @param string $url
     * @return bool
     */
    protected function isRedirect($url)
    {
        $excludeRedirects = Config::get('fv-sitemap.exclude_redirects');

        if (!$excludeRedirects) {
            return false;
        }

        $client = new Client();
        try {
            $response = $client->request('HEAD', $url, ['allow_redirects' => false]);
            $statusCode = $response->getStatusCode();
            return in_array($statusCode, [301, 302, 307, 308]);
        } catch (GuzzleException $e) {
            Log::error('Error checking URL: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get route names to exclude from the sitemap.
     *
     * @return array
     */
    protected function getExcludedRouteNames()
    {
        return Config::get('fv-sitemap.sitemap_exclude_route_names', []);

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

    /**
     * Map excluded route names to their URLs, excluding any that are invalid.
     *
     * @return array
     */
    protected function mapExcludedRoutesToUrls()
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
     * Determine if a path matches any of the excluded patterns.
     *
     * @param string $path
     * @param array $excludedPatterns
     * @return bool
     */
    protected function isPathExcluded($path, $excludedPatterns)
    {
        foreach ($excludedPatterns as $pattern) {
            if (preg_match("#^" . preg_quote($pattern, '#') . "#", $path)) {
                return true;
            }
        }
        return false;
    }
}
