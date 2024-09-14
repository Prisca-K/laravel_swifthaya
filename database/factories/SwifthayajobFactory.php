<?php

namespace Database\Factories;

use App\Models\Company_profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Swifthayajob>
 */
class SwifthayajobFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {

    $user = User::where('user_type', 'company')->inRandomOrder()->first();

    $skillsArray = fake()->randomElements(['PHP', 'Laravel', 'JavaScript', 'MySQL', 'HTML', 'CSS', 'React', 'Vue.js', 'Node.js', 'Express.js', 'MongoDB', 'Python', 'Bootstrap', 'SASS', 'UI', 'UX', 'Figma', 'Photshop', 'SEO', 'Tailwind'], 4);
    return [
      'company_id' => $user,
      'title' => $this->faker->jobTitle,
      'description' => $this->faker->paragraph,
      'required_skills' => json_encode($skillsArray),
      'location' => $this->faker->randomElement(['nigeria', 'ghana', 'germany', 'us', 'india', 'mexico', 'south africa']),
      'salary_range' => $this->faker->randomElement(['10-50', '50-100', '100-500', "500_plus"]),
      'job_type' => $this->faker->randomElement(['full-time', 'part-time', 'contract']),
      'posted_at' => now(),
      'deadline_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
    ];
  }
}
