@extends('layouts.app')

@section('title', 'Create a new blog')

@section('header')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')
    <div id="form-container">
        <h3>Editing {{ $blog->title }}</h3>
        <form id="edit-form" method="POST" action="{{ route('blogs.update', [$blog]) }}">
            @method('PUT')
            <p class="validation-error hide-tag" id="blog-title-error"></p>
            <label for="blog-title">Title</label>
            <input type="text" id="blog-title" name="title" value="{{ $blog->title }}" required>
            <label for="blog-content">Content</label>
            <div id="editor"></div>
            <input id="post-content" type="hidden" name="content" value="{{ $blog->content }}">
            @csrf
        </form>
        <div id="update-button-container">
            <button form="edit-form" class="btn-main" type="submit"><b>UPDATE</b> blog post</button>
            <button form="delete-blog-form" class="btn-main" type="submit">delete blog post</button>
        </div>
    </div>
    <form id="delete-blog-form" method="POST" action="{{ route('blogs.destroy', [$blog]) }}">
        @method('DELETE')
        @csrf
    </form>
@endsection
