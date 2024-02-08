@extends('layouts.main')

@section('content')
    <form action="{{ route('notes.store') }}" method="post">
        @csrf

        <div class="mb-3">
            <label for="content" class="form-label">Content:</label>
            <textarea rows=10 class="form-control" name="content" required>{{ old('content') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection