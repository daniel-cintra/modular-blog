<?php

namespace Modular\Blog\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

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

        $this->info('Modular Blog installed successfully.');
        $this->info('Running the following command to migrate the Blog module:');

        if ($this->confirm('Do you wish to run the Blog migrations?')) {
            $this->call('modular:blog-migrate');

            if ($this->confirm('Do you wish to run the Blog seeders?')) {
                $this->call('modular:blog-seed');
            }
        }
    }

    private function copyBlogModuleDirectory(): void
    {
        $this->info('Copying Blog Module directory...');
        (new Filesystem)->ensureDirectoryExists(base_path('modules'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/modules/Blog', base_path('modules/Blog'));
        $this->info('Blog Module directory copied successfully.');
    }

    private function copyResourcesComponentsFiles(): void
    {
        $this->info('Copying Blog Module components...');
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Components/Modules/Blog'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/resources/js/Components/Modules/Blog', resource_path('js/Components/Modules/Blog'));
        $this->info('Blog Module components copied successfully.');
    }

    private function copyResourcesFiles(): void
    {
        $this->info('Copying Blog Module resources...');
        (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/resources/js/Pages', resource_path('js/Pages'));
        $this->info('Blog Module resources copied successfully.');
    }

    private function copyResourcesSiteFiles(): void
    {
        $this->info('Copying Blog Module resources-site...');
        (new Filesystem)->ensureDirectoryExists(base_path('resources-site'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/resources-site', base_path('resources-site'));
        $this->info('Blog Module resources-site copied successfully.');
    }
}
