@extends('layouts.main')

@section('content')
    <div class="text-muted mb-3 fw-light">{{ $note->created_at }}</div>

    <form action="{{ route('notes.update', $note->id) }}" method="post">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="content" class="form-label">Content:</label>
            <textarea rows=10 class="form-control" name="content" required>{{ old('content', $note->content) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection