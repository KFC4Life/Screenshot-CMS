<head>
    <title>{{ $screenshot->name }}</title>

    <meta name="twitter:title" content="Screenshot" />
    <meta name="twitter:image" content="{{ url('/storage/screenshots/'.$screenshot->full_name) }}" />
    <meta name="twitter:card" content="photo" />
    <meta name="twitter:description" content="Screenshot" />
    <meta name="twitter:url" content="{{ env('APP_URL') }}" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
    @if(Auth::check())
        <a href="#info">
            <img src="{{ url('/storage/screenshots/'.$screenshot->full_name) }}" />
        </a>
        <div id="info" class="overlay">
            <a class="cancel" href="#"></a>
            <div class="modal">
                <h2>Screenshot Information</h2>
                <div class="content">

                    <ul>
                        <li>Uploaded: <b>{{ \Carbon\Carbon::createFromTimeString($screenshot->created_at)->diffForHumans() }}</b></li>
                    </ul>

                    <br />

                    <p>Click outside the modal to close.</p>
                </div>
            </div>
        </div>
    @else
        <img src="{{ url('/storage/screenshots/'.$screenshot->full_name) }}" />
    @endif
</body>