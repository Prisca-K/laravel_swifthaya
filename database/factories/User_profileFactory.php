<?php

namespace Database\Factories;

use App\Models\Company_profile;
use App\Models\Talent_profile;
use App\Models\User;
use App\Models\User_profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User_profile>
 */
class User_profileFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'user_id' => User::factory(),
      'first_name' => fake()->firstName,
      'last_name' => fake()->lastName,
      'location' => $this->faker->randomElement(['nigeria', 'ghana', 'germany', 'us', 'india', 'mexico', 'south africa']),
      'bio' => fake()->paragraph,
      'website' => fake()->url,
      'phone_number' => fake()->randomNumber(7, true),
    ];
  }
  public function configure()
  {
    return $this->afterCreating(function (User_profile $user_profile) {
      // Automatically create a companyProfile for the company
     if ($user_profile->user->user_type === "company") {
      Company_profile::factory()->create([
        'user_profile_id' => $user_profile->id,
      ]);
     }
     if ($user_profile->user->user_type === "talent") {
      Talent_profile::factory()->create([
        'user_profile_id' => $user_profile->id,
      ]);
     }
    });
  }
}
