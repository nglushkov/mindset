@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="mb-3">
            <div class="text-muted mb-3">{{ $note->created_at }}</div>
            <p>{!! nl2br($note->content) !!}</p>
            
            <form action="{{ route('notes.destroy', $note->id) }}" method="post" class="mt-3">
                <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-light">Edit</a>

                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-light" onclick="return confirmDelete()">Delete</button>
            </form>
        </div>

        @if ($note->comments->count() > 0)
            <p><u>Comments:</u></p>
            @foreach($note->comments as $comment)
                <p>{!! nl2br($comment->content) !!}</p>
            @endforeach
        @endif

    </div>

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this note?');
        }
    </script>
@endsection