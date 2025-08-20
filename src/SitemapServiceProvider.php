<?php

namespace Fuelviews\Sitemap;

use Fuelviews\Sitemap\Commands\SitemapGenerateCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SitemapServiceProvider extends PackageServiceProvider
{
    /**
     * Configure the package.
     *
     * Sets up the package configuration, routes, and commands using
     * spatie/laravel-package-tools for consistent package structure.
     */
    public function configurePackage(Package $package): void
    {
        $package
            ->name('sitemap')
            ->hasConfigFile('fv-sitemap')
            ->hasRoute('web')
            ->hasCommand(SitemapGenerateCommand::class);
    }

    /**
     * Register package services.
     *
     * Binds the main Sitemap class as a singleton in the container.
     */
    public function registeringPackage(): void
    {
        $this->app->singleton(Sitemap::class, function ($app) {
            return new Sitemap;
        });
    }
}
