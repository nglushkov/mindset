@extends('layouts.main')
@section('title', 'Mindset Index')

@section('content')

@if(!$notes->count())
    <h3 class="text-muted">Notes is not found...</h3>
@endif
@foreach($notes as $note)
    <div class="card mb-2">
        <div class="card-body p-2">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="#" onclick="copyContent({{ $note->id }});return false;" class="btn btn-sm btn-light">📋</a>
                    <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-sm btn-light">✏️</a>
                    <strong style="cursor: pointer;" onclick="window.location.href = '{{ route('notes.show', $note->id) }}'">@if($note->is_title_by_ai) 🤖 @endif {{ Str::limit($note->title, 50) }}</strong>&nbsp;
                    @foreach($note->tags as $tag)
                        <a href="{{ route('notes.index', ['tag_id' => $tag->id]) }}">{{ $tag->name }}</a>
                    @endforeach
                </div>
                <div>
                    <small class="text-muted fw-light">{{ $note->created_at }} <span class="badge bg-secondary">{{ $note->comments->count() ?: '' }}</span></small>
                </div>
            </div>
            <div style="cursor: pointer;" onclick="window.location.href = '{{ route('notes.show', $note->id) }}'">
                <p></p>
                <div><pre class="m-0">@if($note->is_content_by_ai) 🤖 @endif<span id="note-content-{{ $note->id }}">{!! htmlspecialchars(Str::limit($note->content, 100)) !!}</span></pre></div>
            </div>
        </div>
    </div>
@endforeach

{{ $notes->links() }}
@include('blocks.copy-content')
@endsection
