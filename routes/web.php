<?php

use App\Http\Controllers\Company_profileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndividualController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Talent_ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
})->name("welcome");

Route::get("/dashboard", [DashboardController::class, "index"])->middleware(['auth', 'verified'])->name('dashboard');


// individual

Route::get("/individual/{user}/dashboard", [IndividualController::class, "index"])->middleware(['auth', 'verified', "can:individual"])->name('individual.dashboard');

Route::get("/find-talents", [IndividualController::class, "find_talents"])->middleware(['auth', 'verified', "can:individual_company"])->name('find_talents');

Route::get("/talent-search", [IndividualController::class, "talent_search"])->middleware(['auth', 'verified', "can:individual_company"])->name('talent_search');

// Route::post("/", [UserController::class, "store"])->middleware(['guest'])->name('user.store');

Route::middleware('auth')->group(function () {
  Route::get('/profile/{profile}', [UserController::class, 'edit'])->name('profile.edit');

  Route::post('/profile/{profile}', [UserController::class, 'profile_img'])->name('profile.addimg');

  Route::patch('/profile/{profile}', [UserController::class, 'update'])->name('user.update');

  Route::delete('/profile', [UserController::class, 'destroy'])->name('profile.destroy');
});


// talents
require base_path('routes/talent.php');

// company
require base_path('routes/company.php');

// jobs
require base_path('routes/job.php');

// jobs
require base_path('routes/project.php');










require __DIR__ . '/auth.php';
