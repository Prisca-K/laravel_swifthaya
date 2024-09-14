<?php

use App\Http\Controllers\Company_profileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::get("companies/dashboard", [Company_profileController::class, "index"])->middleware(['auth', 'verified', "can:company"])->name('company.dashboard');

Route::get("company-profile", [Company_profileController::class, "create"])->middleware(['auth', 'verified', "can:company"])->name('company.create');

Route::post("company-profile", [Company_profileController::class, "store"])->middleware(['auth', 'verified', "can:company"])->name('company.store');

// Route::get("company-profile", [Company_profileController::class, "show"])->middleware(['auth', 'verified', "can:company"])->name('company.show');


// same route with user profile
Route::patch("/company-profile/{profile}", [Company_profileController::class, "update"])->middleware(['auth', 'verified', "can:company"])->name('company.update');

// Route::delete("companies/{user_profile}/{company_profile}", [Company_profileController::class, "destroy"])->middleware(['auth', 'verified', "can:company"])->name('company.delete');
