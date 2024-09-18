<?php

use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\TrackingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', "can:individual_company"])->prefix("/projects")->group(function () {
  Route::get("/", [ProjectController::class, "index"]);

  Route::get("/{project}", [ProjectController::class, "show"]);

  Route::post("/store", [ProjectController::class, "store"]);

  Route::patch("/{project}/update", [ProjectController::class, "update"]);

  Route::delete("/{project}", [ProjectController::class, "destroy"]);
});

Route::get("/project_search", [ProjectController::class, "project_search"])->middleware(['aut:sanctum', "can:talent"]);

Route::get('/project_tracking/pending', [TrackingController::class, 'pendingProject']);

Route::patch('/project_tracking/{project}/complete', [TrackingController::class, 'completeProject']);

Route::get('/project_tracking/{project}/start', [TrackingController::class, 'startProject']);
