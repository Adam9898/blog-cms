@extends('layouts.app')

{{-- todo passing the title of the blog from the $blog object seems to generate a strange bug, could be fixed later --}}
@section('title', 'Post')

@section('header')
    <meta name="author" content="{{ $blog->author }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div id="blog-post">
    <div id="blog-content-container">
        <h1>{{ $blog->title }}</h1>
        <p id="author-meta" class="post-meta">Written by: <i>{{ $blog->user->name }}</i></p>
        <p id="post-date-meta" class="post-meta">Posted at: <i>{{ date_format($blog->created_at, 'Y-m-d H:i') }}</i></p>
        <div> {!! $blog->content !!} </div>
    </div>
    <div id="comments">
        @foreach($blog->comments->reverse() as $comment)
            <div class="comment">
                @auth()
                    @if($comment->user->id === Auth::user()->id)
                        <form action="{{ route('comments.destroy', [$comment]) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" title="Delete comment">&#10006;</button>
                        </form>
                    @endif
                @endauth
                <p class="comment-username">{{ $comment->user->name }}</p>
                <p class="comment-content">{{ $comment->content }}</p>
                <img src="{{ asset('img/userimage-final.jpeg') }}">
            </div>
        @endforeach
        @auth()
            <template>
                <div class="comment">
                    <p class="comment-username">{{ Auth::user()->name }}</p>
                    <p class="comment-content"></p>
                    <img src="{{ asset('img/userimage-final.jpeg') }}">
                </div>
            </template>
        @endauth
    </div>
</div>
@auth()
    <form id="new-comment">
        <label for="comment-textarea">Comment:</label>
        <textarea required minlength="3" maxlength="500" name="content" id="comment-textarea"></textarea>
        <input type="hidden" name="blog" value="{{ $blog->id }}">
        @csrf
        <span class="sender-loading-animation"></span>
        <button class="btn-main" type="submit">Post</button>
    </form>
@endauth
@endsection
