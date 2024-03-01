<?php

/**
 * Configuration File: fv-sitemap.php
 *
 * This file contains configuration options for the sitemap generation.
 */

return [
    /**
     * Specifies the default filesystem disk that should be used.
     */
    'disk' => 'public',

    /**
     * Determines whether the index page should be excluded from the sitemap.
     */
    'exclude_subcategory_sitemap_links' => true,

    /**
     * Controls whether redirect URLs should be excluded from the sitemap.
     */
    'exclude_redirects' => true,

    /**
     * An array of route names to be excluded from the sitemap.
     */
    'exclude_route_names' => [
    ],

    /**
     * Specifies paths that should be excluded from the sitemap.
     */
    'exclude_paths' => [
    ],

    /**
     * An array of full URLs to be excluded from the sitemap.
     */
    'exclude_urls' => [
        '/sitemap.xml',
        '/pages_sitemap.xml',
        '/posts_sitemap.xml',
    ],

    /**
     * Specifies the model class to be used for fetching posts to be included in the sitemap.
     */
    'post_model' => [
        //App\Models\Post::class,
    ],
];
