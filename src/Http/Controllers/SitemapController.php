<?php

namespace Fuelviews\Sitemap\Http\Controllers;

use Fuelviews\Sitemap\Sitemap;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class SitemapController
 *
 * Controller responsible for handling requests related to sitemaps.
 */
class SitemapController extends BaseController
{
    protected Sitemap $sitemap;

    /**
     * SitemapController constructor.
     */
    public function __construct(Sitemap $sitemap)
    {
        $this->sitemap = $sitemap;
    }

    /**
     * Retrieve the content of the specified sitemap file.
     *
     * @param  string|null  $filename  The name of the sitemap file.
     *
     * @throws FileNotFoundException
     */
    public function __invoke(?string $filename = null): Response
    {
        $filename = 'sitemap.xml';

        $contents = $this->sitemap->getSitemapContents($filename);

        return response($contents, 200)
            ->header('Content-Type', 'application/xml');
    }
}
