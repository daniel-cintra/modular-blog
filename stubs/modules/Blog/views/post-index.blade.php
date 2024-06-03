@extends('site-layout')

@section('bodyEndScripts')
    @vite('resources-site/js/blog-app.js')
@endsection

@section('content')
    <blog-toolbar :archive-options="{{ json_encode($archiveOptions) }}" :tags="{{ json_encode($tags) }}">
    </blog-toolbar>

    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <!-- Section Title -->
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Blog</h2>

                <p class="mt-2 text-lg leading-8 text-gray-600">
                    @if (isset($fromArchive))
                        Posts from archive: <span class="font-semibold">{{ $fromArchive }}</span>
                    @elseif (isset($fromTag))
                        Posts tagged with: <span class="font-semibold">{{ $fromTag }}</span>
                    @elseif (isset($fromSearch))
                        Posts matching: <span class="font-semibold">{{ $fromSearch }}</span>
                    @else
                        Learn how to grow your business with our expert advice.
                    @endif
                </p>
            </div>

            @if ($posts->count())
                <!-- Posts -->
                <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">


                    @foreach ($posts as $post)
                        <article class="flex flex-col items-start justify-between">
                            <div class="relative w-full">
                                <a href="/blog/{{ $post->slug }}" class="block">
                                    @if ($post->image_url)
                                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}"
                                            class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                                    @else
                                        <div
                                            class="aspect-[16/9] w-full rounded-2xl  sm:aspect-[2/1] lg:aspect-[3/2] flex items-center justify-center bg-gradient-to-bl from-skin-neutral-1 to-skin-neutral-6">
                                            <span class="text-lg text-skin-neutral-9">N/A</span>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                                </a>
                            </div>
                            <div class="max-w-xl">
                                <div class="mt-8 flex items-center gap-2 text-xs">
                                    <div class="text-gray-600 italic flex items-center gap-1">

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="h-3 w-3">
                                            <path
                                                d="M17 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9V3H15V1H17V3ZM4 9V19H20V9H4ZM6 11H8V13H6V11ZM11 11H13V13H11V11ZM16 11H18V13H16V11Z">
                                            </path>
                                        </svg>
                                        {{ $post->published_at->format('F d, Y') }}
                                    </div>

                                    <div class="text-gray-600 italic flex items-center gap-1">
                                        @if ($post->author)
                                            @if ($post->author->image_url)
                                                <img src="{{ $post->author->image_url }}" alt="{{ $post->author->name }}"
                                                    class="h-4 w-4 rounded-md bg-gray-100 object-cover">
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" class="h-4 w-4">
                                                    <path
                                                        d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13Z">
                                                    </path>
                                                </svg>
                                            @endif
                                            {{ $post->author->name }}
                                        @endif
                                    </div>
                                </div>

                                <div class="group relative mb-2">
                                    <h3
                                        class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600 min-h-12 ">
                                        <a href="/blog/{{ $post->slug }}">
                                            <span class="absolute
                                        inset-0"></span>
                                            {{ $post->title }}
                                        </a>
                                    </h3>
                                    <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600">
                                        {{ Str::limit($post->content, 160) }}
                                    </p>
                                </div>

                                <div class="mt-4 min-h-[44px]"> <!-- Reserve space for tags -->
                                    @foreach ($post->tags as $tag)
                                        <a href="/blog/tag/{{ $tag->slug }}"
                                            class="inline-block rounded px-3 py-1.5 text-sm bg-gray-200 mr-2 hover:bg-gray-100">
                                            {{ $tag->name }}
                                        </a>
                                    @endforeach
                                </div>

                            </div>
                        </article>
                    @endforeach


                </div>
            @else
                <p class="text-gray-600 bg-skin-neutral-3 px-4 py-2 rounded mt-2">No posts found.</p>
            @endif

            <div class="mt-12">
                {{ $posts->links('pagination.tailwind') }}
            </div>
        </div>
    </div>
@endsection
