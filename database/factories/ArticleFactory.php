<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(3, true),
            'source' => $this->faker->randomElement(['The Guardian', 'NYTimes', 'NewsAPI']),
            'published_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'url' => $this->faker->unique()->url,
            'category' => $this->faker->randomElement(['World', 'Technology', 'Sports', 'Health', 'Business']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
