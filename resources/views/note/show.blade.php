@extends('layouts.main')
@section('title', $note->title ? 'Mindset ' . $note->title : 'Mindset Note Show')

@section('content')
    <div class="mb-3">
        @if ($note->title)
        <h4>{{ $note->title }}</h4>
        @endif
        <p>
            <a href="#" onclick="copyContent({{ $note->id }});return false;" class="btn btn-sm btn-light">📋 Copy</a>
            @foreach($note->tags as $tag)
                <a href="{{ route('notes.index', ['tag_id' => $tag->id]) }}">{{ $tag->name }}</a>
            @endforeach
            <span class="text-muted mb-3 fw-light small">{{ $note->created_at }}</span>
        </p>

        <div class="card">
            <div class="card-body" id="note-content-{{ $note->id }}">
                <pre class="mb-0">{!! nl2br(htmlspecialchars($note->content)) !!}</pre>
            </div>
        </div>

        <form action="{{ route('notes.destroy', $note->id) }}" method="post" class="mt-3">
            <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-light btn-sm">✏️ Edit</a>

            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-light btn-sm" onclick="return confirmDelete()">🗑️ Delete</button>
        </form>
    </div>

    @if ($note->comments->count() > 0)
        <p><u>Comments:</u></p>
        @foreach($note->comments as $comment)
            <p>{!! nl2br($comment->content) !!}</p>
        @endforeach
    @endif


    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this note?');
        }
    </script>
    @include('blocks.copy-content')

@endsection
