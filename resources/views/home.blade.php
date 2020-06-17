@extends('layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
    <h1>Posts</h1>
    <div id="posts">
        @foreach($posts as $blog)
            <div class="post">
                <a href="{{ route('blogs.show', [$blog->id]) }}" class="post-title">{{ $blog->title }}</a>
                <p class="post-author">{{ $blog->user->name }}</p>
                @auth()
                    @can('update', $blog)
                        <a href="{{ route('blogs.edit', [$blog->id]) }}"><img src="{{ asset('img/settings.png') }}"></a>
                    @endcan
                @endauth
            </div>
        @endforeach
    </div>
    {{ $posts->links() }}
@endsection
