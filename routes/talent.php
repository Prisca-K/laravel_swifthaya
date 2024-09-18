<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\IndividualController;
use App\Http\Controllers\SwifthayajobController;
use App\Http\Controllers\Talent_ProfileController;
use Illuminate\Support\Facades\Route;

Route::get("/talents/dashboard", [Talent_ProfileController::class, "index"])->middleware(['auth', 'verified', "can:talent"])->name('talent.dashboard');

Route::get("talents/job-application-history", [ApplicationController::class, "job_application_history"])->middleware(['auth', 'verified', "can:talent"])->name('job.application_history');

Route::get("/talent-profiles", [Talent_ProfileController::class, "create"])->middleware(['auth', 'verified', "can:talent"])->name('talent.create');

Route::post("/talent-profiles", [Talent_ProfileController::class, "store"])->middleware(['auth', 'verified', "can:talent"])->name('talent.store');

Route::get("/talent-profiles/view", [Talent_ProfileController::class, "show"])->middleware(['auth', 'verified', "can:talent"])->name('talent.show');

Route::get("/talent-profiles/{talent_profile}", [Talent_ProfileController::class, "edit"])->middleware(['auth', 'verified', "can:talent"])->name('talent.edit');

Route::patch("/talent-profiles/{talent_profile}", [Talent_ProfileController::class, "update"])->middleware(['auth', 'verified', "can:talent"])->name('talent.update');

// Route::delete("/talent-profiles/{talent_profile}", [Talent_ProfileController::class, "destroy"])->middleware(['auth', 'verified', "can:talent"])->name('talent.delete');

// candidate details
// check upwork profiles
Route::get("/talent-profiles/{talent_profile}/details", [Talent_ProfileController::class, "talent_details"])->middleware(['auth', 'verified', "can:individual_company"])->name('talent.details');

Route::get("talents/project-application-history", [ApplicationController::class, "project_application_history"])->middleware(['auth', 'verified', "can:talent"])->name('project.application_history');


Route::get("/talent-search", [IndividualController::class, "talent_search"])->middleware(['auth', 'verified', "can:individual_company"])->name('talent_search');
