<?php

namespace Database\Factories;

use App\Models\TodoNotes;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoNotesFactory extends Factory
{
    protected $model = TodoNotes::class;

    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'archived' => $this->faker->boolean,
        ];
    }
}
