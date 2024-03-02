<?php

namespace Fuelviews\Sitemap\Commands;

use Illuminate\Console\Command;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\select;

class InstallCommand extends Command
{
    /*
    * TODO
    */
    public $signature = 'sitemap:install';

    /*
    * TODO
    */
    public $description = 'Sitemap install command';

    /*
     * TODO
     */
    public function handle(): int
    {
        if (confirm(
            label: 'Do you want to publish the configuration file?',
        )) {
            $this->call('vendor:publish', [
                '--provider' => 'Fuelviews\\Sitemap\\SitemapServiceProvider',
                '--tag' => 'config',
            ]);
        }

        if ($frequency = select(
            label: 'How often do you want to generate your sitemap?',
            options: ['daily', 'weekly', 'monthly', 'never'],
            default: 'weekly'
        )) {
            $this->insertSitemapGenerationCommand($frequency);
        }

        if (confirm(
            label: 'Would you like to star our repo on GitHub?'
        )) {
            $this->openInBrowser('https://github.com/fuelviews/laravel-sitemap');
        }

        return self::SUCCESS;
    }

    /*
    * TODO
    */
    protected function insertSitemapGenerationCommand($frequency)
    {
        if ($frequency === 'never') {
            return;
        }

        $kernelPath = app_path('Console/Kernel.php');
        $kernelContents = file_get_contents($kernelPath);

        if (strpos($kernelContents, 'sitemap:generate') !== false) {
            return;
        }

        $commandToInsert = "        \$schedule->command('sitemap:generate')->$frequency();\n";

        $scheduleMethodPos = strpos($kernelContents, 'function schedule(');
        if ($scheduleMethodPos === false) {
            $this->error('Unable to find the schedule method in Kernel.php.');

            return;
        }

        $insertPos = strpos($kernelContents, '//', $scheduleMethodPos);
        if ($insertPos === false) {
            $this->error('Unable to find the insertion point in Kernel.php.');

            return;
        }

        $insertPos = strpos($kernelContents, "\n", $insertPos) + 1;
        $newKernelContents = substr_replace($kernelContents, $commandToInsert, $insertPos, 0);

        if (file_put_contents($kernelPath, $newKernelContents) === false) {
            $this->error('Failed to write to Kernel.php.');

            return;
        }
    }

    /*
    * TODO
    */
    protected function openInBrowser($url)
    {
        switch (PHP_OS_FAMILY) {
            case 'Windows':
                exec('start '.escapeshellarg($url));
                break;
            case 'Linux':
                exec('xdg-open '.escapeshellarg($url));
                break;
            case 'Darwin': // macOS
                exec('open '.escapeshellarg($url));
                break;
            default:
                $this->error('Platform not supported.');
                $this->info("Please visit: $url");
                break;
        }
    }
}
