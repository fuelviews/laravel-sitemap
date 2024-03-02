<?php

namespace Fuelviews\Sitemap\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class SitemapController extends BaseController
{
    /**
     * Handles the retrieval and serving of sitemap files.
     *
     * This method accepts a filename to locate a specific sitemap file within the configured storage disk.
     * It checks for the file's existence in the specified disk storage, constructing the path by prefixing 'sitemap/' to the filename.
     * If the file exists, it returns the file's contents with an HTTP 200 response, setting the 'Content-Type' to 'application/xml'.
     * If the file is not found, it aborts the process with a 404 error, indicating the requested sitemap does not exist.
     */

    public function index($filename)
    {
        $disk = Config::get('fv-sitemap.disk', 'public');
        $filePath = 'sitemap/'.$filename;

        if (Storage::disk($disk)->exists($filePath)) {
            $content = Storage::disk($disk)->get($filePath);

            return Response::make($content, 200, ['Content-Type' => 'application/xml']);
        }

        return abort(404);
    }
}
