<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Screenshot CMS') }}</title>

    <!-- CSS & JS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha256-NuCn4IvuZXdBaFKJOAcsU2Q3ZpwbdFisd5dux4jkQ5w=" crossorigin="anonymous" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between mb-5">
        <a class="navbar-brand" href="#">{{ env('APP_NAME') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav ml-auto">

                <!-- TODO: When logged in show navbar items -->
                @auth
                <span class="navbar-text my-2 my-sm-0 mr-3">{{ auth()->user()->email }}</span>
                <a href="{{ route('logout') }}" class="btn btn-primary my-2 my-sm-0" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                @endauth
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            @if(Request::route()->getName() == 'dashboard' || Request::route()->getName() == 'screenshots.overview' || Request::route()->getName() == 'screenshots.recent')
            <div class="col-12 col-md-3 col-lg-3">
                <nav class="nav nav-pills flex-column">
                    <a class="flex-sm-fill nav-link @if(Request::route()->getName() == 'dashboard') active @endif" href="{{ route('dashboard') }}">
                        <i class="fa fa-dashboard fa-fw"></i> Dashboard
                    </a>
                    <a class="flex-sm-fill nav-link @if(Request::route()->getName() == 'screenshots.recent' || Request::route()->getName() == 'screenshots.overview') active @endif" href="{{ route('screenshots.recent') }}">
                        <i class="fa fa-image fa-fw"></i> Screenshots
                    </a>
                </nav>
            </div>

            <div class="col-12 col-md-9 col-lg-9">
                    @yield('content')
            </div>
            @else
                <div class="col-12 col-md-12 col-lg-12">
                    @yield('content')
                </div>
            @endif
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</body>
</html>
