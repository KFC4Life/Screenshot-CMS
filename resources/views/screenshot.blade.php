<head>
    <title>{{ $screenshot->name }}</title>

    <meta name="twitter:title" content="Screenshot" />
    <meta name="twitter:image" content="{{ url('/storage/screenshots/'.$screenshot->full_name) }}" />
    <meta name="twitter:card" content="photo" />
    <meta name="twitter:description" content="Screenshot" />
    <meta name="twitter:url" content="{{ env('APP_URL') }}" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <link href="{{ asset('style.css') }}" rel="stylesheet" type="text/css">
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
    <img src="{{ url('/storage/screenshots/'.$screenshot->full_name) }}" />
</body>