<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\TryCatch;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
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

        $name = fake()->sentence(10);
        $description = "<h2>" . fake()->sentence(10) . "</h2>" . "<p>" . fake()->sentence(200) . "</p>";

        $is_target = fake()->randomElement([true, true, true, true, true, true, true, true, true,  false]);
        if ($is_target) {
            $target_amount = fake()->randomElement([2500000, 3000000, 3500000, 4000000, 4500000, 5000000, 15000000, 20000000, 25000000]);
            $first_choice_given_amount = 20000;
            $second_choice_given_amount = 50000;
            $third_choice_given_amount = 100000;
            $fourth_choice_given_amount = 150000;
        } else {
            $target_amount = 0;
            $first_choice_given_amount = 0;
            $second_choice_given_amount = 0;
            $third_choice_given_amount = 0;
            $fourth_choice_given_amount = 0;
        }

        $is_limited_time = fake()->randomElement([true, true, true, true, true, true, true, true, true,  false]);
        if ($is_limited_time) {
            $number_of_days = fake()->randomElement([15, 20, 30, 35, 40, 45, 50, 55, 60]);
            $start_date = now()->format('Y-m-d');
            $end_date = now()->addDays($number_of_days)->format('Y-m-d');
        } else {
            $start_date = null;
            $end_date = null;
        }

        return [
            "user_id" => fake()->randomElement(User::role('admin')->get()->pluck('id')),
            "featured_image_url" => $featured_image_url,
            "name" => $name,
            "category_id" => fake()->randomElement(Category::all()->pluck('id')),
            "description" => $description,
            "location" => fake()->city(),
            "instagram_url" => '',
            "facebook_url" => '',
            "twitter_url" => '',
            "maintenance_fee" => 5000,
            "is_target" => $is_target,
            "target_amount" => $target_amount,
            "first_choice_given_amount" => $first_choice_given_amount,
            "second_choice_given_amount" => $second_choice_given_amount,
            "third_choice_given_amount" => $third_choice_given_amount,
            "fourth_choice_given_amount" => $fourth_choice_given_amount,
            "is_limited_time" => $is_limited_time,
            "start_date" => $start_date,
            "end_date" => $end_date,
            "is_shown" => fake()->randomElement([true, true, true, true, true, true, true, true, true,  false]),
            "is_ended" => fake()->randomElement([true, true, true, true, true, true, true, true, true,  false]),
        ];
    }
}
