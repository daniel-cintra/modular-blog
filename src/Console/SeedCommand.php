<?php

namespace Modular\Blog\Console;

use Illuminate\Console\Command;
use Modules\Blog\Database\Seeders\BlogAclSeeder;
use Modules\Blog\Database\Seeders\BlogSeeder;

class SeedCommand extends Command
{
    protected $signature = 'modular:blog-seed';

    protected $description = 'Run the the Modular Blog seeders';

    public function handle(): void
    {
        $this->info('Running the following commands to seed the Blog Module:');

        $this->call(BlogSeeder::class);
        $this->call(BlogAclSeeder::class);

        $this->info('Modular Blog seeded successfully.');
    }
}
