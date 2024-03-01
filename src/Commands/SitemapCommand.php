<?php

namespace Fuelviews\Sitemap\Commands;

use Illuminate\Console\Command;

class SitemapCommand extends Command
{
    public $signature = 'laravel-sitemap';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
