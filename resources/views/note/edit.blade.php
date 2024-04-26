@extends('layouts.main')
@section('title', $note->title ?? 'Mindset Note Edit')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger pb-0">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </ul>
        </div>
    @endif
    <form action="{{ route('notes.update', $note->id) }}" method="post">
        @csrf
        @method('PUT')

        <div class="mb-3 row">
            <label for="title" class="fw-bold col-md-2">Title:</label>
            <div class="col-md-10">
                <input name="title" id="title" maxlength="255" class="form-control w-50" value="{{ old('title', $note->title) }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="content" class="fw-bold col-md-2">Content:</label>
            <div class="col-md-10">
                <textarea rows=10 class="form-control" name="content"  id="content" required autofocus>{{ old('content', $note->content) }}</textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="tagsSelect" class="form-label fw-bold col-md-2">Tags (Select):</label>
            <div class="col-md-6">
                <select class="form-select" id="tagsSelect" name="tags[]" multiple size="10">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $note->tags->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="tagsInput" class="form-label fw-bold col-md-2">Tags Create:</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="tagsInput" name="tagsInput" value="{{ old('tagsInput') }}">
                <small class="form-text text-muted">Enter tags separated by commas</small>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <form action="{{ route('notes.destroy', $note->id) }}" method="post" class="mt-3">

            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-light" onclick="return confirmDelete()">🗑️ Delete</button>
        </form>
    </form>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this note?');
        }
    </script>
@endsection
