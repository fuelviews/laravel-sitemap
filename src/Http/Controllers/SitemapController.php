<?php

namespace Fuelviews\Sitemap\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;

class SitemapController extends BaseController
{
    /*
     * TODO
     */
    public function index($filename)
    {
        $disk = Config::get('fv-sitemap.disk', 'public');
        $filePath = 'sitemap/' . $filename;

        if (Storage::disk($disk)->exists($filePath)) {
            $content = Storage::disk($disk)->get($filePath);
            return Response::make($content, 200, ['Content-Type' => 'application/xml']);
        }

        return abort(404);
    }
}
