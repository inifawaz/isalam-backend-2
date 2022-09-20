<?php

namespace Database\Factories;

use App\Models\Topic;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;

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
    public function definition()
    {
        try {
            $response = Http::timeout(60)->get('https://source.unsplash.com/600x600/?fruit');
            $featured_image_url = $response->handlerStats()['url'];
        } catch (Exception $e) {
            $featured_image_url = 'https://images.unsplash.com/photo-1600423115367-87ea7661688f?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=600&ixid=MnwxfDB8MXxyYW5kb218MHx8ZnJ1aXR8fHx8fHwxNjYyNzMyNDY5&ixlib=rb-1.2.1&q=80&utm_campaign=api-credit&utm_medium=referral&utm_source=unsplash_source&w=600';
        }
        return [
            "user_id" => fake()->randomElement(User::role('admin')->get()->pluck('id')),
            "topic_id" => fake()->randomElement(Topic::get()->pluck('id')),
            "featured_image_url" => $featured_image_url,
            "content" => "<h2>" . fake()->sentence(7) . "</h2>" . "<p>" . fake()->sentence(100) . "</p>"
        ];
    }
}
