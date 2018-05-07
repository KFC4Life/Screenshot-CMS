<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background: #AFDCEB;
            margin: 0;
            font-weight: 100;
        }

        .content {
            padding-top: 250px;
            text-align: center;
        }

        .flex-center {
            align-items: center;
            justify-content: center;
        }

        .title {
            font-size: 84px;
        }

        .notice {
            background: #0275d8;
            color: #fff;
            text-align: center;
            display: block!important;
            padding: 1rem 1rem!important;
            position: sticky;
            top: 0;
            z-index: 1000;
            font-size: 16px;
            text-decoration: none;
            font-family: 'Raleway', sans-serif;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
            font-family: 'Raleway', sans-serif;
        }
    </style>
</head>
<body>
@auth
    <a href="{{ route('dashboard') }}" class="notice">
        You're logged in, click here to return back to the dashboard.
    </a>
@endauth
@guest
<div class="top-right links">
    <a href="{{ route('login') }}">Login</a>
</div>
@endguest

<div class="content flex-center position-ref full-height">
    <img src="{{ asset('logo.png') }}" height="300" />
    <div class="title">
        Screenshot CMS
    </div>
</div>
</html>
