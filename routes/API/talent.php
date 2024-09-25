<?php

use App\Http\Controllers\API\V1\TalentProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', "can:talent"])->prefix("/talent-profiles")->group(function () {

  // View a talent profile 
  Route::get("/", [TalentProfileController::class, "show"]);
  
  // Create a new talent profile (store)
  Route::post("/store", [TalentProfileController::class, "store"]);

  // Update an existing talent profile
  Route::patch("/{talent_profile}/update", [TalentProfileController::class, "update"]);

  // Delete a talent profile
  Route::delete("/{talent_profile}/destroy", [TalentProfileController::class, "destroy"]);
});
