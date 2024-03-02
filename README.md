# Fuelviews laravel sitemap package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/fuelviews/laravel-sitemap.svg?style=flat-square)](https://packagist.org/packages/fuelviews/laravel-sitemap)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/fuelviews/laravel-sitemap/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/fuelviews/laravel-sitemap/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/fuelviews/laravel-sitemap/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/fuelviews/laravel-sitemap/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/fuelviews/laravel-sitemap.svg?style=flat-square)](https://packagist.org/packages/fuelviews/laravel-sitemap)

The Laravel Sitemap package by Fuelviews is a robust and easy-to-use solution designed to automatically generate sitemaps for your Laravel application. This package simplifies the process of creating dynamic sitemaps, ensuring that search engines can effortlessly discover and index your website's pages. Whether you're managing a small blog or a large e-commerce platform, our Laravel Sitemap package seamlessly integrates with your project, enhancing SEO performance and visibility.

## Installation

You can require the package and it's dependencies via composer:

```bash
composer require fuelviews/laravel-sitemap
```

You can install the package with:

```bash
php artisan sitemap:install
```

You can manually publish the config file with:

```bash
php artisan vendor:publish --provider="Fuelviews\Sitemap\SitemapServiceProvider" --tag="laravel-sitemap-config"
```

This is the contents of the published config file:

```php
<?php

return [
    /**
     * Specifies the default filesystem disk that should be used.
     * The 'public_path' disk is typically used for files that need to be publicly accessible to users.
     * This setting can influence where files, such as generated sitemaps, are stored by default.
     */
    'disk' => 'public',

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
    'exclude_route_names' => [
    ],

    /**
     * Specifies paths that should be excluded from the sitemap.
     * Any routes starting with these paths will not be included in the sitemap, enhancing control over the sitemap contents.
     */
    'exclude_paths' => [
    ],

    /**
     * An array of full URLs to be excluded from the sitemap.
     * This allows for fine-grained exclusion of specific pages, such as sitemap files or any other URLs not suitable for search engine indexing.
     */
    'exclude_urls' => [
        '/sitemap.xml',
        '/pages_sitemap.xml',
        '/posts_sitemap.xml',
    ],

    /**
     * Specifies the model class to be used for fetching posts to be included in the sitemap.
     * This setting allows for customization of the source of content, enabling the sitemap to reflect the structure and content of your website accurately.
     * The specified model should implement any necessary logic to retrieve only the posts that should be visible to search engines.
     */
    'post_model' => [
        //App\Models\Post::class,
    ],
];
```

You can also add your models directly by implementing the \Spatie\Sitemap\Contracts\Sitemapable interface. You also need to define your post_model in the fv-sitemap.php config file.
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Post extends Model implements Sitemapable {
    /**
     * Convert the Post model instance into a sitemap URL entry.
     *
     * @return \Spatie\Sitemap\Tags\Url
     */
    public function toSitemapUrl() {
        $url = Url::create(url("{$this->id}"))
            ->setLastModificationDate($this->updated_at)
            ->setChangeFrequency('daily')
            ->setPriority(0.8);

        return $url;
    }
}
```

You can generate the sitemap with:

```bash
php artisan sitemap:generate
```

com

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/fuelviews/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

If you've found a bug regarding security please mail [support@fuelviews.com](mailto:support@fuelviews.com) instead of using the issue tracker.

## Credits

- [Thejmitchener](https://github.com/thejmitchener)
- [Fuelviews](https://github.com/fuelviews)
- [Spatie](https://github.com/spatie)
- [All Contributors](../../contributors)

## Support us

Fuelviews is a web development agency based in Portland, Maine. You'll find an overview of all our projects [on our website](https://fuelviews.com).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
