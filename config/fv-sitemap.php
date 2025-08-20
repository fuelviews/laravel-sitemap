<?php

/**
 * Laravel Sitemap Configuration
 *
 * This file contains all configuration options for the Fuelviews Laravel Sitemap package.
 * Configure these settings to customize how your application's sitemaps are generated.
 */

return [
    /**
     * Storage Disk Configuration
     *
     * Specifies which Laravel filesystem disk should be used to store
     * the generated sitemap files. Common options: 'public', 'local', 's3'
     */
    'disk' => env('SITEMAP_DISK', 'public'),

    /**
     * Sitemap Index Generation
     *
     * When true, generates separate sitemaps for pages and posts with a sitemap index.
     * When false, generates a single combined sitemap containing all content.
     * Recommended: true for sites with many pages/posts for better performance.
     */
    'exclude_subcategory_sitemap_links' => env('SITEMAP_USE_INDEX', true),

    /**
     * Redirect URL Handling
     *
     * When true, URLs that return redirect status codes (301, 302, 307, 308)
     * will be excluded from the sitemap. This helps keep your sitemap clean
     * and focused on final destination URLs.
     */
    'exclude_redirects' => env('SITEMAP_EXCLUDE_REDIRECTS', true),

    /**
     * Excluded Route Names
     *
     * An array of Laravel route names that should be excluded from sitemap generation.
     * Use this to exclude admin routes, API endpoints, or other non-public pages.
     *
     * Example: ['admin.dashboard', 'api.users.index', 'auth.login']
     */
    'exclude_route_names' => [
        // 'admin.*',
        // 'api.*',
        // 'auth.*',
    ],

    /**
     * Excluded URL Paths
     *
     * An array of URL paths (relative to your domain) that should be excluded
     * from sitemap generation. Supports prefix matching for broad exclusions.
     *
     * Example: ['/admin', '/dashboard', '/api']
     */
    'exclude_paths' => [
        // '/admin',
        // '/dashboard',
        // '/api',
    ],

    /**
     * Excluded URLs
     *
     * An array of complete URLs (relative to your domain) that should be excluded
     * from sitemap generation. These are exact matches, not prefixes.
     */
    'exclude_urls' => [
        '/sitemap.xml',
        '/pages_sitemap.xml',
        '/posts_sitemap.xml',
    ],

    /**
     * Post Models for Sitemap Generation
     *
     * An array of Eloquent model classes that should be included in the posts sitemap.
     * Each model must implement the Spatie\Sitemap\Contracts\Sitemapable interface
     * and have a 'status' column with 'published' values.
     *
     * Example configuration:
     * [
     *     App\Models\Post::class,
     *     App\Models\Article::class,
     * ]
     */
    'post_model' => [
        // App\Models\Post::class,
    ],

    /**
     * URL Generation Settings
     *
     * Configure how URLs are generated and processed for the sitemap.
     */
    'url_settings' => [
        /**
         * Remove trailing slashes from URLs to avoid duplicate content issues.
         */
        'remove_trailing_slashes' => true,

        /**
         * Normalize multiple consecutive slashes in URLs.
         */
        'normalize_slashes' => true,
    ],
];
