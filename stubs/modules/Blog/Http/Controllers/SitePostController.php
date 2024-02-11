<?php

namespace Modules\Blog\Http\Controllers;

use Carbon\Carbon;
use Modules\Blog\Models\Post;
use Modules\Blog\Services\Site\GetArchiveOptions;
use Modules\Blog\Services\Site\GetTagOptions;
use Modules\Support\Http\Controllers\SiteController;
use Illuminate\View\View;

class SitePostController extends SiteController
{
    public function index(GetArchiveOptions $getArchiveOptions, GetTagOptions $getTagOptions): View
    {
        $posts = Post::with('tags')
            ->where('published_at', '<=', Carbon::now())
            ->latest()
            ->paginate(6);

        $archiveOptions = $getArchiveOptions->get();
        $tags = $getTagOptions->get();

        return view('blog::post-index', compact('posts', 'archiveOptions', 'tags'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();

        return view('blog::post-show', compact('post'));
    }
}
