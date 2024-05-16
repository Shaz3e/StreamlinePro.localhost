<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task_label_id' => fake()->randomElement([1,11]),
            'assigned_to' => fake()->randomElement([1,6]),
            'title' => fake()->paragraph(1),
            'description' => fake()->paragraph(5),
            'created_by' => fake()->randomElement([1,6]),
            'due_date' => fake()->dateTimeBetween('now', '2 months'),
        ];
    }
}
