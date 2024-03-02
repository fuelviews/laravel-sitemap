# Fuelviews laravel sitemap package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/fuelviews/laravel-sitemap.svg?style=flat-square)](https://packagist.org/packages/fuelviews/laravel-sitemap)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/fuelviews/laravel-sitemap/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/fuelviews/laravel-sitemap/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/fuelviews/laravel-sitemap/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/fuelviews/laravel-sitemap/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/fuelviews/laravel-sitemap.svg?style=flat-square)](https://packagist.org/packages/fuelviews/laravel-sitemap)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-sitemap.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-sitemap)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

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
];
```

You can generate the sitemap with:

```bash
php artisan sitemap:generate
```

## Usage

```
To access the sitemap, navigate to your application's URL and append /sitemap.xml to it.For example, if your application is hosted at http://www.example.com, the sitemap can be found at http://www.example.com/sitemap.xml.
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Thejmitchener](https://github.com/thejmitchener)
- [Fuelviews](https://github.com/fuelviews)
- [Spatie](https://github.com/spatie)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
