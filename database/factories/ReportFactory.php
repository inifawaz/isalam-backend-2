<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "user_id" => fake()->randomElement(User::role('admin')->get()->pluck('id')),
            "project_id" => fake()->randomElement(Project::shown()->get()->pluck('id')),
            "content" => "<h2>" . fake()->sentence(7) . "</h2>" . "<p>" . fake()->sentence(100) . "</p>"
        ];
    }
}
