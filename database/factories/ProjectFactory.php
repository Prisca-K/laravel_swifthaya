<?php

namespace Database\Factories;

use App\Models\Company_profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
    if ($this->faker->boolean) {
      // Poster is a company
      $company = User::where('user_type', 'company')->inRandomOrder()->first() ?: User::factory()->create(['user_type' => 'company']);
      $posterId = $company->id;
    } else {
      // Poster is an individual
      $individual = User::where('user_type', 'individual')->inRandomOrder()->first() ?: User::factory()->create(['user_type' => 'individual']);
      $posterId = $individual->id;
    }

    $skillsArray = fake()->randomElements(['PHP', 'Laravel', 'JavaScript', 'MySQL', 'HTML', 'CSS', 'React', 'Vue.js', 'Node.js', 'Express.js', 'MongoDB', 'Python', 'Bootstrap', 'SASS', 'UI', 'UX', 'Figma', 'Photshop', 'SEO', 'Tailwind'], 4);

    return [
      'poster_id' => $posterId,
      'title' => $this->faker->jobTitle,
      'description' => $this->faker->paragraph,
      'required_skills' => json_encode($skillsArray),
      'budget' => $this->faker->randomFloat(2, 1000, 10000),
      'duration' => $this->faker->numberBetween(1, 30), // Project duration in days
      'posted_at' => now(),
      'deadline_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
    ];
  }
}
