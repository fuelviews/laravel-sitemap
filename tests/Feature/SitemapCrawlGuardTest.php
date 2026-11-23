<?php

namespace Fuelviews\Sitemap\Tests\Feature;

use Fuelviews\Sitemap\Commands\SitemapGenerateCommand;
use Fuelviews\Sitemap\Http\Controllers\SitemapController;
use Fuelviews\Sitemap\Sitemap;
use Fuelviews\Sitemap\Tests\TestCase;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Mockery;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SitemapCrawlGuardTest extends TestCase
{
    /** @test */
    public function it_recognises_sitemap_paths(): void
    {
        foreach (['/sitemap.xml', '/sitemap.xml/', '/pages_sitemap.xml', '/posts_sitemap.xml', '/blog/Sitemap-Index.XML', 'sitemap.xml'] as $path) {
            $this->assertTrue(SitemapGenerateCommand::isSitemapPath($path), $path);
        }

        foreach (['/', '/sitemap', '/about', '/sitemap.xml/extra', '/sitemap.xml.bak', '/sitemaps/page'] as $path) {
            $this->assertFalse(SitemapGenerateCommand::isSitemapPath($path), $path);
        }
    }

    /** @test */
    public function it_returns_503_without_generating_when_generate_on_request_is_off(): void
    {
        config(['fv-sitemap.generate_on_request' => false]);

        $sitemap = Mockery::mock(Sitemap::class);
        $sitemap->shouldNotReceive('generateSitemap');

        try {
            (new SitemapController($sitemap))->__invoke();
            $this->fail('Expected a 503.');
        } catch (HttpException $e) {
            $this->assertSame(503, $e->getStatusCode());
            $this->assertSame('300', $e->getHeaders()['Retry-After'] ?? null);
        }
    }

    /** @test */
    public function it_serves_an_existing_sitemap_when_generate_on_request_is_off(): void
    {
        config(['fv-sitemap.generate_on_request' => false]);
        Storage::disk('public')->put('fv-sitemap/sitemap.xml', '<urlset/>');

        $sitemap = Mockery::mock(Sitemap::class);
        $sitemap->shouldNotReceive('generateSitemap');

        $response = (new SitemapController($sitemap))->__invoke();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('<urlset/>', $response->getContent());
    }

    /** @test */
    public function it_never_requests_sitemap_urls_while_crawling(): void
    {
        config([
            'app.url' => 'http://localhost',
            'fv-sitemap.exclude_subcategory_sitemap_links' => true,
            'fv-sitemap.exclude_redirects' => false,
        ]);

        $requested = [];
        config(['sitemap.guzzle_options' => ['handler' => function (RequestInterface $request) use (&$requested) {
            $path = $request->getUri()->getPath();
            $requested[] = $path;
            $body = $path === '/'
                ? '<html><body><a href="/about">About</a> <a href="/sitemap.xml">Sitemap</a> <a href="/pages_sitemap.xml">Pages</a></body></html>'
                : '<html><body>page</body></html>';

            return Create::promiseFor(new GuzzleResponse(200, ['Content-Type' => 'text/html'], $body));
        }]]);
        View::addNamespace('sitemap', dirname(__DIR__, 2).'/vendor/spatie/laravel-sitemap/resources/views');

        Artisan::call('sitemap:generate');

        $this->assertContains('/', $requested);
        $this->assertContains('/about', $requested);
        $this->assertNotContains('/sitemap.xml', $requested);
        $this->assertNotContains('/pages_sitemap.xml', $requested);
        $this->assertStringContainsString('http://localhost/about', Storage::disk('public')->get('fv-sitemap/sitemap.xml'));
    }

    /** @test */
    public function get_sitemap_contents_does_not_generate_when_generate_on_request_is_off(): void
    {
        config(['fv-sitemap.generate_on_request' => false]);

        $sitemap = Mockery::mock(Sitemap::class)->makePartial();
        $sitemap->shouldNotReceive('generateSitemap');

        $this->expectException(FileNotFoundException::class);

        $sitemap->getSitemapContents('sitemap.xml');
    }
}
