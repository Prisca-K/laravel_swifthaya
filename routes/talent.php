<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\IndividualController;
use App\Http\Controllers\SwifthayajobController;
use App\Http\Controllers\Talent_ProfileController;
use Illuminate\Support\Facades\Route;

Route::get("/talents/{user}/dashboard", [Talent_ProfileController::class, "index"])->middleware(['auth', 'verified', "can:talent"])->name('talent.dashboard');

Route::get("/talents/{user_profile}/create-profile", [Talent_ProfileController::class, "create"])->middleware(['auth', 'verified', "can:talent"])->name('talent.create');

Route::post("/talents/{user_profile}/create", [Talent_ProfileController::class, "store"])->middleware(['auth', 'verified', "can:talent"])->name('talent.store');

Route::get("/talents/{user_profile}/profile", [Talent_ProfileController::class, "show"])->middleware(['auth', 'verified', "can:talent"])->name('talent.show');

Route::get("/talents/{talent_profile}/edit", [Talent_ProfileController::class, "edit"])->middleware(['auth', 'verified', "can:talent"])->name('talent.edit');

Route::patch("/talents/{talent_profile}/edit", [Talent_ProfileController::class, "update"])->middleware(['auth', 'verified', "can:talent"])->name('talent.update');

Route::delete("/talents/{talent_profile}", [Talent_ProfileController::class, "destroy"])->middleware(['auth', 'verified', "can:talent"])->name('talent.delete');

// candidate details
Route::get("/talent{talent_profile}/details", [Talent_ProfileController::class, "talent_details"])->middleware(['auth', 'verified', "can:individual_company"])->name('talent.details');

// offer candidate a job
Route::get("/talent{talent_profile}/offer-job", [SwifthayajobController::class, "offer_job"])->middleware(['auth', 'verified', "can:individual_company"])->name('job.offer_job');

Route::get("/find-talents", [IndividualController::class, "find_talents"])->middleware(['auth', 'verified', "can:individual_company"])->name('find_talents');

Route::get("/talent-search", [IndividualController::class, "talent_search"])->middleware(['auth', 'verified', "can:individual_company"])->name('talent_search');