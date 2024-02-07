@extends('layouts.main')
@section('title', 'Notes')

@section('content')

@foreach($notes as $note)
    <div class="card mb-3">
        <div class="card-body">
            <p class="card-title"><small class="text-muted">{{ $note->created_at }} <span class="badge bg-secondary">{{ $note->comments->count() ?: '' }}</span></small></p>
            <p class="card-text"><a href="{{ route('notes.show', $note->id) }}" class="btn btn-sm btn-light">Read</a> {{ Str::limit($note->content, 100) }}</p>
        </div>
    </div>
@endforeach

{{ $notes->links() }}

@endsection
