<?php

namespace Fuelviews\Sitemap;

use Fuelviews\Sitemap\Commands\SitemapGenerateCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SitemapServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-sitemap')
            ->hasConfigFile('fv-sitemap')
            ->hasRoute('web')
            ->publishesServiceProvider('SitemapServiceProvider')
            ->hasCommand(
                SitemapGenerateCommand::class,
            );
    }
}
