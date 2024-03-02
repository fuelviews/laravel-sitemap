<?php

it('can test', function () {
    expect(true)->toBeTrue();
});

it('loads the sitemap service provider', function () {
    $this->assertTrue(class_exists(\Fuelviews\Sitemap\SitemapServiceProvider::class));
});

