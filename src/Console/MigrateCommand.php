<?php

namespace Modular\Blog\Console;

use Illuminate\Console\Command;

class MigrateCommand extends Command
{
    protected $signature = 'modular:blog-migrate {--seed : Seed the Blog module}';

    protected $description = 'Run the the Modular Blog migrations';

    public function handle(): void
    {
        $this->call('migrate', [
            '--path' => 'modules/Blog/Database/Migrations',
        ]);

        $this->info('Modular Blog migrated successfully.');

        if ($this->option('seed')) {
            $this->call('modular:blog-seed');
        }
    }
}
