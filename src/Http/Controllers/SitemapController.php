<?php

namespace Fuelviews\Sitemap\Http\Controllers;

use Fuelviews\Sitemap\Sitemap;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class SitemapController extends BaseController
{
    protected Sitemap $sitemap;

    public function __construct(Sitemap $sitemap)
    {
        $this->sitemap = $sitemap;
    }

    /**
     * @throws FileNotFoundException
     */
    public function __invoke($filename): Response
    {
        $contents = $this->sitemap->getSitemapContents($filename);

        return response($contents, 200)
            ->header('Content-Type', 'application/xml');
    }
}
