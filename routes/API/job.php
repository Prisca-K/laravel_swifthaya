<?php

use App\Http\Controllers\API\SwifthayajobController;
use App\Http\Controllers\API\TrackingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', "can:company"])->prefix("/jobs")->group(function () {
  Route::get("/", [SwifthayajobController::class, "index"]);


  Route::get("/{job}", [SwifthayajobController::class, "show"]);

  Route::post("/store", [SwifthayajobController::class, "store"]);

  Route::patch("/{job}/update", [SwifthayajobController::class, "update"]);

  Route::delete("/{job}", [SwifthayajobController::class, "destroy"]);
});

Route::get("/job_search", [SwifthayajobController::class, "job_search"])->middleware(['aut:sanctum', "can:talent"]);

// job tracking
Route::get('/job_tracking/pending', [TrackingController::class, 'pendingJob']);

Route::patch('/job_tracking/{job}/complete', [TrackingController::class, 'completeJob']);

Route::get('/job_tracking/{job}/start', [TrackingController::class, 'startJob']);
