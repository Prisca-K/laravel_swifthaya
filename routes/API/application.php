<?php

use App\Http\Controllers\API\ApplicationController;
use Illuminate\Support\Facades\Route;



Route::get("jobs/applicants", [ApplicationController::class, "view_job_applicants"])->middleware(["can:company", 'auth:sanctum']);

Route::get("projects/applicants", [ApplicationController::class, "view_project_applicants"])->middleware(["can:individual_company", 'auth:sanctum']);



Route::middleware(['auth:sanctum', "can:individual_company"])->prefix("/applicants")->group(function () {
  Route::patch('/{application}/accept', [ApplicationController::class, 'accept'])->middleware(['auth:sanctum', "can:individual_company"]);

  Route::patch('/{application}/reject', [ApplicationController::class, 'reject'])->middleware(['auth:sanctum', "can:individual_company"]);
});

Route::middleware(['auth:sanctum', "can:talent"])->group(function () {
  Route::get("talents/job-application-history", [ApplicationController::class, "job_application_history"]);

  Route::get("talents/project-application-history", [ApplicationController::class, "project_application_history"]);

  Route::post("jobs/{job}/apply", [ApplicationController::class, "job_apply"]);

  Route::post("projects/{projects}/apply", [ApplicationController::class, "job_apply"]);
});
