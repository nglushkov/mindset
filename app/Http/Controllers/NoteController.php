<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Note;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Note::orderByDesc('created_at')->with(['comments', 'tags']);
        $tagId = $request->input('tag_id');
        $search = $request->input('search');

        if (!empty($tagId)) {
            if ($tagId != -1) {
                $query->whereHas('tags', function ($query) use ($tagId) {
                    $query->where('tags.id', $tagId);
                });
            } else {
                // Выбрать модели без тегов
                $query->whereDoesntHave('tags');
            }
        }

        if (!empty($search)) {
            $search = '%' . $search . '%';
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', $search)
                    ->orWhere('content', 'like', $search)
                    ->orWhereHas('tags', function ($query) use ($search) {
                        $query->where('name', 'like', $search);
                    });
            });
        }

        $notes = $query->paginate(100);

        return view('note.index', [
            'notes' => $notes
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('note.create', [
            'tags' => Tag::orderBy('name')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNoteRequest $request)
    {
        // Begin a database transaction
        DB::beginTransaction();

        try {
            $selectedTagIds = $request->input('tags', []);
            $tagNames = $request->input('tagsInput', '');
            $selectedTags = Tag::whereIn('id', $selectedTagIds)->get();
            $selectedTagNames = $selectedTags->pluck('name')->toArray();

            // Split the tags input string into an array and remove leading and trailing spaces
            $tagNames = explode(',', $tagNames);
            $tagNames = array_map('trim', $tagNames);

            // Remove empty tags
            $tagNames = array_filter($tagNames);

            // Merge the selected tags and input tags to get all tags to be associated with the note
            $allTags = array_merge($selectedTagNames, $tagNames);

            // Create a new note
            $note = new Note;
            $note->fill($request->validated());
            $note->user_id = auth()->id();
            $note->save();

            // Associate tags with the note
            foreach ($allTags as $tagName) {
                // Find the tag by name or create a new one if it doesn't exist
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                // Attach the tag to the note
                $note->tags()->attach($tag);
            }

            DB::commit();

            return redirect()->route('notes.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        return view('note.show', ['note' => $note]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        return view('note.edit', ['note' => $note]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNoteRequest $request, Note $note)
    {
        DB::beginTransaction();

        try {
            $selectedTagIds = $request->input('tags', []);
            $tagNames = $request->input('tagsInput', '');
            $selectedTags = Tag::whereIn('id', $selectedTagIds)->get();
            $selectedTagNames = $selectedTags->pluck('name')->toArray();

            $tagNames = explode(',', $tagNames);
            $tagNames = array_map('trim', $tagNames);

            $tagNames = array_filter($tagNames);

            $allTags = array_merge($selectedTagNames, $tagNames);

            $note->fill($request->validated());
            $note->save();

            $tagsToAttach = [];
            foreach ($allTags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagsToAttach[] = $tag->id;
            }
            $note->tags()->sync($tagsToAttach);

            DB::commit();

            return redirect()->route('notes.show', ['note' => $note->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        DB::beginTransaction();

        try {
            $note->comments()->delete();
            $note->tags()->detach();
            $note->delete();
            DB::commit();

            return redirect()->route('notes.index');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage());
        }
    }

}
