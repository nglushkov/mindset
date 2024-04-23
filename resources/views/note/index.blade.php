@extends('layouts.main')
@section('title', 'Mindset Index')

@section('content')

@foreach($notes as $note)
    <div class="card mb-3">
        <div class="card-body pb-0">
            <div class="card-text mb-2">
                <a href="#" onclick="copyContent({{ $note->id }});return false;" class="btn btn-sm btn-light">📋</a>
                <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-sm btn-light">✏️</a>
                @foreach($note->tags as $tag)
                    <a href="{{ route('notes.index', ['tag_id' => $tag->id]) }}">{{ $tag->name }}</a>
                @endforeach
                <small class="text-muted fw-light text-end">{{ $note->created_at }} <span class="badge bg-secondary">{{ $note->comments->count() ?: '' }}</span></small>
            </div>
            <div style="cursor: pointer;" onclick="window.location.href = '{{ route('notes.show', $note->id) }}'">
                <p><strong>{{ $note->title }}</strong></p>
                <div id="note-content-{{ $note->id }}"><pre><a href="{{ route('notes.show', $note->id) }}" class="btn btn-sm btn-light">></a> {!! nl2br(Str::limit($note->content, 100)) !!}</pre></div>
            </div>
        </div>
    </div>
@endforeach

{{ $notes->links() }}
@include('blocks.copy-content')
@endsection
