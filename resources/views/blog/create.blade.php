@extends('layouts.app')

@section('title', 'Create a new blog')

@section('header')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')
    <div id="form-container">
        <h1>Create a new blog post</h1>
        <form method="POST" action="{{ route('blogs.create') }}">
            <label for="blog-title">Title</label>
            <input type="text" id="blog-title" required>
            <label for="blog-content">Content</label>
            <textarea type="text" id="blog-title" required></textarea>
        </form>
    </div>
@endsection
