<?php

namespace Fuelviews\Sitemap\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Fuelviews\Sitemap\Sitemap
 */
class Sitemap extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Fuelviews\Sitemap\Sitemap::class;
    }
}
