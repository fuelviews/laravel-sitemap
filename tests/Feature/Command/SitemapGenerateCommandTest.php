<?php

namespace Fuelviews\Sitemap\Tests\Feature\Command;

use Fuelviews\Sitemap\Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class SitemapGenerateCommandTest extends TestCase
{
    /** @test */
    public function it_generates_a_sitemap_successfully(): void
    {
        Artisan::call('sitemap:generate');

        Storage::disk('public')->assertExists('fv-sitemap/sitemap.xml');
        $this->assertStringContainsString('Sitemap generation completed successfully!', Artisan::output());
    }
}
