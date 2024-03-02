<?php

namespace Fuelviews\Sitemap\Commands;

use Illuminate\Console\Command;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\select;

class InstallCommand extends Command
{
    /**
     * The signature of the install command.
     *
     * This property defines the command that should be used to trigger the install process from the console.
     * It is a unique identifier for the command within the application's namespace, allowing it to be called via the Artisan command-line tool.
     */

    public $signature = 'sitemap:install';

    /**
     * A brief description of what the install command does.
     *
     * This property provides a short explanation of the command's purpose and functionality. It helps users understand what the command will do when executed.
     */
    public $description = 'Sitemap install command';

    /**
     * Handles the execution of the sitemap installation command.
     *
     * This method prompts the user for input to configure the sitemap generation and publishing settings.
     * It offers options to publish the configuration file, set the frequency of sitemap generation, and optionally open the GitHub repository page.
     * Utilizes Laravel's command-line UI prompts to facilitate user interaction and customization of the sitemap installation process.
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

    /**
     * Inserts the sitemap generation command into the application's console kernel.
     *
     * This method adds a scheduled task to the application's console kernel based on the user's specified frequency for sitemap generation.
     * It modifies the Kernel.php file programmatically, ensuring that the sitemap generation command is executed as part of the application's command schedule.
     * If the 'never' option is selected, no action is taken.
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

    /**
     * Opens the provided URL in the user's default web browser.
     *
     * This method detects the operating system and uses the appropriate command to open a web browser to the specified URL.
     * It supports Windows, Linux, and macOS, providing a convenient way for users to access the GitHub repository page of the sitemap package.
     * If the operating system is not supported, it displays the URL and prompts the user to visit it manually.
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
