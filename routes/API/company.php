<?php

use App\Http\Controllers\API\V1\CompanyProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', "can:company"])->prefix("/company-profiles")->group(function () {

  // View a single company profile
  Route::get("/", [CompanyProfileController::class, "show"]);

  // Create a new company profile
  Route::post("/", [CompanyProfileController::class, "store"]);

  // Update an existing company profile
  Route::patch("/{company_profile}", [CompanyProfileController::class, "update"]);

  // Delete a company profile
  Route::delete("/{company_profile}", [CompanyProfileController::class, "destroy"]);
});
