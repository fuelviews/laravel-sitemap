<?php

namespace Spatie\Sitemap\Crawler;

use Spatie\Crawler\CrawlProfiles\CrawlProfile;
use Psr\Http\Message\UriInterface;

class Profile extends CrawlProfile
{
    /** @var callable */
    protected $callback;

    public function shouldCrawlCallback(callable $callback): void
    {
        $this->callback = $callback;
    }

    public function shouldCrawl(UriInterface $url): bool
    {
        return ($this->callback)($url);
    }
}
