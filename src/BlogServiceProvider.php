<?php

namespace Modular\Blog;

use Illuminate\Support\ServiceProvider;
use Modular\Blog\Console\InstallCommand;
use Modular\Blog\Console\MigrateCommand;
use Modular\Blog\Console\SeedCommand;

class BlogServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                MigrateCommand::class,
                SeedCommand::class,
            ]);
        }
    }
}
