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

    protected string $defaultFilename = 'sitemap.xml';

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
     * @return Response
     * @throws FileNotFoundException
     */
    public function __invoke(): Response
    {
        $contents = $this->sitemap->getSitemapContents($this->defaultFilename);

        return response($contents, 200)
            ->header('Content-Type', 'application/xml');
    }
}
