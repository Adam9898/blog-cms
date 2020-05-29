<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset("img/blogicon.jpeg") }}"/>
    <title>{{ config('app.name', 'Simple blog system') }}   @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('header')
</head>
<body>
    <header>
        <a href="{{ route('home') }}" id="logo">Simple blog system</a>
        @guest
            <span>
                <a id="login-anchor" class="link-button-main" href="{{ route('login')  }}">Login</a>
                <a id="register-anchor" class="link-button-main" href="{{ route('register')  }}">Register</a>
            </span>
        @endguest
        @auth
            <div id="header-end-container">
                <button id="notification-icon-container"><img src="{{ asset('img/notification.png')  }}"
                                                              alt="notifications">
                    <span class="button-badge">3</span>
                </button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    {{ csrf_field() }}
                    <button class="btn-main" type="submit">Logout</button>
                </form>
            </div>
            <div id="notification-container" hidden>
                @for($i = 0; $i < sizeof(Auth::user()->notifications) && $i < 10; $i++)
                    @php
                        Auth::user()->notifications[$i]->markAsRead;
                    @endphp
                    <div class="notification">
                        <a href="{{ Auth::user()->notifications[$i]->type }}">
                            <p id="notification-headline">{{ Auth::user()->notifications[$i] }}
                                &nbsp;blog post has been {{ Auth::user()->notifications[$i]->type }}</p>
                            <p id="notification-content"></p>
                        </a>
                    </div>
                @endfor
            </div>
        @endauth
    </header>
    <div id="content">
        @yield('content')
    </div>
    <footer>
        <span><i>A simple blog system with laravel backend</i></span>
    </footer>
</body>
</html>
