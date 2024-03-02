<?php

namespace Fuelviews\Sitemap\Tests;

use Fuelviews\Sitemap\SitemapServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            SitemapServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Set environment values required for your tests
        $app['config']->set('app.url', 'https://localhost');
    }
}
