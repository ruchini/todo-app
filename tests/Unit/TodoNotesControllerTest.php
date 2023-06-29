<?php
namespace Tests\Unit\Controllers;

use App\Http\Controllers\TodoNotesController;
use App\Models\TodoNotes;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class TodoNotesControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test index method of TodoNotesController.
     */
    public function testIndex()
    {
        // Create some dummy todo notes
        $todoNotes = TodoNotes::factory()->count(3)->create();

        // Call the index method
        $response = $this->getJson(route('todo.index'));

        // Assert the response
        $response->assertOk();
        $response->assertJson($todoNotes->toArray());
    }

    /**
     * Test store method of TodoNotesController with valid data.
     */
    public function testStoreWithValidData()
    {
        // Create a user
        $user = User::factory()->create();

        // Prepare request data
        $data = [
            'user_id' => $user->id,
            'title' => 'Test Note',
            'description' => 'This is a test note',
        ];

        // Call the store method
        $response = $this->postJson(route('todo.store'), $data);

        // Assert the response
        $response->assertCreated();
        $response->assertJson($data);
    }

    /**
     * Test store method of TodoNotesController with invalid data.
     */
    public function testStoreWithInvalidData()
    {
        // Prepare invalid request data
        $data = [
            'user_id' => 'invalid', // user_id should be an integer
            'title' => '', // title is required
            'description' => 'This is a test note',
        ];

        // Call the store method
        $response = $this->postJson(route('todo.store'), $data);

        // Assert the response
        $response->assertStatus(422); // Unprocessable Entity
    }

    /**
     * Test show method of TodoNotesController with existing todo note.
     */
    public function testShowWithExistingTodoNote()
    {
        // Create a dummy todo note
        $todoNote = TodoNotes::factory()->create();

        // Call the show method
        $response = $this->getJson(route('todo.show', $todoNote->id));

        // Assert the response
        $response->assertOk();
        $response->assertJson($todoNote->toArray());
    }

    /**
     * Test show method of TodoNotesController with non-existing todo note.
     */
    public function testShowWithNonExistingTodoNote()
    {
        // Call the show method with a non-existing todo note id
        $response = $this->getJson(route('todo.show', 999));

        // Assert the response
        $response->assertNotFound();
    }

    // Add more test cases for other methods as per your requirement
}
