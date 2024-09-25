<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SwifthayajobController;
use App\Http\Controllers\Talent_ProfileController;
use Illuminate\Support\Facades\Route;


Route::get("/all-projects", [ProjectController::class, "index"])->middleware(['auth', 'verified', 'can:individual_company'])->name('projects');

Route::get("/projects", [ProjectController::class, "create"])->middleware(['auth', 'verified', 'can:individual_company'])->name('project.create');

Route::post("/projects", [ProjectController::class, "store"])->middleware(['auth', 'verified', 'can:individual_company'])->name('project.store');

Route::get("/projects/{project}", [ProjectController::class, "show"])->middleware(['auth', 'verified', 'can:individual_company'])->name('project.show');

Route::get("/projects/{project}/edit", [ProjectController::class, "edit"])->middleware(['auth', 'verified', 'can:individual_company'])->name('project.edit');

Route::patch("/projects/{project}/edit", [ProjectController::class, "update"])->middleware(['auth', 'verified', 'can:individual_company'])->name('project.update');

Route::delete("/projects/{project}", [ProjectController::class, "destroy"])->middleware(['auth', 'verified', 'can:individual_company'])->name('project.destroy');

Route::get("/project/{project}/details", [ProjectController::class, "project_details"])->middleware(['auth', 'verified', "can:talent"])->name('project.details');

// search routes

// Route::get("/find-projects", [Talent_ProfileController::class, "find_projects"])->middleware(['auth', 'verified', "can:talent"])->name('find_projects');

Route::get("/project_search", [Talent_ProfileController::class, "project_search"])->middleware(['auth', 'verified', "can:talent"])->name('project_search');

// application

// Route::get("project{project}/apply", [ApplicationController::class, "project_apply"])->middleware(['auth', 'verified', "can:talent"])->name('project.apply');

// Route::post("project{project}/apply", [ApplicationController::class, "project_store_application"])->middleware(['auth', 'verified', "can:talent"])->name('project.store_application');


// Route::get("project{project}/applicants", [SwifthayajobController::class, "view_project_applicants"])->middleware(['auth', 'verified', "can:individual_company"])->name('project.applicants');
