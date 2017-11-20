<head>
    <title>{{ $screenshot->name }}</title>

    <meta name="twitter:title" content="Screenshot" />
    <meta name="twitter:image" content="{{ url('/storage/screenshots/'.$full_name) }}" />
    <meta name="twitter:card" content="photo" />
    <meta name="twitter:description" content="Screenshot" />
    <meta name="twitter:url" content="{{ env('APP_URL') }}" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <style>
        html {
            background: url(background.jpg) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        body {
            margin: 0;
        }

        img,video {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            max-width: 95%;
            max-height: 90%;
            box-shadow: 0px 0px 20px 1px #170000;
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
    <img src="{{ url('/storage/screenshots/'.$full_name) }}" />
</body>