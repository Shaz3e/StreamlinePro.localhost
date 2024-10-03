<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = Lead::getStatuses();
        $products = ['Product A', 'Product B', 'Product C', 'Product D', 'Product E'];
        $admins = Admin::pluck('id')->toArray();
        return [
            'name' => fake()->name(),
            'company' => fake()->company(),
            'country' => fake()->country(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'product' => fake()->randomElement($products),
            'message' => fake()->paragraph(3),
            'status' => fake()->randomElement($statuses),
            'created_by' => fake()->randomElement($admins),
            'assigned_to' => fake()->randomElement($admins),
            'assigned_by' => fake()->randomElement($admins),
        ];
    }
}
