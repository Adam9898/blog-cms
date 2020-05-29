@extends('layouts.app')
@section('header')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')

    <div id="form-container">
        <form method="POST" action="{{ route('login') }}">
            <div>{{ __('Login') }}</div>
            @csrf
            <label for="email">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            @error('email')
            <span class="invalid-feedback error">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            @error('password')
                <span class="invalid-feedback error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <button type="submit" class="btn-main">
                {{ __('Login') }}
            </button>
        </form>
    </div>

@endsection
