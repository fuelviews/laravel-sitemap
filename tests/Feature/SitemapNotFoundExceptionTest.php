<?php

namespace Fuelviews\Sitemap\Tests\Feature;

use Fuelviews\Sitemap\Http\Controllers\SitemapController;
use Fuelviews\Sitemap\Sitemap;
use Fuelviews\Sitemap\Tests\TestCase;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SitemapNotFoundExceptionTest extends TestCase
{
    /** @test */
    public function it_returns_404_when_sitemap_cannot_be_found_or_generated(): void
    {
        // Mock Storage to simulate file not existing
        Storage::fake('public');
        
        $mockSitemap = Mockery::mock(Sitemap::class);
        $this->app->instance(Sitemap::class, $mockSitemap);

        // Mock generateSitemap to return false (generation failed)
        $mockSitemap->shouldReceive('generateSitemap')
            ->once()
            ->andReturn(false);

        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('Sitemap not found and could not be generated. Please check your configuration.');

        (new SitemapController($mockSitemap))->__invoke();
    }
}
