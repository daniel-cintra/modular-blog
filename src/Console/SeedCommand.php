<?php

namespace Modular\Blog\Console;

use Illuminate\Console\Command;
use Modules\Blog\Database\Seeders\BlogSeeder;

class SeedCommand extends Command
{
    protected $signature = 'modular:blog-seed';

    protected $description = 'Run the the Modular Blog seeders';

    public function handle(): void
    {
        $this->info('Running the following command to seed the Blog module:');

        $this->call(BlogSeeder::class);

        $this->info('Modular Blog seeded successfully.');
    }
}
