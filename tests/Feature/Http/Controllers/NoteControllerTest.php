<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Note;

class NoteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index(): void
    {
        $response = $this->get(route('notes.index'));

        $response->assertStatus(200);
    }

    public function test_create(): void
    {
        $response = $this->get(route('notes.create'));

        $response->assertStatus(200);
    }

    public function test_store(): void
    {
        $count = Note::get()->count();
        
        $response = $this->post(route('notes.store'), [
            'title' => fake()->text(50),
            'content' => fake()->text(400),
        ]);
        $this->assertCount($count + 1, Note::get());

        $response->assertStatus(200);
    }

    public function test_show(): void
    {
        $response = $this->get(route('notes.show', ['note' => 1]));

        $response->assertStatus(200);
    }

    public function test_edit(): void
    {
        $response = $this->get(route('notes.edit', ['note' => 2]));

        $response->assertStatus(200);
    }

    public function test_destroy(): void
    {
        $count = Note::get()->count();

        $response = $this->delete(route('notes.destroy', ['note' => 1]));

        $this->assertCount($count - 1, Note::get());

        $response->assertStatus(200);
    }
}
