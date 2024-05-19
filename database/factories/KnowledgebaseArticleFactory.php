<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KnowledgebaseArticle>
 */
class KnowledgebaseArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => fake()->randomElement([1,5]),
            'author_id' => fake()->randomElement([1,5]),
            'title' => fake()->paragraph(1),
            'slug' => fake()->slug(),
            'content' => fake()->paragraph(5),
            'is_published' => fake()->randomElement([0,1]),
        ];
    }
}
