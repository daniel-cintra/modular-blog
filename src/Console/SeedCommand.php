<?php

namespace Modular\Blog\Console;

use Illuminate\Console\Command;

class SeedCommand extends Command
{
    protected $signature = 'modular:blog-seed';

    protected $description = 'Run the the Modular Blog seeders';

    public function handle(): void
    {
        $this->info('Running the following command to seed the Blog module:');
        $this->call('db:seed', [
            '--class' => 'BlogSeeder',
        ]);
        $this->info('Modular Blog seeded successfully.');
    }
}
