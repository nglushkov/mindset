@extends('layouts.main')
@section('title', 'Mindset Note Create')

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
    <form action="{{ route('notes.store') }}" method="post">
        @csrf

        <div class="mb-3 row">
            <label for="title" class="fw-bold col-md-2">Title:</label>
            <div class="col-md-10">
                <input name="title" id="title" maxlength="255" class="form-control w-50">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="title" class="fw-bold col-md-2">Content:</label>
            <div class="col-md-10">
                <textarea rows=10 class="form-control" name="content"  id="content" required autofocus>{{ old('content') }}</textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="tagsSelect" class="form-label fw-bold col-md-2">Tags (Select):</label>
            <div class="col-md-6">
                <select class="form-select" id="tagsSelect" name="tags[]" multiple size="10">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="tagsInput" class="form-label fw-bold col-md-2">Tags Create:</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="tagsInput" name="tagsInput">
                <small class="form-text text-muted">Enter tags separated by commas</small>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
