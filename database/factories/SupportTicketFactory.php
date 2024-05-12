<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SupportTicket>
 */
class SupportTicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ticket_number' => fake()->unique()->uuid(),
            'title' => fake()->paragraph(1),
            'message' => fake()->paragraph(5),
            'is_internal' => fake()->randomElement([0, 1]),
            'department_id' => fake()->numberBetween(1,4),
            'support_ticket_status_id' => fake()->numberBetween(1,12),
            'support_ticket_priority_id' => fake()->numberBetween(1,6),
            'user_id' => fake()->numberBetween(1,5),
            // 'admin_id' => fake()->numberBetween(1,5),
            'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
