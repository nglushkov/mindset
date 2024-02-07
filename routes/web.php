<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::controller(NoteController::class)->group(function () {
//     Route::get('/', 'index')->name('notes.index');
//     Route::get('/notes/create', 'create')->name('notes.create');
//     Route::get('/notes/show/{id}', 'show')->name('notes.show');
//     Route::get('/notes/edit{id}', 'edit')->name('notes.edit');
// });
Route::get('/', [NoteController::class, 'index']);
Route::resource('notes', NoteController::class);