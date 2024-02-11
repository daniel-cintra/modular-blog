<?php

use Illuminate\Filesystem\Filesystem;

afterEach(function () {
    (new Filesystem)->deleteDirectory(base_path('modules'));
    (new Filesystem)->deleteDirectory(resource_path('js'));
    (new Filesystem)->deleteDirectory(base_path('resources-site'));
    (new Filesystem)->deleteDirectory(base_path('database/seeders'));
});

it('can run modular-blog:install command', function () {
    $this->artisan('modular:blog-install')
        ->expectsConfirmation('Do you wish to run the Blog migrations?', 'no')
        ->assertSuccessful();
});

it('can copy the Blog directories and files', function () {
    $this->artisan('modular:blog-install')
        ->expectsConfirmation('Do you wish to run the Blog migrations?', 'no')
        ->assertExitCode(0);

    // modules/Blog
    $this->assertDirectoryExists(base_path('modules/Blog'));
    $this->assertDirectoryExists(base_path('modules/Blog/Database'));
    $this->assertDirectoryExists(base_path('modules/Blog/Http'));
    $this->assertDirectoryExists(base_path('modules/Blog/Models'));
    $this->assertDirectoryExists(base_path('modules/Blog/Observers'));
    $this->assertDirectoryExists(base_path('modules/Blog/routes'));
    $this->assertDirectoryExists(base_path('modules/Blog/Services'));
    $this->assertDirectoryExists(base_path('modules/Blog/Tests'));
    $this->assertDirectoryExists(base_path('modules/Blog/views'));

    $this->assertFileExists(base_path('modules/Blog/BlogServiceProvider.php'));
    $this->assertFileExists(base_path('modules/Blog/routes/app.php'));
    $this->assertFileExists(base_path('modules/Blog/routes/site.php'));

    $this->assertFileExists(base_path('modules/Blog/Http/Controllers/PostController.php'));
    $this->assertFileExists(base_path('modules/Blog/Models/Post.php'));

    // resources/js/Pages
    $this->assertDirectoryExists(resource_path('js/Pages/BlogAuthor'));
    $this->assertFileExists(resource_path('js/Pages/BlogAuthor/AuthorIndex.vue'));
    $this->assertFileExists(resource_path('js/Pages/BlogAuthor/AuthorForm.vue'));

    $this->assertDirectoryExists(resource_path('js/Pages/BlogCategory'));
    $this->assertFileExists(resource_path('js/Pages/BlogCategory/CategoryIndex.vue'));
    $this->assertFileExists(resource_path('js/Pages/BlogCategory/CategoryForm.vue'));

    $this->assertDirectoryExists(resource_path('js/Pages/BlogPost'));
    $this->assertFileExists(resource_path('js/Pages/BlogPost/PostIndex.vue'));
    $this->assertFileExists(resource_path('js/Pages/BlogPost/PostForm.vue'));

    $this->assertDirectoryExists(resource_path('js/Pages/BlogTag'));
    $this->assertFileExists(resource_path('js/Pages/BlogTag/TagIndex.vue'));
    $this->assertFileExists(resource_path('js/Pages/BlogTag/TagForm.vue'));

    // resources/js/Components
    $this->assertFileExists(resource_path('js/Components/Modules/Blog/AppImageNotAvailable.vue'));

    // resources-site/js
    $this->assertFileExists(base_path('resources-site/js/blog-app.js'));
    $this->assertFileExists(base_path('resources-site/js/Components/Blog/ArchiveSelector.vue'));
    $this->assertFileExists(base_path('resources-site/js/Components/Blog/BlogToolbar.vue'));
    $this->assertFileExists(base_path('resources-site/js/Components/Blog/SearchInput.vue'));
    $this->assertFileExists(base_path('resources-site/js/Components/Blog/TagSelector.vue'));
});
