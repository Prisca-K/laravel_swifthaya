<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\User_profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Talent_profile>
 */
class Talent_profileFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    // Find or create a user profile linked to a user with type 'talent'
    
    $skillsArray = fake()->randomElements(['PHP', 'Laravel', 'JavaScript', 'MySQL', 'HTML', 'CSS', 'React', 'Vue.js', 'Node.js', 'Express.js', 'MongoDB', 'Python', 'Bootstrap', 'SASS', 'UI', 'UX', 'Figma', 'Photshop', 'SEO', 'Tailwind'], 4);
    $experienceArray = [
      [
        'company' => fake()->company,
        'role' => fake()->jobTitle,
        'duration' => fake()->numberBetween(1, 5),
      ],
      [
        'company' => fake()->company,
        'role' => fake()->jobTitle,
        'duration' => fake()->numberBetween(1, 5),
      ]
    ];

    // Generate an array of education objects
    $educationArray = [
      [
        'degree' => fake()->word,
        'institution' => fake()->company,
        'year' => fake()->year,
      ],
      [
        'degree' => fake()->word,
        'institution' => fake()->company,
        'year' => fake()->year,
      ]
    ];

    // Generate an array of portfolio objects
    $portfolioArray = [
      [
        'title' => fake()->sentence,
        'description' => fake()->paragraph,
        'url' => fake()->url,
      ],
      [
        'title' => fake()->sentence,
        'description' => fake()->paragraph,
        'url' => fake()->url,
      ]
    ];
    return [
      'user_profile_id' => User_profile::factory(),
      'skills' => json_encode($skillsArray),
      'experience' =>  json_encode($experienceArray),
      'education' =>  json_encode($educationArray),
      'portfolio' => json_encode($portfolioArray)
    ];
  }
}
