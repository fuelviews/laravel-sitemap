<?php

namespace Fuelviews\Sitemap\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Sitemap
 *
 * This class provides a facade for the Sitemap package functionality.
 * It allows easy access to sitemap generation and management methods.
 *
 * @method static string getSitemapContents(string $filename)
 *
 * @see \Fuelviews\Sitemap\Sitemap
 */
class Sitemap extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'sitemap';
    }
}
