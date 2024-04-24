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
            <header class="py-3">
                <div class="container p-0">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <a href="{{ route('notes.create') }}" class="btn btn-primary btn-sm">Create Note</a>
                            <a href="{{ route('notes.index') }}" class="btn btn-light btn-sm">Index</a>
                        </div>
                        <div class="col-md-4">
                            <form action="{{ route('notes.index') }}" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search" value="{{ request()->input('search') }}">
                                <button type="submit" class="btn btn-light btn-sm">Search</button>
                            </form>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('logout') }}" class="btn btn-light btn-sm">Logout</a>
                        </div>
                    </div>
                </div>
            </header>
            <div class="col-md-9">
                @yield('content')
            </div>
            <div class="col-md-3">
                <div class="list-group sticky-top">
                    <a href="{{ route('notes.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        All
                        <span class="badge bg-secondary rounded-pill">{{ $totalNotesCount }}</span>
                    </a>
                    <a href="{{ route('notes.index', ['tag_id' => -1]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ request()->input('tag_id') == -1 ? 'active' : '' }}">
                        Without Tags
                        <span class="badge bg-secondary rounded-pill">{{ $notesWithoutTagsCount }}</span>
                    </a>
                    @foreach($tags as $tag)
                        <a href="{{ route('notes.index', ['tag_id' => $tag->id]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ request()->input('tag_id') == $tag->id ? 'active' : '' }}">
                            {{ $tag->name }}
                            <span class="badge bg-secondary rounded-pill">{{ $tag->notes()->count() }}</span>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="col-md-12">
                    @yield('content')
                </div>
            @endif
        </div>
    </div>
</div>

<script src="/assets/js/bootstrap.min.js"></script>
</body>
</html>
