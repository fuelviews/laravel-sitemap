<?php

namespace Fuelviews\Sitemap\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Facade for the Sitemap service.
 */
class Sitemap extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Fuelviews\Sitemap\Sitemap::class;
    }
}
