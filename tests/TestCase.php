<?php

namespace Fuelviews\Sitemap\Tests;

use Fuelviews\Sitemap\SitemapServiceProvider;
use Illuminate\Support\Facades\Storage;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    /**
     * Set up the test environment.
     *
     * This method is called before each test method is executed.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpStorage();
    }

    protected function getPackageProviders($app): array
    {
        return [
            SitemapServiceProvider::class,
            \Spatie\Sitemap\SitemapServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('fv-sitemap.disk', 'public');
        $app['config']->set('fv-sitemap.exclude_subcategory_sitemap_links', true);
        $app['config']->set('fv-sitemap.exclude_redirects', true);
        $app['config']->set('fv-sitemap.exclude_route_names', []);
        $app['config']->set('fv-sitemap.exclude_paths', []);
        $app['config']->set('fv-sitemap.exclude_urls', [
            '/sitemap.xml',
            '/pages_sitemap.xml',
            '/posts_sitemap.xml']);
        $app['config']->set('fv-sitemap.post_model', [
            'App\Models\Post',
        ]);
    }

    /**
     * Set up fake storage for tests.
     */
    protected function setUpStorage(): void
    {
        Storage::fake('public');
    }
}
