<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\TodoNotes;

class TodoNotesTest extends TestCase
{
    /**
     * Test adding a new Todo note to the database.
     *
     * @return void
     */
    public function testAddTodoNote()
    {
        // Create a new TodoNote instance
        $todoNote = new TodoNotes();

        // Set the attributes of the TodoNote
        $todoNote->user_id = 2;
        $todoNote->title = 'Buy groceries';
        $todoNote->description = 'Milk, eggs, bread';
        $todoNote->archived = false;

        // Save the TodoNote to the database
        $todoNote->save();

        // Assert that the TodoNote was successfully saved
        $this->assertDatabaseHas('todo_notes', [
            'title' => 'Buy groceries',
            'description' => 'Milk, eggs, bread',
            'archived' => false,
        ]);
    }
}
