@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/register.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div id="form-container">
        <form method="POST" action="{{ route('register') }}">
            <div>{{ __('Register') }}</div>
            @csrf
            <label for="name">{{ __('Name') }}</label>
            <input id="name" type="text" class="@error('name') is-invalid @enderror"
                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
            @error('name')
                <span class="invalid-feedback error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <label for="email">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email"
                   value="{{ old('email') }}" required autocomplete="email">

            @error('email')
                <span class="invalid-feedback error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <label for="password">{{ __('Password') }}</label>
            <input id="password" type="password" class="@error('password') is-invalid @enderror"
                   name="password" required autocomplete="new-password">

            @error('password')
                <span class="invalid-feedback error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <label for="password-confirm">{{ __('Confirm Password') }}</label>
            <input id="password-confirm" type="password" class="form-control"
                   name="password_confirmation" required autocomplete="new-password">
            <button type="submit" class="btn-main">
                {{ __('Register') }}
            </button>
        </form>
    </div>
@endsection
