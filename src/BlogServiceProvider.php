<?php

namespace Modular\Blog;

use Illuminate\Support\ServiceProvider;
use Modular\Blog\Console\InstallCommand;

class BlogServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }
}
