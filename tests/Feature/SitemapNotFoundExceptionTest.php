<?php

namespace Fuelviews\Sitemap\Tests\Feature;

use Fuelviews\Sitemap\Http\Controllers\SitemapController;
use Fuelviews\Sitemap\Sitemap;
use Fuelviews\Sitemap\Tests\TestCase;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Mockery;

class SitemapNotFoundExceptionTest extends TestCase
{
    /** @test */
    public function it_throws_file_not_found_exception_if_sitemap_does_not_exist_and_cannot_be_generated()
    {
        $mockSitemap = Mockery::mock(Sitemap::class);
        $this->app->instance(Sitemap::class, $mockSitemap);

        $mockSitemap->shouldReceive('getSitemapContents')
            ->once()
            ->with('sitemap.xml')
            ->andThrow(new FileNotFoundException("Sitemap does not exist and could not be generated."));

        $this->expectException(FileNotFoundException::class);

        (new SitemapController($mockSitemap))->__invoke('sitemap.xml');
    }
}
