@extends('layouts.app')

@section('title', 'Create a new blog')

@section('header')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')
    <div id="form-container">
        <h1>Create a new blog post</h1>
        <form id="edit-form" method="POST" action="{{ route('blogs.store') }}">
            <label for="blog-title">Title</label>
            <input type="text" id="blog-title" name="title" required>
            <label for="blog-content">Content</label>
            <div id="editor"></div>
            <input id="post-content" type="hidden" name="content">
            @csrf
            <button class="btn-main" type="submit">Create blog post</button>
        </form>
    </div>
@endsection
