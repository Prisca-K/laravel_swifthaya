<?php

use App\Http\Controllers\API\TalentProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', "can:talent"])->prefix("/talent-profiles")->group(function () {
  Route::get("/", [TalentProfileController::class, "show"]);

  Route::post("/store", [TalentProfileController::class, "store"]);

  Route::patch("/{talent_profile}/update", [TalentProfileController::class, "update"]);

  Route::delete("/{talent_profile}/destroy", [TalentProfileController::class, "destroy"]);
});



