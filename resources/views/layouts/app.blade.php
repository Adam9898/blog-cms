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
                <button id="notification-icon-container" class="openable"
                        onclick="app.notifications.onNotificationButtonPress()">
                    <img src="{{ asset('img/notification.png')  }}" alt="notifications">
                    @if(sizeof(Auth::user()->unreadNotifications) > 0)
                        <span class="button-badge">{{sizeof(Auth::user()->unreadNotifications)}}</span>
                    @endif
                </button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    {{ csrf_field() }}
                    <button class="btn-main" type="submit">Logout</button>
                </form>
            </div>
        @endauth
    </header>
    <div id="content">
        @auth()
            <div id="notification-relative-container">
                <div id="notification-container" class="hide-tag openable">
                    @for($i = 0; $i < sizeof(Auth::user()->notifications) && $i < 10; $i++)
                        <a class="notification @if(is_null(Auth::user()->notifications[$i]->read_at)) unread-notification @endif"
                           href="{{ Auth::user()->notifications[$i]->data['url'] }}">
                            <p class="notification-headline">A blog post has been
                                <b>{{ strtolower(substr(Auth::user()->notifications[$i]->type,
                                   strrpos(Auth::user()->notifications[$i]->type, 'Blog') + 4)) }}</b></p>
                            <p class="notification-content">Blog post title:
                                <b>{{ Auth::user()->notifications[$i]->data['blogTitle'] }}</b><br>
                            Blog post author: <b>{{ Auth::user()->notifications[$i]->data['blogAuthor']}}</b></p>
                        </a>
                    @endfor
                    <template>
                        <div class="notification">
                            <a href="">
                                <p class="notification-headline"></p>
                                <p class="notification-content"></p>
                            </a>
                        </div>
                    </template>
                </div>
            </div>
            @php
                for ($i = 0; $i < sizeof(Auth::user()->notifications) && $i < 10; $i++) {
                       Auth::user()->notifications[$i]->markAsRead();
                }
            @endphp
        @endauth
        @yield('content')
    </div>
    <footer>
        <span><i>A simple blog system with laravel backend</i></span>
    </footer>
    <!-- hidden data used by the application -->
    @auth()
        <div data-userid="{{ Auth::id() }}" hidden></div>
    @endauth
</body>
</html>
