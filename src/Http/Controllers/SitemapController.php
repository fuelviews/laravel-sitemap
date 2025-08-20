<?php

namespace Fuelviews\Sitemap\Http\Controllers;

use Fuelviews\Sitemap\Sitemap;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

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
            $contents = $this->sitemap->getSitemapContents($this->defaultFilename);

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
}
