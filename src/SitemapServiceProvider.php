<?php

namespace Fuelviews\Sitemap;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Fuelviews\Sitemap\Commands\SitemapCommand;

class SitemapServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-sitemap')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-sitemap_table')
            ->hasCommand(SitemapCommand::class);
    }
}
