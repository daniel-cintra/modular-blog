@extends('site-layout')

@section('content')
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">

            <article>

                <h2 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl mb-2">
                    {{ $post->title }}
                </h2>

                <p class="text-gray-500 mb-4">Published at: {{ $post->published_at->format('d/m/Y') }}</p>

                <div>
                    {!! $post->content !!}
                </div>

            </article>

        </div>
    </div>
@endsection
