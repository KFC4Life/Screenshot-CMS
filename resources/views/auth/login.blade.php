<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Screenshot CMS') }}</title>

    <!-- Import Bootstrap CSS and FontAwesome -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha256-NuCn4IvuZXdBaFKJOAcsU2Q3ZpwbdFisd5dux4jkQ5w=" crossorigin="anonymous" />
    <style>
        :root {
            --input-padding-x: .75rem;
            --input-padding-y: .75rem;
        }

        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            max-width: 420px;
            padding: 15px;
            margin: auto;
        }

        .form-label-group {
            position: relative;
            margin-bottom: 1rem;
        }

        .form-label-group > input,
        .form-label-group > label {
            padding: var(--input-padding-y) var(--input-padding-x);
        }

        .form-label-group > label {
            position: absolute;
            top: 0;
            left: 0;
            display: block;
            width: 100%;
            margin-bottom: 0; /* Override default `<label>` margin */
            line-height: 1.5;
            color: #495057;
            border: 1px solid transparent;
            border-radius: .25rem;
            transition: all .1s ease-in-out;
        }

        .form-label-group input::-webkit-input-placeholder {
            color: transparent;
        }

        .form-label-group input:-ms-input-placeholder {
            color: transparent;
        }

        .form-label-group input::-ms-input-placeholder {
            color: transparent;
        }

        .form-label-group input::-moz-placeholder {
            color: transparent;
        }

        .form-label-group input::placeholder {
            color: transparent;
        }

        .form-label-group input:not(:placeholder-shown) {
            padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
            padding-bottom: calc(var(--input-padding-y) / 3);
        }

        .form-label-group input:not(:placeholder-shown) ~ label {
            padding-top: calc(var(--input-padding-y) / 3);
            padding-bottom: calc(var(--input-padding-y) / 3);
            font-size: 12px;
            color: #777;
        }

    </style>
</head>
<body>
    <form class="form-signin" action="{{ route('login') }}" method="POST" role="form">

        {{ csrf_field() }}

        <div class="text-center mb-4">
            <img class="mb-4" src="{{ asset('logo.png') }}" alt="" height="200">
            <h1 class="h3 mb-3 font-weight-normal">Screenshot CMS</h1>
            <p>Don't have an account yet? Ask your administrator to create one for you.</p>
        </div>

        <div class="form-label-group">
            <input name="email" type="email" value="{{ old('email') }}" class="form-control" placeholder="Email address" required autofocus>
            <label for="inputEmail">Email address</label>
            <div class="form-control-feedback">
                        <span class="text-danger align-middle">
                            @if ($errors->has('email'))
                                <i class="fa fa-close"></i> {{ $errors->first('email') }}
                            @endif
                        </span>
            </div>
        </div>

        <div class="form-label-group">
            <input name="password" type="password" class="form-control" placeholder="Password" required>
            <label for="inputPassword">Password</label>
            <div class="form-control-feedback">
                        <span class="text-danger align-middle">
                            @if ($errors->has('password'))
                                <i class="fa fa-close"></i> {{ $errors->first('password') }}
                            @endif
                        </span>
            </div>
        </div>

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted text-center">© Screenshot CMS {{ date("Y") }}</p>
    </form>
</body>
</html>