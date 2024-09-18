<?php

use App\Http\Controllers\API\CompanyProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', "can:company"])->prefix("/company-profile")->group(function () {
Route::get("/", [CompanyProfileController::class, "show"]);

Route::post("/store", [CompanyProfileController::class, "store"]);

Route::patch("/{company_profile}/update", [CompanyProfileController::class, "update"]);

Route::delete("/{company_profile}/delete", [CompanyProfileController::class, "destroy"]);
});