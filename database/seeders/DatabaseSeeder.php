<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    User::factory(2)->create(['user_type' => 'admin']);
    User::factory(9)->create(['user_type' => 'individual']);
    User::factory(9)->create(['user_type' => 'company']);
    User::factory(40)->create(['user_type' => 'talent']);

    // Create company profiles
    // \App\Models\Company_profile::factory(10)->create();

    // Create talent profiles
    // \App\Models\Talent_profile::factory(20)->create();

    // Create jobs
    \App\Models\SwifthayaJob::factory(50)->create();

    // Create projects
    \App\Models\Project::factory(40)->create();
  }
}
