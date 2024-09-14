<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\User_profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company_profile>
 */
class Company_profileFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */


  public function definition()
  {
    // Find or create a user profile linked to a user with type 'company'
    $companyUser_profile = User_profile::whereHas('user', function ($query) {
      $query->where('user_type', 'company');
    })->inRandomOrder()->first();

    return [
      'user_profile_id' => User_profile::factory(),
      'company_name' => fake()->company,
      'industry' => fake()->word,
      'company_size' => fake()->numberBetween(1, 50),
      'founded_year' => fake()->year,
    ];
  }
}
