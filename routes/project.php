<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;


Route::get("/projects/{user}/", [ProjectController::class, "index"])->middleware(['auth', 'verified', 'can:individual_company'])->name('projects');

Route::get("/projects/{user}/create-project", [ProjectController::class, "create"])->middleware(['auth', 'verified', 'can:individual_company'])->name('project.create');

Route::post("/projects/{user}/create-project", [ProjectController::class, "store"])->middleware(['auth', 'verified', 'can:individual_company'])->name('project.store');

Route::get("/projects/project/{project}", [ProjectController::class, "show"])->middleware(['auth', 'verified', 'can:individual_company'])->name('project.show');

Route::get("/projects/{project}/edit", [ProjectController::class, "edit"])->middleware(['auth', 'verified', 'can:individual_company'])->name('project.edit');

Route::patch("/projects/{project}/edit", [ProjectController::class, "update"])->middleware(['auth', 'verified', 'can:individual_company'])->name('project.update');

Route::delete("/projects/{project}", [ProjectController::class, "destroy"])->middleware(['auth', 'verified', 'can:individual_company'])->name('project.destroy');
