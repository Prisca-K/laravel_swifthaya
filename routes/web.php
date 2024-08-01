<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
})->name("welcome");

Route::get("/dashboard", [DashboardController::class, "index"])->middleware(['auth', 'verified'])->name('dashboard');

Route::get("/dashboard/talent{user_profile}", [DashboardController::class, "talent"])->middleware(['auth', 'verified'])->name('talent.dashboard');

Route::get("/dashboard/company{user_profile}", [DashboardController::class, "company"])->middleware(['auth', 'verified'])->name('company.dashboard');

Route::get("/dashboard/individual{user_profile}", [DashboardController::class, "individual"])->middleware(['auth', 'verified'])->name('individual.dashboard');

Route::post("/", [UserController::class, "store"])->middleware(['guest'])->name('user.store');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
