<?php

namespace Fuelviews\Sitemap\Tests\Feature;

use Fuelviews\Sitemap\Http\Controllers\SitemapController;
use Fuelviews\Sitemap\Sitemap;
use Fuelviews\Sitemap\Tests\TestCase;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Mockery;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SitemapNotFoundExceptionTest extends TestCase
{
    /** @test */
    public function it_returns_404_when_sitemap_cannot_be_found_or_generated(): void
    {
        $mockSitemap = Mockery::mock(Sitemap::class);
        $this->app->instance(Sitemap::class, $mockSitemap);

        $mockSitemap->shouldReceive('getSitemapContents')
            ->once()
            ->with('sitemap.xml')
            ->andThrow(new FileNotFoundException('Sitemap does not exist and could not be generated.'));

        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('Sitemap not found. Please generate sitemap using: php artisan sitemap:generate');

        (new SitemapController($mockSitemap))->__invoke();
    }
}
