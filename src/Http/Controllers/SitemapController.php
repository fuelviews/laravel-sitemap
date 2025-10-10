<?php

namespace Fuelviews\Sitemap\Http\Controllers;

use Fuelviews\Sitemap\Sitemap;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

/**
 * Class SitemapController
 *
 * Controller responsible for serving XML sitemap files to search engines and visitors.
 * Handles requests for sitemap.xml and automatically generates sitemaps if they don't exist.
 */
class SitemapController extends BaseController
{
    protected Sitemap $sitemap;

    protected string $defaultFilename = 'sitemap.xml';

    /**
     * Create a new SitemapController instance.
     */
    public function __construct(Sitemap $sitemap)
    {
        $this->sitemap = $sitemap;
    }

    /**
     * Serve the main sitemap file.
     *
     * Retrieves and serves the sitemap.xml file with proper XML headers.
     * If the sitemap doesn't exist, it will be automatically generated.
     *
     * @return Response XML sitemap content with appropriate headers
     *
     * @throws FileNotFoundException If sitemap cannot be found or generated
     */
    public function __invoke(): Response
    {
        try {
            // Check if sitemap needs to be regenerated (only if file doesn't exist)
            if ($this->shouldRegenerateSitemap()) {
                if (! $this->sitemap->generateSitemap()) {
                    abort(404, 'Sitemap not found and could not be generated. Please check your configuration.');
                }
            }

            $contents = $this->getSitemapFileContents();

            return response($contents, 200)
                ->header('Content-Type', 'application/xml; charset=utf-8')
                ->header('Cache-Control', 'public, max-age=3600'); // Cache for 1 hour
        } catch (FileNotFoundException $e) {
            // Log the error for debugging
            logger()->error('Sitemap not found', [
                'filename' => $this->defaultFilename,
                'error' => $e->getMessage(),
            ]);

            // Return a 404 response for missing sitemaps
            abort(404, 'Sitemap not found. Please generate sitemap using: php artisan sitemap:generate');
        }
    }

    /**
     * Check if the sitemap should be regenerated.
     *
     * Only returns true if the sitemap file doesn't exist.
     * No time-based cache expiration - sitemap is only regenerated when:
     * 1. File doesn't exist (first access or manual deletion)
     * 2. php artisan sitemap:generate is run manually
     *
     * @return bool True if sitemap should be regenerated, false otherwise
     */
    protected function shouldRegenerateSitemap(): bool
    {
        $disk = Config::get('fv-sitemap.disk', 'public');
        $path = 'fv-sitemap/'.ltrim($this->defaultFilename, '/');

        // If file doesn't exist, it should be generated
        return ! Storage::disk($disk)->exists($path);
    }

    /**
     * Get sitemap file contents directly from storage.
     *
     * @return string The XML content of the sitemap
     *
     * @throws FileNotFoundException If the file cannot be read
     */
    protected function getSitemapFileContents(): string
    {
        $disk = Config::get('fv-sitemap.disk', 'public');
        $path = 'sitemap/'.ltrim($this->defaultFilename, '/');

        if (! Storage::disk($disk)->exists($path)) {
            throw new FileNotFoundException("Sitemap file '{$this->defaultFilename}' does not exist.");
        }

        $content = Storage::disk($disk)->get($path);

        if ($content === null) {
            throw new FileNotFoundException("Unable to read sitemap content from '{$this->defaultFilename}'");
        }

        return $content;
    }
}
