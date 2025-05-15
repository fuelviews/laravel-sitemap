<?php

namespace Fuelviews\Sitemap;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class Sitemap
{
    /**
     * Generate sitemap contents if not exists, then return the contents.
     *
     * @param  string  $filename  The filename of the sitemap.
     * @return string The contents of the sitemap.
     *
     * @throws FileNotFoundException If the file does not exist and cannot be generated.
     */
    public function getSitemapContents(string $filename): string
    {
        $disk = Config::get('fv-sitemap.disk', 'public');
        $path = 'sitemap/'.$filename;

        if (!Storage::disk($disk)->exists($path) && ! $this->generateSitemap()) {
            throw new FileNotFoundException('Sitemap does not exist and could not be generated.');
        }

        return Storage::disk($disk)->get($path);
    }

    /**
     * Generate the sitemap file.
     *
     * @return bool Returns true if the sitemap was successfully generated, false otherwise.
     */
    protected function generateSitemap(): bool
    {
        Artisan::call('sitemap:generate');

        return true;
    }
}
