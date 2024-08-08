<?php

use App\Http\Controllers\Talent_ProfileController;
use Illuminate\Support\Facades\Route;

Route::get("/talents/{user}/dashboard", [Talent_ProfileController::class, "index"])->middleware(['auth', 'verified', "can:talent"])->name('talent.dashboard');

Route::get("/talents/{user_profile}/create-profile", [Talent_ProfileController::class, "create"])->middleware(['auth', 'verified', "can:talent"])->name('talent.create');

Route::post("/talents/{user_profile}/create", [Talent_ProfileController::class, "store"])->middleware(['auth', 'verified', "can:talent"])->name('talent.store');

Route::get("/talents/{user_profile}/profile", [Talent_ProfileController::class, "show"])->middleware(['auth', 'verified', "can:talent"])->name('talent.show');

Route::get("/talents/{talent_profile}/edit", [Talent_ProfileController::class, "edit"])->middleware(['auth', 'verified', "can:talent"])->name('talent.edit');

Route::patch("/talents/{talent_profile}/edit", [Talent_ProfileController::class, "update"])->middleware(['auth', 'verified', "can:talent"])->name('talent.update');

Route::delete("/talents/{talent_profile}", [Talent_ProfileController::class, "destroy"])->middleware(['auth', 'verified', "can:talent"])->name('talent.delete');

// search routes
// job
Route::get("/find-jobs", [Talent_ProfileController::class, "find_jobs"])->middleware(['auth', 'verified', "can:talent"])->name('find_jobs');

Route::get("/job_search", [Talent_ProfileController::class, "job_search"])->middleware(['auth', 'verified', "can:talent"])->name('job_search');

// project
Route::get("/find-projects", [Talent_ProfileController::class, "find_projects"])->middleware(['auth', 'verified', "can:talent"])->name('find_projects');

Route::get("/project_search", [Talent_ProfileController::class, "project_search"])->middleware(['auth', 'verified', "can:talent"])->name('project_search');