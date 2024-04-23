<?php

namespace App\Providers;

use App\Models\Note;
use App\Models\Tag;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $tags = Tag::orderBy('name')->get();
        view()->share('tags', $tags);

        $notesWithoutTagsCount = Note::doesntHave('tags')->count();
        view()->share('notesWithoutTagsCount', $notesWithoutTagsCount);

        $totalNotesCount = Note::count();
        view()->share('totalNotesCount', $totalNotesCount);

        Paginator::useBootstrapFive();
    }
}
