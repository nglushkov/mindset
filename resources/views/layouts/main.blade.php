<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="row">
        @if (!Auth::guest())
            <div class="col-12">
                <p>
                    <a href="{{ route('notes.index') }}">Mindset</a>
                    <a href="{{ route('notes.create') }}">Create</a>
                    <a href="{{ route('logout') }}">Logout</a>
                </p>
            </div>
        @endif
        <div class="col-12">
            @yield('content')
        </div>
    </div>
</div>

<script src="/assets/js/bootstrap.min.js"></script>
</body>
</html>
