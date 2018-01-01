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
        <a href="#crawler-info">
            <img src="{{ url('/storage/screenshots/'.$screenshot->full_name) }}" />
        </a>
        <div id="crawler-info" class="overlay">
            <a class="cancel" href="#"></a>
            <div class="modal">
                <h2>Crawler Information</h2>
                <div class="content">

                    <table>
                        <thead>
                            <tr>
                                <th>Platform</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Slack</td>
                                <td><i class="fa fa-check"></i></td>
                            </tr>
                            <tr>
                                <td>Discord</td>
                                <td><i class="fa fa-times"></i></td>
                            </tr>
                            <tr>
                                <td>Skype</td>
                                <td><i class="fa fa-check"></i></td>
                            </tr>
                        </tbody>
                    </table>

                    <br />

                    <p>Click outside the modal to close.</p>
                </div>
            </div>
        </div>
    @else
        <img src="{{ url('/storage/screenshots/'.$screenshot->full_name) }}" />
    @endif
</body>