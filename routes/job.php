<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\SwifthayajobController;
use App\Http\Controllers\Talent_ProfileController;
use Illuminate\Support\Facades\Route;



Route::get("/jobs/{user}", [SwifthayajobController::class, "index"])->middleware(['auth', 'verified', 'can:company'])->name('jobs');

Route::get("/jobs/{user}/create-job", [SwifthayajobController::class, "create"])->middleware(['auth', 'verified', 'can:company'])->name('job.create');

Route::post("/jobs/{user}/create-job", [SwifthayajobController::class, "store"])->middleware(['auth', 'verified', 'can:company'])->name('job.store');

Route::get("/jobs/job/{job}", [SwifthayajobController::class, "show"])->middleware(['auth', 'verified', 'can:company'])->name('job.show');

Route::get("/jobs/{job}/edit", [SwifthayajobController::class, "edit"])->middleware(['auth', 'verified', 'can:company'])->name('job.edit');

Route::patch("/jobs/{job}/edit", [SwifthayajobController::class, "update"])->middleware(['auth', 'verified', 'can:company'])->name('job.update');

Route::delete("/jobs/{job}", [SwifthayajobController::class, "destroy"])->middleware(['auth', 'verified', 'can:company'])->name('job.destroy');

Route::get("/job{job}/details", [SwifthayajobController::class, "job_details"])->middleware(['auth', 'verified', "can:talent"])->name('job.details');

// search routes
// job

Route::get("/job_search", [Talent_ProfileController::class, "job_search"])->middleware(['auth', 'verified', "can:talent"])->name('job_search');

/* applicants tracking */
// job
Route::get("job{job}/applicants", [SwifthayajobController::class, "view_job_applicants"])->middleware(['auth', 'verified', "can:individual_company"])->name('job.applicants');

//application

Route::get("job{job}/{user}/apply", [ApplicationController::class, "job_apply"])->middleware(['auth', 'verified', "can:talent"])->name('talent.job.apply');

Route::post("job{job}/{user}/apply", [ApplicationController::class, "job_store_application"])->middleware(['auth', 'verified', "can:talent"])->name('talent.job.apply.store');

Route::get("job/{user}/application-history", [ApplicationController::class, "job_application_history"])->middleware(['auth', 'verified', "can:talent"])->name('talent.job.apply.history');