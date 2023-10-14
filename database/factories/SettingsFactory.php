<?php

namespace Database\Factories;

use App\Models\Settings;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Settings>
 */
class SettingsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "logo" => fake()->text,
            "phone_1" => fake()->phoneNumber,
            "phone_2" => fake()->phoneNumber,
            "category_products" => random_int(5, 20),
            "category_articles" => random_int(5, 20),
            "blog_articles" => random_int(5, 20),
            "home_products" => random_int(5, 20),
            "home_articles" => random_int(5, 20),
            "comments_status" => fake()->boolean,
            "seo_keywords" => fake()->text,
            "seo_description" => fake()->text,
        ];
    }
}
