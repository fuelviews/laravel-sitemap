<?php

use Fuelviews\Sitemap\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', SitemapController::class)
    ->name('sitemap');