<?php

use App\Http\Controllers\API\ReviewController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix("/reviews")->group(function () {
  Route::get("/reviewer", [ReviewController::class, "reviewer"]);
  Route::get("/reviewee", [ReviewController::class, "reviewee"]);

  Route::post("/store", [ReviewController::class, "store"]);

  Route::patch("/{review}/update", [ReviewController::class, "update"]);

  Route::delete("/{review}/destroy", [ReviewController::class, "destroy"]);
});



