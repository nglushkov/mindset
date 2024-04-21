@extends('layouts.main')

@section('content')
    <form action="{{ route('notes.store') }}" method="post">
        @csrf

        <div class="mb-3">
            <input name="title" maxlength="255" class="form-control w-50">
        </div>
        <div class="mb-3">
            <textarea rows=10 class="form-control" name="content" required autofocus>{{ old('content') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
