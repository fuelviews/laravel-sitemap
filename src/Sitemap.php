<?php

namespace Fuelviews\Sitemap;

use Fuelviews\Sitemap\Commands\SitemapGenerateCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

/**
 * Class Sitemap
 *
 * This class handles sitemap content retrieval and generation.
 * It provides functionality for serving sitemap files and automatically
 * generating them when they don't exist.
 */
class Sitemap
{
    /**
     * Get sitemap contents, generating if necessary.
     *
     * Retrieves the content of the specified sitemap file. If the file doesn't exist,
     * it attempts to generate it automatically. This ensures sitemaps are always available
     * even if they haven't been explicitly generated.
     *
     * @param  string  $filename  The filename of the sitemap to retrieve
     * @return string The XML content of the sitemap
     *
     * @throws FileNotFoundException If the file does not exist and cannot be generated
     */
    public function getSitemapContents(string $filename): string
    {
        $disk = $this->getDisk();
        $path = $this->buildPath($filename);

        if (! Storage::disk($disk)->exists($path)) {
            if (! $this->generateSitemap()) {
                throw new FileNotFoundException(
                    "Sitemap '{$filename}' does not exist and could not be generated. ".'Please check your sitemap configuration and ensure all required models exist.'
                );
            }
        }

        $content = Storage::disk($disk)->get($path);

        if ($content === null) {
            throw new FileNotFoundException("Unable to read sitemap content from '{$filename}'");
        }

        return $content;
    }

    /**
     * Generate sitemap files programmatically.
     *
     * Uses Artisan::call to properly execute the command in the correct context.
     * This method provides a way to generate sitemaps programmatically without
     * going through the Artisan console.
     *
     * @return bool True if generation was successful, false otherwise
     */
    public function generateSitemap(): bool
    {
        try {
            $exitCode = \Illuminate\Support\Facades\Artisan::call('sitemap:generate');

            return $exitCode === 0;
        } catch (\Throwable $e) {
            // Log the error for debugging purposes
            logger()->error('Sitemap generation failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return false;
        }
    }

    /**
     * Get the configured disk for sitemap storage.
     */
    protected function getDisk(): string
    {
        return Config::get('fv-sitemap.disk', 'public');
    }

    /**
     * Build the full storage path for a sitemap file.
     */
    protected function buildPath(string $filename): string
    {
        return 'sitemap/'.ltrim($filename, '/');
    }
}
