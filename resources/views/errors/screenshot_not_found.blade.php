<head>
    <title>404</title>

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
<div class="title">
    Screenshot not found
</div>
</body>