<?php

use App\Http\Controllers\Company_profileController;
use Illuminate\Support\Facades\Route;



Route::get("companies/{user}/dashboard", [Company_profileController::class, "index"])->middleware(['auth', 'verified', "can:company"])->name('company.dashboard');

Route::get("companies/{user_profile}/create-profile", [Company_profileController::class, "create"])->middleware(['auth', 'verified', "can:company"])->name('company.create');

Route::post("companies/{user_profile}/create", [Company_profileController::class, "store"])->middleware(['auth', 'verified', "can:company"])->name('company.store');

Route::get("companies/{user_profile}/profile", [Company_profileController::class, "show"])->middleware(['auth', 'verified', "can:company"])->name('company.show');

Route::get("companies/{user_profile}/{company_profile}/edit", [Company_profileController::class, "edit"])->middleware(['auth', 'verified', "can:company"])->name('company.edit');

// same route with user profile
Route::patch("/company/{profile}", [Company_profileController::class, "update"])->middleware(['auth', 'verified', "can:company"])->name('company.update');

Route::delete("companies/{user_profile}/{company_profile}", [Company_profileController::class, "destroy"])->middleware(['auth', 'verified', "can:company"])->name('company.delete');
