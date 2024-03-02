<?php

namespace Fuelviews\Sitemap;

use Fuelviews\Sitemap\Commands\InstallCommand;
use Fuelviews\Sitemap\Commands\SitemapGenerateCommand;
use Fuelviews\Sitemap\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SitemapServiceProvider extends PackageServiceProvider
{
    /**
     * Configures the package within the Laravel application.
     *
     * This method sets up the package by specifying its name, registering its configuration file for publishing, and declaring any service providers it publishes.
     * It also registers console commands provided by the package, enhancing the Artisan CLI with sitemap generation and installation capabilities.
     * This setup facilitates the integration of the sitemap functionality into a Laravel application, making it configurable and extendable.
     */

    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-sitemap')
            ->hasConfigFile('fv-sitemap')
            ->publishesServiceProvider('SitemapServiceProvider')
            ->hasCommands([
                SitemapGenerateCommand::class,
                InstallCommand::class,
            ]);
    }

    /**
     * Registers the package's routes.
     *
     * This method sets up a route that captures requests for XML sitemap files.
     * It directs these requests to the SitemapController, specifically to the 'index' method, which handles the retrieval and serving of sitemap files.
     * The route is configured to only match requests ending in '.xml', ensuring that only sitemap file requests are handled.
     */
    public function PackageRegistered()
    {
        /*if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/fv-sitemap.php' => config_path('fv-sitemap.php'),
            ], 'laravel-sitemap-config');
        }*/

        Route::get('/{filename}', [SitemapController::class, 'index'])
            ->where('filename', '.*\.xml$');
    }
}
