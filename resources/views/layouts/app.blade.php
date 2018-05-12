<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Siemen Rotensen, rotensen.s@gmail.com">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Screenshot CMS</title>

    @yield('css')

    <!-- Import Bootstrap CSS and FontAwesome -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha256-NuCn4IvuZXdBaFKJOAcsU2Q3ZpwbdFisd5dux4jkQ5w=" crossorigin="anonymous" />
    {!! Charts::assets() !!}
    @auth
        @if(Auth::user()->dark_theme_status)
            <style>
                body {
                    background: dimgray !important;
                    color: #fff !important;
                }
                .form-control {
                    background-color: dimgray !important;
                    color: #fff;
                    border: 1px solid dimgray;
                }
                .form-control:focus {
                    color: #fff;
                }
                ::placeholder {
                    color: #fff !important;
                    opacity: 0.7 !important;
                }
                .text-muted {
                    color: #aeaeae !important;
                }
            </style>
        @endif
    @endauth
</head>
<body style="background: #f4f4f4;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between mb-5">
        <a class="navbar-brand" href="{{ env('APP_URL') }}">
            <img src="{{ asset('logo.png') }}" height="30" class="d-inline-block align-top" alt="">
            Screenshot CMS
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                @auth
                    <li class="nav-item @if(Request::route()->getName() == 'dashboard') active @endif">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item @if(Request::route()->getName() == 'screenshots.all' || Request::route()->getName() == 'screenshots.mine') active @endif">
                        <a class="nav-link" href="{{ route('screenshots.mine') }}">Screenshots</a>
                    </li>
                    <li class="nav-item @if(Request::route()->getName() == 'settings' || Request::route()->getName() == 'settings.users') active @endif">
                        <a class="nav-link" href="{{ route('settings') }}">Settings</a>
                    </li>
                    @role('admin', 'web')
                    <li class="nav-item @if(Request::route()->getName() == 'logbook') active @endif">
                        <a class="nav-link" href="{{ route('logbook') }}">Logbook</a>
                    </li>
                    <li class="nav-item @if(Request::route()->getName() == 'statistics') active @endif">
                        <a class="nav-link" href="{{ route('statistics') }}">Statistics</a>
                    </li>
                    @endrole
                @endauth
            </ul>
            @auth
                <ul class="navbar-nav ml-auto">
                    <span class="navbar-text my-2 my-sm-0 mr-3">{{ auth()->user()->email }} ({{ auth()->user()->name }})</span>
                    <a href="{{ route('logout') }}" class="btn btn-primary my-2 my-sm-0" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                </ul>
            @endauth
        </div>
    </nav>

    <div class="container">

        @yield('content')

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">Screenshot CMS</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a target="_blank" href="https://github.com/siemen6/Screenshot-CMS">Source</a></li>
                <li class="list-inline-item"><a target="_blank" href="https://github.com/siemen6/Screenshot-CMS/issues/new">Support</a></li>
            </ul>
        </footer>
    </div>

    <!-- Import jQuery, Bootstrap.js and popper.js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</body>
</html>