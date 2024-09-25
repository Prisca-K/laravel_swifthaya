<?php

use App\Http\Controllers\API\V1\ReviewController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix("/reviews")->group(function () {

  // reviews written by the authenticated user
  Route::get('/reviewed', [ReviewController::class, "reviewer"]);
  // reviews that were recieved by the authenticated user
  Route::get('/reviewers', [ReviewController::class, "reviewee"]);
  // create a review
  Route::post('/{reviewee_id}', [ReviewController::class, "store"]);

  // update a review
  Route::patch('/{review}/', [ReviewController::class, "update"]);

  // delete a review
  Route::delete("/{review}/", [ReviewController::class, "destroy"]);
});
