@extends('layouts.main')

@section('content')
    <div class="text-muted mb-3 fw-light">{{ $note->created_at }}</div>

    <form action="{{ route('notes.update', $note->id) }}" method="post">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <input name="title" maxlength="255" class="form-control w-50" value="{{ $note->title }}">
        </div>

        <div class="mb-3">
            <textarea rows=10 class="form-control" name="content" required>{{ old('content', $note->content) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
