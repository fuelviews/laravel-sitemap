<?php

return [
    /**
     * Specifies the default filesystem disk that should be used.
     * The 'public' disk is typically used for files that need to be publicly accessible to users.
     * This setting can influence where files, such as generated sitemaps, are stored by default.
     */
    'disk' => 'public_path',

    /**
     * Determines whether the index page should be excluded from the sitemap.
     * Setting this to `true` will exclude the index page, `false` will include it.
     */
    'exclude_index' => true,

    /**
     * Controls whether redirect URLs should be excluded from the sitemap.
     * When set to `true`, all redirects are excluded to ensure the sitemap only contains direct links.
     */
    'exclude_redirects' => true,

    /**
     * An array of route names to be excluded from the sitemap.
     * Useful for excluding specific pages that should not be discoverable via search engines.
     */
    'sitemap_exclude_route_names' => [
        'welcome2',
    ],

    /**
     * Specifies paths that should be excluded from the sitemap.
     * Any routes starting with these paths will not be included in the sitemap, enhancing control over the sitemap contents.
     */
    'exclude_paths' => [
        '/posts/',
    ],

    /**
     * An array of full URLs to be excluded from the sitemap.
     * This allows for fine-grained exclusion of specific pages, such as sitemap files or any other URLs not suitable for search engine indexing.
     */
    'exclude_urls' => [
        '/sitemap.xml',
        '/pages_sitemap.xml',
        '/posts_sitemap.xml'
    ],
];
