<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
/**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::select('id')->inRandomOrder()->value('id'),
            'title' => $this->faker->title,
            'body' => $this->faker->paragraph
        ];
    }
}
