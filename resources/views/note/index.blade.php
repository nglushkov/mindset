@extends('layouts.main')
@section('title', 'Notes')

@section('content')

@foreach($notes as $note)
    <div class="card mb-3">
        <div class="card-body pb-0">
            <p class="card-text">
                <a href="#" onclick="copyContent({{ $note->id }});return false;" class="btn btn-sm btn-light">📋 Copy</a>
{{--                <a href="{{ route('notes.show', $note->id) }}" class="btn btn-sm btn-light">Read</a>--}}
                <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-sm btn-light">✏️ Edit</a>
                <small class="text-muted fw-light">{{ $note->created_at }} <span class="badge bg-secondary">{{ $note->comments->count() ?: '' }}</span></small>
            </p>
            <div style="cursor: pointer;" onclick="window.location.href = '{{ route('notes.show', $note->id) }}'">
                <p><strong>{{ $note->title }}</strong></p>
                <p id="note-content-{{ $note->id }}">{!! nl2br(Str::limit($note->content, 100)) !!}</p>
            </div>
        </div>
    </div>
@endforeach

{{ $notes->links() }}
@include('blocks.copy-content')
@endsection
