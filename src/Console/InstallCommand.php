<?php

namespace Modular\Blog\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

use function Laravel\Prompts\confirm;

class InstallCommand extends Command
{
    protected $signature = 'modular:blog-install';

    protected $description = 'Install the Modular Blog required resources';

    public function handle(): void
    {
        $this->copyBlogModuleDirectory();
        $this->copyResourcesFiles();
        $this->copyResourcesSiteFiles();
        $this->copyResourcesComponentsFiles();
        $this->copyTranslationFile();

        $this->call('storage:link');

        $this->call('modular:blog-migrate');

        $this->info('Modular Blog installed successfully.');

        $seederConfirmed = confirm(
            label: 'Do you wish to run the Blog Seeders?',
            default: true,
            yes: 'Yes',
            no: 'No',
            hint: 'The seeder process may take a few seconds, it fetches some images'
        );

        if ($seederConfirmed) {
            $this->call('modular:blog-seed');
        }
    }

    private function copyBlogModuleDirectory(): void
    {
        $this->info('Copying Blog Module directory...');
        (new Filesystem)->ensureDirectoryExists(base_path('modules'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/modules/Blog', base_path('modules/Blog'));
        $this->info('Blog Module directory copied successfully.');
    }

    private function copyResourcesComponentsFiles(): void
    {
        $this->info('Copying Blog Module components...');
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Components/Modules/Blog'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/js/Components/Modules/Blog', resource_path('js/Components/Modules/Blog'));
        $this->info('Blog Module components copied successfully.');
    }

    private function copyResourcesFiles(): void
    {
        $this->info('Copying Blog Module resources...');
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/js/Pages', resource_path('js/Pages'));
        $this->info('Blog Module resources copied successfully.');
    }

    private function copyResourcesSiteFiles(): void
    {
        $this->info('Copying Blog Module resources-site...');
        (new Filesystem)->ensureDirectoryExists(base_path('resources-site'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources-site', base_path('resources-site'));
        $this->info('Blog Module resources-site copied successfully.');
    }

    private function copyTranslationFile(): void
    {
        $paginationEnglish = base_path('lang/en/pagination.php');

        if (! file_exists($paginationEnglish)) {
            (new Filesystem)->ensureDirectoryExists(base_path('lang/en'));
            copy(__DIR__.'/../../stubs/lang/en/pagination.php', base_path('lang/en/pagination.php'));
        }
    }
}
