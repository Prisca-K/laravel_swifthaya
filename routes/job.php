<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\SwifthayajobController;
use App\Http\Controllers\Talent_ProfileController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;



Route::get("/all-jobs", [SwifthayajobController::class, "index"])->middleware(['auth', 'verified', 'can:company'])->name('jobs');

Route::get("/jobs", [SwifthayajobController::class, "create"])->middleware(['auth', 'verified', 'can:company'])->name('job.create');

Route::post("/jobs", [SwifthayajobController::class, "store"])->middleware(['auth', 'verified', 'can:company'])->name('job.store');

Route::get("/jobs/{job}", [SwifthayajobController::class, "show"])->middleware(['auth', 'verified', 'can:company'])->name('job.show');

Route::get("/jobs/{job}/edit", [SwifthayajobController::class, "edit"])->middleware(['auth', 'verified', 'can:company'])->name('job.edit');

Route::patch("/jobs/{job}/edit", [SwifthayajobController::class, "update"])->middleware(['auth', 'verified', 'can:company'])->name('job.update');

Route::delete("/jobs/{job}", [SwifthayajobController::class, "destroy"])->middleware(['auth', 'verified', 'can:company'])->name('job.destroy');

// similar talent details
Route::get("/job-{job}/details", [SwifthayajobController::class, "job_details"])->middleware(['auth', 'verified', "can:talent"])->name('job.details');


// offer candidate a job
Route::get("/offer-job/{talent_profile}", [SwifthayajobController::class, "offer_job"])->middleware(['auth', 'verified', "can:individual_company"])->name('job.offer_job');
// search routes
// job

Route::get("/job_search", [Talent_ProfileController::class, "job_search"])->middleware(['auth', 'verified', "can:talent"])->name('job_search');

/* applicants tracking */
// job
Route::get("job/{job}/applicants", [SwifthayajobController::class, "view_job_applicants"])->middleware(['auth', 'verified', "can:individual_company"])->name('job.applicants');

//application
// for talent to apply to job
Route::get("job-{job}/apply", [ApplicationController::class, "job_apply"])->middleware(['auth', 'verified', "can:talent"])->name('job.apply');

Route::post("job-{job}/apply", [ApplicationController::class, "job_store_application"])->middleware(['auth', 'verified', "can:talent"])->name('job.store_application');


Route::middleware('auth')->group(function () {
  Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
  Route::get('/tracking-history', [TrackingController::class, 'history'])->name('tracking.history');
  Route::get('/tracking/{job}', [TrackingController::class, 'show'])->name('tracking.show');
  Route::patch('/tracking/{job}/complete', [TrackingController::class, 'complete'])->name('tracking.complete');
  Route::get('/jobs/pending', [TrackingController::class, 'showPendingJobs'])->name('jobs.mark-as-started');

  Route::patch('/tracking/{job}', [TrackingController::class, 'startJob'])->name('tracking.start');
});
