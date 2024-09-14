<?php

use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;



// Routes for actions
// job
Route::get('/applicants/{application}', [ApplicationController::class, 'show'])->middleware(['auth', 'verified', "can:individual_company"])->name('applicants.show');

Route::patch('/applicants/{application}/accept', [ApplicationController::class, 'accept'])->middleware(['auth', 'verified', "can:individual_company"])->name('applicants.accept');

Route::patch('/applicants/{application}/reject', [ApplicationController::class, 'reject'])->middleware(['auth', 'verified', "can:individual_company"])->name('applicants.reject');


// talent

Route::get('/applications/{application}', [ApplicationController::class, 'job_details'])->middleware(['auth', 'verified', "can:talent"])->name('applications.job_details');
