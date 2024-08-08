<?php

use App\Http\Controllers\SwifthayajobController;
use Illuminate\Support\Facades\Route;



Route::get("/jobs/{user}", [SwifthayajobController::class, "index"])->middleware(['auth', 'verified', 'can:company'])->name('jobs');

Route::get("/jobs/{user}/create-job", [SwifthayajobController::class, "create"])->middleware(['auth', 'verified', 'can:company'])->name('job.create');

Route::post("/jobs/{user}/create-job", [SwifthayajobController::class, "store"])->middleware(['auth', 'verified', 'can:company'])->name('job.store');

Route::get("/jobs/job/{job}", [SwifthayajobController::class, "show"])->middleware(['auth', 'verified', 'can:company'])->name('job.show');

Route::get("/jobs/{job}/edit", [SwifthayajobController::class, "edit"])->middleware(['auth', 'verified', 'can:company'])->name('job.edit');

Route::patch("/jobs/{job}/edit", [SwifthayajobController::class, "update"])->middleware(['auth', 'verified', 'can:company'])->name('job.update');

Route::delete("/jobs/{job}", [SwifthayajobController::class, "destroy"])->middleware(['auth', 'verified', 'can:company'])->name('job.destroy');


// 

