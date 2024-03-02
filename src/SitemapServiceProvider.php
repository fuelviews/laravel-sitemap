<?php

namespace Fuelviews\Sitemap;

use Fuelviews\Sitemap\Commands\InstallCommand;
use Fuelviews\Sitemap\Commands\SitemapGenerateCommand;
use Fuelviews\Sitemap\Http\Controllers\SitemapController;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Illuminate\Support\Facades\Route;

class SitemapServiceProvider extends PackageServiceProvider
{
    /**
     * TODO
     */
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-sitemap')
            ->hasConfigFile('fv-sitemap')
            ->publishesServiceProvider('SitemapServiceProvider')
            ->hasCommands([
                SitemapGenerateCommand::class,
                InstallCommand::class
            ]);
    }

    /**
     * TODO
     */
    public function PackageRegistered()
    {
        Route::get('/{filename}', [SitemapController::class, 'index'])
            ->where('filename', '.*\.xml$');
    }
}
