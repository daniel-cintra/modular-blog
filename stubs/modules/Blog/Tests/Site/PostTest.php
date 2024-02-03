<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Modules\Blog\Models\Post;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->post = Post::factory()->create();
});

afterEach(function () {
    if ($this->post->image) {
        Storage::disk('public')->delete('blog/'.$this->post->image);
    }
});

test('blog index page can be rendered', function () {
    $response = $this->get('/blog');

    $response->assertStatus(200);
});
