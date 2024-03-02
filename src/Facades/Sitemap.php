<?php

namespace Fuelviews\Sitemap\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Facade for the Sitemap service.
 *
 * This class provides a static interface to the Sitemap functionality, allowing it to be accessed easily throughout the application.
 * It extends Laravel's Facade base class, which provides a simple way to implement a facade for a service container binding.
 * The `getFacadeAccessor` method is overridden to specify the underlying class the facade should proxy to, which is the `\Fuelviews\Sitemap\Sitemap` service.
 * By using this facade, developers can call Sitemap methods statically, offering a convenient API while maintaining loose coupling.
 */
class Sitemap extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Fuelviews\Sitemap\Sitemap::class;
    }
}
